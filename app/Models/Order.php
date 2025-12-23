<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Order ini adalah tabel utama buat nyimpen data transaksi atau pesanan user.
class Order extends Model
{
    protected $table = 'order'; 
    protected $primaryKey = 'orderID';
    public $timestamps = false; // matikan timestamp karna tidak pake created_at dan updated_at

    protected $fillable = ['userID', 'totalharga', 'status'];

    public function detail()
    {
        // Parameter (Model Tujuan, Foreign Key di tabel detail, Primary Key di tabel ini)
        return $this->hasMany(DetailOrder::class, 'orderID', 'orderID');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}