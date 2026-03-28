<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepUpdateRequest extends FormRequest
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
            'id_job' => ['required'],
            'id_proses' => ['required'],
            'deskripsi' => ['required', 'string'],
            'job_id' => ['required', 'integer', 'exists:jobs,id'],
            'proses_id' => ['required', 'integer', 'exists:proses,id'],
        ];
    }
}
