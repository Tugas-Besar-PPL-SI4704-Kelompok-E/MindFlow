<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilDass21 extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'hasil_dass21';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'dass21_id';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'skor_depresi',
        'skor_kecemasan',
        'skor_stres',
        'total_skor',
        'kategori_depresi',
        'kategori_kecemasan',
        'kategori_stres',
        'detail_jawaban',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'detail_jawaban' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  DASS-21 Subscale Mapping (question numbers 1-21)
    //
    //  Stress (S):      1, 6, 8, 11, 12, 14, 18
    //  Anxiety (A):     2, 4, 7, 9, 15, 19, 20
    //  Depression (D):  3, 5, 10, 13, 16, 17, 21
    //
    //  Each raw subscale sum is multiplied by 2 for the final DASS score.
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Question IDs that belong to each subscale.
     */
    public const STRES_ITEMS     = [1, 6, 8, 11, 12, 14, 18];
    public const KECEMASAN_ITEMS = [2, 4, 7, 9, 15, 19, 20];
    public const DEPRESI_ITEMS   = [3, 5, 10, 13, 16, 17, 21];

    /**
     * Calculate all DASS-21 scores from a responses array.
     *
     * @param  array  $responses  e.g. [1 => ['question_id' => 1, 'score' => 2], ...]
     * @return array  ['skor_depresi', 'skor_kecemasan', 'skor_stres', 'total_skor',
     *                 'kategori_depresi', 'kategori_kecemasan', 'kategori_stres']
     */
    public static function hitungSkor(array $responses): array
    {
        $rawDepresi   = 0;
        $rawKecemasan = 0;
        $rawStres     = 0;

        foreach ($responses as $item) {
            $qId   = (int) $item['question_id'];
            $score = (int) $item['score'];

            if (in_array($qId, self::DEPRESI_ITEMS)) {
                $rawDepresi += $score;
            } elseif (in_array($qId, self::KECEMASAN_ITEMS)) {
                $rawKecemasan += $score;
            } elseif (in_array($qId, self::STRES_ITEMS)) {
                $rawStres += $score;
            }
        }

        // Multiply by 2 as per DASS-21 official scoring
        $skorDepresi   = $rawDepresi * 2;
        $skorKecemasan = $rawKecemasan * 2;
        $skorStres     = $rawStres * 2;

        // Total skor is the raw sum of all 21 items (before multiplication)
        $totalSkor = $rawDepresi + $rawKecemasan + $rawStres;

        return [
            'skor_depresi'       => $skorDepresi,
            'skor_kecemasan'     => $skorKecemasan,
            'skor_stres'         => $skorStres,
            'total_skor'         => $totalSkor,
            'kategori_depresi'   => self::kategoriDepresi($skorDepresi),
            'kategori_kecemasan' => self::kategoriKecemasan($skorKecemasan),
            'kategori_stres'     => self::kategoriStres($skorStres),
        ];
    }

    // ──────────────────────────── Severity Cut-offs ────────────────────────

    /**
     * Official DASS-21 Depression severity thresholds.
     */
    public static function kategoriDepresi(int $skor): string
    {
        if ($skor <= 9)  return 'Normal';
        if ($skor <= 13) return 'Ringan';
        if ($skor <= 20) return 'Sedang';
        if ($skor <= 27) return 'Berat';
        return 'Sangat Berat';
    }

    /**
     * Official DASS-21 Anxiety severity thresholds.
     */
    public static function kategoriKecemasan(int $skor): string
    {
        if ($skor <= 7)  return 'Normal';
        if ($skor <= 9)  return 'Ringan';
        if ($skor <= 14) return 'Sedang';
        if ($skor <= 19) return 'Berat';
        return 'Sangat Berat';
    }

    /**
     * Official DASS-21 Stress severity thresholds.
     */
    public static function kategoriStres(int $skor): string
    {
        if ($skor <= 14) return 'Normal';
        if ($skor <= 18) return 'Ringan';
        if ($skor <= 25) return 'Sedang';
        if ($skor <= 33) return 'Berat';
        return 'Sangat Berat';
    }

    // ──────────────────────────── Relationships ────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
