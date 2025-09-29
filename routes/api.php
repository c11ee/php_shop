<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserController::class)->prefix('/auth')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    // 需要验证 token
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});
