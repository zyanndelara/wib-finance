<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->string('mangan_merchant_name')->nullable()->after('remarks');
            $table->integer('mangan_total_deliveries')->nullable()->default(0)->after('mangan_merchant_name');
            $table->decimal('mangan_total_amount', 10, 2)->nullable()->default(0)->after('mangan_total_deliveries');
            $table->decimal('mangan_df', 10, 2)->nullable()->default(0)->after('mangan_total_amount');
            $table->decimal('mangan_gt', 10, 2)->nullable()->default(0)->after('mangan_df');
            $table->decimal('mangan_tips', 10, 2)->nullable()->default(0)->after('mangan_gt');
            $table->decimal('mangan_receipt_non_partners', 10, 2)->nullable()->default(0)->after('mangan_tips');
        });
    }

    public function down(): void
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropColumn([
                'mangan_merchant_name',
                'mangan_total_deliveries',
                'mangan_total_amount',
                'mangan_df',
                'mangan_gt',
                'mangan_tips',
                'mangan_receipt_non_partners',
            ]);
        });
    }
};
