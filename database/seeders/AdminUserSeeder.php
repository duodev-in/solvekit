<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => env('SUPERADMIN_EMAIL', 'admin@duodev.in')],
            [
                'name' => env('SUPERADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('SUPERADMIN_PASSWORD', 'password')),
                'status' => 'active',
                'email_verified_at' => now(),
            ],
        );

        $user->syncRoles('superadmin');
    }
}
