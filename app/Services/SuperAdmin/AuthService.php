<?php

namespace App\Services\SuperAdmin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials): ?User
    {
        if (! Auth::attempt($credentials, true)) {
            return null;
        }

        $user = Auth::user();

        if (! $user instanceof User || $user->status !== 'active' || ! $user->hasAnyRole(['superadmin', 'developer'])) {
            Auth::logout();

            return null;
        }

        request()->session()->regenerate();

        return $user;
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
