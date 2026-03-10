<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_deposit_confirmations', function (Blueprint $table) {
            $table->unsignedInteger('denom_20b')->default(0)->after('denom_20');
        });
    }

    public function down(): void
    {
        Schema::table('bank_deposit_confirmations', function (Blueprint $table) {
            $table->dropColumn('denom_20b');
        });
    }
};
