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
            $table->foreignId('profil_konselor_id')->constrained('profil_konselor', 'profil_konselor_id')->onDelete('cascade');
            $table->string('jadwal');
            $table->string('status')->default('pending');
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
