<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ユーザー登録
Route::middleware(['web', 'guest'])->post('/register', [AuthController::class, 'register']);


// トークン作成・返却
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});


// パスワードリセットのルート
// TODO: URLをNextのURLに変更
Route::get('/reset-password/{token}', function ($token) {
    return redirect()->away("https://your-nextjs-app.com/reset-password?token=$token");
})->name('password.reset');


// ユーザー認証
Route::middleware(['web', 'auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// 開発中のみON
// プリフライトを受け付ける
Route::options('{any}', function () {
    return response()->noContent();
})->where('any', '.*');


// 強制ログアウト
Route::post('/force-logout', function () {
    return response()->json(['message' => 'force logout'])
        ->withoutCookie('access_token')
        ->withoutCookie('laravel_session')
        ->withoutCookie('XSRF-TOKEN');
});
