<?php

namespace App\Http\Requests;

use App\Models\Employer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = Auth::user();
        $employer = $user ? Employer::where('user_id', $user->id)->first() : null;
        $hasExistingDoc = $employer && $employer->dokumen_legalitas;

        return [
            'id_user'             => ['required', 'exists:users,id'],
            'nama_perusahaan'     => ['required', 'string', 'max:50'],
            'deskripsi_perusahaan'=> ['required', 'string'],
            'id_industri_type'    => ['required'],
            'alamat'              => ['nullable', 'string', 'max:150'],
            'logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'dokumen_legalitas'   => [
                $hasExistingDoc ? 'nullable' : 'required',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'dokumen_legalitas.required' => 'Dokumen legalitas usaha wajib diunggah.',
            'dokumen_legalitas.mimes'    => 'Dokumen harus berupa PDF atau gambar (JPG, PNG, WEBP).',
            'dokumen_legalitas.max'      => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}
