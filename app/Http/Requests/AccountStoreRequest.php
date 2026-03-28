<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
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
            'nomor_rekening' => ['required'],
            'nama_bank' => ['required', 'string', 'max:25'],
            'atas_nama' => ['required', 'string', 'max:35'],
        ];
    }
}
