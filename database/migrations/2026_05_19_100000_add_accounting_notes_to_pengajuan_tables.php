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
            if (!Schema::hasColumn('cm_pengajuans', 'no_surat')) {
                $table->string('no_surat')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('cm_pengajuans', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('no_surat');
            }
        });

        // CSR Pengajuans
        Schema::table('csr_pengajuans', function (Blueprint $table) {
            if (!Schema::hasColumn('csr_pengajuans', 'catatan')) {
                $table->text('catatan')->nullable()->after('terbilang');
            }
            if (!Schema::hasColumn('csr_pengajuans', 'no_surat')) {
                $table->string('no_surat')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('csr_pengajuans', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('no_surat');
            }
        });

        // Pengajuan Spareparts
        Schema::table('pengajuan_spareparts', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_spareparts', 'catatan')) {
                $table->text('catatan')->nullable()->after('terbilang');
            }
            if (!Schema::hasColumn('pengajuan_spareparts', 'no_surat')) {
                $table->string('no_surat')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('pengajuan_spareparts', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('no_surat');
            }
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
