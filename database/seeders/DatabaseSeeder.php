<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@uiscan.id',
            'password' => Hash::make('admin111'),
            'role' => 'admin',
        ]);


        Wallet::create([
            'user_id' => $admin->id,
            'balance' => 0,
        ]);


        $user = User::create([
            'name' => 'User UIScan',
            'email' => 'useruiscan@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user', 
        ]);


        Wallet::create([
            'user_id' => $user->id,
            'balance' => 100000, 
        ]);
        
    }
}