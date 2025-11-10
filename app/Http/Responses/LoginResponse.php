<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'ログイン成功',
            'user' => $request->user(),
        ]);
    }
}
