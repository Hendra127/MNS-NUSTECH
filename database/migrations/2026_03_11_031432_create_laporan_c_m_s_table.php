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
        Schema::create('laporan_c_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('site_id');
            $table->string('nama_site')->nullable();
            $table->date('tanggal_on_site')->nullable();
            $table->string('nama_teknisi')->nullable();
            $table->string('laporan_cm')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('biaya_teknisi', 15, 2)->nullable();
            $table->string('foto_on_site')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_c_m_s');
    }
};
