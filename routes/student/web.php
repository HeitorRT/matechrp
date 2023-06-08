<?php

use App\Http\Controllers\Student\Auth\AuthController;
use App\Http\Controllers\Student\Chat\ChatMessageController;
use App\Http\Controllers\Student\AuthStudentController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\WelcomeController;
use App\Http\Controllers\Student\Auth\PasswordSendLinkController;
use App\Http\Controllers\Student\Auth\PasswordResetController;
use App\Http\Controllers\Student\LiveEventController;
use App\Http\Controllers\Student\MovieController;
use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\Student\SerieController;
use App\Http\Controllers\Student\SearchController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\ChapterController;
use Illuminate\Support\Facades\Route;

Route::redirect('/student', '/student/welcome');

Route::middleware('guest:student')
    ->get('student/welcome', [WelcomeController::class, 'form'])
    ->name('student.welcome');

Route::middleware('guest:student')
    ->get('student/auth/sign-in', [AuthController::class, 'form'])
    ->name('student.auth.sign-in');

Route::middleware('guest:student')
    ->post('student/auth/login', [AuthController::class, 'login'])
    ->name('student.auth.login');

Route::post('student/auth/forgot-password-send-link', [PasswordSendLinkController::class, 'sendLink'])
    ->name('student.auth.forgot-password-send-link');

Route::get('student/auth/forgot', [AuthController::class, 'forgot'])
    ->name('student.auth.forgot');

Route::middleware('guest:student')
    ->post('student/auth/reset-password', [PasswordResetController::class, 'reset'])
    ->name('student.auth.password.reset');

Route::middleware('auth:student')
    ->post('student/auth/logout', [AuthController::class, 'logout'])
    ->name('student.auth.logout');

Route::middleware('guest:student')
    ->get('student/auth/reset-password/{token}', [PasswordResetController::class, 'form'])
    ->name('student.password.reset');

Route::middleware('auth:student')
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/movie', [MovieController::class, 'index'])->name('movie');
        Route::get('/serie', [SerieController::class, 'index'])->name('serie');
        Route::get('/search', [SearchController::class, 'index'])->name('search');

        Route::get('/live', [LiveEventController::class, 'index'])->name('live');
        Route::get('/live/{liveEvent}/show', [LiveEventController::class, 'show'])->name('live.show');

        Route::get('/chapter/{chapter}/show', [ChapterController::class, 'show'])->name('chapter.show');

        Route::post('/toggle-content-inside-list/{content}', [AuthStudentController::class, 'toggleContentInsideList'])->name('content.toggle-content-inside-list');

        Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
        Route::put('/notification/make-notification-as-read/{notification}', [NotificationController::class, 'makeNotificationAsRead'])->name('notification.make-notification-as-read');
        Route::put('/notification/make-all-notification-as-read', [NotificationController::class, 'makeAllNotificationAsRead'])->name('notification.make-all-notification-as-read');
        Route::put('/notification/not-show-me-notification', [NotificationController::class, 'notShowMeNotification'])->name('notification.not-show-me-notification');

        Route::get('/edit-profile', [StudentController::class, 'edit'])->name('edit-profile');
        Route::post('/upload-photo', [StudentController::class, 'uploadPhoto'])->name('upload-photo');
        Route::get('/reset-password', [StudentController::class, 'resetPassword'])->name('reset-password');
    });

// Route::get('/chat/{meeting}', [ChatMessageController::class, 'index'])->name('chat-message.index');
// Route::post('chat-message/{meeting}/send', [ChatMessageController::class, 'send'])->name('chat-message.send');
