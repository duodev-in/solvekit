<?php

namespace App\Services\SuperAdmin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            $user = User::create($data);
            $user->syncRoles($roles);
            $user->sendEmailVerificationNotification();

            return $user;
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            if (blank($data['password'] ?? null)) {
                unset($data['password']);
            }

            $user->update($data);
            $user->syncRoles($roles);

            return $user->refresh();
        });
    }

    public function updateStatus(User $user, string $status): User
    {
        $user->update(['status' => $status]);

        return $user->refresh();
    }
}
