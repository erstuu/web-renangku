<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-600">
        <div class="text-center mb-6">
            <div class="bg-blue-600 text-white p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Login Member</h2>
            <p class="text-gray-600 mt-2">Masuk ke akun member Web Renangku</p>
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

        <form method="POST" action="{{ route('login.member.store') }}">
            @csrf

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
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Masukkan password"
                    required>
            </div>

            <!-- Remember Me -->
            <div class="mb-6 flex items-center">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                Login sebagai Member
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun member?
                <a href="{{ route('register.member.form') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Daftar di sini
                </a>
            </p>
        </div>

        <!-- Other Login Links -->
        <div class="mt-4 text-center border-t pt-4">
            <p class="text-sm text-gray-600 mb-3">Login sebagai role lain:</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login.coach.form') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                    Coach
                </a>
                <a href="{{ route('login.admin.form') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">
                    Admin
                </a>
            </div>
        </div>

        <!-- Back to General Login -->
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-gray-700">
                Kembali ke halaman login umum
            </a>
        </div>
    </div>
</body>

</html>