<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, ...$roles) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $userRole = strtolower(trim(optional($user->role)->role_name));
        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('dashboard.' . $this->mapRoleToRoute($userRole))
                ->with('error', 'Access denied. You are not authorized to view this page.');
        }

        return $next($request);
    }

    protected function mapRoleToRoute(string $roleName): string {
        return match ($roleName) {
            'admin' => 'admin',
            'sales manager' => 'manager',
            'agent' => 'agent',
            'client' => 'client',
            default => 'index',
        };
    }
}
