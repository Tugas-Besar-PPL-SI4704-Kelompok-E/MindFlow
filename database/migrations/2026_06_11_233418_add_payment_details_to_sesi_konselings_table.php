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
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->string('payment_channel')->nullable();
            $table->string('xendit_payment_id')->nullable();
            $table->timestamp('payment_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi_konselings', function (Blueprint $table) {
            $table->dropColumn(['payment_channel', 'xendit_payment_id', 'payment_time']);
        });
    }
};
