<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Livewire\Auth\Admin\Login;

// Route::get("register",[AdminAuthController::class,'index'])->name('admin.register')->middleware('guest');
Route::get("admin/login",[AdminAuthController::class, 'login_view'])->name('admin.login');
Route::post("admin/login",Login::class);
