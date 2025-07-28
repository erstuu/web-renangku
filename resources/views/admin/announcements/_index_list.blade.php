@if($announcements->count() > 0)
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengumuman</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $announcements->total() }} pengumuman ditemukan</p>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach($announcements as $announcement)
        <div class="p-6 hover:bg-gray-50">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-bullhorn text-yellow-600 text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="hover:underline">{{ $announcement->title }}</a>
                            </h4>
                            <div class="flex items-center gap-4 mt-1">
                                @if($announcement->is_published)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                                @endif
                                <span class="text-sm text-gray-500"><i class="fas fa-user mr-1"></i>{{ $announcement->admin->full_name ?? '-' }}</span>
                                <span class="text-sm text-gray-500"><i class="fas fa-calendar mr-1"></i>{{ $announcement->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 ml-4">
                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors"><i class="fas fa-eye mr-1"></i>Detail</a>
                    <form action="{{ route('admin.announcements.toggle-publish', $announcement->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $announcement->is_published ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-3 py-2 rounded-md text-sm font-medium text-center transition-colors w-full min-w-[120px]">
                            @if($announcement->is_published)
                            <i class="fas fa-eye-slash mr-1"></i>Jadikan Draft
                            @else
                            <i class="fas fa-upload mr-1"></i>Publish
                            @endif
                        </button>
                    </form>
                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
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
</div>
@else
<div class="bg-white rounded-lg shadow p-12 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-bullhorn text-gray-400 text-3xl"></i>
    </div>
    @if(request()->filled('search') || request()->filled('status'))
    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Pengumuman</h3>
    <p class="text-gray-600 mb-6">Tidak ada pengumuman yang sesuai dengan filter yang dipilih.</p>
    <a href="{{ route('admin.announcements.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md inline-flex items-center">
        <i class="fas fa-refresh mr-2"></i>Reset Filter
    </a>
    @else
    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pengumuman</h3>
    <p class="text-gray-600 mb-6">Belum ada pengumuman yang terdaftar di platform.</p>
    @endif
</div>
@endif