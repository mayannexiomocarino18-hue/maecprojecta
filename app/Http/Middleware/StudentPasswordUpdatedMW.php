<?php

namespace App\Http\Middleware;

use App\Models\UserAccounts;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentPasswordUpdatedMW
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAccountId = $request->session()->get('user_account_id');

        if (! $userAccountId) {
            return redirect()->route('student.login');
        }

        $userAccount = UserAccounts::find($userAccountId);

        if (! $userAccount) {
            $request->session()->forget([
                'user_account_id',
                'user_role',
                'student_id',
            ]);

            return redirect()->route('student.login');
        }

        if ($userAccount->must_change_password) {
            return redirect()->route('student.password.edit');
        }

        return $next($request);
    }
}
