<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    // protected $primaryKey = 'kategoriID';
    public $timestamps = false;
    public $incrementing = false; // Karena Primary Key komposit, auto increment dimatikan

    
    protected $fillable = [
        'orderID',
        'produkID',
        'qty',
    ];

    protected $casts = [
        'orderID' => 'integer', //ubah casting
        'produkID' => 'integer', //ubah casting
        'qty' => 'integer', //ubah casting
    ];

    // fungsi ini untuk memanggil: $detail->produk->namaproduk
    public function produk()
    {
        // Parameter: (Model Tujuan, Foreign Key di tabel ini, Primary Key di tabel tujuan)
        return $this->belongsTo(Produk::class, 'produkID', 'produkID');
    }
    
}