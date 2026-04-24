<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rider_deductions', function (Blueprint $table) {
            $table->foreignId('payroll_id')
                ->nullable()
                ->after('rider_name')
                ->constrained('rider_payrolls')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rider_deductions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payroll_id');
        });
    }
};