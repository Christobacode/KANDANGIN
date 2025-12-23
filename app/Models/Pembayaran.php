<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Pembayaran fungsinya untuk mencatat bukti transaksi atau data pembayaran yang dilakukan user.
class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaranID';
    public $timestamps = false; // matikan timestamp karna tidak pake created_at dan updated_at

    // Casting: Memastikan data yang keluar dari database otomatis diubah ke tipe data yang bener.
    protected $casts = [
        'tglpembayaran' => 'date',
        'totalbayar' => 'integer', 
        'pembayaranID' => 'integer', 
        'userID' => 'integer', 
        'produkID' => 'integer', 
    ];

    protected $fillable = [
        'pembayaranID',
        'tglpembayaran',
        'totalbayar',
        'userID',
        'produkID',
    ];
}