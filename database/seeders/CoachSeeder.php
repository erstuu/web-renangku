<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CoachProfile;
use Illuminate\Support\Facades\Hash;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data coach sample
        $coaches = [
            [
                'full_name' => 'Muhammad Rizki',
                'username' => 'coach_rizki',
                'email' => 'rizki@webrenangku.com',
                'password' => Hash::make('coach123'),
                'profile' => [
                    'specialization' => 'Gaya Bebas & Kupu-kupu',
                    'bio' => 'Pelatih renang profesional dengan pengalaman 8 tahun. Spesialis dalam teknik gaya bebas dan kupu-kupu untuk semua tingkat.',
                    'contact_info' => '08123456789',
                    'certification' => 'Lisensi Pelatih Renang Nasional, WSI (Water Safety Instructor)',
                    'experience_years' => 8,
                    'hourly_rate' => 150000.00,
                ]
            ],
            [
                'full_name' => 'Sari Dewi Putri',
                'username' => 'coach_sari',
                'email' => 'sari@webrenangku.com',
                'password' => Hash::make('coach123'),
                'profile' => [
                    'specialization' => 'Gaya Dada & Gaya Punggung',
                    'bio' => 'Mantan atlet renang nasional. Fokus pada pelatihan teknik dasar dan persiapan kompetisi untuk anak-anak dan remaja.',
                    'contact_info' => '08139876543',
                    'certification' => 'Lisensi Pelatih Renang Profesional, First Aid & CPR',
                    'experience_years' => 12,
                    'hourly_rate' => 200000.00,
                ]
            ],
            [
                'full_name' => 'Andi Setiawan',
                'username' => 'coach_andi',
                'email' => 'andi@webrenangku.com',
                'password' => Hash::make('coach123'),
                'profile' => [
                    'specialization' => 'Renang untuk Pemula & Terapi Air',
                    'bio' => 'Spesialis dalam mengajarkan renang untuk pemula dewasa dan anak-anak. Berpengalaman dalam terapi air untuk rehabilitasi.',
                    'contact_info' => '08145557777',
                    'certification' => 'Certified Swim Instructor, Aquatic Therapy Specialist',
                    'experience_years' => 6,
                    'hourly_rate' => 120000.00,
                ]
            ]
        ];

        foreach ($coaches as $coachData) {
            // Cek apakah coach sudah ada
            $existingCoach = User::where('email', $coachData['email'])->first();

            if (!$existingCoach) {
                // Buat user coach
                $coach = User::create([
                    'full_name' => $coachData['full_name'],
                    'username' => $coachData['username'],
                    'email' => $coachData['email'],
                    'password' => $coachData['password'],
                    'role' => 'coach',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);

                // Buat coach profile
                CoachProfile::create([
                    'user_id' => $coach->id,
                    'specialization' => $coachData['profile']['specialization'],
                    'bio' => $coachData['profile']['bio'],
                    'contact_info' => $coachData['profile']['contact_info'],
                    'certification' => $coachData['profile']['certification'],
                    'experience_years' => $coachData['profile']['experience_years'],
                    'hourly_rate' => $coachData['profile']['hourly_rate'],
                ]);

                $this->command->info("Coach '{$coachData['full_name']}' berhasil dibuat!");
            } else {
                $this->command->info("Coach '{$coachData['full_name']}' sudah ada.");
            }
        }

        $this->command->info('Seeder Coach selesai!');
        $this->command->info('Email/Password: [email]@webrenangku.com / coach123');
    }
}
