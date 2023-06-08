<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::fallback(fn() => redirect()->route('site.home'));
