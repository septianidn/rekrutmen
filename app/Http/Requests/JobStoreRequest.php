<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobStoreRequest extends FormRequest
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
            'employer_id' => ['required'],
            'nama_pekerjaan' => ['required', 'string', 'max:50'],
            'posisi' => ['required', 'string', 'max:50'],
            'requirement' => ['required',],
            'deskripsi_pekerjaan' => ['required',],
            'alamat' => ['required', 'string'],
            'ekspektasi_gaji' => ['required', 'integer'],
            'worktime' => ['required', 'string'],
            'application_deadline' => ['required', 'date'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.proses_id' => ['required', 'integer', 'exists:proses,id'],
            'steps.*.deskripsi' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'steps.required' => 'Tahap seleksi wajib diisi minimal satu tahap.',
            'steps.min' => 'Tahap seleksi wajib diisi minimal satu tahap.',
            'steps.*.proses_id.required' => 'Setiap baris tahap seleksi wajib memilih tahap.',
            'steps.*.proses_id.exists' => 'Tahap seleksi yang dipilih tidak valid.',
        ];
    }
}
