<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'produkID';
    public $timestamps = false;
    protected $guarded = [];

    
    protected $fillable = [
        'namaproduk', 
        'hargaproduk', 
        'stokproduk', 
        'kategoriID', 
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoriID', 'kategoriID');
    }

}