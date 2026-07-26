<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom sparepart_needed_id ke tabel sparetracker agar bisa
     * melacak dari pengajuan mana sebuah record sparetracker berasal.
     */
    public function up(): void
    {
        Schema::table('sparetracker', function (Blueprint $table) {
            if (!Schema::hasColumn('sparetracker', 'sparepart_needed_id')) {
                $table->unsignedBigInteger('sparepart_needed_id')->nullable()->after('keterangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sparetracker', function (Blueprint $table) {
            $table->dropColumn('sparepart_needed_id');
        });
    }
};
