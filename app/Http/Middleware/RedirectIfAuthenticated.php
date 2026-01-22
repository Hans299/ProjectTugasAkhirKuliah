<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        return match (Auth::user()->role->name) {
            'superadmin' => redirect()->route('admin.superadmin.dashboard'),
            'pustakawan' => redirect()->route('admin.pustakawan.dashboard'),
            'laboran'    => redirect()->route('admin.laboran.dashboard'),
            'siswa'      => redirect()->route('siswa.dashboard'),
            default      => redirect()->route('login'),
        };
    }
}
