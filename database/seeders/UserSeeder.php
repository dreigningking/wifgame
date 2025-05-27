<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'surname' => 'Admin',
            'firstname' => 'Super',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('supersecure123'), // Make sure this is hashed!
            'country' => 'Nigeria',
            'language' => 'en',
            'role' => 'superadmin',
        ]);
    }
}
