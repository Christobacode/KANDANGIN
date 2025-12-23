<?php

// File ini untuk mengatur routing, middleware, dan penanganan exception secara terpusat.

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    /**
     * Konfigurasi Routing
     * Mengatur jalur file untuk rute web dan konsol.
     */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Mendaftarkan middleware agar dapat digunakan
    ->withMiddleware(function (Middleware $middleware): void {
        
        // Mendaftarkan alias middleware 'is_admin'
        // bagian ini untuk membatasi akses rute admin.
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

    })
    
    // Konfigurasi Exception Handling digunakan untuk mengatur bagaimana aplikasi menangani error atau pengecualian.
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();