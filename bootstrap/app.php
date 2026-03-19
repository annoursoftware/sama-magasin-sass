<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DevMiddleware;
use App\Http\Middleware\EmployeMiddleware;
use App\Http\Middleware\EntrepreneurMiddleware;
use App\Http\Middleware\EnsureMFAIsVerified;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'dev' => DevMiddleware::class,
            'admin' => AdminMiddleware::class,
            'entrepreneur' => EntrepreneurMiddleware::class,
            'employe' => EmployeMiddleware::class,
            'mfa.verified' => EnsureMFAIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
