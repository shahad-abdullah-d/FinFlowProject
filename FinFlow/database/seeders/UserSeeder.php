<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'employee@finflow.com'],
            [
                'name' => 'FinFlow Employee',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'approved',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@finflow.com'],
            [
                'name' => 'FinFlow Manager',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'approved',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@finflow.com'],
            [
                'name' => 'FinFlow Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}