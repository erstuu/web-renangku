<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Latihan - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Simple Header -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.dashboard') }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Sesi Latihan Tersedia</h1>
        </div>
    </nav>

    <div class="container mx-auto max-w-6xl px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-bold text-gray-900">Sesi Latihan Tersedia</h1>
            </div>
            <p class="text-gray-600">Pilih dan daftar untuk sesi latihan yang sesuai dengan jadwal Anda</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif

        <!-- Training Sessions Grid -->
        @if($availableSessions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availableSessions as $session)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow {{ $session->start_time <= now() ? 'opacity-75' : '' }}">
                <!-- Coach Profile Section -->
                <div class="bg-gradient-to-r {{ $session->start_time <= now() ? 'from-gray-50 to-gray-100' : 'from-blue-50 to-indigo-50' }} px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <!-- Coach Photo -->
                        <div class="flex-shrink-0">
                            @if($session->coach && $session->coach->coachProfile && $session->coach->coachProfile->profile_photo)
                            <img src="{{ asset('storage/' . $session->coach->coachProfile->profile_photo) }}"
                                alt="{{ $session->coach->name }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm {{ $session->start_time <= now() ? 'grayscale' : '' }}">
                            @else
                            <div class="w-12 h-12 rounded-full {{ $session->start_time <= now() ? 'bg-gray-400' : 'bg-blue-500' }} flex items-center justify-center text-white font-semibold text-lg border-2 border-white shadow-sm">
                                {{ substr($session->coach->name ?? 'C', 0, 1) }}
                            </div>
                            @endif
                        </div>
                        <!-- Coach Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold {{ $session->start_time <= now() ? 'text-gray-500' : 'text-gray-900' }} truncate">
                                {{ $session->session_name }}
                                @if($session->start_time <= now())
                                    <span class="text-sm font-normal text-gray-400">(Sudah berlalu)</span>
                                    @endif
                            </h3>
                            <p class="text-sm {{ $session->start_time <= now() ? 'text-gray-400' : 'text-blue-600' }} font-medium">Coach {{ $session->coach->name ?? 'TBA' }}</p>
                        </div>
                    </div>
                </div> <!-- Session Info -->
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($session->start_time)->format('d M Y') }}
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $session->location }}
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $session->sessionRegistrations->count() }}/{{ $session->max_capacity }} peserta
                        </div>

                        @if($session->price > 0)
                        <div class="flex items-center text-sm text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Rp {{ number_format($session->price, 0, ',', '.') }}
                        </div>
                        @else
                        <div class="flex items-center text-sm text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Gratis
                        </div>
                        @endif

                        <!-- Skill Level Badge -->
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($session->skill_level === 'beginner') bg-green-100 text-green-800
                                    @elseif($session->skill_level === 'intermediate') bg-yellow-100 text-yellow-800
                                    @elseif($session->skill_level === 'advanced') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                @if($session->skill_level === 'beginner') Pemula
                                @elseif($session->skill_level === 'intermediate') Menengah
                                @elseif($session->skill_level === 'advanced') Lanjutan
                                @else {{ ucfirst($session->skill_level) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($session->description)
                    <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $session->description }}</p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex gap-2">
                        <a href="{{ route('member.training-sessions.show', $session->id) }}"
                            class="flex-1 text-center py-2 px-3 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>

                        @if(in_array($session->id, $registeredSessionIds))
                        <span class="flex-1 text-center py-2 px-3 text-sm bg-green-100 text-green-800 rounded-md">
                            ✓ Terdaftar
                        </span>
                        @elseif($session->start_time <= now())
                            <span class="flex-1 text-center py-2 px-3 text-sm bg-gray-100 text-gray-600 rounded-md cursor-not-allowed">
                            Sudah Tutup
                            </span>
                            @elseif($session->sessionRegistrations->count() >= $session->max_capacity)
                            <span class="flex-1 text-center py-2 px-3 text-sm bg-red-100 text-red-800 rounded-md">
                                Penuh
                            </span>
                            @else
                            <a href="{{ route('member.payment.show', $session->id) }}"
                                class="flex-1 text-center py-2 px-3 text-sm bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                @if($session->price > 0)
                                Daftar & Bayar
                                @else
                                Daftar Gratis
                                @endif
                            </a>
                            @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada sesi latihan</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada sesi latihan yang tersedia saat ini.</p>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();
        });
    </script>
</body>

</html>