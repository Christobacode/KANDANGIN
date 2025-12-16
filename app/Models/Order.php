<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'orderID';
    public $timestamps = false;

    protected $fillable = [
        'orderID',
        'totalharga',
        'userID',
    ];

    protected $casts = [
        'totalharga' => 'integer', //ubah casting
        'orderID' => 'integer', //ubah casting
        'userID' => 'integer', //ubah casting
    ];

    // // Relasi: Order dimiliki oleh satu User
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'userID', 'userID');
    // }

    // // Relasi: Order memiliki banyak Produk (Many-to-Many melalui detail_order)
    // public function produk()
    // {
    //     return $this->belongsToMany(Produk::class, 'detail_order', 'orderID', 'produkID')
    //                 ->withPivot('qty');
    // }
}