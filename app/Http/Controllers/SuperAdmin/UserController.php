<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreUserRequest;
use App\Http\Requests\SuperAdmin\UpdateUserRequest;
use App\Http\Requests\SuperAdmin\UpdateUserStatusRequest;
use App\Models\AuditLog;
use App\Models\User;
use App\Services\SuperAdmin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request): View
    {
        $users = User::query()->with('roles')
            ->when($request->filled('search'), fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%')->orWhere('email', 'like', '%'.$request->string('search').'%')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()->paginate(20)->withQueryString();

        return view('superadmin.users.index', ['users' => $users, 'statuses' => config('superadmin.statuses')]);
    }

    public function create(): View
    {
        return view('superadmin.users.form', ['user' => new User, 'roles' => Role::orderBy('name')->get()]);
    }

    public function show(User $user): View
    {
        $user->load('roles.permissions');

        $activities = AuditLog::query()
            ->with('user')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('auditable_type', User::class)
                            ->where('auditable_id', $user->id);
                    });
            })
            ->latest()
            ->paginate(15, ['*'], 'activity_page');

        return view('superadmin.users.show', [
            'user' => $user,
            'permissions' => $user->getAllPermissions()->sortBy('name'),
            'permissionGroups' => config('roles.groups', []),
            'activities' => $activities,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')->with('toast', ['type' => 'success', 'message' => 'User created and verification email sent.']);
    }

    public function edit(User $user): View
    {
        return view('superadmin.users.form', ['user' => $user->load('roles'), 'roles' => Role::orderBy('name')->get()]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $this->userService->update($user, $data);

        return redirect()->route('admin.users.index')->with('toast', ['type' => 'success', 'message' => 'User updated.']);
    }

    public function updateStatus(UpdateUserStatusRequest $request, User $user): RedirectResponse
    {
        $this->userService->updateStatus($user, $request->validated('status'));

        return back()->with('toast', ['type' => 'success', 'message' => 'User status updated.']);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->with('toast', ['type' => 'error', 'message' => 'You cannot delete your own account.']);
        }
        $user->delete();

        return back()->with('toast', ['type' => 'success', 'message' => 'User deleted.']);
    }
}
