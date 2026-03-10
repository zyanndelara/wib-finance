<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_deposit_confirmations', function (Blueprint $table) {
            $table->decimal('discrepancy', 15, 2)->default(0)->after('total_amount')
                ->comment('bank_amount - total_amount; negative = over, positive = short');
        });
    }

    public function down(): void
    {
        Schema::table('bank_deposit_confirmations', function (Blueprint $table) {
            $table->dropColumn('discrepancy');
        });
    }
};
