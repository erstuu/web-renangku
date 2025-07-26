<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Member - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('coach.dashboard') }}" class="text-white hover:text-green-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Pendaftaran Member</h1>
            </div>
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

        <div class="bg-white rounded-lg shadow">
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Pendaftaran Member</h2>
                        <p class="text-gray-600 mt-2">Kelola pendaftaran member ke sesi latihan renang Anda</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-800">Menunggu Konfirmasi</p>
                                <p class="text-2xl font-bold text-yellow-900">{{ $pendingCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">Dikonfirmasi</p>
                                <p class="text-2xl font-bold text-green-900">{{ $approvedCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800">Total Pendaftaran</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $registrations->total() ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                    <button class="filter-tab w-full py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm" data-status="all">
                        Semua Pendaftaran
                    </button>
                    <button class="filter-tab w-full py-2 px-4 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900" data-status="pending">
                        Menunggu Konfirmasi
                    </button>
                    <button class="filter-tab w-full py-2 px-4 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900" data-status="confirmed">
                        Dikonfirmasi
                    </button>
                    <button class="filter-tab w-full py-2 px-4 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900" data-status="cancelled">
                        Ditolak
                    </button>
                </div>
            </div>

            <!-- Registrations List -->
            <div class="p-6">
                @if($registrations && $registrations->count() > 0)
                <div class="space-y-4">
                    @foreach($registrations as $registration)
                    <div class="registration-item border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors" data-status="{{ $registration->attendance_status }}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <!-- Member Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-lg">
                                                {{ substr($registration->member->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Registration Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $registration->member->full_name }}</h3>
                                                <p class="text-sm text-gray-600">{{ $registration->member->email }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">{{ $registration->trainingSession->session_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $registration->trainingSession->start_time->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-2 flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <!-- Status Badge -->
                                                @if($registration->attendance_status === 'pending')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu Konfirmasi
                                                </span>
                                                @elseif($registration->attendance_status === 'confirmed')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Dikonfirmasi
                                                </span>
                                                @elseif($registration->attendance_status === 'cancelled')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                                @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($registration->attendance_status) }}
                                                </span>
                                                @endif

                                                <!-- Payment Status -->
                                                @if($registration->payment_status === 'paid')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Sudah Bayar
                                                </span>
                                                @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Belum Bayar
                                                </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Daftar: {{ $registration->registered_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if($registration->attendance_status === 'pending')
                            <div class="flex items-center space-x-2 ml-4">
                                <form method="POST" action="{{ route('coach.registrations.approve', $registration) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                                        Konfirmasi
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('coach.registrations.reject', $registration) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran ini?')">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>

                        <!-- Additional Info (Collapsible) -->
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Lokasi:</span>
                                    <span class="ml-1 text-gray-900">{{ $registration->trainingSession->location }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Durasi:</span>
                                    <span class="ml-1 text-gray-900">
                                        {{ $registration->trainingSession->start_time->format('H:i') }} -
                                        {{ $registration->trainingSession->end_time->format('H:i') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Harga:</span>
                                    <span class="ml-1 text-gray-900">Rp {{ number_format($registration->trainingSession->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $registrations->links() }}
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pendaftaran</h3>
                    <p class="mt-1 text-sm text-gray-500">Pendaftaran member akan muncul di sini setelah mereka mendaftar ke sesi latihan Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('coach.training-sessions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Sesi Latihan Baru
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();

            // Filter functionality
            const filterTabs = document.querySelectorAll('.filter-tab');
            const registrationItems = document.querySelectorAll('.registration-item');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');

                    // Update active tab
                    filterTabs.forEach(t => {
                        t.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                        t.classList.add('text-gray-600', 'hover:text-gray-900');
                    });
                    this.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                    this.classList.remove('text-gray-600', 'hover:text-gray-900');

                    // Filter items
                    registrationItems.forEach(item => {
                        if (status === 'all' || item.getAttribute('data-status') === status) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>