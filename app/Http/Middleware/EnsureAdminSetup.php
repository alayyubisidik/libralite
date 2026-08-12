<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSetup
{
    /**
     * Handle an incoming request.
     *
     * - When no user accounts exist, force the app to the setup-admin page.
     * - Once an admin exists, the setup-admin page is no longer accessible.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isSetupRoute = $request->routeIs('setup.admin.create', 'setup.admin.store');

        $adminExists = User::whereHas('roles', fn ($query) => $query->where('name', 'admin'))->exists();

        if ($adminExists) {
            if ($isSetupRoute) {
                return to_route('login');
            }

            return $next($request);
        }

        if (! $isSetupRoute && User::query()->count() === 0) {
            return to_route('setup.admin.create');
        }

        return $next($request);
    }
}
