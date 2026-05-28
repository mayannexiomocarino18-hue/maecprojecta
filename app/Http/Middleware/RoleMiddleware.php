<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $role = $request->session()->get('user_role');

        if (! $role || ! in_array($role, $roles, true)) {
            return redirect()->route('student.login')
                ->withErrors(['username' => 'You do not have permission to access that page.']);
        }

        return $next($request);
    }
}
