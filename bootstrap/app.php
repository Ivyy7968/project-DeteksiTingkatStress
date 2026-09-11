<?php

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
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if (str_starts_with($request->path(), 'admin')) {
                return route('login.admin');
            }
            return route('login.siswa');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();