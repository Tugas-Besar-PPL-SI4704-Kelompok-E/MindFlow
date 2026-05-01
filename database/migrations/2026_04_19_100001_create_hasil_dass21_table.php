<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_dass21', function (Blueprint $table) {
            $table->id('dass21_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('skor_depresi');       // Sum of depression items × 2
            $table->integer('skor_kecemasan');      // Sum of anxiety items × 2
            $table->integer('skor_stres');           // Sum of stress items × 2
            $table->integer('total_skor');            // Grand total of all 21 items (raw sum)
            $table->string('kategori_depresi');      // Normal, Ringan, Sedang, Berat, Sangat Berat
            $table->string('kategori_kecemasan');
            $table->string('kategori_stres');
            $table->json('detail_jawaban');           // Full JSON of all 21 answers for audit trail
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_dass21');
    }
};
