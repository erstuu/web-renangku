<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Coach - Admin Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/admin-modals.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-red-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Admin Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-red-200">{{ Auth::user()->full_name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.coaches.index') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
                        <i class="fas fa-users mr-3"></i>Manajemen Coach
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-user-friends mr-3"></i>Manajemen Member
                    </a>
                    <a href="{{ route('admin.training-sessions.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-swimming-pool mr-3"></i>Sesi Latihan
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-bullhorn mr-3"></i>Pengumuman
                    </a>
                    <a href="{{ route('admin.data-change-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-edit mr-3"></i>Permintaan Perubahan Data
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
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

            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.coaches.index') }}" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-arrow-left text-xl"></i>
                            </a>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800">Detail Coach</h2>
                                <p class="text-gray-600 mt-1">Informasi lengkap coach {{ $coach->full_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        @if($coach->approval_status === 'pending')
                        <form method="POST" action="{{ route('admin.coaches.approve', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center"
                                onclick="return confirm('Yakin ingin menyetujui coach ini?')">
                                <i class="fas fa-check mr-2"></i>Setujui
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.coaches.reject', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg inline-flex items-center"
                                onclick="return confirm('Yakin ingin menolak coach ini?')">
                                <i class="fas fa-times mr-2"></i>Tolak
                            </button>
                        </form>
                        @endif
                        <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                @if($coach->approval_status === 'approved')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check mr-2"></i>Disetujui
                </span>
                @elseif($coach->approval_status === 'pending')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-clock mr-2"></i>Menunggu Approval
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <i class="fas fa-times mr-2"></i>Ditolak
                </span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Coach Information -->
                <div class="lg:col-span-2">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <p class="text-gray-900 font-medium">{{ $coach->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <p class="text-gray-900">{{ $coach->username }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <p class="text-gray-900">{{ $coach->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                    <p class="text-gray-900">{{ $coach->phone_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                    <p class="text-gray-900">{{ $coach->birth_date ? $coach->birth_date->format('d F Y') : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <p class="text-gray-900">{{ $coach->gender === 'male' ? 'Laki-laki' : ($coach->gender === 'female' ? 'Perempuan' : '-') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <p class="text-gray-900">{{ $coach->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coach Profile Information -->
                    @if($coach->coachProfile)
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profesi</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi</label>
                                    <p class="text-gray-900">{{ $coach->coachProfile->specialization ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman</label>
                                    <p class="text-gray-900">{{ $coach->coachProfile->experience_years ? $coach->coachProfile->experience_years . ' tahun' : '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikasi</label>
                                    <p class="text-gray-900">{{ $coach->coachProfile->certifications ?? '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                    <p class="text-gray-900">{{ $coach->coachProfile->bio ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Training Sessions -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Sesi Latihan</h3>
                        </div>
                        <div class="p-6">
                            @if($coach->trainingSessions && $coach->trainingSessions->count() > 0)
                            <div class="space-y-4">
                                @foreach($coach->trainingSessions->take(5) as $session)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $session->session_name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $session->description }}</p>
                                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                                <span><i class="fas fa-calendar mr-1"></i>{{ $session->start_time ? $session->start_time->format('d M Y') : 'TBD' }}</span>
                                                <span><i class="fas fa-clock mr-1"></i>{{ $session->start_time ? $session->start_time->format('H:i') : 'TBD' }} - {{ $session->end_time ? $session->end_time->format('H:i') : 'TBD' }}</span>
                                                <span><i class="fas fa-users mr-1"></i>{{ $session->registrations ? $session->registrations->count() : 0 }}/{{ $session->max_capacity ?? 0 }} peserta</span>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $session->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $session->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($coach->trainingSessions->count() > 5)
                            <div class="mt-4 text-center">
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Lihat Semua Sesi ({{ $coach->trainingSessions->count() }})
                                </button>
                            </div>
                            @endif
                            @else
                            <p class="text-gray-500 text-center py-8">Belum ada sesi latihan yang dibuat</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="lg:col-span-1">
                    <!-- Account Information -->
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Info Akun</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
                                <p class="text-gray-900">{{ $coach->created_at->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Login</label>
                                <p class="text-gray-900">{{ isset($coach->last_login_at) && $coach->last_login_at ? $coach->last_login_at->format('d F Y, H:i') : 'Belum pernah login' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Email</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coach->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $coach->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Sesi</span>
                                <span class="font-semibold text-gray-900">{{ $coach->trainingSessions ? $coach->trainingSessions->count() : 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Sesi Aktif</span>
                                <span class="font-semibold text-gray-900">{{ $coach->trainingSessions ? $coach->trainingSessions->where('is_active', true)->count() : 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Peserta</span>
                                <span class="font-semibold text-gray-900">
                                    @php
                                    $totalParticipants = 0;
                                    if ($coach->trainingSessions) {
                                    foreach ($coach->trainingSessions as $session) {
                                    $totalParticipants += $session->registrations ? $session->registrations->count() : 0;
                                    }
                                    }
                                    @endphp
                                    {{ $totalParticipants }}
                                </span>
                            </div>
                            {{-- Rating system will be implemented later --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>