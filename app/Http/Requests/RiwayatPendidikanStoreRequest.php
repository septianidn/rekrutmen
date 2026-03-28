<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiwayatPendidikanStoreRequest extends FormRequest
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
            'jenjang' => ['required', 'string', 'max:5'],
            'instansi' => ['required', 'string', 'max:50'],
            'indeks_nilai' => ['nullable', 'string', 'max:4'],
            'keterangan' => ['required', 'string'],
            'jobseeker_id' => ['required', 'integer', 'exists:jobseekers,id'],
        ];
    }
}
