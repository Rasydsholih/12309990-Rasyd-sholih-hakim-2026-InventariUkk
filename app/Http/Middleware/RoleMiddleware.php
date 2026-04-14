<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {

            if ($userRole === 'admin') {
                return redirect('/error404')->with('error', 'Admin tidak boleh ke halaman operator!');
            }

            if ($userRole === 'operator') {
                return redirect('/error404')->with('error', 'Operator tidak boleh ke halaman admin!');
            }

            return redirect('/error404');
        }

        return $next($request);
    }
}