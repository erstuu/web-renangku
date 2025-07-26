<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup Profil Coach - Web Renangku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Lengkapi Profil Coach Anda
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Silakan isi informasi lengkap untuk mendapatkan persetujuan admin
                </p>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

                @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('warning'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    {{ session('warning') }}
                </div>
                @endif

                @if (session('info'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('info') }}
                </div>
                @endif

                <!-- Progress Indicator -->
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
                                    <path fill-evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">Profil</div>
                        </div>
                        <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                        <div class="flex items-center text-gray-500 relative">
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300">
                                <svg class="w-6 h-6 text-gray-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Approval</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('coach.profile.store') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Specialization -->
                        <div class="md:col-span-2">
                            <label for="specialization" class="block text-sm font-medium mt-4 text-gray-700">
                                Spesialisasi <span class="text-red-500">*</span>
                            </label>
                            <input id="specialization" name="specialization" type="text"
                                value="{{ old('specialization', $coachProfile->specialization ?? '') }}"
                                placeholder="contoh: Renang Gaya Bebas, Renang Anak, Renang Kompetisi"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('specialization') border-red-500 @enderror">
                            @error('specialization')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience Years -->
                        <div>
                            <label for="experience_years" class="block text-sm font-medium text-gray-700">
                                Pengalaman (Tahun) <span class="text-red-500">*</span>
                            </label>
                            <input id="experience_years" name="experience_years" type="number" min="0" max="50"
                                value="{{ old('experience_years', $coachProfile->experience_years ?? '') }}"
                                placeholder="0"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('experience_years') border-red-500 @enderror">
                            @error('experience_years')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hourly Rate -->
                        <div>
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700">
                                Tarif per Jam (Rp)
                            </label>
                            <input id="hourly_rate" name="hourly_rate" type="number" min="0" step="1000"
                                value="{{ old('hourly_rate', $coachProfile->hourly_rate ?? '') }}"
                                placeholder="50000"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('hourly_rate') border-red-500 @enderror">
                            @error('hourly_rate')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Info -->
                        <div class="md:col-span-2">
                            <label for="contact_info" class="block text-sm font-medium text-gray-700">
                                Informasi Kontak <span class="text-red-500">*</span>
                            </label>
                            <input id="contact_info" name="contact_info" type="text"
                                value="{{ old('contact_info', $coachProfile->contact_info ?? '') }}"
                                placeholder="WhatsApp: 08123456789, Email: coach@example.com"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('contact_info') border-red-500 @enderror">
                            @error('contact_info')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Certification -->
                        <div class="md:col-span-2">
                            <label for="certification" class="block text-sm font-medium text-gray-700">
                                Sertifikat/Kualifikasi <span class="text-red-500">*</span>
                            </label>
                            <input id="certification" name="certification" type="text"
                                value="{{ old('certification', $coachProfile->certification ?? '') }}"
                                placeholder="contoh: Sertifikat Pelatih Renang PRSI, Water Safety Instructor"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('certification') border-red-500 @enderror">
                            @error('certification')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="md:col-span-2">
                            <label for="bio" class="block text-sm font-medium text-gray-700">
                                Bio/Deskripsi Diri <span class="text-red-500">*</span>
                            </label>
                            <textarea id="bio" name="bio" rows="4"
                                placeholder="Ceritakan tentang diri Anda, pengalaman melatih, filosofi mengajar, dan hal-hal yang membuat Anda unik sebagai coach renang. Minimal 50 karakter."
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm @error('bio') border-red-500 @enderror">{{ old('bio', $coachProfile->bio ?? '') }}</textarea>
                            @error('bio')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimal 50 karakter</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-sm text-gray-600 hover:text-gray-900">
                            Logout
                        </a>

                        <button type="submit"
                            class="group relative w-auto flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Kirim untuk Persetujuan
                        </button>
                    </div>
                </form>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</body>

</html>