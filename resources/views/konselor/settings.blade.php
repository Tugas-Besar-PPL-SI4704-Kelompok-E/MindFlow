@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil - MindFlow')
@section('header', 'Pengaturan Profil')

@section('content')
<div class="w-full">
    
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-8">
        <form action="{{ route('konselor.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Akun -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Keamanan & Akun</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap (Asli)</label>
                        <input type="text" name="nama_asli" value="{{ old('nama_asli', $user->nama_asli) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Samaran (Alias di Forum)</label>
                        <input type="text" name="nama_samaran" value="{{ old('nama_samaran', $user->nama_samaran) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru <span class="text-xs font-normal text-gray-400">(Opsional)</span></label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Profil Profesional -->
            <div class="pt-4">
                <h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Profil Profesional (Dilihat Pasien)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Spesialisasi</label>
                        <select name="spesialisasi" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                            <option value="">Pilih Spesialisasi...</option>
                            @foreach($spesialisasis as $sp)
                                <option value="{{ $sp->nama }}" {{ old('spesialisasi', $profil->spesialisasi ?? '') == $sp->nama ? 'selected' : '' }}>
                                    {{ $sp->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga per Sesi (IDR)</label>
                        <input type="number" name="harga_per_sesi" value="{{ old('harga_per_sesi', $profil->harga_per_sesi ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" min="0" required>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor SIPP / Lisensi</label>
                    <input type="text" name="no_sipp" value="{{ old('no_sipp', $profil->no_sipp ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" required>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keahlian (Pisahkan dengan koma)</label>
                    <textarea name="keahlian" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" placeholder="Misal: Terapi Perilaku Kognitif, Manajemen Stres, Depresi">{{ old('keahlian', $profil->keahlian ?? '') }}</textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Biografi Singkat</label>
                    <textarea name="biografi" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all outline-none bg-gray-50" placeholder="Ceritakan latar belakang dan pengalaman Anda sebagai konselor...">{{ old('biografi', $profil->biografi ?? '') }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all shadow-lg shadow-purple-200 text-lg">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
