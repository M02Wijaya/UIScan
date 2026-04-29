<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@uiscan.id'], // Cek apakah email ini sudah ada
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // Password admin
                'role' => 'admin', // Role diset sebagai admin
                'balance' => 0
            ]
        );
    }
}