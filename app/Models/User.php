<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Menentukan nama tabel karena di SQL namanya 'user' (singular)
    protected $table = 'user';

    // Menentukan primary key karena bukan 'id'
    protected $primaryKey = 'userID';

    // Nonaktifkan timestamps karena tidak ada kolom created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'password',
        'role',
        'username',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi: User memiliki banyak Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'userID', 'userID');
    }

    // Relasi: User memiliki banyak Pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'userID', 'userID');
    }
}