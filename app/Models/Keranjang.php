<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'keranjangID';
    protected $fillable = ['userID', 'produkID', 'qty'];
    
    // matikan timestamp jika tidak ingin ribet, atau nyalakan jika tabel punya created_at
    public $timestamps = false; 

    // Relasi ke Produk 
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkID', 'produkID');
    }
}