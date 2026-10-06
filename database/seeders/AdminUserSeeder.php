<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gym Admin',
            'email' => 'admin@gym.com',
            'password' => Hash::make('admin123'),  // Password hashed hona chahiye
            'role' => 'admin',
        ]);
    }
}
