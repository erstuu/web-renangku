<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Renangku - Sistem Manajemen Kolam Renang</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-800 min-h-screen flex items-center justify-center">
    <!-- Logout Success Message -->
    @if (session('success'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
        <div class="bg-white border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="text-center">
        <!-- Hero Section -->
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-white mb-8">
                <!-- Icon -->
                <div class="mx-auto w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-5xl md:text-6xl font-bold mb-4">
                    Web Renangku
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-blue-100 mb-2">
                    Sistem Manajemen Kolam Renang
                </p>

                <!-- Description -->
                <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto">
                    Platform terpadu untuk mengelola aktivitas kolam renang, jadwal pelatihan, dan administrasi member secara efisien
                </p>
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-white">
                    <div class="text-3xl mb-3">👥</div>
                    <h3 class="text-lg font-semibold mb-2">Manajemen Member</h3>
                    <p class="text-blue-100 text-sm">Kelola data member dan registrasi dengan mudah</p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-white">
                    <div class="text-3xl mb-3">📅</div>
                    <h3 class="text-lg font-semibold mb-2">Jadwal Pelatihan</h3>
                    <p class="text-blue-100 text-sm">Atur jadwal latihan dan sesi pelatihan</p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 text-white">
                    <div class="text-3xl mb-3">📊</div>
                    <h3 class="text-lg font-semibold mb-2">Laporan & Analisis</h3>
                    <p class="text-blue-100 text-sm">Monitor progress dan statistik lengkap</p>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="space-y-4">
                <a href="{{ route('role.selector') }}"
                    class="inline-block bg-white text-blue-600 font-semibold py-4 px-8 rounded-xl shadow-lg hover:bg-blue-50 transform hover:scale-105 transition-all duration-200 text-lg">
                    Masuk ke Sistem
                </a>

                <p class="text-blue-200 text-sm">
                    Pilih role Anda: Admin, Coach, atau Member
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-blue-200 text-sm">
            <p>&copy; 2025 Web Renangku. Semua hak dilindungi.</p>
        </div>
    </div>

    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <!-- Floating Bubbles -->
        <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-white bg-opacity-20 rounded-full animate-pulse"></div>
        <div class="absolute top-1/3 right-1/4 w-6 h-6 bg-white bg-opacity-10 rounded-full animate-bounce"></div>
        <div class="absolute bottom-1/4 left-1/3 w-3 h-3 bg-white bg-opacity-30 rounded-full animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/3 w-5 h-5 bg-white bg-opacity-15 rounded-full animate-bounce"></div>
    </div>

    <!-- Auto-hide success message -->
    @if (session('success'))
    <script>
        setTimeout(function() {
            const successMessage = document.querySelector('.fixed.top-4');
            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.remove();
                }, 500);
            }
        }, 5000); // Hide after 5 seconds
    </script>
    @endif
</body>

</html>