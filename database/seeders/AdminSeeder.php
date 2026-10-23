<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $username = env('ADMIN_USERNAME', 'admin');
        $password = env('ADMIN_PASSWORD', 'GantiPassword123');

        $admin = User::firstOrNew(['username' => $username]);
        $admin->forceFill([
            'name'     => 'Administrator',
            'email'    => $admin->email ?: 'admin@smkhanjuang.local',
            'password' => Hash::make($password),
        ])->save();
    }
}