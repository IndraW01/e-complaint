<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class PengaduanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('mahasiswa')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'token' => ['required', Rule::exists('tikets', 'token')],
            'title' => ['required'],
            'deskripsi' => ['required'],
            'fotos' => ['required', 'array'],
            'fotos.*' => ['required', File::types(['jpg', 'png', 'jpeg', 'svg',])
                ->max(2048)],
            'kategoris' => ['required', 'array'],
            'kategoris.*' => ['required', Rule::exists('kategoris', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'fotos.*.max' => 'The file :position field must not be greater than 2048 kilobytes.',
            'fotos.*.mimes' => 'The file :position field must be a file of type: jpg, png, jpeg, svg.',
        ];
    }
}
