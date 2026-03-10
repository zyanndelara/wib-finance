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
        Schema::table('rider_payrolls', function (Blueprint $table) {
            $table->decimal('base_salary', 15, 2)->change();
            $table->decimal('incentives', 15, 2)->nullable()->change();
            $table->decimal('net_salary', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rider_payrolls', function (Blueprint $table) {
            $table->decimal('base_salary', 10, 2)->change();
            $table->decimal('incentives', 10, 2)->nullable()->change();
            $table->decimal('net_salary', 10, 2)->change();
        });
    }
};
