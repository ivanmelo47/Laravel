<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        /* Compruebo si el url ingresado es diferente del rol con el que inicie session */
        if ($request->user()->role !== $role) {
            /* Si resulta diferente, redireccion a determinado url dependiendo del rol que tiene el usuario que inicio session */
            if ($request->user()->role === 'admin') {
                return redirect('admin/dashboard');
            }
            if ($request->user()->role === 'agent') {
                return redirect('agent/dashboard');
            }
            if ($request->user()->role === 'user') {
                return redirect('dashboard');
            }
            //return redirect('admin/dashboard');
        }
        return $next($request);
    }
}
