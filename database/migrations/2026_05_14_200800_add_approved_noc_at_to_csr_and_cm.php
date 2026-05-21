<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            $table->timestamp('approved_noc_at')->after('approval_status')->nullable();
        });

        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->timestamp('approved_noc_at')->after('approval_status')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            $table->dropColumn('approved_noc_at');
        });

        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->dropColumn('approved_noc_at');
        });
    }
};
