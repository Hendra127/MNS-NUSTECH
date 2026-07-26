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
        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum_dibayar', 'dp_50', 'lunas'])->default('belum_dibayar')->after('approval_status');
            $table->string('bukti_transfer')->nullable()->after('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'bukti_transfer']);
        });
    }
};
