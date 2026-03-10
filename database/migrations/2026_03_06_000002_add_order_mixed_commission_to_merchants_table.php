<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->decimal('commission_small_amount',   10, 2)->nullable()->after('commission_drinks_amount');
            $table->decimal('commission_big_amount',     10, 2)->nullable()->after('commission_small_amount');
            $table->decimal('commission_mixed_percentage', 8, 4)->nullable()->after('commission_big_amount');
            $table->decimal('commission_mixed_amount',   10, 2)->nullable()->after('commission_mixed_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn([
                'commission_small_amount',
                'commission_big_amount',
                'commission_mixed_percentage',
                'commission_mixed_amount',
            ]);
        });
    }
};
