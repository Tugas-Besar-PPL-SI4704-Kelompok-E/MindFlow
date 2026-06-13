@extends('layouts.dashboard')

@section('title', 'Ketersediaan Jadwal - MindFlow')
@section('header', 'Ketersediaan Jadwal')

@section('content')
@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    </div>
@endif

<div class="mb-6">
    <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="bg-purple-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-purple-700 transition-colors">
        + Tambah Jadwal
    </button>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if(count($schedules) > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Mulai</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Selesai</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Aktif</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($schedules as $schedule)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $schedule->hari }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($schedule->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                            <button onclick="document.getElementById('modal-edit-{{ $schedule->counselor_schedule_id }}').classList.remove('hidden')" class="text-blue-600 hover:text-blue-900">Edit</button>
                            <form action="{{ route('konselor.counselor-schedules.destroy', $schedule->counselor_schedule_id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    
                    <!-- Modal Edit -->
                    <div id="modal-edit-{{ $schedule->counselor_schedule_id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('modal-edit-{{ $schedule->counselor_schedule_id }}').classList.add('hidden')"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form action="{{ route('konselor.counselor-schedules.update', $schedule->counselor_schedule_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Edit Jadwal</h3>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Hari</label>
                                            <select name="hari" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                                    <option value="{{ $hari }}" {{ $schedule->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                            <input type="time" name="jam_mulai" value="{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" value="{{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                                        </div>
                                        <div class="mb-4 flex items-center">
                                            <input type="checkbox" name="is_active" id="is_active_{{ $schedule->counselor_schedule_id }}" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" {{ $schedule->is_active ? 'checked' : '' }}>
                                            <label for="is_active_{{ $schedule->counselor_schedule_id }}" class="ml-2 block text-sm text-gray-900">Aktif</label>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                                        <button type="button" onclick="document.getElementById('modal-edit-{{ $schedule->counselor_schedule_id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-10 text-center flex flex-col items-center justify-center">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Jadwal</h3>
            <p class="text-gray-500">Anda belum mengatur ketersediaan waktu untuk konseling.</p>
        </div>
    @endif
</div>

<!-- Modal Create -->
<div id="modal-create" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('modal-create').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('konselor.counselor-schedules.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Tambah Jadwal Ketersediaan</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Hari</label>
                        <select name="hari" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active_new" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" checked>
                        <label for="is_active_new" class="ml-2 block text-sm text-gray-900">Aktif</label>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 sm:ml-3 sm:w-auto sm:text-sm">Tambah</button>
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<!-- Modal Create -->