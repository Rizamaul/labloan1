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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            
            // Kolom Wajib untuk Peminjaman
            // foreignId -> otomatis membuat kolom user_id & item_id
            // constrained -> otomatis menyambungkan ke tabel users & items
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            
            $table->date('loan_date');              // Tanggal pinjam
            $table->date('return_date')->nullable(); // Tanggal kembali (boleh kosong)
            $table->string('status');               // Status (borrowed/returned)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};