<?php

use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CmsManagmentController;
use App\Livewire\Admin\Cms\Home\HeroSection;
use App\Livewire\Admin\Cms\Home\FeaturedSection;


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
    // Featured Book Section
    Route::get('home/featured-book-section', FeaturedSection::class)->name('featuredBookSection.form');
    Route::post('featured-book-section/store-or-update', FeaturedSection::class)->name('featuredBookSection.storeOrUpdate');

});
