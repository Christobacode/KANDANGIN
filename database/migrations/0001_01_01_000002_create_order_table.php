<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('orderID');
            $table->integer('totalharga');
            
            // Foreign Key ke tabel user
            $table->foreignId('userID')
                  ->nullable()
                  ->constrained('user', 'userID')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order');
    }
};