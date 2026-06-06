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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profil_konselor_id');
            $table->unsignedBigInteger('sesi_konseling_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('type'); // deposit, withdrawal
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('profil_konselor_id')->references('profil_konselor_id')->on('profil_konselor')->onDelete('cascade');
            $table->foreign('sesi_konseling_id')->references('sesi_konseling_id')->on('sesi_konselings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
