<?php

use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CmsManagmentController;
use App\Livewire\Admin\Cms\Home\HeroSection;

Route::get("/",[HomeController::class,'index'])->name('index');

Route::controller(CmsManagmentController::class)->name('cms.')->prefix('cms/page-sections/')->group(function () {
    Route::get('/','index')->name('index');
    Route::get('add','create')->name('create');
    Route::post('store','store')->name('store');

});


Route::prefix('cms/meta')->name('cms.meta.')->group(function () {

    // Home page banner section (GET route to view the form/component)
    Route::get('home/hero-section', HeroSection::class)->name('herosection.form');

    // Home page banner section (POST route, often not strictly needed for Livewire)
    Route::post('hero-section/store-or-update', HeroSection::class)->name('herosection.storeOrUpdate');

    // ... (Other CMS meta routes)

});
