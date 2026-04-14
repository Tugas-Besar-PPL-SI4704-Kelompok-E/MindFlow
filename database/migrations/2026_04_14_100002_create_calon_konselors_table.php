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
        Schema::create('calon_konselors', function (Blueprint $table) {
            $table->id('calon_konselor_id');
            $table->string('email');
            $table->string('cv_portfolio_url');
            $table->enum('status_aplikasi', ['pending', 'interview', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_konselors');
    }
};
