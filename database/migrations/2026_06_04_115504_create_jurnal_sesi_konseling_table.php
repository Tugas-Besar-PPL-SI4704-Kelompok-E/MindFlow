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
        Schema::create('jurnal_sesi_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_konseling_id')->constrained('sesi_konselings', 'sesi_konseling_id')->onDelete('cascade');
            $table->unsignedBigInteger('journal_id');
            $table->foreign('journal_id')->references('journal_id')->on('journals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_sesi_konseling');
    }
};
