<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilDass21 extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'hasil_dass21s';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'dass21_id';

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

        return [
            'skor_depresi'       => $skorDepresi,
            'skor_kecemasan'     => $skorKecemasan,
            'skor_stres'         => $skorStres,
            'total_skor'         => $skorDepresi + $skorKecemasan + $skorStres,
            'kategori_depresi'   => self::kategoriDepresi($skorDepresi),
            'kategori_kecemasan' => self::kategoriKecemasan($skorKecemasan),
            'kategori_stres'     => self::kategoriStres($skorStres),
        ];
    }

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
    {
        if ($skor <= 14) return 'Normal';
        if ($skor <= 18) return 'Ringan';
        if ($skor <= 25) return 'Sedang';
        if ($skor <= 33) return 'Parah';
        return 'Sangat Parah';
    }

    // ──────────────────────────── Relationships ────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
