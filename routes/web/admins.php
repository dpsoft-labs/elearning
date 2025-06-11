<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Back\Admins\Roles\RolesController;
use App\Http\Controllers\Web\Back\Admins\Settings\SettingsController;
use App\Http\Controllers\Web\Back\Admins\Settings\LanguagesController;
use App\Http\Controllers\Web\Back\Admins\Settings\CurrenciesController;
use App\Http\Controllers\Web\Back\Admins\Settings\TaxesController;
use App\Http\Controllers\Web\Back\Admins\Settings\PaymentsController;
use App\Http\Controllers\Web\Back\Admins\Settings\FirewallsController;
use App\Http\Controllers\Web\Back\Admins\Settings\BackupAndUpdateController;
use App\Http\Controllers\Web\Back\Admins\Settings\SeoController;
use App\Http\Controllers\Web\Back\Admins\Users\UsersController;
use App\Http\Controllers\Web\Back\Admins\Statistics\VisitiorsController;
use App\Http\Controllers\Web\Back\Admins\Students\StudentsController;
use App\Http\Controllers\Web\Back\Admins\Tickets\TicketsController;
use App\Http\Controllers\Web\Back\Admins\Notes\NotesController;
use App\Http\Controllers\Web\Back\Admins\Subscribers\SubscribersController;
use App\Http\Controllers\Web\Back\Admins\Tasks\TasksController;
use App\Http\Controllers\Web\Back\Admins\Chats\ChatsController;
use App\Http\Controllers\Web\Back\Admins\Pages\Blogs\BlogCategoriesController;
use App\Http\Controllers\Web\Back\Admins\Pages\Blogs\BlogsController;
use App\Http\Controllers\Web\Back\Admins\Pages\Questions\QuestionsController;
use App\Http\Controllers\Web\Back\Admins\Pages\Contacts\ContactsController;
use App\Http\Controllers\Web\Back\Admins\Pages\Teams\TeamsController;
use App\Http\Controllers\Web\Back\Admins\Pages\PagesController;
use App\Http\Controllers\Web\Back\Admins\Emails\EmailsController;
use App\Http\Controllers\Web\Back\Admins\Admissions\AdmissionsController;
use App\Http\Controllers\Web\Back\Admins\Branches\BranchesController;
use App\Http\Controllers\Web\Back\Admins\Colleges\CollegesController;
use App\Http\Controllers\Web\Back\Admins\Courses\CoursesController;
use App\Http\Controllers\Web\Back\Admins\Registrations\RegistrationsController;
use App\Http\Controllers\Web\Back\Admins\Grades\GradesController;
use App\Http\Controllers\Web\Back\Admins\Invoices\InvoicesController;
use App\Http\Controllers\Web\Back\Admins\Statistics\MoneyStatisticsController;
use App\Http\Controllers\Web\Back\Admins\Quizzes\QuizzesController;
use App\Http\Controllers\Web\Back\Admins\Lectures\LecturesController;
use App\Http\Controllers\Web\Back\Admins\Lives\LivesController;

