<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna terautentikasi
        if (Auth::check()) {
            // Jika terautentikasi, ambil pengguna
            $user = Auth::user();
            
            // Set session dengan role pengguna
            $request->session()->put('role', $user->role);
            $request->session()->put('user_id', $user->id);
            
            // Jika pengguna mengakses /login, arahkan ke profil akun
            if ($request->is('login')) {
                return redirect()->route('account.profile');
            }
            
            // Lanjutkan ke rute yang diminta
            return $next($request);
        }
        
        // Simpan URL tujuan ke sesi
        $request->session()->put('url.intended', $request->fullUrl());

        $response = [
            'success' => false,
            'title' => 'Gagal',
            'message' => 'Anda perlu login untuk mengakses halaman ini.',
        ];

        if ($request->expectsJson()) {
            return response()->json($response, 401);
        }

        return redirect()->route('login')->with('response', $response);
    }
}
