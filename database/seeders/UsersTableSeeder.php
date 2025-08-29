<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@azamfc.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@azamfc.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
        }

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@example.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create($user);
            }
        }
    }
}
