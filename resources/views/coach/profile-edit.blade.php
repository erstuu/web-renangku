<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Coach - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('coach.dashboard') }}" class="hover:text-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Edit Profil Coach</h1>
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
        <!-- Flash Messages -->
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

        @if (session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('warning') }}
        </div>
        @endif

        @if (session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 notification-message">
            {{ session('info') }}
        </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 text-white p-6">
                    <div class="flex items-center">
                        <div class="bg-green-500 p-3 rounded-full mr-4">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Edit Profil Coach</h2>
                            <p class="text-green-100">Perbarui informasi profil Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('coach.profile.update') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Informasi Dasar -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>

                                <!-- Nama Lengkap (Read-only) -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <div class="flex space-x-2">
                                        <input type="text" value="{{ $user->full_name }}"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600"
                                            readonly>
                                        <a href="{{ route('coach.data-change-requests.create') }}?type=name"
                                            class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 transition-colors text-sm">
                                            Request Ubah
                                        </a>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Nama tidak dapat diubah langsung. Gunakan tombol "Request Ubah" untuk mengajukan perubahan ke admin.</p>
                                </div>

                                <!-- Email (Read-only) -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>
                                    <div class="flex space-x-2">
                                        <input type="email" value="{{ $user->email }}"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600"
                                            readonly>
                                        <a href="{{ route('coach.data-change-requests.create') }}?type=email"
                                            class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 transition-colors text-sm">
                                            Request Ubah
                                        </a>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah langsung. Gunakan tombol "Request Ubah" untuk mengajukan perubahan ke admin.</p>
                                </div>

                                <!-- Spesialisasi -->
                                <div class="mb-4">
                                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                                        Spesialisasi <span class="text-red-500">*</span>
                                    </label>
                                    <select id="specialization" name="specialization"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('specialization') border-red-500 @enderror">
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="Gaya Bebas" {{ old('specialization', $coachProfile->specialization ?? '') == 'Gaya Bebas' ? 'selected' : '' }}>Gaya Bebas</option>
                                        <option value="Gaya Punggung" {{ old('specialization', $coachProfile->specialization ?? '') == 'Gaya Punggung' ? 'selected' : '' }}>Gaya Punggung</option>
                                        <option value="Gaya Dada" {{ old('specialization', $coachProfile->specialization ?? '') == 'Gaya Dada' ? 'selected' : '' }}>Gaya Dada</option>
                                        <option value="Gaya Kupu-kupu" {{ old('specialization', $coachProfile->specialization ?? '') == 'Gaya Kupu-kupu' ? 'selected' : '' }}>Gaya Kupu-kupu</option>
                                        <option value="Renang Kompetitif" {{ old('specialization', $coachProfile->specialization ?? '') == 'Renang Kompetitif' ? 'selected' : '' }}>Renang Kompetitif</option>
                                        <option value="Renang Rekreasi" {{ old('specialization', $coachProfile->specialization ?? '') == 'Renang Rekreasi' ? 'selected' : '' }}>Renang Rekreasi</option>
                                        <option value="Water Safety" {{ old('specialization', $coachProfile->specialization ?? '') == 'Water Safety' ? 'selected' : '' }}>Water Safety</option>
                                        <option value="Aqua Fitness" {{ old('specialization', $coachProfile->specialization ?? '') == 'Aqua Fitness' ? 'selected' : '' }}>Aqua Fitness</option>
                                    </select>
                                    @error('specialization')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Pengalaman -->
                                <div class="mb-4">
                                    <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pengalaman (Tahun) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="experience_years" name="experience_years"
                                        value="{{ old('experience_years', $coachProfile->experience_years ?? '') }}"
                                        min="0" max="50"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('experience_years') border-red-500 @enderror"
                                        placeholder="Contoh: 5">
                                    @error('experience_years')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tarif per Jam -->
                                <div class="mb-4">
                                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tarif per Jam (Rp)
                                    </label>
                                    <input type="number" id="hourly_rate" name="hourly_rate"
                                        value="{{ old('hourly_rate', $coachProfile->hourly_rate ?? '') }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('hourly_rate') border-red-500 @enderror"
                                        placeholder="Contoh: 150000">
                                    <p class="text-xs text-gray-500 mt-1">Opsional - Bisa dikosongkan</p>
                                    @error('hourly_rate')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Informasi Kontak & Sertifikasi -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Kontak & Sertifikasi</h3>

                                <!-- Informasi Kontak -->
                                <div class="mb-4">
                                    <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-2">
                                        Informasi Kontak <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="contact_info" name="contact_info" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('contact_info') border-red-500 @enderror"
                                        placeholder="Contoh: WhatsApp: 08123456789, Instagram: @coach_swim">{{ old('contact_info', $coachProfile->contact_info ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Informasi kontak yang bisa dihubungi member</p>
                                    @error('contact_info')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sertifikasi -->
                                <div class="mb-4">
                                    <label for="certification" class="block text-sm font-medium text-gray-700 mb-2">
                                        Sertifikasi <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="certification" name="certification" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('certification') border-red-500 @enderror"
                                        placeholder="Contoh: Certified Swimming Instructor (CSI) 2020, Water Safety Instructor (WSI) 2019">{{ old('certification', $coachProfile->certification ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Sebutkan sertifikat yang Anda miliki</p>
                                    @error('certification')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bio/Deskripsi -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Bio/Deskripsi</h3>

                                <div class="mb-4">
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                        Bio/Deskripsi Diri <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="bio" name="bio" rows="6"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                                        placeholder="Ceritakan tentang pengalaman, gaya mengajar, dan keahlian Anda sebagai pelatih renang...">{{ old('bio', $coachProfile->bio ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 50 karakter. Deskripsikan pengalaman dan keahlian Anda</p>
                                    <div class="text-xs text-gray-400 mt-1">
                                        <span id="bio-count">{{ strlen(old('bio', $coachProfile->bio ?? '')) }}</span> karakter
                                    </div>
                                    @error('bio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between">
                            <a href="{{ route('coach.dashboard') }}"
                                class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Character counter for bio
        document.getElementById('bio').addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('bio-count').textContent = count;

            // Change color based on requirement
            const counter = document.getElementById('bio-count');
            if (count < 50) {
                counter.parentElement.className = 'text-xs text-red-400 mt-1';
            } else {
                counter.parentElement.className = 'text-xs text-green-400 mt-1';
            }
        });

        // Initialize character counter on page load
        document.addEventListener('DOMContentLoaded', function() {
            const bio = document.getElementById('bio');
            const count = bio.value.length;
            const counter = document.getElementById('bio-count');

            if (count < 50) {
                counter.parentElement.className = 'text-xs text-red-400 mt-1';
            } else {
                counter.parentElement.className = 'text-xs text-green-400 mt-1';
            }
        });
    </script>
</body>

</html>