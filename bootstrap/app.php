<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CurrencyMiddleware;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\LimitUserSessions;
use Illuminate\Routing\Middleware\ThrottleRequests;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'kashier-webhook' // <-- exclude this route
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            ThrottleRequests::class.':60,1',
            MaintenanceMode::class,
            CurrencyMiddleware::class,
            LimitUserSessions::class,
        ]);

        $middleware->alias([
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
        ]);
        // $middleware->append(MaintenanceMode::class);
        // $middleware->append(CurrencyMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
