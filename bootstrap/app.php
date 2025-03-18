<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RedirectWwwToNonWww;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(RedirectWwwToNonWww::class);
        $middleware->append(ThrottleRequests::class . ':global');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
