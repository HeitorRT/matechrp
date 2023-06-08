<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/student/welcome');

Route::fallback(fn() => redirect()->route('student.welcome'));
