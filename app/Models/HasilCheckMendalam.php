<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilCheckMendalam extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'hasil_check_mendalams';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'check_mendalam_id';

    /**
     * Indicates if the model should be timestamped.
     * Table only has 'created_at', not 'updated_at'.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'check_instan_id',
        'user_id',
        'jawaban_terbuka',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // ──────────────────────────── Relationships ────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hasilCheckInstan()
    {
        return $this->belongsTo(HasilCheckInstan::class, 'check_instan_id', 'check_instan_id');
    }
}
