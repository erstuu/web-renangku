<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - Admin Web Renangku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/admin-modals.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-red-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Web Renangku - Admin Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-red-200">{{ Auth::user()->full_name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="flex">
        <div class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.coaches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-users mr-3"></i>Manajemen Coach
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-2 text-gray-700 bg-red-100 rounded-md">
                        <i class="fas fa-user-friends mr-3"></i>Manajemen Member
                    </a>
                    <a href="{{ route('admin.training-sessions.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-swimming-pool mr-3"></i>Sesi Latihan
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-bullhorn mr-3"></i>Pengumuman
                    </a>
                    <a href="{{ route('admin.data-change-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-edit mr-3"></i>Permintaan Perubahan Data
                    </a>
                </nav>
            </div>
        </div>
        <div class="flex-1 p-6">
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
            <div class="flex items-center justify-between mb-6">
                <div>
                    <div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.members.show', $member->id) }}" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-arrow-left text-xl"></i>
                            </a>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800">Edit Member</h2>
                                <p class="text-gray-600 mt-1">Ubah data member berikut sesuai kebutuhan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <form action="{{ route('admin.members.update', $member->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Informasi Akun</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea id="address" name="address" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('address') border-red-500 @enderror">{{ old('address', $member->address) }}</textarea>
                                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="membership_status" class="block text-sm font-medium text-gray-700 mb-2">Status Membership</label>
                                <select id="membership_status" name="membership_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('membership_status') border-red-500 @enderror">
                                    <option value="active" {{ old('membership_status', optional($member->memberProfile)->membership_status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('membership_status', optional($member->memberProfile)->membership_status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="pending" {{ old('membership_status', optional($member->memberProfile)->membership_status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                </select>
                                @error('membership_status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('full_name') border-red-500 @enderror" required>
                                @error('full_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                                <input type="text" id="username" name="username" value="{{ old('username', $member->username) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('username') border-red-500 @enderror" required>
                                @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('email') border-red-500 @enderror" required>
                                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('password') border-red-500 @enderror">
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Informasi Profil Member</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', optional($member->memberProfile)->phone) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('phone') border-red-500 @enderror">
                                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', optional($member->memberProfile)->date_of_birth) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('date_of_birth') border-red-500 @enderror">
                                @error('date_of_birth')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kontak Darurat</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', optional($member->memberProfile)->emergency_contact_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('emergency_contact_name') border-red-500 @enderror">
                                @error('emergency_contact_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Darurat</label>
                                <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', optional($member->memberProfile)->emergency_contact_phone) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('emergency_contact_phone') border-red-500 @enderror">
                                @error('emergency_contact_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="medical_notes" class="block text-sm font-medium text-gray-700 mb-2">Kondisi Medis</label>
                                <textarea id="medical_notes" name="medical_notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('medical_notes') border-red-500 @enderror">{{ old('medical_notes', optional($member->memberProfile)->medical_notes) }}</textarea>
                                @error('medical_notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.members.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">Batal</a>
                        <button id="submitBtn" type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">Simpan Perubahan</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
</body>

</html>