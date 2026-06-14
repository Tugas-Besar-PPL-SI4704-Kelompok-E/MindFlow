@extends('layouts.admin')

@section('title', 'Rekrutmen Konselor')

@push('styles')
<style>
    .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); z-index:50; align-items:center; justify-content:center; }
    .modal-backdrop.active { display:flex; }
</style>
@endpush

@section('content')
    {{-- Summary Cards --}}
    <div class="grid grid-cols-3 gap-5 mb-8">
        <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-gray-900">{{ $applicants->count() }}</div>
                <div class="text-xs text-gray-500 font-medium">Total Aplikan</div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-yellow-600">{{ $applicants->where('status', 'pending')->count() }}</div>
                <div class="text-xs text-gray-500 font-medium">Menunggu Review</div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-green-600">{{ $applicants->where('status', 'approved')->count() }}</div>
                <div class="text-xs text-gray-500 font-medium">Diverifikasi</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-base font-bold text-gray-800">Daftar Pendaftar Konselor</h3>
                <p class="text-xs text-gray-400 mt-0.5">Kelola dan verifikasi calon konselor MindFlow</p>
            </div>
        </div>

        @if($applicants->isEmpty())
        <div class="px-6 py-16 text-center">
            <div class="text-4xl mb-3">📋</div>
            <div class="text-gray-500 font-semibold">Belum ada aplikan konselor</div>
            <div class="text-gray-400 text-sm mt-1">Aplikan akan muncul di sini setelah ada yang mendaftar melalui halaman rekrutmen.</div>
        </div>
        @else
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Aplikan</th>
                    <th class="px-6 py-4 font-semibold">Spesialisasi</th>
                    <th class="px-6 py-4 font-semibold">SIPP</th>
                    <th class="px-6 py-4 font-semibold">Dokumen</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 text-center font-semibold">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($applicants as $applicant)
                @php $profil = $applicant->profilKonselor; @endphp
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img class="w-9 h-9 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($applicant->nama_asli) }}&background=e9d5ff&color=6b21a8&size=36" alt="">
                            <div>
                                <div class="font-bold text-gray-900 text-sm">{{ $applicant->nama_asli }}</div>
                                <div class="text-gray-400 text-xs">{{ $applicant->email }}</div>
                                @if($profil && $profil->nomor_whatsapp)
                                <div class="text-gray-400 text-xs">📱 {{ $profil->nomor_whatsapp }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-semibold">{{ $profil->spesialisasi ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-mono text-gray-600">{{ $profil->no_sipp ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1.5">
                            @if($profil && $profil->berkas_ktp)
                            <a href="{{ asset('storage/' . $profil->berkas_ktp) }}" target="_blank" class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-semibold hover:bg-blue-100 transition" title="Lihat KTP">🪪 KTP</a>
                            @endif
                            @if($profil && $profil->berkas_sipp)
                            <a href="{{ asset('storage/' . $profil->berkas_sipp) }}" target="_blank" class="px-2 py-1 bg-green-50 text-green-600 rounded text-xs font-semibold hover:bg-green-100 transition" title="Lihat SIPP">📄 SIPP</a>
                            @endif
                            @if($profil && $profil->berkas_cv)
                            <a href="{{ asset('storage/' . $profil->berkas_cv) }}" target="_blank" class="px-2 py-1 bg-orange-50 text-orange-600 rounded text-xs font-semibold hover:bg-orange-100 transition" title="Lihat CV">📋 CV</a>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($applicant->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">⏳ Menunggu</span>
                        @elseif($applicant->status === 'approved')
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">✅ Diverifikasi</span>
                        @elseif($applicant->status === 'rejected')
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold">❌ Ditolak</span>
                        @else
                            <span class="px-3 py-1 bg-gray-50 text-gray-500 rounded-full text-xs font-bold">{{ $applicant->status ?? '-' }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            @if($applicant->status === 'pending')
                                <form action="{{ route('admin.rekrutmen.approve', $applicant->id) }}" method="POST" onsubmit="return confirm('Yakin ingin meng-approve konselor ini?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-xl text-xs font-bold hover:bg-purple-700 transition">✅ Verifikasi</button>
                                </form>
                                <form action="{{ route('admin.rekrutmen.reject', $applicant->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak aplikan ini?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition">❌ Tolak</button>
                                </form>
                            @elseif($applicant->status === 'approved')
                                <span class="text-xs text-green-500 font-semibold">Sudah Diverifikasi</span>
                            @elseif($applicant->status === 'rejected')
                                <form action="{{ route('admin.rekrutmen.approve', $applicant->id) }}" method="POST" onsubmit="return confirm('Yakin ingin meng-approve konselor ini?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-xl text-xs font-bold hover:bg-purple-700 transition">🔄 Approve Ulang</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection