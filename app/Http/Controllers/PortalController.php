<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function studentDashboard(): View
    {
        $userAccount = $this->currentUserAccount();

        return view('dashboards.student', [
            'userAccount' => $userAccount,
            'displayName' => $this->displayName($userAccount),
        ]);
    }

    public function teacherDashboard(): View
    {
        $userAccount = $this->currentUserAccount();

        return view('dashboards.teacher', [
            'userAccount' => $userAccount,
            'displayName' => $this->displayName($userAccount),
        ]);
    }

    public function adminDashboard(): View
    {
        $userAccount = $this->currentUserAccount();

        return view('dashboards.admin', [
            'userAccount' => $userAccount,
            'displayName' => $this->displayName($userAccount),
        ]);
    }

    protected function currentUserAccount(): UserAccounts
    {
        return UserAccounts::with('student')
            ->findOrFail(session('user_account_id'));
    }

    protected function displayName(UserAccounts $userAccount): string
    {
        if ($userAccount->student) {
            return trim($userAccount->student->first_name.' '.$userAccount->student->last_name);
        }

        return $userAccount->username;
    }
}
