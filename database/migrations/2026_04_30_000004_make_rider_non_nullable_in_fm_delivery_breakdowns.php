<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('delivery_breakdowns')) {
            return;
        }

        DB::table('delivery_breakdowns')
            ->whereNull('rider')
            ->update(['rider' => '']);

        DB::statement("ALTER TABLE fm_delivery_breakdowns MODIFY rider VARCHAR(255) NOT NULL DEFAULT ''");
    }

    public function down(): void
    {
        if (!Schema::hasTable('delivery_breakdowns')) {
            return;
        }

        DB::statement("ALTER TABLE fm_delivery_breakdowns MODIFY rider VARCHAR(255) NULL DEFAULT NULL");
    }
};
