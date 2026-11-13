<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Please login first.',
                ]);
        }

        $role = strtolower(trim((string) $user->role));

        // Kapag may specific roles sa route middleware,
        // iyon lang ang pinapayagang makapasok.
        if (!empty($roles)) {
            $allowedRoles = array_map(
                fn ($item) => strtolower(trim($item)),
                $roles
            );

            abort_unless(
                in_array($role, $allowedRoles, true),
                403,
                'You are not authorized to access this page.'
            );

            return $next($request);
        }

        // Owner at admin: general admin access.
        if (in_array($role, ['owner', 'admin'], true)) {
            return $next($request);
        }

        // Staff: access only to their assigned pages.
        $staffRoutes = [
            'rescue_staff' => [
                'admin.report-animal',
                'admin.report-animal.status',
                'admin.report-animal.archive',
            ],

            'shelter_staff' => [
                'admin.manage-animals',
                'admin.register-animal',
                'admin.register-animal.report',
                'admin.register-animal.store',
                'admin.registered-dogs',
                'admin.registered-cats',
                'admin.cages',
                'admin.cages.*',
                'admin.animal-cages',
            ],

            'adoption_staff' => [
                'admin.manage-adoptions',
                'admin.adoptions.approve',
                'admin.adoptions.reject',
                'admin.adoptions.archive',
                'admin.adoptions.complete',
                'admin.adoptions.download',
                'admin.adoption.valid-id',
            ],
        ];

        $routeName = $request->route()?->getName();

        foreach ($staffRoutes[$role] ?? [] as $allowedRoute) {
            if (
                $routeName === $allowedRoute ||
                (
                    str_ends_with($allowedRoute, '.*') &&
                    str_starts_with(
                        (string) $routeName,
                        substr($allowedRoute, 0, -1)
                    )
                )
            ) {
                return $next($request);
            }
        }

        abort(
            403,
            'You are not authorized to access this page.'
        );
    }
}
