<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function booted(){
        static::creating(
            function( Tag $tag ){
                $tag->slug = Str::slug( $tag->name );
            }
        );
    }

    public function posts(){
        return $this->belongsToMany( Post::class );
    }
    

}
