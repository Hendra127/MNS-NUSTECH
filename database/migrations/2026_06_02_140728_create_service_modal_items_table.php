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
        Schema::create('service_modal_items', function (Blueprint $table) {
            $table->id();
            $table->string('modal_key'); // 'jaringan', 'vsat', 'baseband', 'cctv'
            $table->string('title');
            $table->string('year')->nullable();
            $table->string('client')->nullable();
            $table->string('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_modal_items');
    }
};
