<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Auth\PasswordSendLinkController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Chat\ChatMessageController;
use App\Http\Controllers\Admin\CommonQuestionController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ContentExtraController;
use App\Http\Controllers\Admin\CommercialController;
use App\Http\Controllers\Admin\ContentChapterController;
use App\Http\Controllers\Admin\ContentSeasonChapterController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\JobVacancyController;
use App\Http\Controllers\Admin\LiveEventController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\IndicationController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuizzController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/admin', '/admin/auth/sign-in');

Route::middleware('guest:admin')
    ->get('admin/auth/sign-in', [AuthController::class, 'form'])
    ->name('admin.auth.sign-in');

Route::middleware('guest:admin')
    ->post('admin/auth/login', [AuthController::class, 'login'])
    ->name('admin.auth.login');

Route::middleware('guest:admin')
    ->get('admin/auth/forgot-password', [PasswordSendLinkController::class, 'form'])
    ->name('admin.auth.forgot-password-form');

Route::post('admin/auth/forgot-password-send-link', [PasswordSendLinkController::class, 'sendLink'])
    ->name('admin.auth.forgot-password-send-link');

Route::middleware('guest:admin')
    ->post('admin/auth/reset-password', [PasswordResetController::class, 'reset'])
    ->name('admin.auth.password.reset');

Route::middleware('auth:admin')
    ->post('admin/auth/logout', [AuthController::class, 'logout'])
    ->name('admin.auth.logout');

