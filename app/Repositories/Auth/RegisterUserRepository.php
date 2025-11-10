<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\RegisterUserRepositoryInterface;

class RegisterUserRepository implements RegisterUserRepositoryInterface
{
    public function create(array $data)
    {
        return User::Create($data);
    }
}
