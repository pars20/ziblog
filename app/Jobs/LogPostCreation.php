<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Post;
use Illuminate\Support\Facades\Log;

class LogPostCreation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( public Post $post )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep( 10 );
        Log::info('A new post created: '. $this->post->title );
    }
}
