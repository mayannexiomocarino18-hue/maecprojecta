<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherAccountController extends Controller
{
    public function create(): View
    {
        return view('teachers.create');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'email' => 'required|email|unique:user_accounts,email',
            'password' => 'required|string|min:8',
        ]);

        $teacherAccount = UserAccounts::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'role' => 'teacher',
            'is_active' => 1,
            'must_change_password' => 1,
        ]);

        if ($request->ajax()) {
            $request->session()->flash('message', 'Teacher account added successfully.');
            return response()->json($teacherAccount->makeHidden('password'));
        }

        return redirect()
            ->route('admin.students.index')
            ->with('message', 'Teacher account added successfully.');
    }
}
