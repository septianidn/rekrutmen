<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekomendasiUpdateRequest extends FormRequest
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
            'id_jobseeker' => ['required'],
            'nama_perekomendasi' => ['required', 'string', 'max:30'],
            'posisi' => ['required', 'string', 'max:20'],
            'no_hp' => ['required', 'string', 'max:14'],
            'alamat' => ['required', 'string', 'max:50'],
            'jobseeker_id' => ['required', 'integer', 'exists:jobseekers,id'],
        ];
    }
}
