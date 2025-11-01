<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler
{
    /**
     * 認証エラー時のレスポンスをカスタマイズ
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // APIリクエスト時にはJSONレスポンスで401を返す
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
