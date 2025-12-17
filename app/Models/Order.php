<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'orderID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'totalharga',
        'status', // WAJIB ADA
    ];

    protected $casts = [
        'totalharga' => 'integer',
        'orderID' => 'integer',
        'userID' => 'integer',
    ];

    // Relasi ke tabel detail_order
    public function detail()
    {
        return $this->hasMany(DetailOrder::class, 'orderID', 'orderID');
    }
}