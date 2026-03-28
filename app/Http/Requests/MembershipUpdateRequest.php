<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipUpdateRequest extends FormRequest
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
            'nama_membership' => ['required', 'string', 'max:50'],
            'durasi' => ['required', 'string', 'max:25'],
            'harga' => ['required', 'string', 'max:50'],
        ];
    }
}
