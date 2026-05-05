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
        Schema::create('pengajuan_spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('tempat_tanggal')->nullable();
            $table->string('divisi')->nullable();
            $table->string('nomor')->nullable();
            $table->longText('items')->nullable(); // JSON data
            $table->bigInteger('grand_total')->nullable();
            $table->string('terbilang')->nullable();
            
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

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_spareparts');
    }
};

