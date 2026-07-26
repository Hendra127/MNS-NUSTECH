<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the new ENUM values first so we don't lose data
        DB::statement("ALTER TABLE csr_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_dibayar'");
        DB::statement("ALTER TABLE pengajuan_spareparts MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_dibayar'");
        DB::statement("ALTER TABLE cm_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_dibayar'");

        // Migrate existing data to the new values
        DB::statement("UPDATE csr_pengajuans SET status_pembayaran = 'belum_dibayar' WHERE status_pembayaran = 'belum_lunas'");
        DB::statement("UPDATE csr_pengajuans SET status_pembayaran = 'lunas' WHERE status_pembayaran = 'sudah_lunas'");

        DB::statement("UPDATE pengajuan_spareparts SET status_pembayaran = 'belum_dibayar' WHERE status_pembayaran = 'belum_lunas'");
        DB::statement("UPDATE pengajuan_spareparts SET status_pembayaran = 'lunas' WHERE status_pembayaran = 'sudah_lunas'");

        DB::statement("UPDATE cm_pengajuans SET status_pembayaran = 'belum_dibayar' WHERE status_pembayaran = 'belum_lunas'");
        DB::statement("UPDATE cm_pengajuans SET status_pembayaran = 'lunas' WHERE status_pembayaran = 'sudah_lunas'");

        // Remove the old ENUM values
        DB::statement("ALTER TABLE csr_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas') DEFAULT 'belum_dibayar'");
        DB::statement("ALTER TABLE pengajuan_spareparts MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas') DEFAULT 'belum_dibayar'");
        DB::statement("ALTER TABLE cm_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas') DEFAULT 'belum_dibayar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE csr_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");
        DB::statement("ALTER TABLE pengajuan_spareparts MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");
        DB::statement("ALTER TABLE cm_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_dibayar', 'dp_50', 'lunas', 'belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");

        DB::statement("UPDATE csr_pengajuans SET status_pembayaran = 'belum_lunas' WHERE status_pembayaran = 'belum_dibayar'");
        DB::statement("UPDATE csr_pengajuans SET status_pembayaran = 'sudah_lunas' WHERE status_pembayaran = 'lunas'");

        DB::statement("UPDATE pengajuan_spareparts SET status_pembayaran = 'belum_lunas' WHERE status_pembayaran = 'belum_dibayar'");
        DB::statement("UPDATE pengajuan_spareparts SET status_pembayaran = 'sudah_lunas' WHERE status_pembayaran = 'lunas'");

        DB::statement("UPDATE cm_pengajuans SET status_pembayaran = 'belum_lunas' WHERE status_pembayaran = 'belum_dibayar'");
        DB::statement("UPDATE cm_pengajuans SET status_pembayaran = 'sudah_lunas' WHERE status_pembayaran = 'lunas'");

        DB::statement("ALTER TABLE csr_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");
        DB::statement("ALTER TABLE pengajuan_spareparts MODIFY COLUMN status_pembayaran ENUM('belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");
        DB::statement("ALTER TABLE cm_pengajuans MODIFY COLUMN status_pembayaran ENUM('belum_lunas', 'sudah_lunas') DEFAULT 'belum_lunas'");
    }
};
