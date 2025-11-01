<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Job\JobPostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ユーザー登録
Route::middleware(['web', 'guest'])->post('/register', [AuthController::class, 'register']);


// 認証メールのリンクを処理
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::findOrFail($request->id);

    if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => '無効な認証リンクです'], 400);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'すでに認証済みです'], 200);
    }

    $user->markEmailAsVerified();

    return redirect('http://localhost:3000/verified');
})->name('verification.verify');

// 再送処理
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'すでに認証済みです']);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => '認証メールを送信しました']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');


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
