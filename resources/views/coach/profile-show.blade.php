<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Coach - Web Renangku</title>
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
            <h1 class="text-xl font-bold">Profil Anda</h1>
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

        <div class="bg-white rounded-lg shadow">
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Informasi Profil Coach</h2>
                        <p class="text-gray-600 mt-2">Detail informasi dan data coach Anda</p>
                    </div>
                    <a href="{{ route('coach.profile.edit') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profil
                    </a>
                </div>

                <!-- Profile Header -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($coachProfile && $coachProfile->profile_photo)
                        <img class="h-20 w-20 rounded-full object-cover border-4 border-green-200"
                            src="{{ asset('storage/' . $coachProfile->profile_photo) }}"
                            alt="Profile Photo">
                        @else
                        <div class="h-20 w-20 rounded-full bg-green-500 flex items-center justify-center border-4 border-green-200">
                            <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $user->full_name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                            Coach
                        </span>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-6">
                @if(!$coachProfile)
                <!-- Profile Incomplete Notice -->
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Profil Belum Lengkap
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Lengkapi profil Anda untuk mendapatkan akses penuh ke fitur coach dan mulai menerima pendaftaran member.</p>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <a href="{{ route('coach.profile.edit') }}"
                                        class="bg-yellow-50 px-2 py-1.5 rounded-md text-sm font-medium text-yellow-800 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600">
                                        Lengkapi Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Profile Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Specialization -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Spesialisasi</h4>
                        <p class="text-gray-900">{{ $coachProfile->specialization ?? 'Belum diisi' }}</p>
                    </div>

                    <!-- Experience -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Pengalaman</h4>
                        <p class="text-gray-900">{{ $coachProfile->experience_years ?? 0 }} Tahun</p>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Informasi Kontak</h4>
                        <p class="text-gray-900">{{ $coachProfile->contact_info ?? 'Belum diisi' }}</p>
                    </div>

                    <!-- Hourly Rate -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Tarif per Jam</h4>
                        <p class="text-gray-900">
                            @if($coachProfile->hourly_rate)
                            Rp {{ number_format($coachProfile->hourly_rate, 0, ',', '.') }}
                            @else
                            Belum diatur
                            @endif
                        </p>
                    </div>

                    <!-- Certification -->
                    <div class="bg-gray-50 p-4 rounded-lg lg:col-span-2">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Sertifikat/Kualifikasi</h4>
                        <p class="text-gray-900">{{ $coachProfile->certification ?? 'Belum diisi' }}</p>
                    </div>

                    <!-- Bio -->
                    <div class="bg-gray-50 p-4 rounded-lg lg:col-span-2">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Bio/Deskripsi Diri</h4>
                        <p class="text-gray-900 whitespace-pre-line">{{ $coachProfile->bio ?? 'Belum diisi' }}</p>
                    </div>
                </div>
                @endif

                <!-- Profile Status -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Status Profil</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($coachProfile)
                                    <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    @else
                                    <svg class="h-6 w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h5 class="text-sm font-medium text-gray-900">Informasi Profil</h5>
                                    <p class="text-sm text-gray-600">
                                        @if($coachProfile)
                                        <span class="text-green-600">Lengkap</span>
                                        @else
                                        <span class="text-yellow-600">Belum Lengkap</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h5 class="text-sm font-medium text-gray-900">Status Akun</h5>
                                    <p class="text-sm text-green-600">Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize notifications
        window.addEventListener('load', function() {
            try {
                if (typeof NotificationManager !== 'undefined') {
                    const notifications = new NotificationManager();
                    notifications.hideNotifications();
                }
            } catch (e) {
                console.warn('Notifications not available:', e.message);
            }
        });
    </script>
</body>

</html>