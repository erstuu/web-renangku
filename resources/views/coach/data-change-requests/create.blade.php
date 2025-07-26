<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Perubahan Data - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('coach.profile.edit') }}" class="hover:text-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Request Perubahan Data</h1>
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

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-600 text-white p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-500 p-3 rounded-full mr-4">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Request Perubahan Data</h2>
                            <p class="text-blue-100">Ajukan perubahan nama lengkap atau email</p>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Perubahan data pribadi memerlukan persetujuan admin untuk menjaga keamanan akun Anda.
                                Pastikan data yang dimasukkan sudah benar dan sesuai dengan identitas resmi Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('coach.data-change-requests.store') }}" class="p-6">
                    @csrf

                    <!-- Data Saat Ini -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Saat Ini</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ $user->full_name }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Perubahan -->
                    <div class="mb-6">
                        <label for="request_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Perubahan <span class="text-red-500">*</span>
                        </label>
                        <select id="request_type" name="request_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('request_type') border-red-500 @enderror">
                            <option value="">Pilih jenis perubahan</option>
                            <option value="name" {{ request('type') == 'name' || old('request_type') == 'name' ? 'selected' : '' }}>Nama Lengkap</option>
                            <option value="email" {{ request('type') == 'email' || old('request_type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="both" {{ old('request_type') == 'both' ? 'selected' : '' }}>Nama Lengkap dan Email</option>
                        </select>
                        @error('request_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data Baru -->
                    <div class="mb-6" id="new-data-section" style="display: none;">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Baru</h3>

                        <!-- Nama Baru -->
                        <div class="mb-4" id="name-field" style="display: none;">
                            <label for="requested_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="requested_name" name="requested_name"
                                value="{{ old('requested_name') }}"
                                disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed @error('requested_name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap yang baru">
                            @error('requested_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Baru -->
                        <div class="mb-4" id="email-field" style="display: none;">
                            <label for="requested_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="requested_email" name="requested_email"
                                value="{{ old('requested_email') }}"
                                disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed @error('requested_email') border-red-500 @enderror"
                                placeholder="Masukkan email yang baru">
                            @error('requested_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Perubahan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="reason" name="reason" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reason') border-red-500 @enderror"
                            placeholder="Jelaskan alasan mengapa Anda perlu mengubah data tersebut...">{{ old('reason') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter. Berikan alasan yang jelas agar admin dapat memproses request Anda.</p>
                        <div class="text-xs text-gray-400 mt-1">
                            <span id="reason-count">{{ strlen(old('reason', '')) }}</span> karakter
                        </div>
                        @error('reason')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('coach.profile.edit') }}"
                            class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Kirim Request
                        </button>
                    </div>
                </form>
            </div>

            <!-- Link ke Riwayat Request -->
            <div class="mt-6 text-center">
                <a href="{{ route('coach.data-change-requests.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Riwayat Request Perubahan Data →
                </a>
            </div>
        </div>
    </div>

    <script>
        // Handle request type change
        document.getElementById('request_type').addEventListener('change', function() {
            const value = this.value;
            const newDataSection = document.getElementById('new-data-section');
            const nameField = document.getElementById('name-field');
            const emailField = document.getElementById('email-field');
            const nameInput = document.getElementById('requested_name');
            const emailInput = document.getElementById('requested_email');

            if (value) {
                newDataSection.style.display = 'block';

                if (value === 'name' || value === 'both') {
                    nameField.style.display = 'block';
                    nameInput.disabled = false;
                } else {
                    nameField.style.display = 'none';
                    nameInput.disabled = true;
                    nameInput.value = '';
                }

                if (value === 'email' || value === 'both') {
                    emailField.style.display = 'block';
                    emailInput.disabled = false;
                } else {
                    emailField.style.display = 'none';
                    emailInput.disabled = true;
                    emailInput.value = '';
                }
            } else {
                newDataSection.style.display = 'none';
                nameInput.disabled = true;
                emailInput.disabled = true;
                nameInput.value = '';
                emailInput.value = '';
            }
        });

        // Character counter for reason
        document.getElementById('reason').addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('reason-count').textContent = count;

            const counter = document.getElementById('reason-count');
            if (count < 10) {
                counter.parentElement.className = 'text-xs text-red-400 mt-1';
            } else {
                counter.parentElement.className = 'text-xs text-green-400 mt-1';
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger change event to show fields if pre-selected
            document.getElementById('request_type').dispatchEvent(new Event('change'));

            // Initialize counter
            const reason = document.getElementById('reason');
            const count = reason.value.length;
            const counter = document.getElementById('reason-count');

            if (count < 10) {
                counter.parentElement.className = 'text-xs text-red-400 mt-1';
            } else {
                counter.parentElement.className = 'text-xs text-green-400 mt-1';
            }
        });
    </script>
</body>

</html>