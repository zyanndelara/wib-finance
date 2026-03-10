<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('completed'); // completed, cleared, dismissed, reversed, bounced
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('source_bank')->nullable();
            $table->string('destination_bank')->nullable();
            $table->text('notes')->nullable();
            $table->string('verified_by')->nullable();
            $table->string('attached_file')->nullable();
            $table->string('initiated_user')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
