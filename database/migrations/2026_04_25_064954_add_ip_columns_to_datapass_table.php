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
        Schema::table('datapass', function (Blueprint $table) {
            $table->string('ip_ap1')->nullable()->after('pass_ap1');
            $table->string('ip_ap2')->nullable()->after('pass_ap2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datapass', function (Blueprint $table) {
            $table->dropColumn(['ip_ap1', 'ip_ap2']);
        });
    }
};
