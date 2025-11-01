<?php

namespace App\UseCases\Auth;

use App\Models\User;
use App\Repositories\Auth\RegisterUserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(private RegisterUserRepositoryInterface $users) {}

    public function execute(array $data): User
    {
        try {
            $user = $this->users->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            event(new Registered($user)); // イベント発火

            return $user;
        } catch (\Exception $e) {
            throw new \Exception('User registration failed: ' . $e->getMessage());
        }
    }
}
