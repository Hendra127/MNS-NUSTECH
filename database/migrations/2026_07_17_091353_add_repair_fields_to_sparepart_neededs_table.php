<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            if (!Schema::hasColumn('sparepart_neededs', 'foto_sn')) {
                $table->string('foto_sn')->nullable();
            }
            if (!Schema::hasColumn('sparepart_neededs', 'foto_perangkat')) {
                $table->string('foto_perangkat')->nullable();
            }
            if (!Schema::hasColumn('sparepart_neededs', 'sn_perangkat')) {
                $table->string('sn_perangkat')->nullable();
            }
            if (!Schema::hasColumn('sparepart_neededs', 'tipe_pengajuan')) {
                $table->string('tipe_pengajuan')->default('Pembelian Baru');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            //
        });
    }
};
