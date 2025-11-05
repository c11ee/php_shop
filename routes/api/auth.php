<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->controller(UserController::class)->group(function () {
    // Route::get('user', 'user');
    // Route::get('logout', 'logout');
    Route::post('register', 'register');
    // Route::post('login', 'login');

    Route::get('test', function () {
        return 666;
    });
});
