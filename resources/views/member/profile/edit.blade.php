<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil Member - Web Renangku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Simple Header -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.profile.show') }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Edit Profil Anda</h1>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4 max-w-4xl">

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

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Edit Profil Member</h2>
                        <p class="text-gray-600 mt-2">Perbarui informasi profil Anda di bawah ini</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">

                <!-- Form -->
                <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Photo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Profil
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if($memberProfile && $memberProfile->profile_photo)
                                <img id="profile-preview" class="h-16 w-16 rounded-full object-cover border-2 border-gray-300"
                                    src="{{ asset('storage/' . $memberProfile->profile_photo) }}"
                                    alt="Profile Photo">
                                @else
                                <div id="profile-preview" class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-300">
                                    <svg class="h-8 w-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="profile_photo" id="profile_photo"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap *
                            </label>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', $user->full_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email *
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon *
                            </label>
                            <input type="tel" name="phone" id="phone"
                                value="{{ old('phone', $memberProfile->phone ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="08123456789"
                                required>
                            @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir *
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="{{ old('date_of_birth', $memberProfile && $memberProfile->date_of_birth ? $memberProfile->date_of_birth->format('Y-m-d') : '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin *
                            </label>
                            <select name="gender" id="gender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $memberProfile->gender ?? '') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $memberProfile->gender ?? '') === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Swimming Experience -->
                        <div>
                            <label for="swimming_experience" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengalaman Renang *
                            </label>
                            <select name="swimming_experience" id="swimming_experience"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                                <option value="">Pilih Pengalaman</option>
                                <option value="beginner" {{ old('swimming_experience', $memberProfile->swimming_experience ?? '') === 'beginner' ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ old('swimming_experience', $memberProfile->swimming_experience ?? '') === 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced" {{ old('swimming_experience', $memberProfile->swimming_experience ?? '') === 'advanced' ? 'selected' : '' }}>Mahir</option>
                            </select>
                            @error('swimming_experience')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan alamat lengkap">{{ old('address', $memberProfile->address ?? '') }}</textarea>
                        @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Kontak Darurat</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Emergency Contact Name -->
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kontak Darurat *
                                </label>
                                <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $memberProfile->emergency_contact_name ?? '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                @error('emergency_contact_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Emergency Contact Phone -->
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telepon Kontak Darurat *
                                </label>
                                <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $memberProfile->emergency_contact_phone ?? '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="08123456789"
                                    required>
                                @error('emergency_contact_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Emergency Contact Relationship -->
                            <div class="sm:col-span-2">
                                <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hubungan dengan Kontak Darurat *
                                </label>
                                <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship"
                                    value="{{ old('emergency_contact_relationship', $memberProfile->emergency_contact_relationship ?? '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Contoh: Orang Tua, Saudara, Teman"
                                    required>
                                @error('emergency_contact_relationship')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Medical Conditions -->
                    <div>
                        <label for="medical_conditions" class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi Medis / Alergi
                        </label>
                        <textarea name="medical_conditions" id="medical_conditions" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Jelaskan kondisi medis atau alergi yang perlu diketahui (opsional)">{{ old('medical_conditions', $memberProfile->medical_conditions ?? '') }}</textarea>
                        @error('medical_conditions')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('member.profile.show') }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize notifications
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = new NotificationManager();
            notifications.autoHideNotifications();
        });

        // Profile photo preview
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-preview');
                    preview.innerHTML = `<img class="h-16 w-16 rounded-full object-cover border-2 border-gray-300" src="${e.target.result}" alt="Profile Photo Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>