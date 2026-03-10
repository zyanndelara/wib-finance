<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->decimal('commission_food_amount', 10, 2)->nullable()->after('commission_type');
            $table->decimal('commission_drinks_amount', 10, 2)->nullable()->after('commission_food_amount');
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn(['commission_food_amount', 'commission_drinks_amount']);
        });
    }
};
