<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ditolak - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Web Renangku</h1>
            <p class="text-gray-600 mt-2">Platform Manajemen Pelatihan Renang</p>
        </div>

        <!-- Rejection Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <!-- Rejection Icon -->
                <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pendaftaran Ditolak</h2>

                <!-- User Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Halo,</p>
                    <p class="font-semibold text-gray-900">{{ $user->full_name }}</p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>

                <!-- Message -->
                <div class="text-left mb-6">
                    <p class="text-gray-600 mb-4">
                        Maaf, pendaftaran Anda sebagai pelatih renang di platform Web Renangku telah
                        <span class="font-semibold text-red-600">ditolak</span> oleh tim admin.
                    </p>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-red-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Kemungkinan Alasan Penolakan:
                        </h4>
                        <ul class="text-sm text-red-700 space-y-1">
                            <li>• Profil tidak lengkap atau informasi tidak valid</li>
                            <li>• Sertifikasi atau kualifikasi tidak memenuhi standar</li>
                            <li>• Dokumen yang diberikan tidak sesuai atau tidak jelas</li>
                            <li>• Pengalaman yang dicantumkan tidak dapat diverifikasi</li>
                        </ul>
                    </div>

                    <p class="text-gray-600">
                        Jika Anda merasa ini adalah kesalahan atau ingin mengajukan kembali pendaftaran
                        dengan informasi yang lebih lengkap, silakan hubungi tim admin kami.
                    </p>
                </div>

                <!-- Contact Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-blue-800 mb-3">
                        <i class="fas fa-phone mr-2"></i>Hubungi Tim Admin
                    </h4>
                    <div class="text-sm text-blue-700 space-y-2">
                        <p><i class="fas fa-envelope mr-2"></i>Email: admin@webrenangku.com</p>
                        <p><i class="fas fa-phone mr-2"></i>Telepon: +62 123-456-7890</p>
                        <p><i class="fas fa-clock mr-2"></i>Jam Kerja: Senin-Jumat, 09:00-17:00 WIB</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="mailto:admin@webrenangku.com?subject=Pertanyaan%20Mengenai%20Penolakan%20Pendaftaran%20Coach&body=Halo%20Tim%20Admin,%0A%0ASaya%20{{ $user->full_name }}%20({{ $user->email }})%20ingin%20menanyakan%20mengenai%20penolakan%20pendaftaran%20saya%20sebagai%20coach.%0A%0ATerima%20kasih."
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>Hubungi Admin
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>

                <!-- Additional Info -->
                <p class="text-xs text-gray-500 mt-6">
                    Pendaftaran ditolak pada: {{ now()->format('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} Web Renangku. Platform Manajemen Pelatihan Renang.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh setiap 30 detik untuk cek status approval yang mungkin berubah
            // setTimeout(() => {
            //     window.location.reload();
            // }, 30000);
        });
    </script>
</body>

</html>