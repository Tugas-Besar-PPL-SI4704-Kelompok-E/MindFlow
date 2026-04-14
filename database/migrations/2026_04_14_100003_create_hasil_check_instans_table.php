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
        Schema::create('hasil_check_instans', function (Blueprint $table) {
            $table->id('check_instan_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('poin_skor');
            $table->string('kategori_hasil'); // 'Buruk', 'Biasa', 'Baik'
            $table->boolean('is_mendalam_offered')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_check_instans');
    }
};
