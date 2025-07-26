<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Request Perubahan Data - Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('coach.data-change-requests.index') }}" class="hover:text-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Detail Request Perubahan Data</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">
                                Request #{{ $dataChangeRequest->id }}
                            </h2>
                            <p class="text-sm text-gray-600">
                                Dibuat pada {{ $dataChangeRequest->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            @if($dataChangeRequest->status == 'pending')
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Review
                            </span>
                            @elseif($dataChangeRequest->status == 'approved')
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Disetujui
                            </span>
                            @else
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Ditolak
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Request Type -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Jenis Perubahan</h3>
                        @if($dataChangeRequest->request_type == 'name')
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Nama Lengkap
                        </span>
                        @elseif($dataChangeRequest->request_type == 'email')
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                            Email
                        </span>
                        @else
                        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            Nama Lengkap dan Email
                        </span>
                        @endif
                    </div>

                    <!-- Data Changes -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Perubahan Data</h3>

                        @if($dataChangeRequest->current_name && $dataChangeRequest->requested_name)
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <h4 class="font-medium text-gray-700 mb-2">Nama Lengkap</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Data Lama</label>
                                    <div class="mt-1 p-2 bg-red-50 border border-red-200 rounded-md">
                                        <span class="text-red-700 line-through">{{ $dataChangeRequest->current_name }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Data Baru</label>
                                    <div class="mt-1 p-2 bg-green-50 border border-green-200 rounded-md">
                                        <span class="text-green-700">{{ $dataChangeRequest->requested_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($dataChangeRequest->current_email && $dataChangeRequest->requested_email)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-700 mb-2">Email</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Data Lama</label>
                                    <div class="mt-1 p-2 bg-red-50 border border-red-200 rounded-md">
                                        <span class="text-red-700 line-through">{{ $dataChangeRequest->current_email }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Data Baru</label>
                                    <div class="mt-1 p-2 bg-green-50 border border-green-200 rounded-md">
                                        <span class="text-green-700">{{ $dataChangeRequest->requested_email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Reason -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Alasan Perubahan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $dataChangeRequest->reason }}</p>
                        </div>
                    </div>

                    <!-- Review Information -->
                    @if($dataChangeRequest->status != 'pending')
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Review</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status</label>
                                    <div class="mt-1">
                                        @if($dataChangeRequest->status == 'approved')
                                        <span class="text-green-700 font-medium">Disetujui</span>
                                        @else
                                        <span class="text-red-700 font-medium">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Tanggal Review</label>
                                    <div class="mt-1">
                                        <span class="text-gray-700">
                                            {{ $dataChangeRequest->reviewed_at ? $dataChangeRequest->reviewed_at->format('d M Y, H:i') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($dataChangeRequest->reviewer)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600">Direview oleh</label>
                                <div class="mt-1">
                                    <span class="text-gray-700">{{ $dataChangeRequest->reviewer->full_name }}</span>
                                </div>
                            </div>
                            @endif

                            @if($dataChangeRequest->admin_notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Catatan Admin</label>
                                <div class="mt-1 p-3 bg-white border border-gray-200 rounded-md">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $dataChangeRequest->admin_notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Timeline -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Request dibuat pada
                                                        <span class="font-medium text-gray-900">{{ $dataChangeRequest->created_at->format('d M Y, H:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @if($dataChangeRequest->status != 'pending')
                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                @if($dataChangeRequest->status == 'approved')
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                                @else
                                                <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Request
                                                        <span class="font-medium {{ $dataChangeRequest->status == 'approved' ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ $dataChangeRequest->status == 'approved' ? 'disetujui' : 'ditolak' }}
                                                        </span>
                                                        pada {{ $dataChangeRequest->reviewed_at ? $dataChangeRequest->reviewed_at->format('d M Y, H:i') : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('coach.data-change-requests.index') }}"
                            class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            Kembali ke Daftar
                        </a>

                        @if($dataChangeRequest->status == 'pending')
                        <span class="text-yellow-600 font-medium">Menunggu review dari admin</span>
                        @elseif($dataChangeRequest->status == 'rejected')
                        <a href="{{ route('coach.data-change-requests.create') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Buat Request Baru
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>