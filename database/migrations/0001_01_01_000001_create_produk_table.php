<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produkID');
            $table->string('namaproduk', 100);
            $table->integer('hargaproduk');
            $table->integer('stokproduk');
            
            $table->string('gambar')->nullable(); 
            
           
            $table->unsignedBigInteger('kategoriID');
            $table->foreign('kategoriID')->references('kategoriID')->on('kategori')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};