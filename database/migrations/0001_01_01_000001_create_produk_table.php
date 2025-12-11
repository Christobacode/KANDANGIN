<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produkID');
            $table->string('namaproduk', 100);
            $table->decimal('hargaproduk', 10, 2);
            $table->integer('stokproduk');
            
            // Foreign Key ke tabel kategori
            // nullable() karena di SQL aslinya DEFAULT NULL
            $table->foreignId('kategoriID')
                  ->nullable()
                  ->constrained('kategori', 'kategoriID')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};