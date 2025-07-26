<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu Persetujuan - Web Renangku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <!-- Pending Icon -->
                <div class="mx-auto w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>

                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Menunggu Persetujuan Admin
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Aplikasi coach Anda sedang ditinjau oleh admin
                </p>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

                @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative notification-message">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative notification-message">
                    {{ session('error') }}
                </div>
                @endif

                @if (session('warning'))
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative notification-message">
                    {{ session('warning') }}
                </div>
                @endif

                @if (session('info'))
                <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative notification-message">
                    {{ session('info') }}
                </div>
                @endif

                <!-- Progress Status -->
                <div class="mb-8">
                    <div class="flex items-center">
                        <div class="flex items-center text-green-600 relative">
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-green-600 bg-green-600 text-white">
                                <svg class="w-6 h-6 text-white mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">Registrasi</div>
                        </div>
                        <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-green-600"></div>
                        <div class="flex items-center text-green-600 relative">
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-green-600 bg-green-600 text-white">
                                <svg class="w-6 h-6 text-white mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">Profil</div>
                        </div>
                        <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-yellow-500"></div>
                        <div class="flex items-center text-yellow-600 relative">
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-yellow-600 bg-yellow-600 text-white animate-pulse">
                                <svg class="w-6 h-6 text-white mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-yellow-600">Approval</div>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Status:</strong> Menunggu persetujuan admin
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Coach Profile Summary -->
                @if($user->coachProfile && $user->coachProfile->isComplete())
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Profil Anda</h3>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->full_name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Spesialisasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->coachProfile->specialization }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pengalaman</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->coachProfile->experience_years }} tahun</dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Sertifikat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->coachProfile->certification }}</dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Bio</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Str::limit($user->coachProfile->bio, 150) }}</dd>
                        </div>
                    </dl>
                </div>
                @endif

                <!-- Information Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Proses Review Sedang Berlangsung
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Admin sedang meninjau aplikasi coach Anda. Proses ini biasanya memakan waktu 1-3 hari kerja. Anda akan mendapat notifikasi melalui email ketika ada update status.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col space-y-4">
                    <a href="{{ route('coach.profile.edit') }}"
                        class="w-full flex justify-center py-2 px-4 border border-blue-300 rounded-md shadow-sm bg-white text-sm font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Profil
                    </a>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Logout
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</body>

</html>