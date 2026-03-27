<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultMemberPages = [
            'dashboard',
            'remittance',
            'bank-deposit',
            'merchants',
            'profile',
        ];

        $defaultAdminPages = [
            'dashboard',
            'remittance',
            'bank-deposit',
            'merchants',
            'members',
            'audit-logs',
            'profile',
        ];

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'accessible_pages')) {
                $table->json('accessible_pages')->nullable()->after('status');
            }
        });

        DB::table('users')
            ->whereNull('accessible_pages')
            ->update(['accessible_pages' => json_encode($defaultMemberPages)]);

        DB::table('users')
            ->where('role', 'admin')
            ->update(['accessible_pages' => json_encode($defaultAdminPages)]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'accessible_pages')) {
                $table->dropColumn('accessible_pages');
            }
        });
    }
};
