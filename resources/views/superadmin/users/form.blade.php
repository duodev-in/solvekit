@extends('superadmin.layout.app')

@section('title', ($user->exists ? 'Edit user' : 'Add user').' | SolveKit')

@section('content')
    <div class="mb-6"><flux:button href="{{ route('admin.users.index') }}" variant="outline">Back to users</flux:button><h1 class="mt-4 text-3xl font-semibold">{{ $user->exists ? 'Edit user' : 'Add user' }}</h1></div>
    <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="max-w-2xl space-y-5 rounded-sm border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        @csrf @if($user->exists) @method('PUT') @endif
        <flux:input name="name" label="Name" value="{{ old('name', $user->name) }}" placeholder="Full name" required />
        <flux:input name="email" type="email" label="Email" value="{{ old('email', $user->email) }}" placeholder="you@example.com" required />
        <flux:input name="password" type="password" label="Password" placeholder="Minimum 8 characters" :required="!$user->exists" />
        <flux:input name="password_confirmation" type="password" label="Confirm password" placeholder="Repeat the password" :required="!$user->exists" />
        <flux:select name="status" label="Status" required>@foreach(config('superadmin.statuses') as $status)<option value="{{ $status }}" @selected(old('status', $user->status ?: 'active') === $status)>{{ ucfirst($status) }}</option>@endforeach</flux:select>
        <fieldset><legend class="mb-2 text-sm font-medium">Roles</legend><div class="grid gap-2 sm:grid-cols-2">@foreach($roles as $role)<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, old('roles', $user->roles?->pluck('name')->all() ?? []), true))> {{ ucfirst($role->name) }}</label>@endforeach</div></fieldset>
        @if($errors->any()) <flux:callout variant="danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></flux:callout> @endif
        <div class="flex justify-end gap-2"><flux:button href="{{ route('admin.users.index') }}" variant="ghost">Cancel</flux:button><flux:button type="submit" variant="primary">Save user</flux:button></div>
    </form>
@endsection
