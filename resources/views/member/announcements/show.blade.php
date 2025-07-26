<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Notifications -->
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

    <!-- Simple Header -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex items-center">
            <a href="{{ route('member.announcements.index') }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Detail Pengumuman</h1>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow">
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-orange-500 flex items-center justify-center">
                            <i class="fas fa-bullhorn text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $announcement->title }}</h2>
                        <p class="text-gray-600 mt-1">
                            <i class="fas fa-user mr-1"></i>{{ $announcement->admin->name }} •
                            <i class="fas fa-calendar mr-1"></i>{{ $announcement->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Published Status Badge -->
                <div class="mb-6">
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                        <i class="fas fa-check-circle mr-1"></i>Dipublikasikan
                    </span>
                </div>

                <!-- Announcement Content -->
                <div class="prose max-w-none">
                    <div class="text-gray-800 leading-relaxed text-lg">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                </div>

                <!-- Additional Information -->
                @if($announcement->updated_at != $announcement->created_at)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-edit mr-1"></i>
                        Terakhir diperbarui: {{ $announcement->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-end">
                        <div class="flex items-center space-x-2">
                            <button onclick="window.print()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-print mr-2"></i>Cetak
                            </button>

                            <button onclick="shareAnnouncement()"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                <i class="fas fa-share mr-2"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize notifications
            const notificationManager = new NotificationManager();
        });

        function shareAnnouncement() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $announcement->title }}',
                    text: '{{ Str::limit(strip_tags($announcement->content), 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Link berhasil disalin ke clipboard!');
                });
            }
        }
    </script>
</body>

</html>