<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function (\Illuminate\Routing\Router $router) {
            
            // 1. Daftarkan routes/web.php (untuk Siswa & Tamu)
            $router->middleware('web')
                   ->group(base_path('routes/web.php'));

            // 2. Daftarkan routes/admin.php (untuk Admin)
            $router->middleware('web')
                   ->prefix('admin')
                   ->name('admin.')
                   ->group(base_path('routes/admin.php'));
        },
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