// ==================================================admin routes===============================================================================================================

    // --------------------------------------------------lectures-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/lectures')->controller(LecturesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.lectures');
        Route::post('/store', 'store')->name('dashboard.admins.lectures-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.lectures-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.lectures-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.lectures-delete');
    });
    // --------------------------------------------------lives-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/lives')->controller(LivesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.lives');
        Route::post('/store', 'store')->name('dashboard.admins.lives-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.lives-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.lives-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.lives-delete');
    });
    // --------------------------------------------------quizs-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/quizzes')->controller(QuizzesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.quizzes');
        Route::post('/store', 'store')->name('dashboard.admins.quizzes-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.quizzes-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.quizzes-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.quizzes-delete');
        Route::get('/{id}/questions', 'questions')->name('dashboard.admins.quizzes-questions');
        Route::post('/questions', 'storeQuestion')->name('dashboard.admins.quizzes.questions.store');
        Route::get('/questions/{id}/edit', 'editQuestion')->name('dashboard.admins.quizzes.questions.edit');
        Route::post('/questions/{id}/update', 'updateQuestion')->name('dashboard.admins.quizzes.questions.update');
        Route::get('/questions/{id}/delete', 'deleteQuestion')->name('dashboard.admins.quizzes.questions.delete');
        Route::get('/grade/{id}', 'grade')->name('dashboard.admins.quizzes-grade');
        Route::get('/get-attempt/{id}', 'getAttempt')->name('dashboard.admins.quizzes-get-attempt');
        Route::post('/update-grade', 'updateGrade')->name('dashboard.admins.quizzes-update-grade');
        Route::get('/statistics/{id}', 'statistics')->name('dashboard.admins.quizzes-statistics');
    });
    // --------------------------------------------------invoices-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/invoices')->controller(InvoicesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.invoices');
        Route::get('/show', 'show')->name('dashboard.admins.invoices-show');
        Route::get('/delete', 'delete')->name('dashboard.admins.invoices-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.invoices-deleteSelected');
    });
    // --------------------------------------------------grades-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/grades')->controller(GradesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.grades');
        Route::get('/show', 'show')->name('dashboard.admins.grades-show');
        Route::post('/upload', 'upload')->name('dashboard.admins.grades-upload');
        Route::get('/download-template', 'downloadTemplate')->name('dashboard.admins.grades-download-template');
    });
    // --------------------------------------------------registrations-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/registrations')->controller(RegistrationsController::class)->group(function () {
        Route::post('/store', 'store')->name('dashboard.admins.registrations-store');
        Route::get('/delete', 'delete')->name('dashboard.admins.registrations-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.registrations-deleteSelected');
        Route::get('/{student_id}', 'show')->name('dashboard.admins.registrations-show');
        Route::get('/available/{student_id}', 'availableCourses')->name('dashboard.admins.registrations-available');
    });
    // --------------------------------------------------courses-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/courses')->controller(CoursesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.courses');
        Route::get('/show', 'show')->name('dashboard.admins.courses-show');
        Route::post('/store', 'store')->name('dashboard.admins.courses-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.courses-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.courses-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.courses-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.courses-deleteSelected');
        Route::get('/staff', 'staff')->name('dashboard.admins.courses-staff');
        Route::post('/staff/add', 'addStaff')->name('dashboard.admins.courses-staff-add');
        Route::get('/staff/remove', 'removeStaff')->name('dashboard.admins.courses-staff-remove');
    });
    // --------------------------------------------------branches-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/branches')->controller(BranchesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.branches');
        Route::get('/show', 'show')->name('dashboard.admins.branches-show');
        Route::post('/store', 'store')->name('dashboard.admins.branches-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.branches-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.branches-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.branches-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.branches-deleteSelected');
    });
    // --------------------------------------------------colleges-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/colleges')->controller(CollegesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.colleges');
        Route::get('/show', 'show')->name('dashboard.admins.colleges-show');
        Route::post('/store', 'store')->name('dashboard.admins.colleges-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.colleges-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.colleges-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.colleges-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.colleges-deleteSelected');
    });
    // --------------------------------------------------admissions-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/admissions')->controller(AdmissionsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.admissions');
        Route::get('/show', 'show')->name('dashboard.admins.admissions-show');
        Route::post('/update', 'update')->name('dashboard.admins.admissions-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.admissions-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.admissions-deleteSelected');
    });
    // --------------------------------------------------emails-------------------------------------------------------------------------------------------------------------
    Route::prefix('admins/emails')->controller(EmailsController::class)->group(function () {
        Route::get('/{folder}', 'index')->name('dashboard.admins.emails');
        Route::get('/show', 'show')->name('dashboard.admins.emails-show');
        Route::post('/reply', 'sendReply')->name('dashboard.admins.emails-reply');
    });
    // =======================================================students==============================================================================================================
    Route::prefix('admins/students')->controller(StudentsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.students');
        Route::get('/search', 'search')->name('dashboard.admins.students-search');
        Route::get('/show', 'show')->name('dashboard.admins.students-show');
        Route::get('/add', 'add')->name('dashboard.admins.students-add');
        Route::post('/store', 'store')->name('dashboard.admins.students-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.students-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.students-update');
        Route::put('/updatepassword', 'updatepassword')->name('dashboard.admins.students-updatepassword');
        Route::get('/inactive', 'inactive')->name('dashboard.admins.students-inactive');
        Route::get('/active', 'active')->name('dashboard.admins.students-active');
        Route::get('/delete-inactive', 'deleteinactive')->name('dashboard.admins.students-delete-inactive');
        Route::get('/delete-all-inactive', 'deleteallinactive')->name('dashboard.admins.students-delete-allinactive');
        Route::get('/export', 'export')->name('dashboard.admins.students.export');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.students-delete-selected');
        Route::get('/import', 'import')->name('dashboard.admins.students-import-get');
        Route::post('/import', 'import')->name('dashboard.admins.students-import-post');
    });
    // =======================================================tickets==============================================================================================================
    Route::prefix('admins/tickets')->controller(TicketsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.tickets');
        Route::post('/store', 'store')->name('dashboard.admins.tickets-store');
        Route::get('/show', 'show')->name('dashboard.admins.tickets-show');
        Route::post('/reply', 'reply')->name('dashboard.admins.tickets-reply');
        Route::get('/close', 'close')->name('dashboard.admins.tickets-close');
        Route::get('/active', 'active')->name('dashboard.admins.tickets-active');
        Route::get('/delete', 'delete')->name('dashboard.admins.tickets-delete');
        Route::get('/deleteAll', 'deleteAll')->name('dashboard.admins.tickets-deleteAll');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.tickets-deleteSelected');
        Route::get('/get-new-messages', 'getNewMessages')->name('dashboard.admins.tickets-get-new-messages');
    });
    // =======================================================subscribers==============================================================================================================
    Route::prefix('admins/subscribers')->controller(SubscribersController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.subscribers');
        Route::post('/store', 'store')->name('dashboard.admins.subscribers-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.subscribers-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.subscribers-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.subscribers-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.subscribers-deleteSelected');
    });
    // =======================================================notes==============================================================================================================
    Route::prefix('admins/notes')->controller(NotesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.notes');
        Route::get('/show', 'show')->name('dashboard.admins.notes-show');
        Route::post('/store', 'store')->name('dashboard.admins.notes-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.notes-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.notes-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.notes-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.notes-deleteSelected');
        Route::get('/check', 'check')->name('dashboard.admins.notes-check');
    });
    // =======================================================blog==============================================================================================================
        Route::prefix('admins/blog/articles')->controller(BlogsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.blogs.articles');
            Route::get('/show', 'show')->name('dashboard.admins.blogs.articles-show');
            Route::post('/store', 'store')->name('dashboard.admins.blogs.articles-store');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.blogs.articles-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.blogs.articles-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.blogs.articles-auto-translate');
            Route::get('/edit', 'edit')->name('dashboard.admins.blogs.articles-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.blogs.articles-update');
            Route::get('/delete', 'delete')->name('dashboard.admins.blogs.articles-delete');
            Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.blogs.articles-deleteSelected');
            Route::get('/comments/delete', 'deleteComment')->name('dashboard.admins.blogs.comments-delete');
        });
        Route::prefix('admins/blog/categories')->controller(BlogCategoriesController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.blogs.categories');
            Route::post('/store', 'store')->name('dashboard.admins.blogs.categories-store');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.blogs.categories-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.blogs.categories-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.blogs.categories-auto-translate');
            Route::get('/edit', 'edit')->name('dashboard.admins.blogs.categories-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.blogs.categories-update');
            Route::get('/delete', 'delete')->name('dashboard.admins.blogs.categories-delete');
            Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.blogs.categories-deleteSelected');
        });
    // =======================================================pages==============================================================================================================
        Route::prefix('admins/pages')->controller(PagesController::class)->group(function () {
            Route::patch('/update', 'update')->name('dashboard.admins.pages-update');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.pages-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.pages-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.pages-auto-translate');
            Route::get('/{page}', 'index')->name('dashboard.admins.pages');
        });
        // --------------------------------------------------questions-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/questions')->controller(QuestionsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.questions');
            Route::post('/store', 'store')->name('dashboard.admins.questions-store');
            Route::get('/edit', 'edit')->name('dashboard.admins.questions-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.questions-update');
            Route::get('/delete', 'delete')->name('dashboard.admins.questions-delete');
            Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.questions-deleteSelected');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.questions-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.questions-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.questions-auto-translate');
        });
        // --------------------------------------------------teams-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/teams')->controller(TeamsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.teams');
            Route::post('/store', 'store')->name('dashboard.admins.teams-store');
            Route::get('/edit', 'edit')->name('dashboard.admins.teams-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.teams-update');
            Route::get('/delete', 'delete')->name('dashboard.admins.teams-delete');
        });
        // --------------------------------------------------Contact us-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/contact-us')->controller(ContactsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.contacts');
            Route::get('/show', 'show')->name('dashboard.admins.contacts-show');
            Route::get('/done', 'done')->name('dashboard.admins.contacts-done');
            Route::get('/delete', 'delete')->name('dashboard.admins.contacts-delete');
            Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.contacts-deleteSelected');
        });
    // =======================================================users==============================================================================================================
    Route::prefix('admins/users')->controller(UsersController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.users');
        Route::get('/show', 'show')->name('dashboard.admins.users-show');
        Route::get('/export', 'export')->name('dashboard.admins.users.export');
        Route::get('/add', 'add')->name('dashboard.admins.users-add');
        Route::post('/store', 'store')->name('dashboard.admins.users-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.users-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.users-update');
        Route::put('/updatepassword', 'updatepassword')->name('dashboard.admins.users-updatepassword');
        Route::get('/inactive', 'inactive')->name('dashboard.admins.users-inactive');
        Route::get('/active', 'active')->name('dashboard.admins.users-active');
        Route::get('/delete-inactive', 'deleteinactive')->name('dashboard.admins.users-delete-inactive');
        Route::get('/delete-all-inactive', 'deleteallinactive')->name('dashboard.admins.users-delete-allinactive');
        Route::post('/role', 'role')->name('dashboard.admins.users-role');
        Route::post('/roledelete', 'roledelete')->name('dashboard.admins.users-roledelete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.users-delete-selected');
        Route::get('/import', 'import')->name('dashboard.admins.users-import-get');
        Route::post('/import', 'import')->name('dashboard.admins.users-import-post');
    });
    // =======================================================tasks==============================================================================================================
    Route::prefix('admins/tasks')->controller(TasksController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.tasks');
        Route::post('/store', 'store')->name('dashboard.admins.tasks-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.tasks-edit');
        Route::patch('/update', 'update')->name('dashboard.admins.tasks-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.tasks-delete');
        Route::get('/delete-selected', 'deleteSelected')->name('dashboard.admins.tasks-delete-selected');
        Route::post('/update-status', 'updateStatus')->name('dashboard.admins.tasks-update-status');
        Route::post('/check-overdue', 'checkOverdueTasks')->name('dashboard.admins.tasks-check-overdue');
        Route::get('/calendar', 'calendar')->name('dashboard.admins.tasks-calendar');
    });
    // =======================================================chats==============================================================================================================
    Route::prefix('admins/chats')->controller(ChatsController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.chats');
        Route::get('/show', 'show')->name('dashboard.admins.chats.show');
        Route::post('/store', 'store')->name('dashboard.admins.chats.store');
        Route::post('/send-message', 'sendMessage')->name('dashboard.admins.chats.send-message');
        Route::post('/add-users-to-group', 'addUsersToGroup')->name('dashboard.admins.chats.add-users-to-group');
        Route::post('/remove-user-from-group', 'removeUserFromGroup')->name('dashboard.admins.chats.remove-user-from-group');
        Route::get('/leave-group', 'leaveGroup')->name('dashboard.admins.chats.leave-group');
        Route::get('/get-new-messages', 'getNewMessages')->name('dashboard.admins.chats.get-new-messages');
        Route::get('/search-users', 'searchUsers')->name('dashboard.admins.chats.search-users');
        Route::get('/check-read-status', 'checkReadStatus')->name('dashboard.admins.chats.check-read-status');
    });
    // =======================================================roles & permitions==============================================================================================================
    Route::prefix('admins/roles')->controller(RolesController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.admins.roles');
        Route::post('/store', 'store')->name('dashboard.admins.roles-store');
        Route::get('/edit', 'edit')->name('dashboard.admins.roles-edit');
        Route::post('/update', 'update')->name('dashboard.admins.roles-update');
        Route::get('/delete', 'delete')->name('dashboard.admins.roles-delete');
    });
    // =======================================================statistics==============================================================================================================
    Route::prefix('admins/statistics')->controller(VisitiorsController::class)->group(function () {
        Route::get('/visitors', 'visitors')->name('dashboard.admins.statistics-visitors');
        Route::post('/visitors/status', 'visitorsStatus')->name('dashboard.admins.statistics-visitors-status');
        Route::get('/google', 'google')->name('dashboard.admins.statistics-google');
        Route::post('/google/status', 'googleStatus')->name('dashboard.admins.statistics-google-status');
    });
    Route::prefix('admins/statistics')->controller(MoneyStatisticsController::class)->group(function () {
        Route::get('/money', 'index')->name('dashboard.admins.statistics-money');
    });
    // =======================================================Settings===============================================================================================================
        Route::prefix('admins/settings')->controller(SettingsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.settings');
            Route::post('/update', 'update')->name('dashboard.admins.settings-update');
            Route::post('/clear-cache', 'clearCache')->name('dashboard.admins.clear-cache');
            Route::post('/reset', 'reset')->name('dashboard.admins.settings-reset');
        });
        // --------------------------------------------------languages-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/languages')->controller(LanguagesController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.languages');
            Route::get('/status', 'status')->name('dashboard.admins.languages-status');
            Route::get('/translate', 'translate')->name('dashboard.admins.languages-translate');
            Route::post('/translate/store', 'translateStore')->name('dashboard.admins.languages-translate-store');
            Route::get('/delete', 'delete')->name('dashboard.admins.languages-delete');
        });
        // --------------------------------------------------seo-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/seo')->controller(SeoController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.seo');
            Route::get('/show', 'show')->name('dashboard.admins.seo-show');
            Route::get('/edit', 'edit')->name('dashboard.admins.seo-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.seo-update');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.seo-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.seo-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.seo-auto-translate');
        });
        // --------------------------------------------------currencies-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/currencies')->controller(CurrenciesController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.currencies');
            Route::get('/exchange', 'exchange')->name('dashboard.admins.currencies-exchange');
            Route::get('/status', 'status')->name('dashboard.admins.currencies-status');
            Route::get('/edit', 'edit')->name('dashboard.admins.currencies-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.currencies-update');
            Route::get('/delete', 'delete')->name('dashboard.admins.currencies-delete');
        });
        // --------------------------------------------------payments-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/payments')->controller(PaymentsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.payments');
            Route::post('/update', 'update')->name('dashboard.admins.payments-update');
            Route::post('/translate', 'translate')->name('dashboard.admins.payments-translate');
        });
        // --------------------------------------------------taxes-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/taxes')->controller(TaxesController::class)->group(function () {
            Route::get('/', 'index')->name(name: 'dashboard.admins.taxes');
            Route::post('/store', 'store')->name('dashboard.admins.taxes-store');
            Route::get('/edit', 'edit')->name('dashboard.admins.taxes-edit');
            Route::patch('/update', 'update')->name('dashboard.admins.taxes-update');
            Route::get('/get-translations', 'getTranslations')->name('dashboard.admins.taxes-get-translations');
            Route::patch('/translate', 'translate')->name('dashboard.admins.taxes-translate');
            Route::get('/auto-translate', 'autoTranslate')->name('dashboard.admins.taxes-auto-translate');
            Route::get('/delete', 'delete')->name('dashboard.admins.taxes-delete');
        });
        // --------------------------------------------------firewalls-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/firewalls')->controller(FirewallsController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.admins.firewalls');
            Route::post('/store', 'store')->name('dashboard.admins.firewalls-store');
            Route::get('/delete', 'delete')->name('dashboard.admins.firewalls-delete');
        });
        // --------------------------------------------------backup&update-------------------------------------------------------------------------------------------------------------
        Route::prefix('admins/settings/backup')->controller(BackupAndUpdateController::class)->group(function () {
            Route::get('/take', 'take')->name('dashboard.admins.backup-take');
            Route::get('/delete', 'delete')->name('dashboard.admins.backup-delete');
        });
        Route::prefix('admins/settings/update')->controller(BackupAndUpdateController::class)->group(function () {
            Route::get('/check', 'checkUpdate')->name('dashboard.admins.update-check');
            Route::get('/run', 'runUpdate')->name('dashboard.admins.update-run');
        });


