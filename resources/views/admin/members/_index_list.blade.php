@if($members->count() > 0)
<!-- Members List -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Member</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $members->total() }} member ditemukan</p>
    </div>

    <div class="divide-y divide-gray-200">
        @foreach($members as $member)
        <div class="p-6 hover:bg-gray-50">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <!-- Member Info -->
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $member->full_name }}</h4>
                            <p class="text-gray-600">{{ $member->email }}</p>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Bergabung: {{ $member->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-2 ml-4">
                    <a href="{{ route('admin.members.show', $member->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors">
                        <i class="fas fa-eye mr-1"></i>Detail
                    </a>
                    <form method="POST" action="{{ route('admin.members.toggle-status', $member->id) }}" onsubmit="return confirm('Yakin ingin mengubah status aktif/nonaktif member ini?')">
                        @csrf
                        <button type="submit"
                            class="{{ $member->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                            <i class="fas {{ $member->is_active ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                            {{ $member->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.members.destroy', $member->id) }}" onsubmit="return confirm('Hapus member ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-users text-gray-400 text-3xl"></i>
        </div>
        @if(request()->filled('search') || request()->filled('status'))
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Member</h3>
        <p class="text-gray-600 mb-6">Tidak ada member yang sesuai dengan filter yang dipilih.</p>
        <a href="{{ route('admin.members.index') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
            <i class="fas fa-refresh mr-2"></i>Reset Filter
        </a>
        @else
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Member</h3>
        <p class="text-gray-600 mb-6">Belum ada member yang terdaftar di platform.</p>
        @endif
    </div>
    @endif