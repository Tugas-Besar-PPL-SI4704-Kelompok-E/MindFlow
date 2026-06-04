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
        Schema::create('counselor_schedules', function (Blueprint $table) {
            $table->id('counselor_schedule_id');
            $table->unsignedBigInteger('profil_konselor_id');
            $table->string('hari'); // Senin, Selasa, dst.
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('profil_konselor_id')->references('profil_konselor_id')->on('profil_konselor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_schedules');
    }
};
