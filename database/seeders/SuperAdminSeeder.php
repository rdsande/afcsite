<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default super admin user
        User::updateOrCreate(
            ['email' => 'admin@azamfc.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@azamfc.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        // Create a test admin user
        User::updateOrCreate(
            ['email' => 'testadmin@azamfc.com'],
            [
                'name' => 'Test Admin',
                'email' => 'testadmin@azamfc.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        // Create a test editor user
        User::updateOrCreate(
            ['email' => 'editor@azamfc.com'],
            [
                'name' => 'Test Editor',
                'email' => 'editor@azamfc.com',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Super admin and test users created successfully!');
        $this->command->info('Super Admin: admin@azamfc.com / password123');
        $this->command->info('Test Admin: testadmin@azamfc.com / password123');
        $this->command->info('Test Editor: editor@azamfc.com / password123');
    }
}
