<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\UserType;
use App\UserStatus;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'type' => UserType::SuperAdmin,
            'status' => UserStatus::Active,
        ]);
    }
}
