<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Member Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if (session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            {{ session('info') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::user()->full_name }}!</h2>
            <p class="text-gray-600 mb-4">Anda login sebagai Member di Web Renangku.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded">
                    <h3 class="font-semibold text-blue-800">Jadwal Latihan</h3>
                    <p class="text-blue-600">Lihat jadwal latihan yang tersedia</p>
                </div>

                <div class="bg-green-50 p-4 rounded">
                    <h3 class="font-semibold text-green-800">Pendaftaran Kelas</h3>
                    <p class="text-green-600">Daftar kelas renang sesuai jadwal</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>