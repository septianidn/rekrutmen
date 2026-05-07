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
            'id_industri_type'    => ['required', 'exists:industri_type,id'],
            'alamat'              => ['required', 'string', 'max:150'],
            'telp'                => ['required', 'string', 'max:20'],
            'website'             => ['nullable', 'string', 'max:255'],
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
            'nama_perusahaan.required'      => 'Nama perusahaan wajib diisi.',
            'deskripsi_perusahaan.required' => 'Deskripsi perusahaan wajib diisi.',
            'id_industri_type.required'     => 'Tipe industri wajib dipilih.',
            'id_industri_type.exists'       => 'Tipe industri yang dipilih tidak valid.',
            'alamat.required'               => 'Alamat perusahaan wajib diisi.',
            'telp.required'                 => 'Nomor telepon perusahaan wajib diisi.',
            'dokumen_legalitas.required'    => 'Dokumen legalitas usaha wajib diunggah.',
            'dokumen_legalitas.mimes'       => 'Dokumen harus berupa PDF atau gambar (JPG, PNG, WEBP).',
            'dokumen_legalitas.max'         => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}
