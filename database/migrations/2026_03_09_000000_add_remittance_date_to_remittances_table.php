<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->date('remittance_date')->nullable()->after('remarks');
        });

        // Backfill existing records: use the date portion of created_at
        DB::table('remittances')->whereNull('remittance_date')->update([
            'remittance_date' => DB::raw('DATE(created_at)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropColumn('remittance_date');
        });
    }
};
