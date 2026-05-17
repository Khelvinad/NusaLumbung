<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_pools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('commodity');
            $table->string('unit');
            $table->decimal('target_qty', 12, 2);
            $table->decimal('current_qty', 12, 2)->default(0);
            $table->string('status')->default('open');
            $table->date('deadline');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_pools');
    }
};
