<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Member</title>
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
            <a href="{{ route('member.dashboard') }}" class="text-white hover:text-blue-200 mr-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold">Pengumuman</h1>
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
                        <h2 class="text-2xl font-bold text-gray-800">Pengumuman Terbaru</h2>
                        <p class="text-gray-600 mt-1">Informasi dan berita terbaru untuk member</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if($announcements->count() > 0)
                <div class="space-y-6">
                    @foreach($announcements as $announcement)
                    <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-xl font-semibold text-gray-800 mr-3">
                                        <a href="{{ route('member.announcements.show', $announcement->id) }}"
                                            class="hover:text-blue-600 transition-colors">
                                            {{ $announcement->title }}
                                        </a>
                                    </h3>

                                    <!-- Published Status Badge -->
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>Dipublikasikan
                                    </span>
                                </div>

                                <div class="text-gray-600 mb-3">
                                    <p>{{ Str::limit($announcement->content, 200) }}</p>
                                </div>

                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user mr-1"></i>
                                    <span class="mr-4">{{ $announcement->admin->name }}</span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    <span>{{ $announcement->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            <div class="ml-4">
                                <a href="{{ route('member.announcements.show', $announcement->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($announcements->hasPages())
                <div class="mt-8">
                    {{ $announcements->links() }}
                </div>
                @endif

                @else
                <div class="text-center py-12">
                    <i class="fas fa-bullhorn text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Pengumuman</h3>
                    <p class="text-gray-500">Belum ada pengumuman yang tersedia untuk member.</p>
                </div>
                @endif
            </div>
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