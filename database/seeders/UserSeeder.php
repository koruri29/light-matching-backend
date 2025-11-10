<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '依頼者1',
            'email' => 'client1@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => '2025-11-09 13:20:38',
            'role' => UserRoles::CLIENT->value,
        ]);
        User::create([
            'name' => '応募者1',
            'email' => 'worker1@example.com',
            'password' => Hash::make('password'),
            'role' => UserRoles::WORKER->value,
        ]);
    }
}
