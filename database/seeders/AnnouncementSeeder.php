<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('No admin user found. Please create an admin user first.');
            return;
        }

        $announcements = [
            [
                'title' => 'Selamat Datang di Web Renangku!',
                'content' => 'Selamat datang di platform pembelajaran renang online Web Renangku! Kami sangat senang Anda bergabung dengan komunitas renang kami. Di sini, Anda dapat mendaftar ke berbagai sesi latihan, mengikuti program pelatihan dengan coach profesional, dan meningkatkan kemampuan renang Anda. 

Jangan lupa untuk melengkapi profil Anda terlebih dahulu dan jelajahi berbagai sesi latihan yang tersedia. Tim kami siap membantu Anda mencapai tujuan dalam berenang!',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Program Latihan Intensif Bulan Ini',
                'content' => 'Kami dengan bangga mengumumkan program latihan intensif khusus untuk bulan ini! Program ini dirancang untuk meningkatkan teknik renang Anda secara signifikan dalam waktu 4 minggu.

Program mencakup:
- Latihan teknik dasar dan lanjutan
- Sesi privat dengan coach berpengalaman
- Evaluasi kemajuan mingguan
- Sertifikat penyelesaian

Daftar sekarang karena tempat terbatas!',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Perubahan Jadwal Sesi Latihan',
                'content' => 'Mohon perhatian untuk seluruh member, terdapat perubahan jadwal untuk beberapa sesi latihan minggu depan:

- Sesi Grup Senin: Dipindah dari 09:00 ke 10:00
- Sesi Privat Rabu: Ditambah slot baru pukul 15:00
- Sesi Kompetisi Jumat: Dipindah ke Sabtu pukul 08:00

Silakan periksa jadwal terbaru di halaman sesi latihan. Terima kasih atas pengertiannya.',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Tips Keselamatan di Kolam Renang',
                'content' => 'Keselamatan adalah prioritas utama kami. Berikut beberapa tips penting untuk menjaga keselamatan selama berlatih:

1. Selalu lakukan pemanasan sebelum masuk kolam
2. Jangan berenang sendirian, pastikan ada coach atau teman
3. Gunakan pelampung jika diperlukan
4. Ikuti instruksi coach dengan seksama
5. Jangan memaksakan diri jika merasa lelah
6. Keluar dari kolam jika merasa tidak enak badan

Keselamatan Anda adalah tanggung jawab bersama!',
                'is_published' => true,
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'Kompetisi Renang Antar Member',
                'content' => 'Bersiaplah untuk kompetisi renang antar member yang akan diadakan bulan depan! Ini adalah kesempatan bagus untuk mengukur kemajuan Anda dan bertemu dengan member lainnya.

Kategori kompetisi:
- Freestyle 50m (Pemula & Menengah)
- Backstroke 50m (Semua level)
- Breaststroke 25m (Pemula)
- Medley 100m (Lanjutan)

Pendaftaran dibuka mulai minggu depan. Hadiah menarik menanti para pemenang!',
                'is_published' => true,
                'published_at' => now()->subHours(6),
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create([
                'admin_id' => $admin->id,
                'title' => $announcement['title'],
                'content' => $announcement['content'],
                'is_published' => $announcement['is_published'],
                'published_at' => $announcement['published_at'],
            ]);
        }

        $this->command->info('Announcements seeded successfully!');
    }
}
