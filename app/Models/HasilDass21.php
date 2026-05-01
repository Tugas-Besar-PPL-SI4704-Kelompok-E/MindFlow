<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilDass21 extends Model
{
    /**
     * The table associated with the model.
     */
<<<<<<< HEAD
    protected $table = 'hasil_dass21';
=======
    protected $table = 'hasil_dass21s';
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'dass21_id';

    /**
     * Indicates if the model should be timestamped.
<<<<<<< HEAD
=======
     * Table only has 'created_at', not 'updated_at'.
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248
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

<<<<<<< HEAD
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
=======
    // ──────────────────────────── Scoring Logic ────────────────────────────

    /**
     * Hitung skor DASS-21 dari array responses.
     *
     * DASS-21 terdiri dari 21 pertanyaan, masing-masing skor 0-3.
     * Pertanyaan dibagi 3 sub-skala (dikali 2 untuk konversi ke DASS-42):
     *   - Depresi    : pertanyaan 3, 5, 10, 13, 16, 17, 21
     *   - Kecemasan  : pertanyaan 2, 4, 7, 9, 15, 19, 20
     *   - Stres      : pertanyaan 1, 6, 8, 11, 12, 14, 18
     *
     * @param array $responses Array of ['question_id' => int, 'score' => int]
     * @return array
     */
    public static function hitungSkor(array $responses): array
    {
        // Mapping pertanyaan ke sub-skala (nomor 1-21)
        $depresiQuestions    = [3, 5, 10, 13, 16, 17, 21];
        $kecemasanQuestions  = [2, 4, 7, 9, 15, 19, 20];
        $stresQuestions      = [1, 6, 8, 11, 12, 14, 18];

        $skorDepresi = 0;
        $skorKecemasan = 0;
        $skorStres = 0;

        foreach ($responses as $response) {
            $qid = (int) $response['question_id'];
            $score = (int) $response['score'];

            if (in_array($qid, $depresiQuestions)) {
                $skorDepresi += $score;
            } elseif (in_array($qid, $kecemasanQuestions)) {
                $skorKecemasan += $score;
            } elseif (in_array($qid, $stresQuestions)) {
                $skorStres += $score;
            }
        }

        // Kalikan 2 sesuai standar DASS-21 → DASS-42
        $skorDepresi *= 2;
        $skorKecemasan *= 2;
        $skorStres *= 2;
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248

        return [
            'skor_depresi'       => $skorDepresi,
            'skor_kecemasan'     => $skorKecemasan,
            'skor_stres'         => $skorStres,
<<<<<<< HEAD
            'total_skor'         => $totalSkor,
=======
            'total_skor'         => $skorDepresi + $skorKecemasan + $skorStres,
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248
            'kategori_depresi'   => self::kategoriDepresi($skorDepresi),
            'kategori_kecemasan' => self::kategoriKecemasan($skorKecemasan),
            'kategori_stres'     => self::kategoriStres($skorStres),
        ];
    }

<<<<<<< HEAD
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
=======
    /**
     * Kategori skor Depresi (skala DASS-42).
     */
    private static function kategoriDepresi(int $skor): string
    {
        if ($skor <= 9) return 'Normal';
        if ($skor <= 13) return 'Ringan';
        if ($skor <= 20) return 'Sedang';
        if ($skor <= 27) return 'Parah';
        return 'Sangat Parah';
    }

    /**
     * Kategori skor Kecemasan (skala DASS-42).
     */
    private static function kategoriKecemasan(int $skor): string
    {
        if ($skor <= 7) return 'Normal';
        if ($skor <= 9) return 'Ringan';
        if ($skor <= 14) return 'Sedang';
        if ($skor <= 19) return 'Parah';
        return 'Sangat Parah';
    }

    /**
     * Kategori skor Stres (skala DASS-42).
     */
    private static function kategoriStres(int $skor): string
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248
    {
        if ($skor <= 14) return 'Normal';
        if ($skor <= 18) return 'Ringan';
        if ($skor <= 25) return 'Sedang';
<<<<<<< HEAD
        if ($skor <= 33) return 'Berat';
        return 'Sangat Berat';
=======
        if ($skor <= 33) return 'Parah';
        return 'Sangat Parah';
>>>>>>> e4a1f5550b6ad112b7f0a792283f148e613bf248
    }

    // ──────────────────────────── Relationships ────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
