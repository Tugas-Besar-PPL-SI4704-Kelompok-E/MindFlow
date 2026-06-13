<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CounselorSchedule;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

class StoreKonselingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        // PBI-46: Prevent sudden booking (must be at least 3 hours in advance)
        $minBookingTime = now()->addHours(3)->toDateTimeString();

        return [
            'konselor_id' => 'required|exists:profil_konselor,profil_konselor_id',
            'jadwal' => 'required|date|after:' . $minBookingTime,
            'media_konseling' => 'required|in:video_call,voice_call,chat',
            'payment_method' => 'required|in:transfer,e-wallet',
            'deskripsi' => 'nullable|string|max:1000',
            'journals' => 'nullable|array',
            'journals.*' => 'exists:journals,journal_id',
        ];
    }

    public function messages()
    {
        return [
            'jadwal.after' => 'Jadwal tidak valid. Pemesanan tidak boleh mendadak, silakan pilih jadwal minimal 3 jam dari sekarang.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->has('jadwal') || !$this->has('konselor_id')) {
                return;
            }

            try {
                $jadwal = Carbon::parse($this->input('jadwal'));
            } catch (\Exception $e) {
                return;
            }

            $dayNames = ['minggu','senin','selasa','rabu','kamis','jumat','sabtu'];
            $dayName = $dayNames[$jadwal->dayOfWeek];

            $schedules = CounselorSchedule::where('profil_konselor_id', $this->input('konselor_id'))
                ->where('is_active', true)
                ->get();

            $time = $jadwal->format('H:i:s');

            $allowed = $schedules->contains(function ($s) use ($dayName, $time) {
                return strtolower($s->hari) === $dayName && $time >= $s->jam_mulai && $time < $s->jam_selesai;
            });

            if (!$allowed) {
                $validator->errors()->add('jadwal', 'Jadwal tidak sesuai dengan ketersediaan konselor. Silakan pilih hari dan jam yang tersedia.');
            }
        });
    }

    protected function prepareForValidation()
    {
        if ($this->has('jadwal')) {
            $this->merge([
                'jadwal' => \Carbon\Carbon::parse($this->input('jadwal'))->toDateTimeString()
            ]);
        }
    }
}
