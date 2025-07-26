<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permintaan - Admin Web Renangku</title>
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
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-user-friends mr-3"></i>Manajemen Member
                    </a>
                    <a href="{{ route('admin.training-sessions.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-swimming-pool mr-3"></i>Sesi Latihan
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-bullhorn mr-3"></i>Pengumuman
                    </a>
                    <a href="{{ route('admin.data-change-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
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
                        <h2 class="text-3xl font-bold text-gray-800">Detail Permintaan Perubahan Data</h2>
                        <p class="text-gray-600 mt-2">Review dan kelola permintaan perubahan data</p>
                    </div>
                    <a href="{{ route('admin.data-change-requests.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Request Info -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <!-- Request Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Permintaan</h3>
                                <p class="text-sm text-gray-500">ID: #{{ $request->id }}</p>
                            </div>
                            <div class="text-right">
                                @switch($request->status)
                                @case('pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Menunggu Review
                                </span>
                                @break
                                @case('approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Disetujui
                                </span>
                                @break
                                @case('rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>Ditolak
                                </span>
                                @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Request Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Permintaan</label>
                                <p class="mt-1 text-sm text-gray-900">
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
                            </div>

                            @if($request->reason)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alasan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $request->reason }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Permintaan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $request->created_at->format('d F Y, H:i:s') }}</p>
                            </div>

                            @if($request->reviewed_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Ditinjau</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $request->reviewed_at->format('d F Y, H:i:s') }}</p>
                            </div>
                            @endif

                            @if($request->admin_notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan Admin</label>
                                <p class="mt-1 text-sm text-red-600">{{ $request->admin_notes }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Data Comparison -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Perbandingan Data</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Field
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Data Lama
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Data Baru
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if($request->request_type === 'name' || $request->request_type === 'both')
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Nama Lengkap
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->current_name ?: '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                {{ $request->requested_name ?: '-' }}
                                            </td>
                                        </tr>
                                        @endif

                                        @if($request->request_type === 'email' || $request->request_type === 'both')
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Email
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $request->current_email ?: '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                {{ $request->requested_email ?: '-' }}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($request->status === 'pending')
                        <div class="mt-8 flex space-x-4">
                            <form method="POST" action="{{ route('admin.data-change-requests.approve', $request->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')">
                                    <i class="fas fa-check mr-2"></i>Setujui Permintaan
                                </button>
                            </form>

                            <button type="button"
                                onclick="openRejectModal()"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>Tolak Permintaan
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- User Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengguna</h3>

                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user text-gray-600 text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $request->user->full_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $request->user->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ ucfirst($request->user->role) }}</p>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Username</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $request->user->username }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Status Akun</label>
                                        <p class="mt-1">
                                            @if($request->user->is_active)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                            @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>Non-aktif
                                            </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $request->user->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('admin.data-change-requests.reject', $request->id) }}">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Tolak Permintaan
                                </h3>
                                <div class="mt-4">
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan Admin (Opsional)
                                    </label>
                                    <textarea id="admin_notes"
                                        name="admin_notes"
                                        rows="3"
                                        placeholder="Berikan alasan mengapa permintaan ini ditolak..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak Permintaan
                        </button>
                        <button type="button"
                            onclick="closeRejectModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>