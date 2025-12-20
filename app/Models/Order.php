<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order'; 
    protected $primaryKey = 'orderID';
    public $timestamps = false;

    protected $fillable = ['userID', 'totalharga', 'status'];

    public function detail()
    {
        return $this->hasMany(DetailOrder::class, 'orderID', 'orderID');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}