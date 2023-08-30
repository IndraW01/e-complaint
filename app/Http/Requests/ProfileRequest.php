<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'password' => ['required', 'min:6'],
            'foto' => ['required', File::types(['jpg', 'png', 'jpeg', 'svg',])
                ->max(2048)],
            'email' => [Rule::excludeIf(!Auth::guard('mahasiswa')->check()), 'required', 'email', Rule::unique('mahasiswas', 'email')->ignore(Auth::id())],
        ];
    }
}
