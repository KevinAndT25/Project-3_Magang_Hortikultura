<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com', // bisa diubah
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'no_hp' => '08123456789',
        ]);
    }
}