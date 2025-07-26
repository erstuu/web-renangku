@if($pendingCoaches->count() > 0)
<!-- Pending Coaches List -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Coach Pending</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $pendingCoaches->total() }} coach menunggu approval</p>
    </div>

    <div class="divide-y divide-gray-200">
        @foreach($pendingCoaches as $coach)
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
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                Mendaftar: {{ $coach->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <!-- Coach Profile Details -->
                    @if($coach->coachProfile)
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Spesialisasi:</span>
                                    @if($coach->coachProfile->specializations)
                                    {{ implode(', ', json_decode($coach->coachProfile->specializations, true) ?? []) }}
                                    @else
                                    <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    <span class="font-medium">Pengalaman:</span>
                                    {{ $coach->coachProfile->experience_years ?? 0 }} tahun
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Sertifikasi:</span>
                                    @if($coach->coachProfile->certifications)
                                    {{ implode(', ', json_decode($coach->coachProfile->certifications, true) ?? []) }}
                                    @else
                                    <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    <span class="font-medium">Tarif per Sesi:</span>
                                    Rp {{ number_format($coach->coachProfile->hourly_rate ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @if($coach->coachProfile->bio)
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Bio:</span>
                                {{ $coach->coachProfile->bio }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-2 ml-4">
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.coaches.approve', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('Yakin approve coach {{ $coach->full_name }}?')">
                                <i class="fas fa-check mr-1"></i>Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.coaches.reject', $coach->id) }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                                onclick="return confirm('Yakin tolak coach {{ $coach->full_name }}? Aksi ini akan menghapus akun mereka.')">
                                <i class="fas fa-times mr-1"></i>Tolak
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('admin.coaches.show', $coach->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium text-center transition-colors">
                        <i class="fas fa-eye mr-1"></i>Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($pendingCoaches->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $pendingCoaches->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@else
<!-- Empty State -->
<div class="bg-white rounded-lg shadow p-12 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-user-check text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Coach Pending</h3>
    <p class="text-gray-600 mb-6">
        @if(request()->hasAny(['search', 'sort']))
        Tidak ada coach yang sesuai dengan filter yang dipilih.
        @else
        Saat ini tidak ada coach yang menunggu approval.
        @endif
    </p>
    @if(request()->hasAny(['search', 'sort']))
    <a href="{{ route('admin.coaches.pending') }}"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
        <i class="fas fa-refresh mr-2"></i>Reset Filter
    </a>
    @endif
</div>
@endif