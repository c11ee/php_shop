<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // 统一配置路由：自动加载并设置前缀
            loadApiRoutes('api');
            loadApiRoutes('admin');
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckAbilities::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            // 捕获错误
        });
    })->create();

/**
 * 自动加载指定目录下的所有路由文件
 * 根据文件路径自动设置前缀
 */
function loadApiRoutes(string $prefix)
{
    $apiRoutesDir = base_path("routes/{$prefix}");

    if (is_dir($apiRoutesDir)) {
        $files = glob($apiRoutesDir . '/*.php');

        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $prefix = "{$prefix}/{$filename}";
            $namePrefix = "{$filename}.";

            Route::middleware('api')
                ->prefix($prefix)
                ->name($namePrefix)
                ->group($file);
        }
    }
}
