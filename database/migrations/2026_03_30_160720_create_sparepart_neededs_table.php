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
        Schema::create('sparepart_neededs', function (Blueprint $table) {
            $table->id();
            $table->string('site_id')->nullable();
            $table->string('sparepart_name');
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->string('status')->default('Pending'); // Pending, Approved, Completed, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart_neededs');
    }
};
