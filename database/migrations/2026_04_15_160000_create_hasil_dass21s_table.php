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
        Schema::create('hasil_dass21s', function (Blueprint $table) {
            $table->id('dass21_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('skor_depresi');
            $table->integer('skor_kecemasan');
            $table->integer('skor_stres');
            $table->integer('total_skor');
            $table->string('kategori_depresi');
            $table->string('kategori_kecemasan');
            $table->string('kategori_stres');
            $table->json('detail_jawaban')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_dass21s');
    }
};
