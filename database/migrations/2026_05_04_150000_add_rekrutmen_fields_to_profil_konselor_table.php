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
        Schema::table('profil_konselor', function (Blueprint $table) {
            $table->string('nomor_whatsapp')->nullable()->after('keahlian');
            $table->string('no_sipp')->nullable()->after('nomor_whatsapp');
            $table->string('berkas_ktp')->nullable()->after('no_sipp');
            $table->string('berkas_sipp')->nullable()->after('berkas_ktp');
            $table->string('berkas_cv')->nullable()->after('berkas_sipp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_konselor', function (Blueprint $table) {
            $table->dropColumn(['nomor_whatsapp', 'no_sipp', 'berkas_ktp', 'berkas_sipp', 'berkas_cv']);
        });
    }
};
