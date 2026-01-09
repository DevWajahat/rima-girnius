<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Contact as  ContactModel;

class Contact extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

public function save()
    {
        $this->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10',
        ]);

        $contact = ContactModel::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        \App\Events\ContactFormSubmitted::dispatch($contact);

        session()->flash('success', 'Thank you! Your message has been sent successfully.');

        $this->reset();
    }
    public function render()
    {
        return view('livewire.web.contact');
    }
}
