<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePageAccess
{
    /**
     * Ensure the authenticated user has access to the given page key.
     */
    public function handle(Request $request, Closure $next, string $pageKey): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasPageAccess($pageKey)) {
            return $next($request);
        }

        return redirect()->route($user->firstAccessibleRouteName())
            ->with('error', 'You do not have permission to access that page.');
    }
}
