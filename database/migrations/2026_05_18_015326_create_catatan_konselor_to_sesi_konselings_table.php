<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sesi_konselings', 'catatan_konselor')) {
            Schema::table('sesi_konselings', function (Blueprint $table) {
                $table->text('catatan_konselor')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sesi_konselings', 'catatan_konselor')) {
            Schema::table('sesi_konselings', function (Blueprint $table) {
                $table->dropColumn('catatan_konselor');
            });
        }
    }
};
