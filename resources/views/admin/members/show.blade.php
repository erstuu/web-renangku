<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Member - Admin Web Renangku</title>
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
                    <a href="{{ route('admin.coaches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-users mr-3"></i>Manajemen Coach
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
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
                            <a href="{{ route('admin.members.index') }}" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-arrow-left text-xl"></i>
                            </a>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800">Detail Member</h2>
                                <p class="text-gray-600 mt-1">Informasi lengkap member {{ $member->full_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                @if($member->is_active)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Aktif
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-700">
                    Non-aktif
                </span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Member Information -->
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
                                    <p class="text-gray-900 font-medium">{{ $member->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <p class="text-gray-900">{{ $member->username }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <p class="text-gray-900">{{ $member->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                    <p class="text-gray-900">{{ $member->phone_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                    <p class="text-gray-900">{{ $member->birth_date ? $member->birth_date->format('d F Y') : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <p class="text-gray-900">{{ $member->gender === 'male' ? 'Laki-laki' : ($member->gender === 'female' ? 'Perempuan' : '-') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <p class="text-gray-900">{{ $member->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Profile Information -->
                    @if($member->memberProfile)
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Profil Member</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Membership</label>
                                    <p class="text-gray-900">{{ ucfirst($member->memberProfile->membership_status) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
                                    <p class="text-gray-900">{{ $member->created_at->format('d F Y') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                    <p class="text-gray-900">{{ $member->memberProfile->notes ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Session Registrations -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Riwayat Pendaftaran Sesi</h3>
                        </div>
                        <div class="p-6">
                            @if($member->sessionRegistrations && $member->sessionRegistrations->count() > 0)
                            <div class="space-y-4">
                                @foreach($member->sessionRegistrations->take(5) as $registration)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $registration->trainingSession->session_name ?? '-' }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">Coach: {{ $registration->trainingSession->coach->full_name ?? '-' }}</p>
                                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                                <span><i class="fas fa-calendar mr-1"></i>{{ $registration->trainingSession->start_time ? $registration->trainingSession->start_time->format('d M Y') : 'TBD' }}</span>
                                                <span><i class="fas fa-clock mr-1"></i>{{ $registration->trainingSession->start_time ? $registration->trainingSession->start_time->format('H:i') : 'TBD' }} - {{ $registration->trainingSession->end_time ? $registration->trainingSession->end_time->format('H:i') : 'TBD' }}</span>
                                                <span><i class="fas fa-receipt mr-1"></i>Status: {{ ucfirst($registration->payment_status) }}</span>
                                                <span><i class="fas fa-user-check mr-1"></i>Absensi: {{ ucfirst($registration->attendance_status) }}</span>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $registration->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $registration->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($member->sessionRegistrations->count() > 5)
                            <div class="mt-4 text-center">
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Lihat Semua Pendaftaran ({{ $member->sessionRegistrations->count() }})
                                </button>
                            </div>
                            @endif
                            @else
                            <p class="text-gray-500 text-center py-8">Belum ada pendaftaran sesi</p>
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
                                <p class="text-gray-900">{{ $member->created_at->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Login</label>
                                <p class="text-gray-900">{{ isset($member->last_login_at) && $member->last_login_at ? $member->last_login_at->format('d F Y, H:i') : 'Belum pernah login' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Email</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $member->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
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
                                <span class="text-gray-600">Total Pendaftaran</span>
                                <span class="font-semibold text-gray-900">{{ $totalRegistrations }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Sesi Dihadiri</span>
                                <span class="font-semibold text-gray-900">{{ $attendedSessions }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pembayaran Lunas</span>
                                <span class="font-semibold text-gray-900">{{ $paidRegistrations }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>