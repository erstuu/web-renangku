<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.registrations.index') }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Konfirmasi Pembayaran</h1>
        </div>
    </nav>

    <div class="container mx-auto max-w-4xl px-4 py-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 notification-message">
            {{ session('success') }}
        </div>
        @endif

        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600">Silakan lakukan pembayaran untuk mengkonfirmasi pendaftaran Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Registration Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Pendaftaran</h2>

                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Sesi Latihan:</span>
                        <span class="text-gray-900">{{ $registration->trainingSession->session_name }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Pelatih:</span>
                        <span class="text-gray-900">{{ $registration->trainingSession->coach->full_name }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Jadwal:</span>
                        <span class="text-gray-900">{{ $registration->trainingSession->start_time->format('d M Y, H:i') }} - {{ $registration->trainingSession->end_time->format('H:i') }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Lokasi:</span>
                        <span class="text-gray-900">{{ $registration->trainingSession->location }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Tanggal Daftar:</span>
                        <span class="text-gray-900">{{ $registration->registered_at->format('d M Y, H:i') }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Status Pembayaran:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Instruksi Pembayaran</h2>

                @if($paymentInfo && isset($paymentInfo['payment_method']))
                @if($paymentInfo['payment_method'] === 'bank_transfer')
                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <h3 class="font-medium text-blue-900 mb-2">Transfer Bank</h3>
                    <div class="space-y-2 text-sm text-blue-800">
                        <div>Bank: {{ $paymentInfo['bank_name'] ?? 'N/A' }}</div>
                        <div>Rekening: {{ $paymentInfo['account_number'] ?? 'N/A' }}</div>
                        <div>Jumlah: Rp {{ number_format($paymentInfo['amount'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-4 rounded-lg mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Nomor Rekening Tujuan:</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>BCA:</span>
                            <span class="font-mono">1234567890</span>
                        </div>
                        <div class="flex justify-between">
                            <span>BNI:</span>
                            <span class="font-mono">0987654321</span>
                        </div>
                        <div class="flex justify-between">
                            <span>BRI:</span>
                            <span class="font-mono">1122334455</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Mandiri:</span>
                            <span class="font-mono">5544332211</span>
                        </div>
                    </div>
                </div>
                @elseif($paymentInfo['payment_method'] === 'e_wallet')
                <div class="bg-green-50 p-4 rounded-lg mb-4">
                    <h3 class="font-medium text-green-900 mb-2">E-Wallet</h3>
                    <div class="space-y-2 text-sm text-green-800">
                        <div>Nomor HP: {{ $paymentInfo['phone_number'] ?? 'N/A' }}</div>
                        <div>Jumlah: Rp {{ number_format($paymentInfo['amount'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-4 rounded-lg mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Scan QR Code atau transfer ke:</h4>
                    <div class="space-y-2 text-sm">
                        <div>GoPay: 081234567890</div>
                        <div>OVO: 081234567890</div>
                        <div>DANA: 081234567890</div>
                        <div>ShopeePay: 081234567890</div>
                    </div>
                </div>
                @elseif($paymentInfo['payment_method'] === 'credit_card')
                <div class="bg-purple-50 p-4 rounded-lg mb-4">
                    <h3 class="font-medium text-purple-900 mb-2">Kartu Kredit</h3>
                    <div class="space-y-2 text-sm text-purple-800">
                        <div>Jumlah: Rp {{ number_format($paymentInfo['amount'] ?? 0, 0, ',', '.') }}</div>
                        <div>Referensi: {{ $paymentInfo['payment_reference'] ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-4 rounded-lg mb-4">
                    <p class="text-sm text-gray-600">
                        Anda akan diarahkan ke halaman pembayaran yang aman untuk menyelesaikan transaksi kartu kredit.
                    </p>
                </div>
                @endif
                @endif

                <!-- Payment Amount -->
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-700">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($registration->trainingSession->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Reference Number -->
                @if($paymentInfo && isset($paymentInfo['payment_reference']))
                <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                    <h4 class="font-medium text-yellow-900 mb-2">Nomor Referensi:</h4>
                    <div class="font-mono text-yellow-800">{{ $paymentInfo['payment_reference'] }}</div>
                    <div class="text-sm text-yellow-700 mt-1">Simpan nomor ini sebagai bukti pembayaran</div>
                </div>
                @endif

                <!-- Instructions -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Instruksi:</h4>
                    <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                        <li>Lakukan pembayaran sesuai dengan jumlah yang tertera</li>
                        <li>Gunakan nomor referensi sebagai keterangan transfer</li>
                        <li>Pembayaran akan diverifikasi dalam 1x24 jam</li>
                        <li>Anda akan mendapat notifikasi setelah pembayaran dikonfirmasi</li>
                    </ol>
                </div>

                <!-- Demo Complete Payment Button -->
                <div class="mt-6">
                    <form action="{{ route('member.payment.complete', $registration->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors font-medium">
                            [DEMO] Simulasi Pembayaran Selesai
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        *Tombol ini hanya untuk demo. Di aplikasi nyata, status akan otomatis diupdate setelah pembayaran.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('member.registrations.index') }}"
                class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                Lihat Riwayat Pendaftaran
            </a>
            <a href="{{ route('member.training-sessions.index') }}"
                class="bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700 transition-colors">
                Kembali ke Sesi Latihan
            </a>
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