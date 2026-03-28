<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndustriTypeStoreRequest extends FormRequest
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
            'nama_industri' => ['required', 'string', 'max:50'],
            'employer_id' => ['required', 'integer', 'exists:employers,id'],
        ];
    }
}
