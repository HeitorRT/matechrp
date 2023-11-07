<?php

use App\Http\Controllers\Site\DownloadController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ServiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/home', [HomeController::class, 'index'])->name('site.home');
Route::get('/soon', [HomeController::class, 'soon'])->name('site.soon');
Route::get('/download', [DownloadController::class, 'index'])->name('site.download');
Route::get('/services', [ServiceController::class, 'index'])->name('site.services');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('site.services.show');