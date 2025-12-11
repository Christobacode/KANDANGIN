<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaranID';
    public $timestamps = false;

    // Casting tanggal agar otomatis jadi object Carbon/Date
    protected $casts = [
        'tglpembayaran' => 'date',
    ];

    protected $fillable = [
        'tglpembayaran',
        'totalbayar',
        'userID',
        'produkID',
    ];

    // Relasi: Pembayaran dilakukan oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Relasi: Pembayaran terkait Produk tertentu
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkID', 'produkID');
    }
}