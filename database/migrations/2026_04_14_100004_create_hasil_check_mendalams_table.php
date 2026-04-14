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
        Schema::create('hasil_check_mendalams', function (Blueprint $table) {
            $table->id('check_mendalam_id');
            $table->foreignId('check_instan_id')->nullable()->constrained('hasil_check_instans', 'check_instan_id')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('jawaban_terbuka');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_check_mendalams');
    }
};
