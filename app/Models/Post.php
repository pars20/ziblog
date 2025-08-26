<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Post extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function( Post $post ){

            $slug = Str::slug($post->title);
            $originalSlug = $slug;
            $count = 1;
            // Use exists() which returns a true boolean.
            // The check is performed on the updated $slug variable in each loop.
            while (static::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-" . $count++;
            }
            $post->slug = $slug;

        });

        static::saved(
            function( Post $post ){
                Cache::tags(['posts'])->flush();
                Cache::forget("show_post_".$post->slug);
            }
        );
        static::deleted(
            function ( Post $post ){
                Cache::tags(['posts'])->flush();
                Cache::forget("show_post_".$post->slug);
            }
        );

    }

    public function user(){
        return $this->belongsTo( User::class );
    }

    public function tags(){
        return $this->belongsToMany( Tag::class );
    }

    public function comments(){
        return $this->morphMany( Comment::class, 'commentable' );
    }

}
