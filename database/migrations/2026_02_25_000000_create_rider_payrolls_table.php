<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rider_payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('rider_id');
            $table->string('rider_name');
            $table->decimal('base_salary', 15, 2);
            $table->decimal('incentives', 15, 2)->nullable();
            $table->string('salary_schedule');
            $table->string('mode_of_payment');
            $table->decimal('net_salary', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rider_payrolls');
    }
};
