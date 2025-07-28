<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sesi Latihan - Admin Web Renangku</title>
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
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Manajemen Sesi Latihan</h2>
                        <p class="text-gray-600 mt-2">Kelola semua sesi latihan yang terdaftar dalam sistem</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.training-sessions.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Tambah Sesi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-swimmer text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Sesi</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalSessions }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Sesi Aktif</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $activeSessions }}</p>
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
                            <p class="text-sm font-medium text-gray-600">Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $todaySessions }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-plus text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Akan Datang</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $upcomingSessions }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <form id="searchForm" method="GET" action="{{ route('admin.training-sessions.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-64">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Sesi</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nama sesi, lokasi, atau pelatih..."
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
                            <option value="" {{ request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="session_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Sesi</label>
                        <select name="session_type" id="session_type" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="" {{ request('session_type') === '' ? 'selected' : '' }}>Semua Tipe</option>
                            <option value="reguler" {{ request('session_type') === 'reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="private" {{ request('session_type') === 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                    <div>
                        <label for="coach_id" class="block text-sm font-medium text-gray-700 mb-2">Pelatih</label>
                        <select name="coach_id" id="coach_id" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="" {{ request('coach_id') === '' ? 'selected' : '' }}>Semua Pelatih</option>
                            @foreach($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ request('coach_id') == $coach->id ? 'selected' : '' }}>{{ $coach->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <!-- Sessions List -->
            <div id="sessionsContainer">
                @include('admin.training-sessions._index_list', ['sessions' => $sessions])
                <div class="p-4">{{ $sessions->withQueryString()->links() }}</div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('search');
                    const statusSelect = document.getElementById('status');
                    const sessionTypeSelect = document.getElementById('session_type');
                    const coachSelect = document.getElementById('coach_id');
                    const searchSpinner = document.getElementById('searchSpinner');
                    const sessionsContainer = document.getElementById('sessionsContainer');
                    let searchTimeout;

                    function performSearch() {
                        const searchTerm = searchInput.value;
                        const statusFilter = statusSelect.value;
                        const sessionType = sessionTypeSelect.value;
                        const coachId = coachSelect.value;

                        searchSpinner.classList.remove('hidden');
                        if (searchTimeout) {
                            clearTimeout(searchTimeout);
                        }
                        searchTimeout = setTimeout(() => {
                            const url = new URL(window.location.origin + '/admin/training-sessions');
                            if (searchTerm) url.searchParams.set('search', searchTerm);
                            if (statusFilter) url.searchParams.set('status', statusFilter);
                            if (sessionType) url.searchParams.set('session_type', sessionType);
                            if (coachId) url.searchParams.set('coach_id', coachId);
                            url.searchParams.set('ajax', '1');

                            fetch(url, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    sessionsContainer.innerHTML = data.html;
                                    searchSpinner.classList.add('hidden');
                                    // Update URL without page reload
                                    const newUrl = new URL(window.location);
                                    if (searchTerm) {
                                        newUrl.searchParams.set('search', searchTerm);
                                    } else {
                                        newUrl.searchParams.delete('search');
                                    }
                                    if (statusFilter) {
                                        newUrl.searchParams.set('status', statusFilter);
                                    } else {
                                        newUrl.searchParams.delete('status');
                                    }
                                    if (sessionType) {
                                        newUrl.searchParams.set('session_type', sessionType);
                                    } else {
                                        newUrl.searchParams.delete('session_type');
                                    }
                                    if (coachId) {
                                        newUrl.searchParams.set('coach_id', coachId);
                                    } else {
                                        newUrl.searchParams.delete('coach_id');
                                    }
                                    window.history.pushState({}, '', newUrl);
                                })
                                .catch(error => {
                                    console.error('Search error:', error);
                                    searchSpinner.classList.add('hidden');
                                });
                        }, 500);
                    }

                    searchInput.addEventListener('input', performSearch);
                    statusSelect.addEventListener('change', performSearch);
                    sessionTypeSelect.addEventListener('change', performSearch);
                    coachSelect.addEventListener('change', performSearch);
                });
            </script>
        </div>
    </div>
</body>

</html>