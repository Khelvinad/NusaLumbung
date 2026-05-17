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
        Schema::create('harvest_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembuat_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_pool');
            $table->integer('target_qty');
            $table->integer('current_qty')->default(0);
            $table->date('deadline');
            $table->enum('status', ['open', 'fulfilled', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_pools');
    }
};
