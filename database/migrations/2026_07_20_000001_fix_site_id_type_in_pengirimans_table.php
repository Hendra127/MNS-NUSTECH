<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix: Ubah tipe kolom site_id di pengirimans dari unsignedBigInteger (integer)
     * menjadi string (varchar), agar cocok dengan sites.site_id yang bertipe string.
     * Sebelumnya menggunakan foreignId() yang menghasilkan UNSIGNED BIGINT.
     */
    public function up(): void
    {
        if (Schema::hasTable('pengirimans')) {
            Schema::table('pengirimans', function (Blueprint $table) {
                // Drop foreign key constraint dulu jika ada
                try {
                    $table->dropForeign(['site_id']);
                } catch (\Exception $e) {
                    // Foreign key mungkin tidak ada atau nama berbeda, lanjutkan
                }

                // Ubah tipe kolom site_id menjadi string agar cocok dengan sites.site_id
                $table->string('site_id', 50)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pengirimans')) {
            Schema::table('pengirimans', function (Blueprint $table) {
                // Kembalikan ke unsignedBigInteger jika di-rollback
                $table->unsignedBigInteger('site_id')->nullable()->change();
            });
        }
    }
};
