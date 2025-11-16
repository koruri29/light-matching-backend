<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\UseCases\Auth\RegisterUserAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action)
    {
        try {
            $action->execute($request->validated());
            return response()->json(['data' => [
                'success' => true,
                'message' => 'ユーザー登録に成功しました'
            ]], 201);
        } catch (\Exception $e) {
            Log::error('ユーザー登録中にエラーが発生しました。', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['data' => [
                'success' => false,
                'message' => $e->getMessage()
            ]], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, true)) {
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが正しくありません。'
            ], 401);
        }

        $request->session()->regenerate();
        $user = $request->user();
        $token = $user->createToken('spa')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'ログイン成功',
            'user' => $user,
            'access_token' => $token,
        ], 200)
            ->cookie(
                'access_token',                // クッキー名
                $token,                        // 値
                60*24,                         // 有効期限（分）
                '/',                           // パス
                null,                          // ドメイン（nullなら同一オリジン）
                env("SESSION_SECURE_COOKIE"),  // secure（https限定）
                true,                          // httpOnly
                false,                         // raw
                env("SESSION_SAME_SITE")       // sameSite
            );
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out'])
            ->withCookie(Cookie::forget('laravel_session'))
            ->withCookie(Cookie::forget('XSRF-TOKEN'));
    }
}
