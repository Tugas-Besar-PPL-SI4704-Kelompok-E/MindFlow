<?php

namespace App\Http\Controllers;

use App\Models\CounselorSchedule;
use Illuminate\Http\Request;

class CounselorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profilKonselor = auth()->user()->profilKonselor;
        if (!$profilKonselor) {
            return redirect()->route('dashboard')->with('error', 'Profil konselor tidak ditemukan.');
        }

        $schedules = $profilKonselor->counselorSchedules()->orderBy('hari')->get();
        
        return view('konselor.schedule.index', compact('schedules'));
    }

    public function create()
    {
        // View can be handled within index (modal) or separate
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $profilKonselor = auth()->user()->profilKonselor;
        
        CounselorSchedule::create([
            'profil_konselor_id' => $profilKonselor->profil_konselor_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('konselor.counselor-schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(CounselorSchedule $counselorSchedule)
    {
        //
    }

    public function edit(CounselorSchedule $counselorSchedule)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $schedule = CounselorSchedule::where('counselor_schedule_id', $id)
            ->where('profil_konselor_id', auth()->user()->profilKonselor->profil_konselor_id)
            ->firstOrFail();

        $schedule->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('konselor.counselor-schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = CounselorSchedule::where('counselor_schedule_id', $id)
            ->where('profil_konselor_id', auth()->user()->profilKonselor->profil_konselor_id)
            ->firstOrFail();
            
        $schedule->delete();

        return redirect()->route('konselor.counselor-schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
