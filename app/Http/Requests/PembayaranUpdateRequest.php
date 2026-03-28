<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranUpdateRequest extends FormRequest
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
            'id_membership' => ['required'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_berakhir' => ['required', 'date'],
            'nomor_rekening' => ['required'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'membership_id' => ['required', 'integer', 'exists:memberships,id'],
            'users_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
