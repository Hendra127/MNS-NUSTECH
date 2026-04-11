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
            $table->string('urgency')->default('Medium')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sparepart_neededs', function (Blueprint $table) {
            $table->dropColumn('urgency');
        });
    }
};
