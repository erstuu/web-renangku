<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full p-6">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Web Renangku</h1>
            <p class="text-gray-600 text-lg">Sistem Manajemen Kolam Renang</p>
            <p class="text-gray-500 mt-2">Silakan pilih role untuk masuk ke sistem</p>
        </div>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 max-w-md mx-auto">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 max-w-md mx-auto">
            {{ session('error') }}
        </div>
        @endif

        @if (session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6 max-w-md mx-auto">
            {{ session('info') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Admin Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-red-600 hover:shadow-xl transition duration-300">
                <div class="text-center">
                    <div class="bg-red-600 text-white p-4 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Admin</h3>
                    <p class="text-gray-600 mb-4">Akses penuh untuk mengelola sistem</p>
                    <div class="space-y-2 mb-6">
                        <p class="text-sm text-gray-500">• Kelola semua user</p>
                        <p class="text-sm text-gray-500">• Pengaturan sistem</p>
                        <p class="text-sm text-gray-500">• Laporan lengkap</p>
                    </div>
                    <a href="{{ route('login.admin.form') }}"
                        class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 inline-block text-center">
                        Login Admin
                    </a>
                    <p class="text-xs text-gray-400 mt-2">*Admin tidak dapat mendaftar</p>
                </div>
            </div>

            <!-- Coach Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-green-600 hover:shadow-xl transition duration-300">
                <div class="text-center">
                    <div class="bg-green-600 text-white p-4 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Coach</h3>
                    <p class="text-gray-600 mb-4">Pelatih renang profesional</p>
                    <div class="space-y-2 mb-6">
                        <p class="text-sm text-gray-500">• Kelola jadwal latihan</p>
                        <p class="text-sm text-gray-500">• Data member</p>
                        <p class="text-sm text-gray-500">• Laporan pelatihan</p>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('login.coach.form') }}"
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 inline-block text-center">
                            Login Coach
                        </a>
                        <a href="{{ route('register.coach.form') }}"
                            class="w-full bg-white text-green-600 border border-green-600 py-2 px-4 rounded-md hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 inline-block text-center">
                            Daftar Coach
                        </a>
                    </div>
                </div>
            </div>

            <!-- Member Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-blue-600 hover:shadow-xl transition duration-300">
                <div class="text-center">
                    <div class="bg-blue-600 text-white p-4 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Member</h3>
                    <p class="text-gray-600 mb-4">Anggota kolam renang</p>
                    <div class="space-y-2 mb-6">
                        <p class="text-sm text-gray-500">• Daftar kelas renang</p>
                        <p class="text-sm text-gray-500">• Lihat jadwal latihan</p>
                        <p class="text-sm text-gray-500">• Riwayat latihan</p>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('login.member.form') }}"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 inline-block text-center">
                            Login Member
                        </a>
                        <a href="{{ route('register.member.form') }}"
                            class="w-full bg-white text-blue-600 border border-blue-600 py-2 px-4 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 inline-block text-center">
                            Daftar Member
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                Sistem Web Renangku &copy; 2025. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>

</html>