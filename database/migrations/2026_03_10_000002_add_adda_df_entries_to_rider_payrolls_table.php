<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('rider_payrolls', 'adda_df_entries')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->json('adda_df_entries')->nullable()->after('adda_df_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('rider_payrolls', 'adda_df_entries')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->dropColumn('adda_df_entries');
            });
        }
    }
};
