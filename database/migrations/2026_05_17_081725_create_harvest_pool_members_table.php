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
        Schema::create('harvest_pool_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_pool_id')->constrained()->cascadeOnDelete();
            $table->foreignId('petani_id')->constrained('users')->cascadeOnDelete();
            $table->integer('qty_kontribusi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_pool_members');
    }
};
