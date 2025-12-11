<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_order', function (Blueprint $table) {
            // Relasi ke order
            $table->foreignId('orderID')
                  ->constrained('order', 'orderID')
                  ->cascadeOnDelete(); // Hapus detail jika order dihapus

            // Relasi ke produk
            $table->foreignId('produkID')
                  ->constrained('produk', 'produkID')
                  ->cascadeOnDelete();

            $table->integer('qty')->default(1);

            // Membuat Composite Primary Key (kombinasi orderID & produkID)
            $table->primary(['orderID', 'produkID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_order');
    }
};