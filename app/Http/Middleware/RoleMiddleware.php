<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                           ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // If no specific role is required, just check if user can manage content
        if (!$role) {
            if ($user->canManageContent()) {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        }

        // Check specific role requirements
        switch ($role) {
            case 'super_admin':
                if ($user->isSuperAdmin()) {
                    return $next($request);
                }
                break;
                
            case 'admin':
                if ($user->isAdmin()) {
                    return $next($request);
                }
                break;
                
            case 'editor':
                if ($user->isEditor() || $user->isAdmin()) {
                    return $next($request);
                }
                break;
                
            case 'content_manager':
                if ($user->canManageContent()) {
                    return $next($request);
                }
                break;
                
            case 'publisher':
                if ($user->canPublishContent()) {
                    return $next($request);
                }
                break;
        }

        abort(403, 'Unauthorized access.');
    }
}
