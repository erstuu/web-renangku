<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/admin-modals.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <button type="submit" class="bg-red-800 hover:bg-red-900 px-4 py-2 rounded text-white">
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.coaches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
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
                        @if($pendingDataChangeRequests > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $pendingDataChangeRequests }}</span>
                        @endif
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
                <h2 class="text-3xl font-bold text-gray-800">Dashboard Admin</h2>
                <p class="text-gray-600 mt-2">Kelola seluruh aspek platform Web Renangku</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Coaches -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Coach</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalCoaches }}</p>
                            @if($pendingCoaches > 0)
                            <p class="text-sm text-orange-600">{{ $pendingCoaches }} pending approval</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Total Members -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-friends text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Member</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalMembers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Sessions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-swimming-pool text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Sesi</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalSessions }}</p>
                            <p class="text-sm text-green-600">{{ $activeSessions }} aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Hari Ini</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Sesi Hari Ini</span>
                            <span class="font-semibold text-blue-600">{{ $todaySessions }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pendaftaran Hari Ini</span>
                            <span class="font-semibold text-green-600">{{ $todayRegistrations }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Pendaftaran</span>
                            <span class="font-semibold text-red-600">{{ $totalRegistrations }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pembayaran Selesai</span>
                            <span class="font-semibold text-green-600">{{ $paidRegistrations }}</span>
                        </div>
                    </div>
                </div>

                <!-- Monthly Registrations Chart -->
                <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Trend Pendaftaran 12 Bulan Terakhir</h3>
                    <canvas id="monthlyChart" width="400" height="200"
                        data-monthly='{!! json_encode($monthlyRegistrations ?? []) !!}'></canvas>
                </div>
            </div>

            <!-- Quick Actions & Recent Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pending Coach Approvals -->
                @if($recentCoaches->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Coach Menunggu Approval</h3>
                        <a href="{{ route('admin.coaches.pending') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentCoaches as $coach)
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $coach->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $coach->email }}</p>
                                <p class="text-xs text-gray-500">Mendaftar: {{ $coach->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('admin.coaches.approve', $coach->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.coaches.reject', $coach->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                        onclick="return confirm('Yakin tolak coach ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pending Data Change Requests -->
                @if($recentDataChangeRequests->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Permintaan Perubahan Data</h3>
                        <a href="{{ route('admin.data-change-requests.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentDataChangeRequests as $request)
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $request->user->full_name }}</p>
                                <p class="text-sm text-gray-600">
                                    @switch($request->request_type)
                                    @case('name')
                                    Perubahan Nama
                                    @break
                                    @case('email')
                                    Perubahan Email
                                    @break
                                    @case('both')
                                    Perubahan Nama & Email
                                    @break
                                    @default
                                    {{ ucfirst($request->request_type) }}
                                    @endswitch
                                </p>
                                <p class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.data-change-requests.show', $request->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Review
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recent Registrations -->
                @if($recentRegistrations->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pendaftaran Terbaru</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentRegistrations as $registration)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $registration->user->full_name }}</p>
                                <p class="text-sm text-gray-600">{{ $registration->trainingSession->session_name }}</p>
                                <p class="text-xs text-gray-500">{{ $registration->registered_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($registration->payment_status === 'paid') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($registration->payment_status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Registration Chart
            const ctx = document.getElementById('monthlyChart');
            if (ctx && typeof Chart !== 'undefined') {
                // Get data from data attribute
                const monthlyDataRaw = ctx.getAttribute('data-monthly');
                let monthlyData = [];

                try {
                    monthlyData = JSON.parse(monthlyDataRaw || '[]');
                } catch (e) {
                    console.log('Error parsing monthly data:', e);
                    monthlyData = [];
                }

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthlyData.map(item => item.month || ''),
                        datasets: [{
                            label: 'Pendaftaran',
                            data: monthlyData.map(item => item.count || 0),
                            borderColor: 'rgb(147, 51, 234)',
                            backgroundColor: 'rgba(147, 51, 234, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>