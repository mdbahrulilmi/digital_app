<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $referer = $request->header('referer');
        
        // Simpan data pengunjung dengan referrer
        Visitor::updateOrCreate(
            ['ip_address' => $request->ip()],
            [
                'last_visit' => now(), 
                'user_agent' => $request->userAgent(),
                'referrer' => $referer 
            ]
        );

        return $next($request);
    }
}
