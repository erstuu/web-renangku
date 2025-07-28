@if($coaches->count() > 0)
<!-- Coaches List -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Coach</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $coaches->total() }} coach ditemukan</p>
    </div>

    <div class="divide-y divide-gray-200">
        @foreach($coaches as $coach)
        <div class="p-6 hover:bg-gray-50">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <!-- Coach Info -->
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-red-600 text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $coach->full_name }}</h4>
                            <p class="text-gray-600">{{ $coach->email }}</p>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($coach->approval_status === 'approved') bg-green-100 text-green-800
                                    @elseif($coach->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($coach->approval_status) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($coach->is_active) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $coach->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Bergabung: {{ $coach->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Coach Profile Summary -->
                    @if($coach->coachProfile)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Pengalaman:</span>
                                    {{ $coach->coachProfile->experience_years ?? 0 }} tahun
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-medium">Tarif per Sesi:</span>
                                    Rp {{ number_format($coach->coachProfile->hourly_rate ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Spesialisasi:</span>
                                    @if($coach->coachProfile->specializations)
                                    {{ implode(', ', array_slice(json_decode($coach->coachProfile->specializations, true) ?? [], 0, 2)) }}
                                    @if(count(json_decode($coach->coachProfile->specializations, true) ?? []) > 2)
                                    ...
                                    @endif
                                    @else
                                    <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-2 ml-4">
                    <a href="{{ route('admin.coaches.show', $coach->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors">
                        <i class="fas fa-eye mr-1"></i>Detail
                    </a>
                    <form method="POST" action="{{ route('admin.coaches.toggle-status', $coach->id) }}" onsubmit="return confirm('Yakin ingin mengubah status aktif/nonaktif coach ini?')">
                        @csrf
                        <button type="submit"
                            class="{{ $coach->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                            <i class="fas {{ $coach->is_active ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                            {{ $coach->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.coaches.destroy', $coach->id) }}" onsubmit="return confirm('Hapus coach ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                    @if($coach->approval_status === 'pending')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.coaches.approve', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('Yakin approve coach {{ $coach->full_name }}?')">
                                <i class="fas fa-check mr-1"></i>Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.coaches.reject', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('Yakin tolak coach {{ $coach->full_name }}?')">
                                <i class="fas fa-times mr-1"></i>Tolak
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($coaches->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $coaches->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-lg shadow p-12 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-users text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Coach</h3>
    <p class="text-gray-600 mb-6">
        @if(request()->hasAny(['search', 'status']))
        Tidak ada coach yang sesuai dengan filter yang dipilih.
        @else
        Belum ada coach yang terdaftar di platform.
        @endif
    </p>
    @if(request()->hasAny(['search', 'status']))
    <a href="{{ route('admin.coaches.index') }}"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
        <i class="fas fa-refresh mr-2"></i>Reset Filter
    </a>
    @endif
</div>
@endif