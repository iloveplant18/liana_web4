<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->is('admin/*')) {
            Visitor::create([
                'visit_time' => now(),
                'page_url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'host_name' => gethostbyaddr($request->ip()),
                'browser_name' => $request->header('User-Agent')
            ]);
        }

        return $response;
    }
}
