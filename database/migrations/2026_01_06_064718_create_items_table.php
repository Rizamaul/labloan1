<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            
            // --- INI HASIL LANGKAH 1 & 2 DIGABUNG ---
            $table->string('name');         // Nama barang
            $table->text('description');    // Deskripsi
            $table->integer('stock');       // Stok
            
            // Kolom category_id yang tadi bikin error
            $table->unsignedBigInteger('category_id')->nullable();
            // ----------------------------------------

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};