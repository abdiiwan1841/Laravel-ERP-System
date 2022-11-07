<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackLastActiveAt
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
        if (! $request->user()) {
            return $next($request);
        }

        if (! $request->user()->last_active_at || $request->user()->last_active_at->isPast()) {
            $request->user()->update([
                'last_active_at' => now(),
            ]);
        }
        return $next($request);
    }
}
