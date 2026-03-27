<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mt_merchant', function (Blueprint $table) {
            if (!Schema::hasColumn('mt_merchant', 'partner_type')) {
                $table->enum('partner_type', ['partner', 'non-partner'])->default('non-partner')->after('merchant_type');
            }
        });

        DB::table('mt_merchant')
            ->whereIn('merchant_type', ['partner', 'non-partner'])
            ->update([
                'partner_type' => DB::raw('merchant_type'),
            ]);
    }

    public function down(): void
    {
        Schema::table('mt_merchant', function (Blueprint $table) {
            if (Schema::hasColumn('mt_merchant', 'partner_type')) {
                $table->dropColumn('partner_type');
            }
        });
    }
};
