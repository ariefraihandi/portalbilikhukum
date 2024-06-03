<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessMenu;

class SidebarMiddleware
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
        // Periksa apakah session memiliki 'role'
        if ($request->session()->has('role')) {
            // Dapatkan role dari session
            $role = $request->session()->get('role');
            
            // Tambahkan role ke request agar bisa diakses di controller
            $request->merge(['userRole' => $role]);

            // Ambil akses menu berdasarkan role
            $accessMenus = AccessMenu::where('role_id', $role)->with('menu')->get();

            // Tambahkan akses menu ke request agar bisa diakses di controller
            $request->attributes->set('accessMenus', $accessMenus);
        }

        return $next($request);
    }
}
