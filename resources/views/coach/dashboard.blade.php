<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Coach - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Coach Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white">
                    Logout
                </button>
            </form>
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
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-4">Selamat Datang, Coach {{ Auth::user()->full_name }}!</h2>
                    <p class="text-gray-600">Anda login sebagai Coach di Web Renangku.</p>
                </div>
                <div class="flex-shrink-0 ml-6">
                    @if(Auth::user()->coachProfile && Auth::user()->coachProfile->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->coachProfile->profile_photo) }}"
                        alt="Foto Profile {{ Auth::user()->full_name }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-green-200 shadow-lg">
                    @else
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center border-4 border-green-200 shadow-lg">
                        <span class="text-white font-bold text-2xl">
                            {{ substr(Auth::user()->full_name, 0, 1) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Alert for Pending Registrations -->
            @if(isset($pendingRegistrations) && $pendingRegistrations > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm text-yellow-700">
                            Anda memiliki <strong>{{ $pendingRegistrations }} pendaftaran</strong> yang menunggu konfirmasi.
                        </p>
                    </div>
                    <div class="ml-3">
                        <a href="{{ route('coach.registrations.index') }}" class="bg-yellow-100 text-yellow-800 hover:bg-yellow-200 px-3 py-1 rounded text-sm font-medium transition-colors">
                            Lihat Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Sesi Aktif</p>
                            <p class="text-2xl font-bold text-green-900">{{ $activeSessionsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Total Member</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $totalMembers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">Pendaftaran</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $pendingRegistrations ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-800">Pendapatan Bulan Ini</p>
                            <p class="text-2xl font-bold text-purple-900">Rp {{ number_format($monthlyEarnings ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg border border-green-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-green-800">Sesi Latihan</h3>
                    </div>
                    <p class="text-green-600 mb-4">Kelola jadwal dan sesi latihan renang Anda</p>
                    <div class="space-y-2">
                        <a href="{{ route('coach.training-sessions.index') }}" class="block w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 transition-colors">
                            Lihat Semua Sesi
                        </a>
                        <a href="{{ route('coach.training-sessions.create') }}" class="block w-full bg-green-100 text-green-800 text-center py-2 rounded hover:bg-green-200 transition-colors">
                            Buat Sesi Baru
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg border border-blue-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-blue-800">Pendaftaran Member</h3>
                    </div>
                    <p class="text-blue-600 mb-4">Kelola pendaftaran member ke sesi latihan renang Anda</p>

                    <!-- Registration Summary -->
                    <div class="bg-white rounded p-3 mb-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-600">{{ $pendingRegistrations ?? 0 }}</div>
                                <div class="text-yellow-700">Menunggu</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $totalMembers ?? 0 }}</div>
                                <div class="text-blue-700">Total Member</div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('coach.registrations.index') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition-colors">
                            Kelola Pendaftaran
                        </a>
                        @if($pendingRegistrations > 0)
                        <a href="{{ route('coach.registrations.index') }}?filter=pending" class="block w-full bg-yellow-100 text-yellow-800 text-center py-2 rounded hover:bg-yellow-200 transition-colors">
                            {{ $pendingRegistrations }} Perlu Konfirmasi
                        </a>
                        @endif
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-lg border border-yellow-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="ml-3 text-lg font-semibold text-yellow-800">Profil Coach</h3>
                    </div>
                    <p class="text-yellow-600 mb-4">Kelola informasi profil dan sertifikasi Anda</p>
                    <div class="space-y-2">
                        <a href="{{ route('coach.profile.show') }}" class="block w-full bg-yellow-600 text-white text-center py-2 rounded hover:bg-yellow-700 transition-colors">
                            Lihat Profil
                        </a>
                        <a href="{{ route('coach.profile.edit') }}" class="block w-full bg-yellow-100 text-yellow-800 text-center py-2 rounded hover:bg-yellow-200 transition-colors">
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Sessions -->
            @if(isset($recentSessions) && $recentSessions->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Sessions -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Sesi Latihan Terbaru</h3>
                        <a href="{{ route('coach.training-sessions.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentSessions as $session)
                        <div class="bg-white p-4 rounded border-l-4 border-green-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $session->session_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $session->start_time->format('d M Y, H:i') }} - {{ $session->end_time->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ $session->location }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $session->sessionRegistrations->count() }}/{{ $session->max_capacity }} peserta
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Registrations -->
                @if(isset($recentRegistrations) && $recentRegistrations->count() > 0)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pendaftaran Terbaru</h3>
                        <a href="{{ route('coach.registrations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentRegistrations as $registration)
                        <div class="bg-white p-4 rounded border-l-4 
                            @if($registration->attendance_status === 'registered') border-blue-500
                            @elseif($registration->attendance_status === 'attended') border-green-500
                            @elseif($registration->attendance_status === 'absent') border-red-500
                            @else border-gray-500
                            @endif">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 bg-gradient-to-r from-blue-400 to-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ substr($registration->member->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $registration->member->full_name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $registration->trainingSession->session_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $registration->registered_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($registration->attendance_status === 'registered')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Terdaftar
                                    </span>
                                    @elseif($registration->attendance_status === 'attended')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Hadir
                                    </span>
                                    @elseif($registration->attendance_status === 'absent')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Tidak Hadir
                                    </span>
                                    @elseif($registration->attendance_status === 'cancelled')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Dibatalkan
                                    </span>
                                    @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($registration->attendance_status) }}
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
            @elseif(isset($recentRegistrations) && $recentRegistrations->count() > 0)
            <!-- Only Recent Registrations if no sessions -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pendaftaran Terbaru</h3>
                    <a href="{{ route('coach.registrations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat semua →
                    </a>
                </div>
                <div class="space-y-3">
                    @foreach($recentRegistrations as $registration)
                    <div class="bg-white p-4 rounded border-l-4 
                        @if($registration->attendance_status === 'registered') border-blue-500
                        @elseif($registration->attendance_status === 'attended') border-green-500
                        @elseif($registration->attendance_status === 'absent') border-red-500
                        @else border-gray-500
                        @endif">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 bg-gradient-to-r from-blue-400 to-green-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ substr($registration->member->full_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $registration->member->full_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $registration->trainingSession->session_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $registration->registered_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($registration->attendance_status === 'registered')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Terdaftar
                                </span>
                                @elseif($registration->attendance_status === 'attended')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Hadir
                                </span>
                                @elseif($registration->attendance_status === 'absent')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Tidak Hadir
                                </span>
                                @elseif($registration->attendance_status === 'cancelled')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Dibatalkan
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($registration->attendance_status) }}
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();
        });
    </script>
</body>

</html>