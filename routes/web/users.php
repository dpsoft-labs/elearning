<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Web\Back\Users\Tickets\TicketsController;
    use App\Http\Controllers\Web\Back\Users\Notes\NotesController;
    use App\Http\Controllers\Web\Back\Users\Invoices\InvoicesController;
    use App\Http\Controllers\Web\Back\Users\Registrations\RegistrationsController;
    use App\Http\Controllers\Web\Back\Users\Quizzes\QuizzesController;
    use App\Http\Controllers\Web\Back\Users\Lectures\LecturesController;
    use App\Http\Controllers\Web\Back\Users\Lives\LivesController;
    use App\Http\Controllers\Web\Back\Users\Ai\AiController;

        // --------------------------------------------------lectures-------------------------------------------------------------------------------------------------------------
        Route::controller(LecturesController::class)->group(function () {
            Route::get('/dashboard/lectures', 'index')->name('dashboard.users.lectures');
            Route::get('/dashboard/lectures/show', 'show')->name('dashboard.users.lectures-show');
        });
        // --------------------------------------------------lives-------------------------------------------------------------------------------------------------------------
        Route::controller(LivesController::class)->group(function () {
            Route::get('/dashboard/lives', 'index')->name('dashboard.users.lives');
        });
    // --------------------------------------------------quizs-------------------------------------------------------------------------------------------------------------
    Route::controller(QuizzesController::class)->group(function () {
        Route::get('/dashboard/quizzes', 'index')->name('dashboard.users.quizzes');
        Route::get('/dashboard/quizzes/open', 'open')->name('dashboard.users.quizzes-open');
        Route::post('/dashboard/quizzes/submit', 'submit')->name('dashboard.users.quizzes-submit');
        Route::get('/dashboard/quizzes/show', 'show')->name('dashboard.users.quizzes-show');
    });
        // --------------------------------------------------registrations-------------------------------------------------------------------------------------------------------------
    Route::prefix('users/registrations')->controller(RegistrationsController::class)->group(function () {
        Route::get('/', 'show')->name('dashboard.users.registrations');
        Route::post('/store', 'store')->name('dashboard.users.registrations-store');
        Route::get('/available/{student_id}', 'availableCourses')->name('dashboard.users.registrations-available');
    });
    // --------------------------------------------------invoices-------------------------------------------------------------------------------------------------------------
    Route::prefix('users/invoices')->controller(InvoicesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.users.invoices');
        Route::get('/show', 'show')->name('dashboard.users.invoices-show');
    });
    // --------------------------------------------------registrations-------------------------------------------------------------------------------------------------------------
    Route::prefix('users/registrations')->controller(RegistrationsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.users.registrations');
    });
    // =======================================================tickets==============================================================================================================
    Route::prefix('users/tickets')->controller(TicketsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.users.tickets');
        Route::get('/show', 'show')->name('dashboard.users.tickets-show');
        Route::post('/reply', 'reply')->name('dashboard.users.tickets-reply');
        Route::post('/store', 'store')->name('dashboard.users.tickets-store');
        Route::get('/get-new-messages', 'getNewMessages')->name('dashboard.users.tickets-get-new-messages');
    });
    // =======================================================notes==============================================================================================================
    Route::prefix('users/notes')->controller(NotesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.users.notes');
        Route::get('/show', 'show')->name('dashboard.users.notes-show');
        Route::post('/store', 'store')->name('dashboard.users.notes-store');
        Route::get('/edit', 'edit')->name('dashboard.users.notes-edit');
        Route::patch('/update', 'update')->name('dashboard.users.notes-update');
        Route::get('/delete', 'delete')->name('dashboard.users.notes-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.users.notes-deleteSelected');
        Route::get('/check', 'check')->name('dashboard.users.notes-check');
    });
    Route::get('users/ai', [AiController::class, 'index'])->name('dashboard.users.ai');
    Route::get('users/ai/getremaining', [AiController::class, 'get_remaining'])->name('dashboard.users.ai-getremaining');
    Route::post('users/ai', [AiController::class, 'message'])->name('dashboard.users.ai-message');

