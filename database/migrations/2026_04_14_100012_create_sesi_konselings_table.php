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
        Schema::create('sesi_konselings', function (Blueprint $table) {
            $table->id('sesi_konseling_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('konselor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwals', 'jadwal_id')->onDelete('cascade');
            $table->text('keluhan_awal');
            $table->enum('status_sesi', ['menunggu_pembayaran', 'terjadwal', 'selesai', 'batal'])->default('menunggu_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_konselings');
    }
};
