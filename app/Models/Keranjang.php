<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Keranjang fungsinya buat nampung sementara barang-barang yang mau dibeli sama user.
class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'keranjangID';
    protected $fillable = ['userID', 'produkID', 'qty'];
    
    // matikan timestamp karna tidak pake created_at dan updated_at
    public $timestamps = false; 

    // Relasi ke Produk 
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkID', 'produkID');
    }
}