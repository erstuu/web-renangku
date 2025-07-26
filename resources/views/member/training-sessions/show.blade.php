<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sesi Latihan - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.training-sessions.index') }}" class="text-white hover:text-blue-200 flex items-center">
                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-xl font-bold">{{ $session->session_name }}</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto max-w-4xl px-4 py-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 notification-message">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 notification-message">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <!-- Coach Profile Section -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Pelatih</h3>
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        @if($session->coach->coachProfile && $session->coach->coachProfile->profile_photo)
                        <img class="h-16 w-16 rounded-full object-cover border-2 border-blue-200"
                            src="{{ asset('storage/' . $session->coach->coachProfile->profile_photo) }}"
                            alt="Foto {{ $session->coach->name }}">
                        @else
                        <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center border-2 border-blue-200">
                            <span class="text-white text-xl font-semibold">
                                {{ substr($session->coach->name, 0, 1) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $session->coach->name }}</h4>
                        <p class="text-sm text-blue-600">Pelatih Renang</p>
                        <p class="text-sm text-gray-500">Berpengalaman dan profesional</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-3">Informasi Sesi</h3>
                    <div class="space-y-2">
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('d M Y') }}</p>
                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}</p>
                        <p><strong>Lokasi:</strong> {{ $session->location }}</p>
                        <p><strong>Kapasitas:</strong> {{ $session->sessionRegistrations->count() }}/{{ $session->max_capacity }}</p>
                        <p><strong>Harga:</strong>
                            @if($session->price > 0)
                            Rp {{ number_format($session->price, 0, ',', '.') }}
                            @else
                            Gratis
                            @endif
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3">Aksi</h3>
                    @if($isRegistered)
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-3">
                        ✓ Anda sudah terdaftar
                    </div>
                    <form action="{{ route('member.training-sessions.cancel', $session->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700"
                            onclick="return confirm('Yakin ingin membatalkan?')">
                            Batalkan Pendaftaran
                        </button>
                    </form>
                    @elseif($availableSlots > 0)
                    <a href="{{ route('member.payment.show', $session->id) }}" class="w-full py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 inline-block text-center">
                        @if($session->price > 0)
                        Daftar & Bayar (Rp {{ number_format($session->price, 0, ',', '.') }})
                        @else
                        Daftar Gratis
                        @endif
                    </a>
                    @else
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        Sesi sudah penuh
                    </div>
                    @endif
                </div>
            </div>

            @if($session->description)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-3">Deskripsi</h3>
                <p class="text-gray-700">{{ $session->description }}</p>
            </div>
            @endif
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