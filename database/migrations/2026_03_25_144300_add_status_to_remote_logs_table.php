<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remote_logs', function (Blueprint $table) {
            $table->enum('status', ['success', 'failed', 'unknown'])
                  ->default('unknown')
                  ->after('source_page')
                  ->comment('Status koneksi: success = berhasil masuk, failed = gagal/offline, unknown = tidak diketahui');
        });
    }

    public function down(): void
    {
        Schema::table('remote_logs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
