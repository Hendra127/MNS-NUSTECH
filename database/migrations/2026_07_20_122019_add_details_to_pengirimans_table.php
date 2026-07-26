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
        if (Schema::hasTable('pengirimans')) {
            Schema::table('pengirimans', function (Blueprint $table) {
                $table->date('tanggal_pengiriman')->nullable();
                $table->string('nama_pengirim')->nullable();
                $table->string('nama_penerima')->nullable();
                $table->string('kabkota_pengirim')->nullable();
                $table->string('kabkota_penerima')->nullable();
                $table->decimal('biaya_pengiriman', 15, 2)->nullable();
                $table->string('klasifikasi')->nullable()->default('BMN');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pengirimans')) {
            Schema::table('pengirimans', function (Blueprint $table) {
                $table->dropColumn([
                    'tanggal_pengiriman',
                    'nama_pengirim',
                    'nama_penerima',
                    'kabkota_pengirim',
                    'kabkota_penerima',
                    'biaya_pengiriman',
                    'klasifikasi'
                ]);
            });
        }
    }
};
