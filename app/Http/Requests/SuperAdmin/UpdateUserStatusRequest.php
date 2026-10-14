<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('manage users') ?? false;
    }

    public function rules(): array
    {
        return ['status' => ['required', Rule::in(config('superadmin.statuses'))]];
    }
}
