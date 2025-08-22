<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmailToNewUser implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( public int $userid )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep( 25 );
        $user = User::find($this->userid);
        Log::info( "Email sent to a new registered user : {$user->email}" );
    }
}
