<?php

use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CmsManagmentController;
use App\Livewire\Admin\Cms\Home\HeroSection;
use App\Livewire\Admin\Cms\Home\FeaturedSection;
use App\Livewire\Admin\Cms\Home\AboutSection;
use App\Livewire\Admin\Cms\About\AboutSection as AboutPageSection;
use App\Livewire\Admin\Cms\Books\StorytellingSection;
use App\Livewire\Admin\Blogs\BlogIndex;
use App\Livewire\Admin\Blogs\BlogCreate;
use App\Livewire\Admin\Blogs\BlogEdit;


Route::get("/",[HomeController::class,'index'])->name('index');

Route::controller(CmsManagmentController::class)->name('cms.')->prefix('cms/page-sections/')->group(function () {
    Route::get('/','index')->name('index');
    Route::get('add','create')->name('create');
    Route::post('store','store')->name('store');

});


Route::prefix('cms/meta')->name('cms.meta.')->group(function () {

    // Home Hero section
    Route::get('home/hero-section', HeroSection::class)->name('herosection.form');
    Route::post('hero-section/store-or-update', HeroSection::class)->name('herosection.storeOrUpdate');

    //Home Featured Book Section
    Route::get('home/featured-book-section', FeaturedSection::class)->name('featuredBookSection.form');
    Route::post('featured-book-section/store-or-update', FeaturedSection::class)->name('featuredBookSection.storeOrUpdate');

    // About Section (Corrected Name)
    Route::get('home/about-section', AboutSection::class)->name('aboutSection.form');

    // About Page Section
    Route::post('about-section/store-or-update', AboutSection::class)->name('aboutSection.storeOrUpdate');

    Route::get('about', AboutPageSection::class)->name('aboutPage.section');

    // Books Page Section
    // Books Page - Storytelling Section
Route::get('books/storytelling-section', StorytellingSection::class)
    ->name('books.storytellingSection.form');

});


// Note: We use a separate prefix 'blogs' to keep it clean
Route::prefix('blogs')->name('blogs.')->group(function () {

    // 1. READ (List all blogs)
    Route::get('/', BlogIndex::class)->name('index');

    // 2. CREATE (Show the create form)
    Route::get('/create', BlogCreate::class)->name('create');

    // 3. UPDATE (Show the edit form - requires ID)
    Route::get('/{id}/edit', BlogEdit::class)->name('edit');

    // 4. DELETE (Optional Route)
    // In Livewire, delete is usually a method inside the Index component.
    // However, if you want a specific route for it:
    // Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');
});
