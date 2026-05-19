<?php

// Fix for Railway deployment: prevent empty environment cache variables from resolving to the base path.
// This prevents the "require(/app): Failed to open stream" error.
foreach (['APP_CONFIG_CACHE', 'APP_EVENTS_CACHE', 'APP_PACKAGES_CACHE', 'APP_ROUTES_CACHE', 'APP_SERVICES_CACHE'] as $__key) {
    if (isset($_ENV[$__key]) && $_ENV[$__key] === '') unset($_ENV[$__key]);
    if (isset($_SERVER[$__key]) && $_SERVER[$__key] === '') unset($_SERVER[$__key]);
    if (getenv($__key) === '') putenv($__key);
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLanguage::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();