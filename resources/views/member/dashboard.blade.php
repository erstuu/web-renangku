<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Member Dashboard</h1>
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('error') }}
        </div>
        @endif

        @if (session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('warning') }}
        </div>
        @endif

        @if (session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('info') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->full_name }}!</h2>
                <!-- User Profile Photo -->
                <div class="flex-shrink-0">
                    @if(Auth::user()->memberProfile && Auth::user()->memberProfile->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->memberProfile->profile_photo) }}"
                        alt="{{ Auth::user()->full_name }}"
                        class="w-16 h-16 rounded-full object-cover border-3 border-blue-200 shadow-lg">
                    @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl border-3 border-blue-200 shadow-lg">
                        {{ substr(Auth::user()->full_name ?? 'U', 0, 1) }}
                    </div>
                    @endif
                </div>
            </div>
            <p class="text-gray-600 mb-6">Kelola jadwal latihan dan tingkatkan kemampuan renang Anda bersama coach profesional.</p>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Total Pendaftaran</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $totalRegistrations ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Sesi Selesai</p>
                            <p class="text-2xl font-bold text-green-900">{{ $completedSessions ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">Menunggu Konfirmasi</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $pendingRegistrations ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-800">Level Renang</p>
                            <p class="text-lg font-bold text-purple-900">
                                @if($memberProfile && $memberProfile->swimming_experience)
                                @if($memberProfile->swimming_experience === 'beginner') Pemula
                                @elseif($memberProfile->swimming_experience === 'intermediate') Menengah
                                @elseif($memberProfile->swimming_experience === 'advanced') Mahir
                                @else {{ ucfirst($memberProfile->swimming_experience) }}
                                @endif
                                @else
                                Belum diset
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg border border-blue-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-blue-800">Sesi Latihan</h3>
                    </div>
                    <p class="text-blue-600 mb-4">Jelajahi dan daftar ke sesi latihan yang tersedia</p>
                    <div class="space-y-2">
                        <a href="{{ route('member.training-sessions.index') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition-colors">
                            Lihat Sesi Tersedia
                        </a>
                        <a href="{{ route('member.registrations.index') }}" class="block w-full bg-blue-100 text-blue-800 text-center py-2 rounded hover:bg-blue-200 transition-colors">
                            Riwayat Pendaftaran
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg border border-green-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-green-800">Profil Saya</h3>
                    </div>
                    <p class="text-green-600 mb-4">Kelola informasi pribadi dan preferensi latihan</p>
                    <div class="space-y-2">
                        <a href="{{ route('member.profile.show') }}" class="block w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 transition-colors">
                            Lihat Profil
                        </a>
                        <a href="{{ route('member.profile.edit') }}" class="block w-full bg-green-100 text-green-800 text-center py-2 rounded hover:bg-green-200 transition-colors">
                            Edit Profil
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-lg border border-orange-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-orange-800">Pengumuman</h3>
                    </div>
                    <p class="text-orange-600 mb-4">Lihat pengumuman dan informasi terbaru</p>
                    <div class="space-y-2">
                        <a href="{{ route('member.announcements.index') }}" class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition-colors">
                            Lihat Pengumuman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Upcoming Sessions -->
                @if(isset($upcomingSessions) && $upcomingSessions->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Sesi Latihan Mendatang</h3>
                        <a href="{{ route('member.registrations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($upcomingSessions as $registration)
                        <div class="bg-white p-4 rounded border-l-4 border-blue-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $registration->trainingSession->session_name }}</h4>
                                    <p class="text-sm text-gray-600">Coach: {{ $registration->trainingSession->coach->full_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $registration->trainingSession->start_time->format('d M Y, H:i') }} - {{ $registration->trainingSession->end_time->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ $registration->trainingSession->location }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Terkonfirmasi
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Available Sessions -->
                @if(isset($availableSessions) && $availableSessions->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Sesi Tersedia</h3>
                        <a href="{{ route('member.training-sessions.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($availableSessions->take(3) as $session)
                        <div class="bg-white p-4 rounded border-l-4 border-green-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $session->session_name }}</h4>
                                    <p class="text-sm text-gray-600">Coach: {{ $session->coach->full_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $session->start_time->format('d M Y, H:i') }} - {{ $session->end_time->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ $session->location }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $session->sessionRegistrations->count() }}/{{ $session->max_capacity }} peserta
                                    </span>
                                    <p class="text-sm font-medium text-gray-900 mt-1">Rp {{ number_format($session->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recent Announcements -->
                @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pengumuman Terbaru</h3>
                        <a href="{{ route('member.announcements.index') }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentAnnouncements as $announcement)
                        <div class="bg-white p-4 rounded border-l-4 border-orange-500">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $announcement->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $announcement->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recent Registrations -->
                @if(isset($myRegistrations) && $myRegistrations->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Pendaftaran</h3>
                        <a href="{{ route('member.registrations.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($myRegistrations->take(3) as $registration)
                        <div class="bg-white p-4 rounded border-l-4 
                            @if($registration->attendance_status === 'pending') border-yellow-500
                            @elseif($registration->attendance_status === 'confirmed') border-blue-500
                            @elseif($registration->attendance_status === 'completed') border-green-500
                            @else border-red-500
                            @endif">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $registration->trainingSession->session_name }}</h4>
                                    <p class="text-sm text-gray-600">Coach: {{ $registration->trainingSession->coach->full_name }}</p>
                                    <p class="text-xs text-gray-500">Daftar: {{ $registration->registered_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    @if($registration->attendance_status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                    @elseif($registration->attendance_status === 'confirmed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Terkonfirmasi
                                    </span>
                                    @elseif($registration->attendance_status === 'completed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                    @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Empty State for New Members -->
            @if((!isset($availableSessions) || $availableSessions->count() == 0) &&
            (!isset($myRegistrations) || $myRegistrations->count() == 0))
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Selamat datang di Web Renangku!</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai perjalanan renang Anda dengan bergabung ke sesi latihan yang tersedia.</p>
                <div class="mt-6">
                    <a href="{{ route('member.training-sessions.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Jelajahi Sesi Latihan
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();
        });
    </script>
</body>

</html>