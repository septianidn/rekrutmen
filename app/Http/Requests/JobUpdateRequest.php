<?php

namespace App\Http\Requests;

use App\Models\Progress;
use Illuminate\Foundation\Http\FormRequest;

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
