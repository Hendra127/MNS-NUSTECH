<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom pendukung ke tabel log_pergantians agar bisa
     * mencatat riwayat perubahan status/kondisi Sparetracker secara lengkap.
     */
    public function up(): void
    {
        Schema::table('log_pergantians', function (Blueprint $table) {
            if (!Schema::hasColumn('log_pergantians', 'aksi')) {
                // Jenis aksi: 'repair_selesai', 'dikirim', 'stok_masuk', 'manual_update', dll
                $table->string('aksi')->nullable()->after('keterangan');
            }
            if (!Schema::hasColumn('log_pergantians', 'status_lama')) {
                $table->string('status_lama')->nullable()->after('aksi');
            }
            if (!Schema::hasColumn('log_pergantians', 'status_baru')) {
                $table->string('status_baru')->nullable()->after('status_lama');
            }
            if (!Schema::hasColumn('log_pergantians', 'kondisi_lama')) {
                $table->string('kondisi_lama')->nullable()->after('status_baru');
            }
            if (!Schema::hasColumn('log_pergantians', 'kondisi_baru')) {
                $table->string('kondisi_baru')->nullable()->after('kondisi_lama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('log_pergantians', function (Blueprint $table) {
            $table->dropColumn(['aksi', 'status_lama', 'status_baru', 'kondisi_lama', 'kondisi_baru']);
        });
    }
};
