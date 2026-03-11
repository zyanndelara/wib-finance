<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('rider_payrolls', 'renumeration_26_days')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->decimal('renumeration_26_days', 15, 2)->default(0)->after('incentives');
            });
        }

        if (!Schema::hasColumn('rider_payrolls', 'adda_df')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->decimal('adda_df', 15, 2)->default(0)->after('renumeration_26_days');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('rider_payrolls', 'renumeration_26_days')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->dropColumn('renumeration_26_days');
            });
        }

        if (Schema::hasColumn('rider_payrolls', 'adda_df')) {
            Schema::table('rider_payrolls', function (Blueprint $table) {
                $table->dropColumn('adda_df');
            });
        }
    }
};
