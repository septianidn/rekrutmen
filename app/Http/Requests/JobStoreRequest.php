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

        ];
    }
}
