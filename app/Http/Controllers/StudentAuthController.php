<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Throwable;

class StudentAuthController extends Controller
{
    public function showLogin(): ViewContract|Response
    {
        try {
            return view('auth.student-login');
        } catch (Throwable $e) {
            report($e);

            if (config('app.debug')) {
                return response(
                    '<pre style="white-space: pre-wrap; font-family: monospace; padding: 16px;">'
                    .e((string) $e).
                    '</pre>',
                    500
                );
            }

            throw $e;
        }
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $userAccount = UserAccounts::with('student')
                ->where('username', $credentials['username'])
                ->first();

            if (! $userAccount || ! $userAccount->is_active || ! $this->passwordMatches($credentials['password'], $userAccount->password)) {
                return back()
                    ->withErrors(['username' => 'Invalid username or password.'])
                    ->withInput($request->only('username'));
            }

            if ($this->needsBcryptRehash($userAccount->password)) {
                $userAccount->update([
                    'password' => $this->bcryptHash($credentials['password']),
                ]);
            }

            $request->session()->regenerate();
            $request->session()->put([
                'user_account_id' => $userAccount->id,
                'user_role' => $userAccount->role,
                'student_id' => optional($userAccount->student)->id,
            ]);

            if ($userAccount->must_change_password) {
                return redirect()
                    ->route('student.password.edit')
                    ->with('message', $this->loginMessage($userAccount));
            }

            return redirect()
                ->route($this->redirectRoute($userAccount))
                ->with('message', $this->loginMessage($userAccount));
        } catch (Throwable $e) {
            report($e);

            if (config('app.debug')) {
                return response(
                    '<pre style="white-space: pre-wrap; font-family: monospace; padding: 16px;">'
                    .e((string) $e).
                    '</pre>',
                    500
                );
            }

            throw $e;
        }
    }

    public function showChangePassword(): ViewContract
    {
        $userAccount = $this->currentUserAccount();

        if (! $userAccount->must_change_password) {
            return redirect()->route($this->redirectRoute($userAccount));
        }

        return view('auth.change-student-password', [
            'userAccount' => $userAccount,
            'displayName' => $this->displayName($userAccount),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $userAccount = $this->currentUserAccount();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:current_password',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if (! $this->passwordMatches($request->current_password, $userAccount->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $userAccount->update([
            'password' => $this->bcryptHash($request->new_password),
            'must_change_password' => 0,
        ]);

        return redirect()
            ->route($this->redirectRoute($userAccount))
            ->with('message', $this->loginMessage($userAccount));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'user_account_id',
            'user_role',
            'student_id',
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('student.login')
            ->with('message', 'Successful Logout');
    }

    protected function currentUserAccount(): UserAccounts
    {
        return UserAccounts::with('student')
            ->findOrFail(session('user_account_id'));
    }

    protected function redirectRoute(?UserAccounts $userAccount = null): string
    {
        $userAccount ??= $this->currentUserAccount();

        return match ($userAccount->role) {
            'teacher' => 'teacher.dashboard',
            'admin' => 'admin.students.index',
            default => 'student.dashboard',
        };
    }

    protected function displayName(UserAccounts $userAccount): string
    {
        if ($userAccount->student) {
            return trim($userAccount->student->first_name.' '.$userAccount->student->last_name);
        }

        return $userAccount->username;
    }

    protected function loginMessage(UserAccounts $userAccount): string
    {
        return 'Successful Login';
    }

    protected function passwordMatches(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    protected function needsBcryptRehash(string $hashedPassword): bool
    {
        return password_needs_rehash($hashedPassword, PASSWORD_BCRYPT);
    }

    protected function bcryptHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
