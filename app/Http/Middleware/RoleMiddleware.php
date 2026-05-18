<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $hasRole = $user->divisionMemberships()
            ->whereHas('role', function ($query) use ($roles) {
                $query->whereIn('slug', $roles);
            })
            ->exists();

        if (!$hasRole) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
