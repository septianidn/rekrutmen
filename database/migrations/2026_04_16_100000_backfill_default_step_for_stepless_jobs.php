<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Validation now requires every job to have at least one tahap seleksi.
        // Seed a single default step ("Tes Administrasi", falling back to the
        // lowest-id proses) for any job that has none, so legacy jobs remain
        // editable by their employers after this release.
        $defaultProsesId = DB::table('proses')->where('nama_proses', 'Tes Administrasi')->value('id')
            ?? DB::table('proses')->orderBy('id')->value('id');

        if ($defaultProsesId === null) {
            return;
        }

        $steplessJobIds = DB::table('job')
            ->leftJoin('step', 'step.job_id', '=', 'job.id')
            ->whereNull('job.deleted_at')
            ->whereNull('step.id')
            ->pluck('job.id')
            ->unique();

        $now = now();
        foreach ($steplessJobIds as $jobId) {
            DB::table('step')->insert([
                'job_id' => $jobId,
                'proses_id' => $defaultProsesId,
                'urutan' => 1,
                'deskripsi' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Not reversible — backfilled rows are indistinguishable from
        // steps the employer added themselves afterwards.
    }
};
