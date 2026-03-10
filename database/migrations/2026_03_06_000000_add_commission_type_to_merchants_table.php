<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->enum('commission_type', [
                'fixed_per_item',
                'category_based_fixed',
                'fixed_per_order',
                'percentage_based',
                'mixed',
            ])->default('percentage_based')->after('commission_rate');
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('commission_type');
        });
    }
};
