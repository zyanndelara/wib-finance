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
        Schema::table('fm_remittances', function (Blueprint $table) {
            try {
                $table->dropForeign(['rider_id']);
            } catch (\Throwable $e) {
                // Ignore when the foreign key does not exist.
            }
        });

        Schema::table('fm_bank_deposit_confirmations', function (Blueprint $table) {
            try {
                $table->dropForeign(['rider_id']);
            } catch (\Throwable $e) {
                // Ignore when the foreign key does not exist.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fm_remittances', function (Blueprint $table) {
            try {
                $table->foreign('rider_id')->references('id')->on('fm_riders')->onDelete('cascade');
            } catch (\Throwable $e) {
                // Ignore if the riders table does not exist.
            }
        });

        Schema::table('fm_bank_deposit_confirmations', function (Blueprint $table) {
            try {
                $table->foreign('rider_id')->references('id')->on('fm_riders')->onDelete('cascade');
            } catch (\Throwable $e) {
                // Ignore if the riders table does not exist.
            }
        });
    }
};
