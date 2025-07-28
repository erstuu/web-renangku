@if($sessions->count() > 0)
<!-- Sessions List -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Sesi Latihan</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $sessions->total() }} sesi ditemukan</p>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach($sessions as $session)
        <div class="p-6 hover:bg-gray-50 flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-swimmer text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ $session->session_name }}</h4>
                        <p class="text-gray-600">{{ $session->coach?->full_name ?? '-' }}</p>
                        <div class="flex items-center gap-4 mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $session->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $session->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">
                                {{ ucfirst($session->session_type) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $session->location }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>{{ $session->start_time->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex flex-col gap-2 ml-4">
                <a href="{{ route('admin.training-sessions.show', $session->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors">
                    <i class="fas fa-eye mr-1"></i>Detail
                </a>
                <form method="POST" action="{{ route('admin.training-sessions.toggle-status', $session->id) }}" onsubmit="return confirm('Ubah status sesi ini?')">
                    @csrf
                    <button type="submit"
                        class="{{ $session->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                        <i class="fas {{ $session->is_active ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                        {{ $session->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.training-sessions.destroy', $session->id) }}" onsubmit="return confirm('Hapus sesi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                        <i class="fas fa-trash mr-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-lg shadow p-12 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-swimmer text-gray-400 text-3xl"></i>
    </div>
    <h4 class="text-lg font-semibold text-gray-700 mb-2">Belum ada sesi latihan ditemukan</h4>
    @if(request()->except('page'))
    <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian.</p>
    @else
    <p class="text-gray-500">Silakan tambahkan sesi latihan baru.</p>
    @endif
</div>
@endif