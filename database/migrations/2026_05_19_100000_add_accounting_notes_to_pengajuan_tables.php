<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // CM Pengajuans
        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->string('no_surat')->nullable()->after('catatan');
            $table->text('keterangan')->nullable()->after('no_surat');
        });

        // CSR Pengajuans
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('terbilang');
            $table->string('no_surat')->nullable()->after('catatan');
            $table->text('keterangan')->nullable()->after('no_surat');
        });

        // Pengajuan Spareparts
        Schema::table('pengajuan_spareparts', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('terbilang');
            $table->string('no_surat')->nullable()->after('catatan');
            $table->text('keterangan')->nullable()->after('no_surat');
        });
    }

    public function down(): void
    {
        Schema::table('cm_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['no_surat', 'keterangan']);
        });

        Schema::table('csr_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'no_surat', 'keterangan']);
        });

        Schema::table('pengajuan_spareparts', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'no_surat', 'keterangan']);
        });
    }
};
