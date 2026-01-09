<?php

namespace App\Events;

use App\Models\Contact;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(public Contact $contact)
    {
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
