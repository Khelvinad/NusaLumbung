<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_pool_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_pool_id')->constrained('harvest_pools')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('qty', 12, 2);
            $table->timestamps();

            $table->unique(['harvest_pool_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_pool_members');
    }
};
