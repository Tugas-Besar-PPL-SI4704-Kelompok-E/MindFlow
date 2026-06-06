<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

    protected function prepareForValidation()
    {
        if ($this->has('jadwal')) {
            $this->merge([
                'jadwal' => \Carbon\Carbon::parse($this->input('jadwal'))->toDateTimeString()
            ]);
        }
    }
}
