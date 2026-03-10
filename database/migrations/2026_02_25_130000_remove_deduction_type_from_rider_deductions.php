<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rider_deductions', function (Blueprint $table) {
            if (Schema::hasColumn('rider_deductions', 'deduction_type')) {
                $table->dropColumn('deduction_type');
            }
        });
    }

    public function down()
    {
        Schema::table('rider_deductions', function (Blueprint $table) {
            $table->string('deduction_type')->after('rider_name');
        });
    }
};
