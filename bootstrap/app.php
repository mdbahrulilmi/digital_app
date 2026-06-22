<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: [
        'midtrans/webhook',
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'already_admin' => \App\Http\Middleware\RedirectAdmin::class,
            'already_member' => \App\Http\Middleware\RedirectMember::class,
    ]);

    $middleware->redirectTo('/login');
    
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
