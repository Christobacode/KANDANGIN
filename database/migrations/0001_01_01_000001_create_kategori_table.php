<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel 'kategori' 
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('kategoriID'); // Primary Key (sesuai request tabel produk)
            $table->string('namakategori', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};