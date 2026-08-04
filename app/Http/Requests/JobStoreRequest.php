<?php

namespace App\Http\Requests;

use App\Models\Proses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'steps.*.nama_custom' => ['nullable', 'string', 'max:100'],
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

    /**
     * When a step uses the "Lainnya" stage, the custom stage name is
     * mandatory — otherwise the step would have no meaningful label.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $lainnyaId = Proses::where('nama_proses', 'Lainnya')->value('id');
            if (!$lainnyaId) {
                return;
            }

            foreach ((array) $this->input('steps', []) as $i => $step) {
                if ((int) ($step['proses_id'] ?? 0) === (int) $lainnyaId
                    && trim((string) ($step['nama_custom'] ?? '')) === '') {
                    $validator->errors()->add(
                        "steps.$i.nama_custom",
                        'Nama tahap wajib diisi saat memilih tahap "Lainnya".'
                    );
                }
            }
        });
    }
}
