@extends('layouts.admin')

@section('title', 'Pengaturan Akun & Sistem')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Profil Admin</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Asli</label>
                    <input type="text" name="nama_asli" value="{{ old('nama_asli', $user->nama_asli) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Samaran (Alias)</label>
                    <input type="text" name="nama_samaran" value="{{ old('nama_samaran', $user->nama_samaran) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Keamanan Akun</h3>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50">
                </div>
            </div>
        </div>
        


        <div class="pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all shadow-lg shadow-purple-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
