<?php

namespace App\Http\Requests;

use App\Models\Progress;
use App\Models\Proses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class JobUpdateRequest extends FormRequest
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
     *
     * `steps` is required on normal edits, but relaxed to `nullable` when
     * the job is locked (any applicant already has pipeline progress) —
     * in that case `JobController::syncSteps` ignores submitted steps
     * anyway, so forcing them through would only produce confusing errors.
     */
    public function rules(): array
    {
        $job = $this->route('job');
        $locked = $job && Progress::whereHas('step', fn ($q) => $q->where('job_id', $job->id))->exists();

        $stepsRules = $locked
            ? ['nullable', 'array']
            : ['required', 'array', 'min:1'];

        $stepsItemRules = $locked
            ? ['nullable', 'integer', 'exists:proses,id']
            : ['required', 'integer', 'exists:proses,id'];

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
            'steps' => $stepsRules,
            'steps.*.proses_id' => $stepsItemRules,
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
     * mandatory. Locked jobs submit disabled (empty) step fields, so the
     * check naturally no-ops there.
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
