<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $existingAdmin = User::where('role', 'admin')->first();

        if (!$existingAdmin) {
            // Buat akun admin default
            User::create([
                'full_name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@webrenangku.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin account created successfully!');
            $this->command->info('Email: admin@webrenangku.com');
            $this->command->info('Password: password123');
            $this->command->warn('Please change the default password after login!');
        } else {
            $this->command->info('Admin account already exists.');
        }

        // Opsional: Buat beberapa admin tambahan
        $additionalAdmins = [
            [
                'full_name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@webrenangku.com',
                'password' => Hash::make('superadmin123'),
            ],
        ];

        foreach ($additionalAdmins as $adminData) {
            $existing = User::where('email', $adminData['email'])->first();

            if (!$existing) {
                User::create([
                    'full_name' => $adminData['full_name'],
                    'username' => $adminData['username'],
                    'email' => $adminData['email'],
                    'password' => $adminData['password'],
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                $this->command->info("✅ Additional admin '{$adminData['full_name']}' created!");
            }
        }
    }
}
