<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('master.user.update')) {
            return [
                'role_id' => ['required', Rule::exists('roles', 'id')]
            ];
        }

        $user = $this->route('user');

        return [
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => ['required', 'min:3', 'alpha_num'],
            'jenis_kelamin' => ['required', Rule::in(['laki', 'perempuan'])]
        ];
    }
}
