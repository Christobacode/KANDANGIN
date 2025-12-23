<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Kategori fungsinya untuk mengelola data kategori produk.
class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'kategoriID';
    public $timestamps = false;

    protected $fillable = [
        'namakategori',
        'kategoriID',
    ];

    // Casting: Memastikan data yang keluar dari database otomatis diubah ke tipe data yang bener.
    protected $casts = [
        'kategoriID' => 'integer', //ubah casting
    ];
}