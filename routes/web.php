<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Job\JobController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
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

Route::middleware([
    HandleCors::class,
    'web',
    'auth:sanctum',
])->group(function () {
    Route::get('/job-counts', [JobController::class, 'getJobPostCountsByDate']);
    Route::get('/jobs', [JobController::class, 'getJobs']);
});


use Illuminate\Support\Facades\Log;

Route::get('/debug-proxy', function (Request $request) {
    return response()->json([
        // リクエスト情報
        'is_secure' => $request->isSecure(),
        'scheme' => $request->getScheme(),
        'host' => $request->getHost(),
        'url' => $request->url(),

        // プロキシヘッダー
        'x_forwarded_proto' => $request->header('X-Forwarded-Proto'),
        'x_forwarded_for' => $request->header('X-Forwarded-For'),
        'x_forwarded_host' => $request->header('X-Forwarded-Host'),
        'x_forwarded_port' => $request->header('X-Forwarded-Port'),

        // 設定値
        'app_url' => config('app.url'),
        'session_secure' => config('session.secure'),
        'session_domain' => config('session.domain'),
        'session_same_site' => config('session.same_site'),

        // サーバー変数
        'server_https' => $request->server('HTTPS'),
        'server_port' => $request->server('SERVER_PORT'),

        'session_id' => $request->session()->getId(),
        'session_data' => $request->session()->all(),
        'cookies' => $request->cookies->all(),
        'has_laravel_session' => $request->hasCookie('laravel_session'),
    ]);
});
