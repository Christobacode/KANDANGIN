<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <--- INI YANG HILANG TADI!

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Membuat Akun Admin sesuai request kamu
        User::factory()->create([
            'username' => 'Adminkandangin',       // Username Login
            'email'    => 'admin@kandangin.com',
            'password' => Hash::make('ADMINJUDOL'), // Password Login
            'role'     => 'admin',
        ]);
        
        // (Opsional) Akun User Biasa untuk tes
        User::factory()->create([
            'username' => 'biasaaja',
            'email'    => 'biasaaja@kandangin.com',
            'password' => Hash::make('user123'), 
            'role'     => 'user',
        ]);
    }
}