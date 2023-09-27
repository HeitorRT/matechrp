<?php

use App\Http\Controllers\Site\AboutUsController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ServiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::name('site.')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/soon', [HomeController::class, 'soon'])->name('soon');
    Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
});