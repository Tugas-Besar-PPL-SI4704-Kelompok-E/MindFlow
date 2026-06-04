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
        return [
            'konselor_id' => 'required|exists:profil_konselor,profil_konselor_id',
            'jadwal' => 'required|date|after:now',
            'media_konseling' => 'required|in:video_call,voice_call,chat',
            'payment_method' => 'required|in:transfer,e-wallet',
            'deskripsi' => 'nullable|string|max:1000',
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
