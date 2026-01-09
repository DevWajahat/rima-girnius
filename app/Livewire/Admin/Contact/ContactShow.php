<?php

namespace App\Livewire\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;

class ContactShow extends Component
{
    public $contact;

    public function mount($id)
    {
        $this->contact = Contact::findOrFail($id);
    }

    public function delete()
    {
        $this->contact->delete();
        session()->flash('message', 'Message deleted successfully.');
        return redirect()->route('admin.contacts.index');
    }

    public function render()
    {
        return view('livewire.admin.contact.contact-show');
    }
}
