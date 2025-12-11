<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaranID');
            $table->date('tglpembayaran')->nullable();
            $table->integer('totalbayar')->nullable();
            
            // Relasi ke User
            $table->foreignId('userID')
                  ->nullable()
                  ->constrained('user', 'userID');
            
            // Relasi ke Produk
            $table->foreignId('produkID')
                  ->nullable()
                  ->constrained('produk', 'produkID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};