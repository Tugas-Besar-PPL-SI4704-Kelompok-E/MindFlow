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
        Schema::create('laporan_forums', function (Blueprint $table) {
            $table->id('laporan_forum_id');
            $table->foreignId('forum_id')->constrained('forums', 'forum_id')->onDelete('cascade');
            $table->foreignId('pelapor_id')->constrained('users')->onDelete('cascade');
            $table->string('alasan_laporan');
            $table->enum('status_tindak_lanjut', ['pending', 'dihapus', 'diabaikan'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_forums');
    }
};
