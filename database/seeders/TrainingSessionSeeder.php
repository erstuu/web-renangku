<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;

class TrainingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some coach users
        $coaches = User::where('role', 'coach')->get();

        if ($coaches->count() == 0) {
            $this->command->warn('No coaches found. Please run CoachSeeder first.');
            return;
        }

        $sessions = [
            [
                'session_name' => 'Renang Dasar untuk Pemula',
                'description' => 'Sesi latihan renang untuk pemula yang ingin mempelajari teknik dasar renang. Cocok untuk yang belum pernah berenang sebelumnya.',
                'start_time' => Carbon::now()->addDays(3)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(3)->setTime(10, 30),
                'location' => 'Kolam Renang Utama',
                'max_capacity' => 15,
                'price' => 50000,
                'session_type' => 'group',
                'skill_level' => 'beginner',
                'is_active' => true,
            ],
            [
                'session_name' => 'Teknik Gaya Bebas Menengah',
                'description' => 'Pelatihan intensif untuk memperbaiki teknik gaya bebas. Fokus pada pernapasan dan koordinasi gerakan.',
                'start_time' => Carbon::now()->addDays(5)->setTime(16, 0),
                'end_time' => Carbon::now()->addDays(5)->setTime(17, 0),
                'location' => 'Kolam Renang Lane 1-4',
                'max_capacity' => 8,
                'price' => 75000,
                'session_type' => 'group',
                'skill_level' => 'intermediate',
                'is_active' => true,
            ],
            [
                'session_name' => 'Latihan Daya Tahan',
                'description' => 'Sesi latihan khusus untuk meningkatkan daya tahan dan kekuatan dalam berenang. Untuk perenang yang sudah berpengalaman.',
                'start_time' => Carbon::now()->addDays(7)->setTime(7, 0),
                'end_time' => Carbon::now()->addDays(7)->setTime(8, 30),
                'location' => 'Kolam Renang Utama',
                'max_capacity' => 12,
                'price' => 0, // Gratis
                'session_type' => 'group',
                'skill_level' => 'advanced',
                'is_active' => true,
            ],
            [
                'session_name' => 'Aqua Fitness',
                'description' => 'Senam air yang menyenangkan untuk kebugaran dan kesehatan. Tidak perlu bisa berenang.',
                'start_time' => Carbon::now()->addDays(2)->setTime(18, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(19, 0),
                'location' => 'Kolam Renang Dangkal',
                'max_capacity' => 20,
                'price' => 30000,
                'session_type' => 'group',
                'skill_level' => 'beginner',
                'is_active' => true,
            ],
            [
                'session_name' => 'Renang Kompetitif',
                'description' => 'Pelatihan untuk persiapan kompetisi renang. Fokus pada kecepatan dan teknik sempurna.',
                'start_time' => Carbon::now()->addDays(10)->setTime(6, 0),
                'end_time' => Carbon::now()->addDays(10)->setTime(8, 0),
                'location' => 'Kolam Renang Kompetisi',
                'max_capacity' => 6,
                'price' => 100000,
                'session_type' => 'competition',
                'skill_level' => 'advanced',
                'is_active' => true,
            ],
        ];

        foreach ($sessions as $session) {
            $session['coach_id'] = $coaches->random()->id;
            TrainingSession::create($session);
        }

        $this->command->info('Training sessions seeded successfully!');
    }
}
