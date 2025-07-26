<!-- Requests List -->
<div class="bg-white rounded-lg shadow">
    @if($requests->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengguna
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jenis Permintaan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $request->user->full_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $request->user->email }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ ucfirst($request->user->role) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            @switch($request->request_type)
                            @case('name')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user-edit mr-1"></i>Ubah Nama
                            </span>
                            @break
                            @case('email')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-envelope mr-1"></i>Ubah Email
                            </span>
                            @break
                            @case('both')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                <i class="fas fa-edit mr-1"></i>Ubah Nama & Email
                            </span>
                            @break
                            @default
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-question mr-1"></i>{{ ucfirst($request->request_type) }}
                            </span>
                            @endswitch
                        </div>
                        @if($request->reason)
                        <div class="text-xs text-gray-500 mt-1">
                            {{ Str::limit($request->reason, 50) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>{{ $request->created_at->format('d M Y') }}</div>
                        <div class="text-xs">{{ $request->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($request->status)
                        @case('pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Menunggu
                        </span>
                        @break
                        @case('approved')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>Disetujui
                        </span>
                        @break
                        @case('rejected')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times mr-1"></i>Ditolak
                        </span>
                        @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.data-change-requests.show', $request->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm transition-colors">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>

                            @if($request->status === 'pending')
                            <form method="POST" action="{{ route('admin.data-change-requests.approve', $request->id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm transition-colors"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')">
                                    <i class="fas fa-check mr-1"></i>Setujui
                                </button>
                            </form>

                            <button type="button"
                                data-request-id="{{ $request->id }}"
                                onclick="openRejectModal(this.getAttribute('data-request-id'))"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm transition-colors">
                                <i class="fas fa-times mr-1"></i>Tolak
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $requests->links() }}
    </div>
    @endif
    @else
    <div class="text-center py-12">
        <div class="text-gray-400 text-6xl mb-4">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada permintaan</h3>
        <p class="text-gray-500">Belum ada permintaan perubahan data yang masuk.</p>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-times text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Tolak Permintaan
                            </h3>
                            <div class="mt-4">
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan Admin (Opsional)
                                </label>
                                <textarea id="admin_notes"
                                    name="admin_notes"
                                    rows="3"
                                    placeholder="Berikan alasan mengapa permintaan ini ditolak..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tolak
                    </button>
                    <button type="button"
                        onclick="closeRejectModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>