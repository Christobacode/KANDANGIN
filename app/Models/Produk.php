<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'produkID';
    public $timestamps = false;

    protected $fillable = [
        'produkID',
        'namaproduk',
        'hargaproduk',
        'stokproduk',
        'kategoriID',
    ];

    protected $casts = [
        'hargaproduk' => 'integer', //ubah casting
        'stokproduk' => 'integer', //ubah casting
        'produkID' => 'integer', //ubah casting
        'kategoriID' => 'integer', //ubah casting
    ];

    // // Relasi: Produk dimiliki oleh satu Kategori
    // public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'kategoriID', 'kategoriID');
    // }

    // // Relasi: Produk ada di banyak Order (Many-to-Many melalui detail_order)
    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'detail_order', 'produkID', 'orderID')
    //                 ->withPivot('qty');
    // }

    // // Relasi: Produk bisa memiliki riwayat pembayaran (opsional, berdasarkan struktur FK di tabel pembayaran)
    // public function pembayaran()
    // {
    //     return $this->hasMany(Pembayaran::class, 'produkID', 'produkID');
    // }
}