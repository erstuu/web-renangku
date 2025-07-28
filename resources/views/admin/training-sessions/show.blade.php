<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sesi Latihan - Admin Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/js/notifications.js"></script>
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
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-user-friends mr-3"></i>Manajemen Member
                    </a>
                    <a href="{{ route('admin.training-sessions.index') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
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
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.training-sessions.index') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-1">Detail Sesi Latihan</h2>
                            <p class="text-gray-600">Informasi lengkap sesi <span class="font-semibold">{{ $session->session_name }}</span></p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.training-sessions.edit', $session->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $session->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                    {{ $session->is_active ? 'Aktif' : 'Non-aktif' }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 ml-2">
                    {{ ucfirst($session->session_type) }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informasi Sesi -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Sesi</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sesi</label>
                                    <p class="text-gray-900 font-medium">{{ $session->session_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelatih</label>
                                    <p class="text-gray-900 font-medium">{{ $session->coach?->full_name ?? '-' }}</p>
                                    @if($session->coach && $session->coach->coachProfile)
                                    <div class="text-gray-600 text-sm mt-1">
                                        <span>Email: {{ $session->coach->email }}</span><br>
                                        <span>No. HP: {{ $session->coach->coachProfile->phone ?? '-' }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                    <p class="text-gray-900 font-medium">{{ $session->location }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                                    <p class="text-gray-900 font-medium">{{ $session->start_time->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                                    <p class="text-gray-900 font-medium">{{ $session->end_time->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Level Kemampuan</label>
                                    <p class="text-gray-900 font-medium capitalize">{{ $session->skill_level }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                    <p class="text-gray-900 font-medium">Rp{{ number_format($session->price,0,',','.') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Maksimal</label>
                                    <p class="text-gray-900 font-medium">{{ $session->max_capacity }} orang</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <p class="text-gray-900">{{ $session->description ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statistik Pendaftar -->
                <div>
                    <div class="bg-white rounded-lg shadow mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik Pendaftar</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Total Pendaftar</span>
                                <span class="font-bold text-blue-700 text-lg">{{ $totalRegistrations }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Sudah Bayar</span>
                                <span class="font-bold text-green-700 text-lg">{{ $paidRegistrations }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Hadir</span>
                                <span class="font-bold text-yellow-700 text-lg">{{ $attendedCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pendaftar -->
            <div class="bg-white rounded-lg shadow mt-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Pendaftar</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm mb-4 border border-gray-200 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-gray-200">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-gray-200">Email</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-gray-200">Status Bayar</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-gray-200">Kehadiran</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-gray-200">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($session->sessionRegistrations as $reg)
                            <tr class="even:bg-gray-50 hover:bg-red-50 transition-colors border-b border-gray-100 last:border-b-0">
                                <td class="px-4 py-3 align-middle">{{ $reg->user?->full_name ?? '-' }}</td>
                                <td class="px-4 py-3 align-middle">{{ $reg->user?->email ?? '-' }}</td>
                                <td class="px-4 py-3 align-middle">
                                    @switch($reg->payment_status)
                                    @case('pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Menunggu</span>
                                    @break
                                    @case('paid')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Lunas</span>
                                    @break
                                    @case('refunded')
                                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-medium">Refund</span>
                                    @break
                                    @default
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">-</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    @switch($reg->attendance_status)
                                    @case('registered')
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">Terdaftar</span>
                                    @break
                                    @case('attended')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">Hadir</span>
                                    @break
                                    @case('absent')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium">Tidak Hadir</span>
                                    @break
                                    @case('canceled')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Dibatalkan</span>
                                    @break
                                    @default
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">-</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 align-middle">{{ $reg->notes ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada pendaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>