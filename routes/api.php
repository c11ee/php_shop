<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 🔐 需要认证 + 限流的路由
Route::prefix('auth')
    ->middleware(['auth:sanctum', 'throttle:api'])
    ->group(function () {
        // 获取当前用户
        Route::get('user', function (Request $request) {
            return $request->user();
        });

        // 退出登录
        Route::get('logout', [UserController::class, 'logout']);
    });

// 🌐 公共接口（不需要认证，只限流）
Route::prefix('auth')
    ->middleware('throttle:api')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
