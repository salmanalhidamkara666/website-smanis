<?php
namespace App\Http\Middleware;
use Closure;use Illuminate\Http\Request;use App\Models\User;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = User::find(session('user_id'));
        if (!$user || !in_array($user->role, $roles, true)) abort(403, 'Akses ditolak.');
        view()->share('authUser', $user);
        return $next($request);
    }
}
