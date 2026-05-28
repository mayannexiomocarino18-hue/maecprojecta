<?php

namespace Database\Seeders;

use App\Models\UserAccounts;
use Illuminate\Database\Seeder;

class AdminUserAccountSeeder extends Seeder
{
    /**
     * Seed the application's admin account.
     */
    public function run(): void
    {
        UserAccounts::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => password_hash('Admin12345', PASSWORD_BCRYPT),
                'role' => 'admin',
                'is_active' => 1,
                'must_change_password' => 0,
            ]
        );
    }
}
