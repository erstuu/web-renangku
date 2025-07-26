<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataChangeRequest;
use App\Models\User;

class DataChangeRequestSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users (members and coaches) to create requests for
        $members = User::where('role', 'member')->take(3)->get();
        $coaches = User::where('role', 'coach')->take(2)->get();
        $users = $members->merge($coaches);

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder, CoachSeeder, and member seeders first.');
            return;
        }

        $requests = [
            [
                'user_id' => $users->first()->id,
                'request_type' => 'name',
                'current_name' => $users->first()->full_name,
                'requested_name' => 'Ahmad Budi Santoso',
                'current_email' => null,
                'requested_email' => null,
                'reason' => 'Saya ingin mengubah nama sesuai dengan KTP yang baru',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->skip(1)->first()->id : $users->first()->id,
                'request_type' => 'email',
                'current_name' => null,
                'requested_name' => null,
                'current_email' => $users->count() > 1 ? $users->skip(1)->first()->email : $users->first()->email,
                'requested_email' => 'email.baru@gmail.com',
                'reason' => 'Email lama sudah tidak bisa diakses',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->count() > 2 ? $users->skip(2)->first()->id : $users->first()->id,
                'request_type' => 'both',
                'current_name' => $users->count() > 2 ? $users->skip(2)->first()->full_name : $users->first()->full_name,
                'requested_name' => 'Siti Rahayu Permata',
                'current_email' => $users->count() > 2 ? $users->skip(2)->first()->email : $users->first()->email,
                'requested_email' => 'siti.rahayu.new@gmail.com',
                'reason' => 'Perubahan nama dan email setelah menikah',
                'status' => 'approved',
                'reviewed_by' => User::where('role', 'admin')->first()?->id,
                'admin_notes' => 'Perubahan disetujui setelah verifikasi dokumen',
                'reviewed_at' => now()->subDays(2),
            ],
            [
                'user_id' => $users->count() > 3 ? $users->skip(3)->first()->id : $users->first()->id,
                'request_type' => 'name',
                'current_name' => $users->count() > 3 ? $users->skip(3)->first()->full_name : $users->first()->full_name,
                'requested_name' => 'Muhammad Rizki Ramadhan',
                'current_email' => null,
                'requested_email' => null,
                'reason' => 'Nama yang terdaftar salah ejaan',
                'status' => 'rejected',
                'reviewed_by' => User::where('role', 'admin')->first()?->id,
                'admin_notes' => 'Dokumen pendukung belum lengkap',
                'reviewed_at' => now()->subDays(1),
            ],
        ];

        foreach ($requests as $request) {
            DataChangeRequest::create($request);
        }

        $this->command->info('Data change requests seeded successfully!');
    }
}
