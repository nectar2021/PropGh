<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AdminAuthenticate extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $user = $request->user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }

    protected function redirectTo(Request $request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
