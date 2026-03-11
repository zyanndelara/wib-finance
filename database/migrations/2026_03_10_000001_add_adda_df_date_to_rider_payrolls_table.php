<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rider_payrolls', function (Blueprint $table) {
            $table->date('adda_df_date')->nullable()->after('adda_df');
        });
    }

    public function down(): void
    {
        Schema::table('rider_payrolls', function (Blueprint $table) {
            $table->dropColumn('adda_df_date');
        });
    }
};
