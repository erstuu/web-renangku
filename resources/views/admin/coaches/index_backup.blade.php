<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Coach - Admin Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
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
                        <h2 class="text-3xl font-bold text-gray-800">Manajemen Coach</h2>
                        <p class="text-gray-600 mt-2">Kelola semua coach di platform Web Renangku</p>
                    </div>
                    <a href="{{ route('admin.coaches.pending') }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-clock mr-2"></i>Pending Approval
                        @if($pendingCoaches > 0)
                        <span class="ml-2 bg-yellow-700 text-xs rounded-full px-2 py-1">{{ $pendingCoaches }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Coach</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalCoaches }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedCoaches }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingCoaches }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Rejected</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $rejectedCoaches }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <form id="searchForm" method="GET" action="{{ route('admin.coaches.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-64">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Coach</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nama, email, atau username..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <div id="searchSpinner" class="hidden mt-2">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Mencari...
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.coaches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-refresh mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <div id="coachesContainer">
                @include('admin.coaches._index_list', ['coaches' => $coaches])
            </div>
                    @foreach($coaches as $coach)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Coach Info -->
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-user text-red-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $coach->full_name }}</h4>
                                        <p class="text-gray-600">{{ $coach->email }}</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($coach->approval_status === 'approved') bg-green-100 text-green-800
                                                @elseif($coach->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($coach->approval_status) }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($coach->is_active) bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $coach->is_active ? 'Aktif' : 'Non-aktif' }}
                                            </span>
                                            <p class="text-sm text-gray-500">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Bergabung: {{ $coach->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coach Profile Summary -->
                                @if($coach->coachProfile)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Pengalaman:</span>
                                                {{ $coach->coachProfile->experience_years ?? 0 }} tahun
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <span class="font-medium">Tarif per Sesi:</span>
                                                Rp {{ number_format($coach->coachProfile->hourly_rate ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Spesialisasi:</span>
                                                @if($coach->coachProfile->specializations)
                                                {{ implode(', ', array_slice(json_decode($coach->coachProfile->specializations, true) ?? [], 0, 2)) }}
                                                @if(count(json_decode($coach->coachProfile->specializations, true) ?? []) > 2)
                                                ...
                                                @endif
                                                @else
                                                <span class="text-gray-400">Tidak ada</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2 ml-4">
                                @if($coach->approval_status === 'pending')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.coaches.approve', $coach->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                            onclick="return confirm('Yakin approve coach {{ $coach->full_name }}?')">
                                            <i class="fas fa-check mr-1"></i>Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.coaches.reject', $coach->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                            onclick="return confirm('Yakin tolak coach {{ $coach->full_name }}?')">
                                            <i class="fas fa-times mr-1"></i>Tolak
                                        </button>
                                    </form>
                                </div>
                                @endif

                                @if($coach->approval_status === 'approved')
                                <form method="POST" action="{{ route('admin.coaches.toggle-status', $coach->id) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-{{ $coach->is_active ? 'orange' : 'green' }}-500 hover:bg-{{ $coach->is_active ? 'orange' : 'green' }}-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors w-full">
                                        <i class="fas fa-{{ $coach->is_active ? 'pause' : 'play' }} mr-1"></i>
                                        {{ $coach->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('admin.coaches.show', $coach->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($coaches->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $coaches->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Coach</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['search', 'status']))
                    Tidak ada coach yang sesuai dengan filter yang dipilih.
                    @else
                    Belum ada coach yang terdaftar di platform.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.coaches.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
                    <i class="fas fa-refresh mr-2"></i>Reset Filter
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            try {
                const notificationManager = new NotificationManager();
            } catch (e) {
                console.log('NotificationManager not available');
            }
        });
    </script>
</body>

</html>