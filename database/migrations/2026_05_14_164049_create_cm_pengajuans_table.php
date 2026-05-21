<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cm_pengajuans', function (Blueprint $table) {
            $table->id();

            // Info Pengajuan
            $table->string('tempat_tanggal')->nullable();
            $table->string('divisi')->nullable();
            $table->string('nomor')->nullable();

            // Detail CM
            $table->text('nama_site')->nullable(); // Multi-site support like CSR
            $table->string('tanggal_kunjungan')->nullable();
            $table->string('nama_teknisi')->nullable();
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->text('rincian_kebutuhan')->nullable();
            $table->bigInteger('total')->default(0);
            $table->string('terbilang')->nullable();
            $table->text('catatan')->nullable();

            // Approval workflow status
            $table->string('approval_status')->default('pending');
            $table->timestamp('approved_manager_at')->nullable();
            $table->timestamp('approved_accounting_at')->nullable();
            $table->timestamp('approved_direktur_at')->nullable();
            $table->timestamp('approved_penasihat_at')->nullable();

            // Signatures (TTD) - Storing paths or indicator
            $table->string('ttd_pemohon')->nullable();
            $table->string('ttd_manager')->nullable();
            $table->string('ttd_accounting')->nullable();
            $table->string('ttd_direktur')->nullable();
            $table->string('ttd_penasihat')->nullable();

            // Names and Roles for display
            $table->string('pemohon_nama')->nullable();
            $table->string('pemohon_jabatan')->nullable();
            $table->string('diverifikasi1_nama')->nullable();
            $table->string('diverifikasi1_jabatan')->nullable();
            $table->string('diverifikasi2_nama')->nullable();
            $table->string('diverifikasi2_jabatan')->nullable();
            $table->string('disetujui_nama')->nullable();
            $table->string('disetujui_jabatan')->nullable();
            $table->string('mengetahui_nama')->nullable();
            $table->string('mengetahui_jabatan')->nullable();

            // Rejection info
            $table->string('rejected_by')->nullable();
            $table->text('rejection_reason')->nullable();

            // Creator
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cm_pengajuans');
    }
};
