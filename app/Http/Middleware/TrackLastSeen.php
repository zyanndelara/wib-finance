<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Update at most once per minute to avoid hammering the DB
            $user = Auth::user();
            if (!$user->last_seen_at || now()->diffInSeconds($user->last_seen_at) >= 60) {
                DB::table('users')->where('id', $user->id)->update(['last_seen_at' => now()]);
                $user->last_seen_at = now(); // keep in-memory in sync
            }
        }

        return $next($request);
    }
}
