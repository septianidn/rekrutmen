<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelatihanStoreRequest extends FormRequest
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
            'nama_pelatihan' => ['required', 'string', 'max:50'],
            'tahun' => ['required', 'string', 'max:4'],
            'sertifikat' => ['required', 'string', 'max:250'],
            'jobseeker_id' => ['required', 'integer', 'exists:jobseekers,id'],
        ];
    }
}
