<?php

namespace App\Providers;

// use App\Events\UserRegistered;
// use App\Listeners\SendWelcomeEmail;
// use Illuminate\Support\Facades\Event;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen( UserRegistered::class, SendWelcomeEmail::class );

        Route::bind( 'post', function( $val ){
            return Cache::remember( "show_post_".$val, 3600, function() use ($val){
                return Post::where( 'slug', $val )
                    ->with( ['user','tags'] )
                    ->firstOrFail();
            });
        });
        
    }
}
