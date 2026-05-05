<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spesialisasi extends Model
{
    protected $fillable = ['nama', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Hitung jumlah konselor yang memiliki spesialisasi ini.
     */
    public function getJumlahKonselorAttribute(): int
    {
        return ProfilKonselor::where('spesialisasi', $this->nama)->count();
    }
}
