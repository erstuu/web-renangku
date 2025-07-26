<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil Coach - Web Renangku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Simple Header -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('coach.dashboard') }}" class="text-white hover:text-green-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Edit Profil Anda</h1>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4 max-w-4xl">

        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Flash Messages -->
            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded notification-message">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded notification-message">
                {{ session('error') }}
            </div>
            @endif

            @if (session('warning'))
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded notification-message">
                {{ session('warning') }}
            </div>
            @endif

            @if (session('info'))
            <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded notification-message">
                {{ session('info') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Profile Information Section -->
            <div class="mb-6">
                <h4 class="text-lg font-bold text-gray-900 mb-2">
                    Informasi Profil Coach
                </h4>
                <p class="text-sm text-gray-500">
                    Lengkapi informasi di bawah ini dengan benar.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('coach.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profile Photo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Profil
                        </label>
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0" id="current-photo">
                                @if($coachProfile && $coachProfile->profile_photo)
                                <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-300"
                                    src="{{ Storage::url($coachProfile->profile_photo) }}"
                                    alt="Foto profil saat ini">
                                @else
                                <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-300">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file"
                                    id="profile_photo"
                                    name="profile_photo"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                @error('profile_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Specialization -->
                    <div class="md:col-span-2">
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                            Spesialisasi *
                        </label>
                        <input id="specialization" name="specialization" type="text"
                            value="{{ old('specialization', $coachProfile->specialization ?? '') }}"
                            placeholder="contoh: Renang Gaya Bebas, Renang Anak, Renang Kompetisi"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('specialization')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience Years -->
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">
                            Pengalaman (Tahun) *
                        </label>
                        <input id="experience_years" name="experience_years" type="number" min="0" max="50"
                            value="{{ old('experience_years', $coachProfile->experience_years ?? '') }}"
                            placeholder="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hourly Rate -->
                    <div>
                        <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif per Jam (Rp)
                        </label>
                        <input id="hourly_rate" name="hourly_rate" type="number" min="0" step="1000"
                            value="{{ old('hourly_rate', $coachProfile->hourly_rate ?? '') }}"
                            placeholder="50000"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('hourly_rate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Info -->
                    <div class="md:col-span-2">
                        <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-2">
                            Informasi Kontak *
                        </label>
                        <input id="contact_info" name="contact_info" type="text"
                            value="{{ old('contact_info', $coachProfile->contact_info ?? '') }}"
                            placeholder="WhatsApp: 08123456789, Email: coach@example.com"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('contact_info')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Certification -->
                    <div class="md:col-span-2">
                        <label for="certification" class="block text-sm font-medium text-gray-700 mb-2">
                            Sertifikat/Kualifikasi *
                        </label>
                        <input id="certification" name="certification" type="text"
                            value="{{ old('certification', $coachProfile->certification ?? '') }}"
                            placeholder="contoh: Sertifikat Pelatih Renang PRSI, Water Safety Instructor"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('certification')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Bio/Deskripsi Diri *
                        </label>
                        <textarea id="bio" name="bio" rows="4"
                            placeholder="Ceritakan tentang diri Anda, pengalaman melatih, filosofi mengajar, dan hal-hal yang membuat Anda unik sebagai coach renang. Minimal 50 karakter."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('bio', $coachProfile->bio ?? '') }}</textarea>
                        @error('bio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimal 50 karakter</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('coach.dashboard') }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-8"></div>

            <!-- Request Data Change Section -->
            <div class="mb-8">
                <h4 class="text-lg font-bold text-gray-900 mb-4">
                    Request Perubahan Data Akun
                </h4>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-yellow-800">
                        <strong>Catatan:</strong> Perubahan nama dan email memerlukan persetujuan admin.
                        Data yang Anda kirim akan direview terlebih dahulu. Minimal salah satu field harus diisi.
                    </p>
                </div>

                <form method="POST" action="{{ route('coach.request-data-change') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Current Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Saat Ini
                            </label>
                            <input type="text" value="{{ auth()->user()->name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                        </div>

                        <!-- New Name -->
                        <div>
                            <label for="requested_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Baru (Opsional)
                            </label>
                            <input id="requested_name" name="requested_name" type="text"
                                value="{{ old('requested_name') }}"
                                placeholder="Masukkan nama baru jika ingin diubah"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Current Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Saat Ini
                            </label>
                            <input type="email" value="{{ auth()->user()->email }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                        </div>

                        <!-- New Email -->
                        <div>
                            <label for="requested_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Baru (Opsional)
                            </label>
                            <input id="requested_email" name="requested_email" type="email"
                                value="{{ old('requested_email') }}"
                                placeholder="Masukkan email baru jika ingin diubah"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Perubahan
                        </label>
                        <textarea id="reason" name="reason" rows="3"
                            placeholder="Jelaskan alasan Anda ingin mengubah data tersebut"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('reason') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simplified and robust photo preview
        function setupPhotoPreview() {
            console.log('Setting up photo preview...');

            const photoInput = document.querySelector('#profile_photo');
            const currentPhoto = document.querySelector('#current-photo');

            console.log('Elements found:', {
                input: !!photoInput,
                container: !!currentPhoto
            });

            if (!photoInput || !currentPhoto) {
                console.error('Required elements not found');
                return;
            }

            photoInput.onchange = function(e) {
                console.log('File input changed');

                const file = e.target.files?.[0];
                if (!file) {
                    console.log('No file selected');
                    return;
                }

                console.log('File:', file.name, file.type, file.size);

                // Validation
                if (!file.type.match(/^image\/(jpeg|jpg|png)$/)) {
                    alert('Please select JPG, JPEG, or PNG image');
                    e.target.value = '';
                    return;
                }

                if (file.size > 2097152) { // 2MB
                    alert('File too large. Maximum 2MB');
                    e.target.value = '';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    console.log('Image loaded, updating preview');
                    currentPhoto.innerHTML = `
                        <img src="${event.target.result}" 
                             alt="Preview" 
                             class="h-20 w-20 object-cover rounded-full border-2 border-gray-300">
                    `;
                };

                reader.onerror = function() {
                    console.error('Failed to read file');
                };

                reader.readAsDataURL(file);
            };

            console.log('Photo preview setup complete');
        }

        // Initialize everything
        window.addEventListener('load', function() {
            console.log('Window loaded');

            // Setup notifications if available
            try {
                if (typeof NotificationManager !== 'undefined') {
                    const notifications = new NotificationManager();
                    notifications.hideNotifications();
                }
            } catch (e) {
                console.warn('Notifications not available:', e.message);
            }

            // Setup photo preview
            setupPhotoPreview();
        });

        // Fallback for DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM ready');

            // Small delay to ensure everything is ready
            setTimeout(function() {
                if (!document.querySelector('#profile_photo').onchange) {
                    console.log('Photo preview not set up, trying again...');
                    setupPhotoPreview();
                }
            }, 100);
        });
    </script>
</body>

</html>