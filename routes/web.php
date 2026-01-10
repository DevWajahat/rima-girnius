<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\BooksController;
use App\Http\Controllers\Web\BlogsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Livewire\Auth\Web\VerifyEmail;
use App\Livewire\Auth\Web\Register;




/* Route::get('/', function () { */
/*     return view('welcome'); */
/* }); */

Route::get("/",[HomeController::class, 'index'])->name('home');
Route::get("about",[AboutController::class,'index'])->name('about');
Route::get("contact",[ContactController::class, 'index'])->name('contact');
Route::get("books",[BooksController::class,'index'])->name('books');
Route::get("blogs",[BlogsController::class,'index'])->name('blogs');
Route::get("blogs/{id}", [BlogsController::class, 'show'])->name('blogs.show');
# Route::get("/")->name()

Route::middleware('auth')->group(function () {

    // --- THIS IS THE MISSING PART ---

    // 1. The "Notice" Page (Where you want to redirect)
    Route::get('/email/verify', VerifyEmail::class)
        ->name('verification.notice');

    // 2. The Logic to Handle the Link Click (Laravel handles this)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/books'); // Redirect to books after verifying
    })->middleware(['signed'])->name('verification.verify');

    // ---------------------------------

    // Your protected routes
    /* Route::get('/books', function () { */
    /*     return view('books'); // Replace with your Books component */
    /* })->middleware('verified')->name('books.index'); // Add 'verified' here! */
});


Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::get('/logout', function () {
    // 1. Log the user out
    auth()->logout();

    // 2. Invalidate the session (Security best practice)
    session()->invalidate();
    session()->regenerateToken();

    // 3. Redirect to home or login page
    return redirect('/');
})->name('logout');


?>
