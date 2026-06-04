<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profil_konselor', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_konselor', 'harga_per_sesi')) {
                $table->decimal('harga_per_sesi', 12, 2)->nullable()->default(0)->after('berkas_cv');
            }
        });
    }

    public function down()
    {
        Schema::table('profil_konselor', function (Blueprint $table) {
            if (Schema::hasColumn('profil_konselor', 'harga_per_sesi')) {
                $table->dropColumn('harga_per_sesi');
            }
        });
    }
};
