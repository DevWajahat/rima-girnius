<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue; // Optional: Implements this to send in background
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationEmail
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // Check if User implements verification and hasn't verified yet
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {

            // This calls the method in your User model
            // which triggers the CustomVerifyEmail notification we created earlier
            $event->user->sendEmailVerificationNotification();
        }
    }
}
