<?php

use Illuminate\Support\Facades\Route;

dd('aqui');
Route::redirect('/', '/home');

Route::fallback(fn() => redirect()->route('site.home'));
