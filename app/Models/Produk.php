<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Produk fungsinya untuk mengelola data barang atau produk yang dijual di aplikasi Kandangin.
class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produkID';
    public $timestamps = false; // matikan timestamp karna tidak pake created_at dan updated_at

    
    protected $fillable = [
        'namaproduk', 
        'hargaproduk', 
        'stokproduk', 
        'kategoriID', 
        'gambar'
    ];

    // Relasi ke model kategori
    public function kategori()
    {
        // Parameter (Model Tujuan, Foreign Key di tabel ini, Primary Key di tabel kategori)
        return $this->belongsTo(Kategori::class, 'kategoriID', 'kategoriID');
    }

}