<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KeycloakAuthenticate
{
    public function handle(Request $request, Closure $next, string $guard = 'client')
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $config = config("services.keycloak.{$guard}");

            // Verify token and get user info
            $response = Http::get($config['base_url'] . '/realms/' . $config['realm'] . '/protocol/openid-connect/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            if (!$response->successful()) {
                return response()->json(['error' => 'Invalid token'], 401);
            }

            $userInfo = $response->json();

            // For admin routes, verify required roles
            if ($guard === 'admin') {
                $hasAdminRole = collect($userInfo['realm_access']['roles'] ?? [])
                    ->contains(function ($role) {
                        return in_array($role, ['admin', 'super-admin']);
                    });

                if (!$hasAdminRole) {
                    return response()->json(['error' => 'Insufficient permissions'], 403);
                }
            }

            // Add user info to request for later use
            $request->attributes->add(['user' => $userInfo]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }
}
