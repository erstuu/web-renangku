<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sesi Latihan - Admin Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.training-sessions.show', $session->id) }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Edit Sesi Latihan</h2>
                    <p class="text-gray-600 mt-1">Ubah data sesi latihan di bawah ini</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow border border-gray-200">
                <form action="{{ route('admin.training-sessions.update', $session->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="session_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Sesi <span class="text-red-500">*</span></label>
                            <input type="text" id="session_name" name="session_name" value="{{ old('session_name', $session->session_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('session_name') border-red-500 @enderror" required>
                            @error('session_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="coach_id" class="block text-sm font-medium text-gray-700 mb-2">Pelatih <span class="text-red-500">*</span></label>
                            <div class="mb-2">
                                <span class="inline-block bg-gray-100 px-3 py-1 rounded text-gray-800 text-sm">
                                    Pelatih saat ini: <strong>{{ $session->coach?->full_name ?? '-' }}</strong>
                                </span>
                            </div>
                            <select id="coach_id" name="coach_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('coach_id') border-red-500 @enderror" required>
                                <option value="{{ $session->coach_id }}" selected hidden>{{ $session->coach?->full_name ?? '-- Pilih Pelatih --' }}</option>
                                @foreach($coaches as $coach)
                                @if($coach->id != $session->coach_id)
                                <option value="{{ $coach->id }}">{{ $coach->full_name }}</option>
                                @endif
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">* Pilih pelatih lain hanya jika ingin mengganti pelatih sesi ini.</p>
                            @error('coach_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time', $session->start_time ? $session->start_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('start_time') border-red-500 @enderror" required>
                            @error('start_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" id="end_time" name="end_time" value="{{ old('end_time', $session->end_time ? $session->end_time->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('end_time') border-red-500 @enderror" required>
                            @error('end_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                            <input type="text" id="location" name="location" value="{{ old('location', $session->location) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('location') border-red-500 @enderror" required>
                            @error('location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="max_capacity" class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Maksimal <span class="text-red-500">*</span></label>
                            <input type="number" id="max_capacity" name="max_capacity" value="{{ old('max_capacity', $session->max_capacity) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('max_capacity') border-red-500 @enderror" required>
                            @error('max_capacity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" value="{{ old('price', $session->price) }}" min="0" step="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('price') border-red-500 @enderror" required>
                            @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="session_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Sesi <span class="text-red-500">*</span></label>
                            <select id="session_type" name="session_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('session_type') border-red-500 @enderror" required>
                                <option value="group" {{ old('session_type', $session->session_type) == 'group' ? 'selected' : '' }}>Group</option>
                                <option value="private" {{ old('session_type', $session->session_type) == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="competition" {{ old('session_type', $session->session_type) == 'competition' ? 'selected' : '' }}>Kompetisi</option>
                            </select>
                            @error('session_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="skill_level" class="block text-sm font-medium text-gray-700 mb-2">Level Kemampuan <span class="text-red-500">*</span></label>
                            <select id="skill_level" name="skill_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('skill_level') border-red-500 @enderror" required>
                                <option value="all" {{ old('skill_level', $session->skill_level) == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="beginner" {{ old('skill_level', $session->skill_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('skill_level', $session->skill_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('skill_level', $session->skill_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('skill_level')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Status Aktif <span class="text-red-500">*</span></label>
                            <select id="is_active" name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('is_active') border-red-500 @enderror" required>
                                <option value="1" {{ old('is_active', $session->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $session->is_active) == 0 ? 'selected' : '' }}>Non-aktif</option>
                            </select>
                            @error('is_active')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('description') border-red-500 @enderror" placeholder="Deskripsi sesi, materi, catatan, dll.">{{ old('description', $session->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.training-sessions.show', $session->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">Batal</a>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>