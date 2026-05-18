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
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->string('media_konseling')->default('video_call')->after('jadwal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->dropColumn('media_konseling');
        });
    }
};
