<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.training-sessions.show', $session->id) }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Pembayaran Sesi Latihan</h1>
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Session Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Sesi Latihan</h2>

                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Nama Sesi:</span>
                        <span class="text-gray-900">{{ $session->session_name }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Pelatih:</span>
                        <span class="text-gray-900">{{ $session->coach->full_name }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Jadwal:</span>
                        <span class="text-gray-900">{{ $session->start_time->format('d M Y, H:i') }} - {{ $session->end_time->format('H:i') }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Lokasi:</span>
                        <span class="text-gray-900">{{ $session->location }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Tipe:</span>
                        <span class="text-gray-900">{{ ucfirst($session->session_type) }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Level:</span>
                        <span class="text-gray-900">{{ ucfirst($session->skill_level) }}</span>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-700">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($session->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Metode Pembayaran</h2>

                <form action="{{ route('member.payment.process', $session->id) }}" method="POST" id="paymentForm">
                    @csrf

                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Metode Pembayaran</label>

                        <!-- Bank Transfer -->
                        <div class="mb-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Transfer Bank</div>
                                        <div class="text-sm text-gray-500">BCA, BNI, BRI, Mandiri</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- E-Wallet -->
                        <div class="mb-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="e_wallet" class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">E-Wallet</div>
                                        <div class="text-sm text-gray-500">GoPay, OVO, DANA, ShopeePay</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Credit Card -->
                        <div class="mb-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="credit_card" class="mr-3" required>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 6v-2h12v2H4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Kartu Kredit</div>
                                        <div class="text-sm text-gray-500">Visa, Mastercard</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Bank Transfer Details -->
                    <div id="bank_transfer_details" class="payment-details hidden mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank</label>
                                <select name="bank_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="Mandiri">Mandiri</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening</label>
                                <input type="text" name="account_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nomor rekening">
                            </div>
                        </div>
                    </div>

                    <!-- E-Wallet Details -->
                    <div id="e_wallet_details" class="payment-details hidden mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                            <input type="text" name="phone_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();

            // Payment method change handler
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const paymentDetails = document.querySelectorAll('.payment-details');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // Hide all payment details
                    paymentDetails.forEach(detail => {
                        detail.classList.add('hidden');
                    });

                    // Show relevant payment details
                    const selectedDetail = document.getElementById(this.value + '_details');
                    if (selectedDetail) {
                        selectedDetail.classList.remove('hidden');
                    }
                });
            });

            // Form validation
            const form = document.getElementById('paymentForm');
            form.addEventListener('submit', function(e) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');

                if (!selectedMethod) {
                    e.preventDefault();
                    alert('Pilih metode pembayaran terlebih dahulu');
                    return;
                }

                // Validate specific payment method requirements
                if (selectedMethod.value === 'bank_transfer') {
                    const bankName = document.querySelector('select[name="bank_name"]').value;
                    const accountNumber = document.querySelector('input[name="account_number"]').value;

                    if (!bankName || !accountNumber) {
                        e.preventDefault();
                        alert('Lengkapi informasi bank transfer');
                        return;
                    }
                }

                if (selectedMethod.value === 'e_wallet') {
                    const phoneNumber = document.querySelector('input[name="phone_number"]').value;

                    if (!phoneNumber) {
                        e.preventDefault();
                        alert('Masukkan nomor HP untuk e-wallet');
                        return;
                    }
                }
            });
        });
    </script>
</body>

</html>