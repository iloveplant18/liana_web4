<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('isAdmin') || $request->session()->get('isAdmin') !== 1) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
} 