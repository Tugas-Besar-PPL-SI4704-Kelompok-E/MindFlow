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
        Schema::create('journals', function (Blueprint $table) {
            // Sesuai dengan ERD: journal_id sebagai Primary Key
            $table->id('journal_id');
            
            // Relasi ke tabel users: foreign key untuk mencatat siapa penulisnya
            // Cascade delete: Jika user dihapus, jurnal miliknya juga terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom untuk menyimpan teks/cerita refleksi harian
            $table->text('content');
            
            // Timestamps bawaan Laravel (created_at & updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
