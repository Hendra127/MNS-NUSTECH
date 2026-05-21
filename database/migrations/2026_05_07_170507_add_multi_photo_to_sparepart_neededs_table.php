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
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            $table->string('foto_resi')->nullable()->after('photo');
            $table->string('foto_terpasang')->nullable()->after('foto_resi');
            $table->string('foto_sn')->nullable()->after('foto_terpasang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            $table->dropColumn(['foto_resi', 'foto_terpasang', 'foto_sn']);
        });
    }
};
