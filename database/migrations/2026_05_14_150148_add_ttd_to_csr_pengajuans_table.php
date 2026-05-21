<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            // Signature image paths (auto-filled when created / approved)
            $table->string('ttd_pemohon')->nullable()->after('mengetahui_jabatan');
            $table->string('ttd_manager')->nullable()->after('ttd_pemohon');
            $table->string('ttd_accounting')->nullable()->after('ttd_manager');
            $table->string('ttd_direktur')->nullable()->after('ttd_accounting');
            $table->string('ttd_penasihat')->nullable()->after('ttd_direktur');
        });
    }

    public function down(): void
    {
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['ttd_pemohon', 'ttd_manager', 'ttd_accounting', 'ttd_direktur', 'ttd_penasihat']);
        });
    }
};
