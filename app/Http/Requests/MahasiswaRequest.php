<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MahasiswaRequest extends FormRequest
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
        $mahasiswa = $this->route('mahasiswa');

        return [
            'name' => ['required'],
            'nim' => ['required', 'integer', Rule::unique('mahasiswas')->ignore($mahasiswa?->id)],
            'jurusan_id' => ['required', Rule::exists('jurusans', 'id')],
            'angkatan' => ['required'],
            'foto' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
        ];
    }
}
