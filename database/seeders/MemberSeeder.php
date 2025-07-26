<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MemberProfile;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data member sample
        $members = [
            [
                'full_name' => 'Budi Santoso',
                'username' => 'budi_santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('member123'),
                'profile' => [
                    'date_of_birth' => '1995-05-15',
                    'phone' => '08211112222',
                    'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                    'emergency_contact_name' => 'Siti Santoso (Istri)',
                    'emergency_contact_phone' => '08223334444',
                    'membership_status' => 'active',
                    'joined_at' => '2024-01-15',
                    'medical_notes' => 'Tidak ada riwayat penyakit serius. Alergi seafood.',
                ]
            ],
            [
                'full_name' => 'Dewi Lestari',
                'username' => 'dewi_lestari',
                'email' => 'dewi@gmail.com',
                'password' => Hash::make('member123'),
                'profile' => [
                    'date_of_birth' => '1988-12-03',
                    'phone' => '08235556666',
                    'address' => 'Jl. Sudirman No. 456, Jakarta Selatan',
                    'emergency_contact_name' => 'Ahmad Lestari (Suami)',
                    'emergency_contact_phone' => '08247778888',
                    'membership_status' => 'active',
                    'joined_at' => '2024-02-20',
                    'medical_notes' => 'Sedang dalam program rehabilitasi cedera lutut.',
                ]
            ],
            [
                'full_name' => 'Rina Wati',
                'username' => 'rina_wati',
                'email' => 'rina@yahoo.com',
                'password' => Hash::make('member123'),
                'profile' => [
                    'date_of_birth' => '2000-08-22',
                    'phone' => '08259990000',
                    'address' => 'Jl. Gatot Subroto No. 789, Jakarta Barat',
                    'emergency_contact_name' => 'Ibu Sari (Ibu)',
                    'emergency_contact_phone' => '08261113333',
                    'membership_status' => 'active',
                    'joined_at' => '2024-03-10',
                    'medical_notes' => 'Sehat. Rutin check-up bulanan.',
                ]
            ],
            [
                'full_name' => 'Joko Widodo',
                'username' => 'joko_wid',
                'email' => 'joko@outlook.com',
                'password' => Hash::make('member123'),
                'profile' => [
                    'date_of_birth' => '1992-11-07',
                    'phone' => '08274445555',
                    'address' => 'Jl. Thamrin No. 321, Jakarta Timur',
                    'emergency_contact_name' => 'Maya Widodo (Istri)',
                    'emergency_contact_phone' => '08286667777',
                    'membership_status' => 'pending',
                    'joined_at' => '2024-07-20',
                    'medical_notes' => 'Pemula dalam renang. Takut air dalam.',
                ]
            ],
            [
                'full_name' => 'Lisa Permata',
                'username' => 'lisa_permata',
                'email' => 'lisa@gmail.com',
                'password' => Hash::make('member123'),
                'profile' => [
                    'date_of_birth' => '1985-04-18',
                    'phone' => '08298889999',
                    'address' => 'Jl. Kemang No. 654, Jakarta Selatan',
                    'emergency_contact_name' => 'David Permata (Suami)',
                    'emergency_contact_phone' => '08301112222',
                    'membership_status' => 'active',
                    'joined_at' => '2023-12-01',
                    'medical_notes' => 'Atlet renang amatir. Kondisi fisik sangat baik.',
                ]
            ]
        ];

        foreach ($members as $memberData) {
            // Cek apakah member sudah ada
            $existingMember = User::where('email', $memberData['email'])->first();

            if (!$existingMember) {
                // Buat user member
                $member = User::create([
                    'full_name' => $memberData['full_name'],
                    'username' => $memberData['username'],
                    'email' => $memberData['email'],
                    'password' => $memberData['password'],
                    'role' => 'member',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                // Buat member profile
                MemberProfile::create([
                    'user_id' => $member->id,
                    'date_of_birth' => $memberData['profile']['date_of_birth'],
                    'phone' => $memberData['profile']['phone'],
                    'address' => $memberData['profile']['address'],
                    'emergency_contact_name' => $memberData['profile']['emergency_contact_name'],
                    'emergency_contact_phone' => $memberData['profile']['emergency_contact_phone'],
                    'membership_status' => $memberData['profile']['membership_status'],
                    'joined_at' => $memberData['profile']['joined_at'],
                    'medical_notes' => $memberData['profile']['medical_notes'],
                ]);

                $this->command->info("✅ Member '{$memberData['full_name']}' berhasil dibuat!");
            } else {
                $this->command->info("ℹ️  Member '{$memberData['full_name']}' sudah ada.");
            }
        }

        $this->command->info('🎯 Seeder Member selesai!');
        $this->command->info('📧 Email/Password: [nama]@[provider].com / member123');
    }
}
