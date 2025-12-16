<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'kategoriID';
    public $timestamps = false;

    protected $fillable = [
        'namakategori',
        'kategoriID',
    ];

    protected $casts = [
        'kategoriID' => 'integer', //ubah casting
    ];

    // // Relasi: Kategori memiliki banyak Produk
    // public function produk()
    // {
    //     return $this->hasMany(Produk::class, 'kategoriID', 'kategoriID');
    // }
}