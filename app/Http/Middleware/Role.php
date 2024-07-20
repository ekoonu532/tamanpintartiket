<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        if ($user->role !== $role) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        // Cek jika user adalah admin dan mencoba mengakses root URL
        if ($user->role === 'admin' && !$request->is('admin/*')) {
            return redirect()->route('admin.dashboard');
        }

        // Ensure non-admin can't access admin routes
        if ($user->role !== 'admin' && $request->is('admin/*')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
