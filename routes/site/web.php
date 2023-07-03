<?php

use App\Http\Controllers\Site\AboutUsController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', [HomeController::class, 'index'])->name('site.home');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('site.about-us');
