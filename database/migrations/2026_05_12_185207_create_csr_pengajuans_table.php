<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csr_pengajuans', function (Blueprint $table) {
            $table->id();

            // Info Pengajuan
            $table->string('tempat_tanggal')->nullable();
            $table->string('divisi')->nullable();
            $table->string('nomor')->nullable();

            // Detail CSR
            $table->string('nama_site')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->text('rincian_kebutuhan')->nullable(); // JSON array or text
            $table->bigInteger('total')->default(0);
            $table->string('terbilang')->nullable();

            // Approval workflow status
            // pending -> approved_manager -> approved_accounting -> approved_direktur -> approved_penasihat
            $table->string('approval_status')->default('pending');
            $table->timestamp('approved_manager_at')->nullable();
            $table->timestamp('approved_accounting_at')->nullable();
            $table->timestamp('approved_direktur_at')->nullable();
            $table->timestamp('approved_penasihat_at')->nullable();

            // Rejection tracking
            $table->string('rejected_by')->nullable(); // manager/accounting/direktur/penasihat
            $table->text('rejection_reason')->nullable();

            // Signatories
            $table->string('pemohon_nama')->nullable();
            $table->string('pemohon_jabatan')->nullable();

            $table->string('diverifikasi1_nama')->nullable();   // NOC Leader
            $table->string('diverifikasi1_jabatan')->nullable();

            $table->string('diverifikasi2_nama')->nullable();   // Manager
            $table->string('diverifikasi2_jabatan')->nullable();

            $table->string('diverifikasi3_nama')->nullable();   // Accounting
            $table->string('diverifikasi3_jabatan')->nullable();

            $table->string('disetujui_nama')->nullable();       // Direktur
            $table->string('disetujui_jabatan')->nullable();

            $table->string('mengetahui_nama')->nullable();      // Penasihat
            $table->string('mengetahui_jabatan')->nullable();

            // Created by
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csr_pengajuans');
    }
};
