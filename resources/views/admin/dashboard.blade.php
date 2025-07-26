<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-red-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Admin Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 px-4 py-2 rounded text-white">
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

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Selamat Datang, Admin {{ Auth::user()->full_name }}!</h2>
            <p class="text-gray-600 mb-4">Anda memiliki akses penuh untuk mengelola Web Renangku.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-red-50 p-4 rounded">
                    <h3 class="font-semibold text-red-800">Kelola User</h3>
                    <p class="text-red-600">Manajemen semua user sistem</p>
                </div>

                <div class="bg-blue-50 p-4 rounded">
                    <h3 class="font-semibold text-blue-800">Kelola Coach</h3>
                    <p class="text-blue-600">Manajemen data coach</p>
                </div>

                <div class="bg-green-50 p-4 rounded">
                    <h3 class="font-semibold text-green-800">Kelola Member</h3>
                    <p class="text-green-600">Manajemen data member</p>
                </div>

                <div class="bg-yellow-50 p-4 rounded">
                    <h3 class="font-semibold text-yellow-800">Pengaturan</h3>
                    <p class="text-yellow-600">Konfigurasi sistem</p>
                </div>
            </div>
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