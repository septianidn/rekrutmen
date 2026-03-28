<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestasiStoreRequest extends FormRequest
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
            'nama_penghargaan' => ['required', 'string', 'max:40'],
            'tahun' => ['required', 'string', 'max:4'],
            'dokumen' => ['required', 'string', 'max:250'],
            'jobseeker_id' => ['required', 'integer', 'exists:jobseekers,id'],
        ];
    }
}
