<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\BooksController;
use App\Http\Controllers\Web\BlogsController;
/* Route::get('/', function () { */
/*     return view('welcome'); */
/* }); */

Route::get("/",[HomeController::class, 'index'])->name('home');
Route::get("about",[AboutController::class,'index'])->name('about');
Route::get("contact",[ContactController::class, 'index'])->name('contact');
Route::get("books",[BooksController::class,'index'])->name('books');
Route::get("blogs",[BlogsController::class,'index'])->name('blogs');
# Route::get("/")->name()


?>
