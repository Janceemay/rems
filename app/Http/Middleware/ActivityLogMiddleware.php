<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class ActivityLogMiddleware {
    public function handle(Request $request, Closure $next) {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();

            if ($request->isMethod('post') || $request->isMethod('put') ||
                $request->isMethod('patch') || $request->isMethod('delete')) {

                AuditLog::create([
                    'user_id' => $user->user_id,
                    'action' => strtoupper($request->method()),
                    'target_table' => $this->getRouteModel($request),
                    'target_id' => $this->getRouteModelId($request),
                    'timestamp' => now(),
                    'remarks' => 'Route: ' . $request->path(),
                ]);
            }
        }

        return $response;
    }

    protected function getRouteModel(Request $request): ?string {
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return null;
        }

        return explode('.', $routeName)[0] ?? null;
    }

    protected function getRouteModelId(Request $request): ?int {
        $params = $request->route()?->parameters() ?? [];
        foreach ($params as $param) {
            if (is_object($param) && property_exists($param, $param->getKeyName())) {
                return $param->getKey();
            }
            if (is_numeric($param)) {
                return (int) $param;
            }
        }
        return null;
    }
}

