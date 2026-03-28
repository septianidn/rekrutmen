<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressUpdateRequest extends FormRequest
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
            'id_application' => ['required'],
            'id_step' => ['required'],
            'catatan' => ['required', 'string'],
            'lulus' => ['required'],
            'application_id' => ['required', 'integer', 'exists:applications,id'],
            'step_id' => ['required', 'integer', 'exists:steps,id'],
        ];
    }
}
