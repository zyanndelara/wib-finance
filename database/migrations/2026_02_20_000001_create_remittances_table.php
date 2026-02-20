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
        Schema::create('remittances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_id')->constrained()->onDelete('cascade');
            $table->integer('total_deliveries');
            $table->decimal('total_delivery_fee', 10, 2);
            $table->decimal('total_remit', 10, 2);
            $table->decimal('total_tips', 10, 2)->default(0);
            $table->decimal('total_collection', 10, 2);
            $table->string('mode_of_payment');
            $table->string('remit_photo')->nullable();
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remittances');
    }
};
