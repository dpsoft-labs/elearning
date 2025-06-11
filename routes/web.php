<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Web\Back\NotificationController;
use App\Http\Controllers\Web\Front\FrontController;
use App\Http\Controllers\Web\Back\HomeController;
use App\Http\Controllers\Web\Back\ProfileController;
use App\Http\Controllers\Web\TestController;
use App\Http\Middleware\EnhancedVisitorTracker;


use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Http;

Route::get('/test', [TestController::class, 'index'])->name('test');
Route::get('test2', function () {

    $message = 'ما هي المدينة التي تقع في المغرب؟';
    $context = json_decode('[]', true);

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyCVoxgBTlZACBES2I9W8CLQRDbNEYudBXg';

    // Build conversation history
    $contents = [];

    // Add previous conversation context if available
    if (!empty($context)) {
        foreach ($context as $exchange) {
            if (isset($exchange[0]) && isset($exchange[1])) {
                $contents[] = [
                    'role' => 'user',
                    'parts' => [['text' => $exchange[0]]]
                ];
                $contents[] = [
                    'role' => 'model',
                    'parts' => [['text' => $exchange[1]]]
                ];
            }
        }
    }

    // Add current message
    $contents[] = [
        'role' => 'user',
        'parts' => [['text' => $message]]
    ];

    $data = [
        'contents' => $contents
    ];

    try {
        $response = Http::post($url, $data);
        $complete = json_decode($response->body());
        dd($complete);
    } catch (\Exception $e) {
        dd($e);
    }
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'firewall.ip']
    ],
    function () {
        Route::middleware([EnhancedVisitorTracker::class])->group(function () {

            Route::controller(FrontController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/about', 'about')->name('about');
                Route::get('/blog', 'blog')->name('blog');
                Route::get('/blog/{slug}', 'blogDetails')->name('blog.show'); // don't change this route name because it's used in the notification system
                Route::post('/blog/reply', 'blogReply')->name('blog.reply');
                Route::get('/team', 'team')->name('team');
                Route::get('/faqs', 'faqs')->name('faqs');
                Route::get('/contact-us', 'contact')->name('contact');
                Route::post('/contact-us', 'contactStore')->name('contact.store');
                Route::get('/terms', 'terms')->name('terms');
                Route::get('/privacy', 'privacy')->name('privacy');
                Route::post('/subscribe', 'subscribe')->name('subscribe');
                Route::get('/unsubscribe/{token}', 'unsubscribe')->name('unsubscribe'); // don't change this route name because it's used in the notification system
                Route::get('/payments/verify/{payment?}', 'verify')->name('verify-payment');
                Route::post('/kashier-webhook', 'kashierWebhook')->name('kashier-webhook');
                Route::get('/admission', 'admission')->name('admission');
                Route::post('/admission', 'admissionStore')->name('admission.store');
                Route::get('/admission/show', 'admissionShow')->name('admission.show');
            });
        });
        //======================================================Dashboard=========================================================

        $middleware = ['auth'];
        $settings = app('view')->shared('settings');
        $emailVerified = $settings['emailVerified'] ?? false;

        if ($emailVerified) {
            $middleware[] = 'verified';
        }

        Route::group(['middleware' => $middleware], function () {
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            // ----------------------------------------------notification routes-------------------------------------------------------------------------------------------------------------
            Route::prefix('/notification')->controller(NotificationController::class)->group(function () {
                Route::get('/show', 'show')->name('dashboard.notification-show');
                Route::get('/delete', 'delete')->name('dashboard.notification-delete');
                Route::get('/deleteall', 'deleteall')->name('dashboard.notification-deleteAll');
                Route::get('/markall', 'markall')->name('dashboard.notification-markAll');
                Route::get('/sse', 'sse')->name('dashboard.notification-sse');
            });
            // -----------------------------------------------profile routes-------------------------------------------------------------------------------------------------------------
            Route::prefix('/profile')->controller(ProfileController::class)->group(function () {
                Route::get('/', 'index')->name('dashboard.profile');
                Route::patch('/update', 'update')->name('dashboard.profile-update');
                Route::post('/photo', 'uploadPhoto')->name('dashboard.profile-uploadPhoto');
                Route::put('/password', 'updatePassword')->name('dashboard.profile-updatePassword');
                Route::delete('/delete', 'delete')->name('dashboard.profile-delete');
                Route::post('/apiCreate', 'apiCreate')->name('dashboard.profile-apiCreate');
                Route::get('/apiDelete', 'apiDelete')->name('dashboard.profile-apiDelete');
                Route::get('/2fa', 'show2faForm')->name('profile.2fa.form');
                Route::post('/2fa/enable', 'enable2fa')->name('profile.2fa.enable');
                Route::post('/2fa/disable', 'disable2fa')->name('profile.2fa.disable');
            });

            require __DIR__ . '/web/users.php';
            require __DIR__ . '/web/admins.php';
        });

        Route::impersonate();

        require __DIR__.'/web/auth.php';
    }
);
