<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sesi Latihan - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('coach.training-sessions.index') }}" class="text-white hover:text-green-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Edit Sesi Latihan</h1>
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
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Edit Sesi Latihan</h2>
                        <p class="text-gray-600 mt-2">Perbarui informasi sesi latihan: {{ $trainingSession->session_name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('coach.training-sessions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Registration Info -->
            @if($trainingSession->sessionRegistrations->count() > 0)
            <div class="p-6 border-b border-gray-200">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Perhatian:</strong> Sesi ini sudah memiliki {{ $trainingSession->sessionRegistrations->count() }} pendaftaran.
                                Hati-hati saat mengubah waktu, lokasi, atau kapasitas karena dapat mempengaruhi peserta yang sudah terdaftar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('coach.training-sessions.update', $trainingSession) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Session Name -->
                        <div>
                            <label for="session_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Sesi Latihan <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                id="session_name"
                                name="session_name"
                                value="{{ old('session_name', $trainingSession->session_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('session_name') border-red-500 @enderror"
                                placeholder="Contoh: Latihan Renang Gaya Bebas Pemula">
                            @error('session_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Sesi
                            </label>
                            <textarea id="description"
                                name="description"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                placeholder="Jelaskan tentang sesi latihan ini, apa yang akan dipelajari, teknik yang diajarkan, dll...">{{ old('description', $trainingSession->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                id="location"
                                name="location"
                                value="{{ old('location', $trainingSession->location) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('location') border-red-500 @enderror"
                                placeholder="Contoh: Kolam Renang Gelora Bung Karno">
                            @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Session Type -->
                        <div>
                            <label for="session_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Sesi <span class="text-red-500">*</span>
                            </label>
                            <select id="session_type"
                                name="session_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('session_type') border-red-500 @enderror">
                                <option value="">Pilih jenis sesi</option>
                                <option value="group" {{ old('session_type', $trainingSession->session_type) == 'group' ? 'selected' : '' }}>Kelompok</option>
                                <option value="private" {{ old('session_type', $trainingSession->session_type) == 'private' ? 'selected' : '' }}>Privat</option>
                                <option value="competition" {{ old('session_type', $trainingSession->session_type) == 'competition' ? 'selected' : '' }}>Persiapan Kompetisi</option>
                            </select>
                            @error('session_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Skill Level -->
                        <div>
                            <label for="skill_level" class="block text-sm font-medium text-gray-700 mb-2">
                                Level Kemampuan <span class="text-red-500">*</span>
                            </label>
                            <select id="skill_level"
                                name="skill_level"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('skill_level') border-red-500 @enderror">
                                <option value="">Pilih level kemampuan</option>
                                <option value="beginner" {{ old('skill_level', $trainingSession->skill_level) == 'beginner' ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ old('skill_level', $trainingSession->skill_level) == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced" {{ old('skill_level', $trainingSession->skill_level) == 'advanced' ? 'selected' : '' }}>Mahir</option>
                                <option value="all" {{ old('skill_level', $trainingSession->skill_level) == 'all' ? 'selected' : '' }}>Semua Level</option>
                            </select>
                            @error('skill_level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $trainingSession->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Sesi aktif (dapat dilihat oleh member)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local"
                                id="start_time"
                                name="start_time"
                                value="{{ old('start_time', $trainingSession->start_time->format('Y-m-d\TH:i')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('start_time') border-red-500 @enderror">
                            @error('start_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local"
                                id="end_time"
                                name="end_time"
                                value="{{ old('end_time', $trainingSession->end_time->format('Y-m-d\TH:i')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('end_time') border-red-500 @enderror">
                            @error('end_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Capacity -->
                        <div>
                            <label for="max_capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                Kapasitas Maksimal <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                id="max_capacity"
                                name="max_capacity"
                                value="{{ old('max_capacity', $trainingSession->max_capacity) }}"
                                min="{{ $trainingSession->sessionRegistrations->count() }}"
                                max="50"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('max_capacity') border-red-500 @enderror"
                                placeholder="Contoh: 10">
                            <p class="text-xs text-gray-500 mt-1">
                                Minimal {{ $trainingSession->sessionRegistrations->count() }} (sudah ada {{ $trainingSession->sessionRegistrations->count() }} pendaftaran), maksimal 50 peserta
                            </p>
                            @error('max_capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price', $trainingSession->price) }}"
                                    min="0"
                                    step="1000"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                    placeholder="150000">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Harga dalam Rupiah per peserta</p>
                            @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Registrations Info -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Informasi Pendaftaran</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <div>Total Pendaftar: <span class="font-medium">{{ $trainingSession->sessionRegistrations->count() }} orang</span></div>
                                <div>Konfirmasi: <span class="font-medium text-green-600">{{ $trainingSession->sessionRegistrations->where('attendance_status', 'confirmed')->count() }} orang</span></div>
                                <div>Menunggu: <span class="font-medium text-yellow-600">{{ $trainingSession->sessionRegistrations->where('attendance_status', 'pending')->count() }} orang</span></div>
                                <div>Kapasitas Tersisa: <span class="font-medium">{{ $trainingSession->max_capacity - $trainingSession->sessionRegistrations->count() }} slot</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('coach.training-sessions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-medium transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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