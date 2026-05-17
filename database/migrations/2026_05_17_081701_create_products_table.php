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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Petani pemilik
            $table->foreignId('commodity_id')->nullable()->constrained('commodity_prices')->nullOnDelete();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0); // Validasi controller tidak boleh negatif
            $table->string('foto'); 
            $table->date('estimasi_panen');
            $table->boolean('is_approved')->default(false); // Sesuai task Filament approve/reject
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
