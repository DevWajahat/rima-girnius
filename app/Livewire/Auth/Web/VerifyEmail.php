<?php

namespace App\Livewire\Auth\Web;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class VerifyEmail extends Component
{
    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return $this->redirect('/books', navigate: true);
        }

        Auth::user()->sendEmailVerificationNotification();

        // Flash a success message
        session()->flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.auth.web.verify-email')
            ->extends('layouts.web.app');
    }
}
