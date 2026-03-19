<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_deposit_confirmations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rider_id');
            $table->index('rider_id');
            $table->foreignId('confirmed_by')->constrained('users')->cascadeOnDelete();
            $table->date('deposit_date');
            $table->decimal('bank_amount', 15, 2)->comment('Original daily remit amount');
            $table->unsignedInteger('denom_1000')->default(0);
            $table->unsignedInteger('denom_500')->default(0);
            $table->unsignedInteger('denom_200')->default(0);
            $table->unsignedInteger('denom_100')->default(0);
            $table->unsignedInteger('denom_50')->default(0);
            $table->unsignedInteger('denom_20')->default(0);
            $table->unsignedInteger('denom_10')->default(0);
            $table->unsignedInteger('denom_5')->default(0);
            $table->unsignedInteger('denom_1')->default(0);
            $table->decimal('total_amount', 15, 2)->comment('Sum of all denomination amounts');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_deposit_confirmations');
    }
};
