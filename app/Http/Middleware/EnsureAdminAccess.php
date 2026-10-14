<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        if ($request->user()->status !== 'active' || ! $request->user()->hasAnyRole(['superadmin', 'developer'])) {
            abort(403);
        }

        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('admin.verification.notice');
        }

        return $next($request);
    }
}
