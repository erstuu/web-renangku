<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Coach - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6 border-t-4 border-green-600">
        <div class="text-center mb-6">
            <div class="bg-green-600 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Coach</h2>
            <p class="text-gray-600 mt-2">Bergabung sebagai coach Web Renangku</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.coach.store') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    value="{{ old('full_name') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan nama lengkap"
                    required>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan username"
                    required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan email"
                    required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan password"
                    required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Konfirmasi password"
                    required>
            </div>

            <!-- Hidden role field -->
            <input type="hidden" name="role" value="coach">

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                Daftar sebagai Coach
            </button>
        </form>

        <!-- Role-specific information -->
        <div class="mt-6 p-4 bg-green-50 rounded-md">
            <p class="text-sm text-green-700">
                <strong>Coach:</strong> Anda dapat mengelola jadwal pelatihan dan melihat data member.
            </p>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun coach?
                <a href="{{ route('login.coach.form') }}" class="text-green-600 hover:text-green-800 font-medium">
                    Login di sini
                </a>
            </p>
        </div>

        <!-- Different role links -->
        <div class="mt-4 text-center border-t pt-4">
            <p class="text-xs text-gray-500 mb-2">Daftar sebagai role lain:</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register.member.form') }}" class="text-xs text-blue-600 hover:text-blue-800">
                    Member
                </a>
            </div>
            <div class="mt-2">
                <p class="text-xs text-gray-400">
                    Admin tidak dapat mendaftar. Silakan <a href="{{ route('login.admin.form') }}" class="text-red-600 hover:text-red-800">login</a> dengan akun admin yang sudah ada.
                </p>
            </div>
        </div>
    </div>
</body>

</html>