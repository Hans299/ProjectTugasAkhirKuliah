<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            
            // ======================================================
            //      ALIAS KUSTOM ANDA (INI SUDAH BENAR)
            // ======================================================
            'superadmin' => \App\Http\Middleware\IsSuperadmin::class,
            'pustakawan' => \App\Http\Middleware\IsPustakawan::class,
            'laboran' => \App\Http\Middleware\IsLaboran::class,
            'siswa' => \App\Http\Middleware\IsSiswa::class,

            // ======================================================
            //      ALIAS BAWAAN LARAVEL (INI YANG ERROR)
            // ======================================================
            // GANTI 'App\Http\Middleware\...' MENJADI 'Illuminate\Auth\Middleware\...'
            
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            
            // Tambahkan ini juga, ini adalah alias bawaan yang berguna
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
