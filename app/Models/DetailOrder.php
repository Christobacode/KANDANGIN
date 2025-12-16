<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    // protected $primaryKey = 'kategoriID';
    public $timestamps = false;
    public $incrementing = false; // Karena Primary Key komposit, auto increment dimatikan

    // Karena Laravel tidak support composite key secara native di $primaryKey,
    // kita biarkan kosong atau atur logic khusus jika perlu update via model ini.
    
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
}