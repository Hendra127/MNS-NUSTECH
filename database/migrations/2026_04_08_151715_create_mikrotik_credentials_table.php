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
        Schema::create('mikrotik_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('site_id', 50)->unique();
            $table->string('api_host', 100);
            $table->integer('api_port')->default(8728);
            $table->string('api_user', 100);
            $table->text('api_password');
            $table->boolean('use_ssl')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_connected')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
            // site_id sudah unique() di atas sebagai index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_credentials');
    }
};
