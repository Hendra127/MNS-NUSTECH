<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('log_perangkat', function (Blueprint $table) {
            if (!Schema::hasColumn('log_perangkat', 'status')) {
                $table->string('status')->nullable()->after('layanan');
            }
            if (!Schema::hasColumn('log_perangkat', 'foto_perangkat_baru')) {
                $table->string('foto_perangkat_baru')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_perangkat', function (Blueprint $table) {
            $table->dropColumn(['status', 'foto_perangkat_baru']);
        });
    }
};
