<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PruneOldPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-old-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Unpublished posts older than one month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info( "Starting to prune old unpublished posts...");
        $deletedCount = Post::where('created_at', '<', Carbon::now()->subMonth() )
            ->delete();//where('is_published',false)
        $this->info("Successfully deleted {$deletedCount} old posts.");
    }
}
