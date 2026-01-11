<?php

namespace App\Livewire\Auth\Web;

use App\Events\UserRegistered; // <--- Import your NEW Custom Event
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Auth\Events\Registered; // <--- 1. IMPORT THIS AT THE TOP

class Register extends Component
{
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        $user = User::create([
            'first_name' => $validated['firstName'],
            'last_name'  => $validated['lastName'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => 'user',
        ]);

        // --- CHANGE THIS LINE ---
        // Dispatch your custom event
        event(new Registered($user));

        Auth::login($user);

        return $this->redirect(route('verification.notice'), navigate: true);


    }

    public function render()
    {
        return view('livewire.auth.web.register')->extends('layouts.web.app');
    }
}
