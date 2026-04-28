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
        Schema::table('log_perangkat', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('perangkat');
            $table->string('layanan')->nullable()->after('keterangan'); // e.g. SEWA LAYANAN, BMN
            $table->string('foto_baru')->nullable()->after('layanan');  // path to uploaded photo
            $table->string('column_1')->nullable()->after('foto_baru');
            $table->string('column_2')->nullable()->after('column_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_perangkat', function (Blueprint $table) {
            $table->dropColumn(['qty', 'layanan', 'foto_baru', 'column_1', 'column_2']);
        });
    }
};
