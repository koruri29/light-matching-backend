<?php

namespace App\Repositories\Auth;

interface RegisterUserRepositoryInterface
{
    public function create(array $data);
}
