<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model DetailOrder Fungsinya buat nyimpen rincian barang apa aja yang dibeli di setiap transaksi (order).
class DetailOrder extends Model
{
    protected $table = 'detail_order';
    // protected $primaryKey = 'kategoriID';
    public $timestamps = false; // biar di table tidak error karna tidak pake created_at dan updated_at
    public $incrementing = false; // Karena Primary Key komposit, auto increment dimatikan

    
    protected $fillable = [
        'orderID',
        'produkID',
        'qty',
    ];

    // Casting: Memastikan data yang keluar dari database otomatis diubah ke tipe data yang bener.
    protected $casts = [
        'orderID' => 'integer', 
        'produkID' => 'integer', 
        'qty' => 'integer', 
    ];

    // fungsi ini untuk memanggil: $detail->produk->namaproduk
    public function produk()
    {
        // Parameter (Model Tujuan, Foreign Key di tabel ini, Primary Key di tabel tujuan)
        return $this->belongsTo(Produk::class, 'produkID', 'produkID');
    }
    
}