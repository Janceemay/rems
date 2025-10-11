<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware{
    public function handle(Request $request, Closure $next, $roles){
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $rolesArray = array_map('trim', explode(',', $roles));

        if (!in_array(optional($user->role)->role_name, $rolesArray)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
