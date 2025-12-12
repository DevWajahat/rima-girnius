<?php

namespace App\Livewire\Auth\Admin;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $email;
    public $password;


    public function render()
    {
        return view('livewire.auth.admin.login');
    }

    public function login()
    {
        $validated = $this->validate([
            'email'=> 'required|email|max:255',
            'password' => 'required|min:8|max:16'
        ]);

        $credentials = array_merge($validated, ['role' => 'admin']);

        if(Auth::attempt($credentials)) {

            return $this->redirectRoute('admin.index',navigate:true);

        }

        else{

            $this->addError('email','The email or password is incorrect.');
        }



    }


}



