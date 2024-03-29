<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class JurusanRequest extends FormRequest
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
        $jurusan = $this->route('jurusan');

        return [
            'name' => ['required'],
            'slug' => ['required', Rule::unique('jurusans', 'slug')->ignore($jurusan?->id)],
            'kaprodi' => ['required'],
        ];
    }
}
