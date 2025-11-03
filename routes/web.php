<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Job\JobController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::post('/login', [AuthController::class, 'login']);

// 認証済み&メール確認済みのルート
// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
Route::middleware([
    HandleCors::class,
    'web',
    'auth:sanctum',
    'verified',
])->group(function () {
    Route::post('/post', [JobController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/jobs', [JobController::class, 'getJobSummary']);
});

Route::post('/force-logout', function () {
    return response()->json(['message' => 'force logout'])
        ->withoutCookie('access_token')
        ->withoutCookie('laravel_session')
        ->withoutCookie('XSRF-TOKEN');
});
