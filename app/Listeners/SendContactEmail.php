<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ContactFormSubmitted;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;


class SendContactEmail
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
public function handle(ContactFormSubmitted $event): void
    {
        // Replace this string with the actual author's email or config('mail.from.address')
        $authorEmail = 'rimaginarius@example.com';

        Mail::to($authorEmail)->send(new ContactFormMail($event->contact));
    }


}
