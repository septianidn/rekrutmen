<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisasiUpdateRequest extends FormRequest
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
            'nama_organisasi' => ['required', 'string', 'max:30'],
            'jabatan' => ['required', 'string', 'max:20'],
            'keterangan' => ['required', 'string'],
            'jobseeker_id' => ['required', 'integer', 'exists:jobseekers,id'],
        ];
    }
}
