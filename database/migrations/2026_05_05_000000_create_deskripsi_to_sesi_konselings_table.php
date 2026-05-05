<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->string('deskripsi')->after('jadwal');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
