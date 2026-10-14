<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = env('SUPERADMIN_PASSWORD');

        if (blank($password)) {
            throw new RuntimeException('Set SUPERADMIN_PASSWORD in .env before seeding the superadmin account.');
        }

        $user = User::updateOrCreate(
            ['email' => env('SUPERADMIN_EMAIL', 'admin@duodev.in')],
            [
                'name' => env('SUPERADMIN_NAME', 'Super Admin'),
                'password' => Hash::make($password),
                'status' => 'active',
            ],
        );

        $user->forceFill(['email_verified_at' => $user->email_verified_at ?? now()])->save();

        $user->syncRoles('superadmin');
    }
}
