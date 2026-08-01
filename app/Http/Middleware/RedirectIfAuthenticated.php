<?php
namespace App\Http\Middleware;
use Closure;use Illuminate\Http\Request;use App\Models\User;
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user_id')) {
            $user = User::find(session('user_id'));
            return redirect()->route($user?->role.'.dashboard');
        }
        return $next($request);
    }
}
