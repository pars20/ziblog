<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmailToNewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        //dd( $event->user, $event->user->email );
        //SendWelcomeEmailToNewUser::dispatch( $event->user->id );
        sleep( 25 );
        Log::info( "Email sent to a new registered user : {$event->user->email}" );
    }
}
