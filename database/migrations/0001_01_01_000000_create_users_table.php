<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            // Menggunakan nama custom 'userID' sebagai Primary Key
            $table->id('userID'); 
            $table->string('nama', 100);
            $table->string('password', 255); // Disarankan 255 untuk hash
            $table->string('role', 50);
            $table->string('email', 100);
            $table->string('username', 100);
            
            // Opsional: timestamps (created_at, updated_at)
            // $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};