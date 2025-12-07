<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\ContactController;

/* Route::get('/', function () { */
/*     return view('welcome'); */
/* }); */

Route::get("/",[HomeController::class, 'index'])->name('home');
Route::get("about",[AboutController::class,'index'])->name('about');
Route::get("contact",[ContactController::class, 'index'])->name('contact');

# Route::get("/")->name()


?>
