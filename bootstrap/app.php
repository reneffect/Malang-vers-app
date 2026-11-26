<?php

use App\Http\Middleware\CheckEbookAccess;
use App\Http\Middleware\CheckSubscriptionExpiry;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsMember;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias
        $middleware->alias([
            'admin'              => EnsureUserIsAdmin::class,
            'member'             => EnsureUserIsMember::class,
            'check.ebook'        => CheckEbookAccess::class,
            'subscription.expiry' => CheckSubscriptionExpiry::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
