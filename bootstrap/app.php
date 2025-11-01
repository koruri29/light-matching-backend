<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🔵 最優先でCORSを通す
        $middleware->prepend(HandleCors::class);

        // 🔒 Sanctumのstateful認証
        $middleware->statefulApi();

        // 🎯 ミドルウェアのエイリアス定義
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
        ]);

        // 🔄 APIルートのミドルウェアグループ
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            HandleCors::class
        ]);

        // 🌐 Webルートのミドルウェアグループ
        $middleware->group('web', [
            EnsureFrontendRequestsAreStateful::class,
            HandleCors::class
        ]);

        $middleware->priority([
            HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'http://localhost:3000/*'
        ]);
    })->create();
