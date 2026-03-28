<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', 'string'],
            'street_addr' => ['nullable', 'string'],
            'email_verified_at' => ['nullable'],
            'user_type' => ['required', 'string'],
            'password' => ['required', 'password'],
            'status' => ['required', 'in:pending,active,blocked,inactive'],
            'profile_image' => ['nullable', 'string'],
            'remember_token' => ['nullable', 'string', 'max:100'],
        ];
    }
}
