<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('mode_of_payment');
        });
    }

    public function down()
    {
        Schema::table('remittances', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};
