<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

//Model User model ini penting dan spesial karena mewarisi Authenticatable, fungsinya buat ngurusin login, pendaftaran, dan identitas user di aplikasi Kandangin.
class User extends Authenticatable
{
    

    // menentukan nama tabel karena di SQL namanya 'user' (singular)
    protected $table = 'user';

    // menentukan primary key karena bukan 'id'
    protected $primaryKey = 'userID';

    // matikan timestamp karna tidak pake created_at dan updated_at
    public $timestamps = false; 

    // Mass Assignment Protection: Kolom mana saja yang boleh diisi lewat User::create().
    // Penting buat keamanan biar gak ada orang iseng masukin data ke kolom yang gak seharusnya.
    protected $fillable = [
        'userID',
        'nama',
        'password',
        'role',
        'username',
    ];

    // Hidden Attributes: Kolom yang bakal disembunyikan kalau datanya diubah jadi array atau JSON.
    protected $hidden = [
        'password',
    ];
}