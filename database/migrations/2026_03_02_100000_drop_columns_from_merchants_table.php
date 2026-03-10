<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn(['contact_person', 'contact_number', 'total_orders', 'total_sales']);
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('contact_person')->nullable()->after('category');
            $table->string('contact_number')->nullable()->after('contact_person');
            $table->unsignedInteger('total_orders')->default(0)->after('address');
            $table->decimal('total_sales', 14, 2)->default(0)->after('total_orders');
        });
    }
};
