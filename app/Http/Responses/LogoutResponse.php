
<?php

namespace App\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        // APIトークン削除
        if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
            $request->user()->currentAccessToken()?->delete();
        }

        // Laravelセッション破棄
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // クッキーをまとめて削除
        return response()->json([
            'success' => true,
            'message' => 'ログアウトしました'
        ])
        ->cookie(cookie()->forget('laravel_session', '/', config('session.domain')))
        ->cookie(cookie()->forget('XSRF-TOKEN'))
        ->cookie(cookie()->forget('access_token'));
    }
}
