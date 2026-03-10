<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rider_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('rider_id');
            $table->string('rider_name');
            $table->string('deduction_type');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rider_deductions');
    }
};
