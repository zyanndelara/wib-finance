<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update mt_merchant table on wheninba_MercifulGod connection
        if (Schema::connection('wheninba_MercifulGod')->hasTable('mt_merchant')) {
            Schema::connection('wheninba_MercifulGod')->table('mt_merchant', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::connection('wheninba_MercifulGod')->hasColumn('mt_merchant', 'commission_items')) {
                    $table->json('commission_items')->nullable()->comment('Fixed per item commission configuration');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::connection('wheninba_MercifulGod')->hasTable('mt_merchant')) {
            Schema::connection('wheninba_MercifulGod')->table('mt_merchant', function (Blueprint $table) {
                if (Schema::connection('wheninba_MercifulGod')->hasColumn('mt_merchant', 'commission_items')) {
                    $table->dropColumn('commission_items');
                }
            });
        }
    }
};
