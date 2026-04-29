<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilCheckInstan extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'hasil_check_instans';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'check_instan_id';

    /**
     * Indicates if the model should be timestamped.
     * Table only has 'created_at', not 'updated_at'.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'poin_skor',
        'kategori_hasil',
        'is_mendalam_offered',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_mendalam_offered' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Determine the kategori_hasil based on poin_skor (1-10 scale).
     *
     * 1-4  => Buruk
     * 5-6  => Biasa
     * 7-10 => Baik
     */
    public static function determineKategori(int $skor): string
    {
        if ($skor <= 4) {
            return 'Buruk';
        } elseif ($skor <= 6) {
            return 'Biasa';
        }
        return 'Baik';
    }

    // ──────────────────────────── Relationships ────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hasilCheckMendalam()
    {
        return $this->hasOne(HasilCheckMendalam::class, 'check_instan_id', 'check_instan_id');
    }
}
