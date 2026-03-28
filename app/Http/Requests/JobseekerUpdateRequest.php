<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobseekerUpdateRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'string', 'max:15'],
            'ttl' => ['required', 'date'],
            'id_jobseeker_type' => ['required'],
            'users_id' => ['required', 'integer', 'exists:users,id'],
            'jobseeker_type_id' => ['required', 'integer', 'exists:jobseeker_types,id'],
        ];
    }
}
