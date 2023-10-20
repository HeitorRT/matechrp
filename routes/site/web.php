<?php

use App\Http\Controllers\Site\AboutUsController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ServiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', [HomeController::class, 'index'])->name('site.home');
Route::get('/soon', [HomeController::class, 'soon'])->name('site.soon');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('site.about-us');
Route::get('/contact', [ContactController::class, 'index'])->name('site.contact');
Route::get('/services', [ServiceController::class, 'index'])->name('site.services');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('site.services.show');