<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.admin.register');
    }

    public function login_view()
    {
        return view('auth.admin.login');
    }
}