Route::middleware('guest:admin')
    ->get('admin/auth/reset-password/{token}', [PasswordResetController::class, 'form'])
    ->name('admin.password.reset');

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::post('chat-message/{meeting}/send', [ChatMessageController::class, 'send'])->name('chat-message.send');

        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/commercial', [CommercialController::class, 'index'])->name('commercial.index');
        Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

        Route::post('order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::resource('order', OrderController::class)->only(['create', 'store', 'edit', 'update', 'show']);

        Route::resource('user', UserController::class);
        Route::post('user/destroy-multiples', [UserController::class, 'destroyMultiples'])->name('user.destroy-multiples');

        Route::resource('role', RoleController::class);
        Route::post('role/destroy-multiples', [RoleController::class, 'destroyMultiples'])->name('role.destroy-multiples');

        Route::get('student/export', [StudentController::class, 'export'])->name('student.export');
        Route::get('student/search', [StudentController::class, 'search'])->name('student.search');
        Route::resource('student', StudentController::class);
        Route::post('student/destroy-multiples', [StudentController::class, 'destroyMultiples'])->name('student.destroy-multiples');

        Route::resource('category', CategoryController::class);
        Route::post('category/destroy-multiples', [CategoryController::class, 'destroyMultiples'])->name('category.destroy-multiples');

        Route::get('section/sort-index', [SectionController::class, 'sortIndex'])->name('section.sort-index');
        Route::resource('section', SectionController::class);
        Route::post('section/destroy-multiples', [SectionController::class, 'destroyMultiples'])->name('section.destroy-multiples');
        Route::post('section/reorder', [SectionController::class, 'reorder'])->name('section.reorder');

        Route::resource('group', GroupController::class);
        Route::post('group/destroy-multiples', [GroupController::class, 'destroyMultiples'])->name('group.destroy-multiples');

        Route::resource('job-vacancy', JobVacancyController::class);
        Route::post('job-vacancy/destroy-multiples', [JobVacancyController::class, 'destroyMultiples'])->name('job-vacancy.destroy-multiples');

        Route::resource('indication', IndicationController::class);
        Route::post('indication/destroy-multiples', [IndicationController::class, 'destroyMultiples'])->name('indication.destroy-multiples');

        Route::resource('campaign', CampaignController::class);
        Route::post('campaign/destroy-multiples', [CampaignController::class, 'destroyMultiples'])->name('campaign.destroy-multiples');

        Route::resource('common-question', CommonQuestionController::class);
        Route::post('common-question/destroy-multiples', [CommonQuestionController::class, 'destroyMultiples'])->name('common-question.destroy-multiples');

        Route::resource('product', ProductController::class);
        Route::post('product/destroy-multiples', [ProductController::class, 'destroyMultiples'])->name('product.destroy-multiples');

        Route::resource('item', ItemController::class);
        Route::post('item/destroy-multiples', [ItemController::class, 'destroyMultiples'])->name('item.destroy-multiples');

        Route::put('live-event/{liveEvent}/toggle-offer-availability', [LiveEventController::class, 'toggleOfferAvailability'])->name('live-event.toggle-offer-availability');
        Route::get('live-event/{liveEvent}/follow', [LiveEventController::class, 'follow'])->name('live-event.follow');

        Route::resource('live-event', LiveEventController::class);
        Route::post('live-event/destroy-multiples', [LiveEventController::class, 'destroyMultiples'])->name('live-event.destroy-multiples');

        Route::put('meeting/{meeting}/toggle-offer-availability', [MeetingController::class, 'toggleOfferAvailability'])->name('meeting.toggle-offer-availability');
        Route::put('meeting/{meeting}/start', [MeetingController::class, 'start'])->name('meeting.start');
        Route::put('meeting/{meeting}/finish', [MeetingController::class, 'finish'])->name('meeting.finish');
        Route::put('meeting/{meeting}/detach-student/{student}', [MeetingController::class, 'detachStudent'])->name('meeting.detach-student');
        Route::get('meeting/{meeting}/follow', [MeetingController::class, 'follow'])->name('meeting.follow');

        Route::resource('meeting', MeetingController::class);
        Route::post('meeting/destroy-multiples', [MeetingController::class, 'destroyMultiples'])->name('meeting.destroy-multiples');

        Route::prefix('content')->group(function () {
            Route::get('top', [ContentController::class, 'top'])->name('content.top');
            Route::put('{content}/set-position', [ContentController::class, 'setPosition'])->name('content.set-position');
            Route::put('{content}/remove-position', [ContentController::class, 'removePosition'])->name('content.remove-position');

            Route::get('{content}/titles', [ContentController::class, 'titles'])->name('content.titles');
            Route::get('{content}/titles/show', [ContentController::class, 'showTitles'])->name('content.titles.show');

            Route::get('export', [ContentController::class, 'export'])->name('content.export');

            Route::get('{content}/chapter/show', [ContentChapterController::class, 'show'])->name('content.chapter.show');
            Route::get('{content}/extra/show-list', [ContentExtraController::class, 'showList'])->name('content.extra.show-list');
            Route::get('{content}/season/show-list', [SeasonController::class, 'showList'])->name('content.season.show-list');
        });

        Route::resource('notification', NotificationController::class)->only(['index', 'edit', 'update', 'show']);

        Route::resource('content', ContentController::class);
        Route::post('content/destroy-multiples', [ContentController::class, 'destroyMultiples'])->name('content.destroy-multiples');

        Route::resource('content.extra', ContentExtraController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('content.season', SeasonController::class);
        Route::resource('content.chapter', ContentChapterController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::resource('content.season.chapter', ContentSeasonChapterController::class)->only(['store', 'update', 'destroy']);
        Route::post('content/{content}/season/{season}/chapter/reorder', [ContentSeasonChapterController::class, 'reorderChapters'])->name('content.season.chapter.reorder');

        Route::resource('quizz', QuizzController::class);
        Route::post('quizz/destroy-multiples', [QuizzController::class, 'destroyMultiples'])->name('quizz.destroy-multiples');

        Route::get('quizz/{content}/linkables/{type}', [QuizzController::class, 'linkables'])->name('quizz.linkables');

        Route::get('system-setting', [SystemSettingController::class, 'index'])->name('system-setting.index');
        Route::put('system-setting', [SystemSettingController::class, 'update'])->name('system-setting.update');

        Route::resource('popup', PopupController::class);
        Route::post('popup/destroy-multiples', [PopupController::class, 'destroyMultiples'])->name('popup.destroy-multiples');
    });


