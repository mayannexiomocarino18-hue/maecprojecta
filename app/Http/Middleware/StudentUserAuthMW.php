<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentUserAuthMW
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('user_account_id')) {
            return redirect()->route('student.login');
        }

        return $next($request);
    }
}
