<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_user' => ['required'],
            'nama_perusahaan' => ['required', 'string', 'max:50'],
            'deskripsi_perusahaan' => ['required', 'string'],
            'id_industri_type' => ['required'],
            'alamat' => ['nullable', 'string', 'max:150'],
            'users_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
