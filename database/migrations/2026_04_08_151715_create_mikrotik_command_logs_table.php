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
        Schema::create('mikrotik_command_logs', function (Blueprint $table) {
            $table->id();
            $table->string('site_id', 50);
            $table->unsignedBigInteger('user_id');
            $table->string('command', 255);
            $table->json('parameters')->nullable();
            $table->text('response')->nullable();
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->string('category', 50)->nullable(); // interface, ip, dhcp, firewall, dll
            $table->timestamp('executed_at')->useCurrent();
            $table->timestamps();

            $table->index('site_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['site_id', 'executed_at'], 'mtcl_site_time_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_command_logs');
    }
};
