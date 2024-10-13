<?php

use App\Http\Middleware\AuthorizationExceptionHandler;
use App\Http\Middleware\UserRoleMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: '/api/e10/v1',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user.role' => UserRoleMiddleware::class,
            // 'auth.exception' => AuthorizationExceptionHandler::class,
        ]);
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(function ($request, Throwable $exception) {
        //     if ($exception instanceof ModelNotFoundException) {
        //         return response()->json([
        //             'success' => false,
        //             'error' => [
        //                 'code' => 404,
        //                 'message' => 'Resource not found',
        //             ],
        //         ], 404);
        //     }
    
        //     return response()->json([
        //         'success' => false,
        //         'error' => [
        //             'code' => $exception->getCode(),
        //             'message' => $exception->getMessage(),
        //         ],
        //     ], $exception?->getStatusCode() ?: 500);
        // });
    })->create();
