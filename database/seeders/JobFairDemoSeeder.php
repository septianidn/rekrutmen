<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\EmployerContract;
use App\Models\IndustriType;
use App\Models\Job;
use App\Models\JobFair;
use App\Models\JobFairAttendance;
use App\Models\Jobseeker;
use App\Models\JobseekerType;
use App\Models\Proses;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Builds an "event-in-progress" Job Fair so the sidang demo can show
 * jobseeker check-in, booth scan, and queue without waiting for a real
 * fair date. The employer is pre-verified and on an active contract so
 * payment/membership is bypassed.
 *
 * Login credentials (password = "password" for all):
 *   - Admin     : admin@example.com           (from UserTableSeeder)
 *   - Employer  : demo.employer@karirsukses.test
 *   - Jobseeker : demo.jobseeker@pusatkarir.test
 */
class JobFairDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $admin = User::where('user_type', 'admin')->firstOrFail();

            $industri = IndustriType::firstOrCreate(['nama_industri' => 'IT']);
            $jobseekerType = JobseekerType::firstOrCreate(['jobseekerType' => 'Unand']);
            $proses = Proses::firstOrCreate(['nama_proses' => 'Tes Administrasi']);

            $employer = $this->seedEmployer($admin, $industri);
            $this->seedContract($employer, $admin);
            $job = $this->seedJob($employer, $proses);
            $fair = $this->seedJobFair();
            $this->attachJobToFair($fair, $job, $employer);
            $jobseeker = $this->seedJobseeker($jobseekerType);
            $this->seedAttendance($fair, $jobseeker);
        });

        $this->command->info('JobFairDemoSeeder selesai. Login:');
        $this->command->line('  Employer  : demo.employer@karirsukses.test / password');
        $this->command->line('  Jobseeker : demo.jobseeker@pusatkarir.test / password');
    }

    private function seedEmployer(User $admin, IndustriType $industri): Employer
    {
        $user = User::updateOrCreate(
            ['email' => 'demo.employer@karirsukses.test'],
            [
                'first_name'        => 'Demo',
                'last_name'         => 'Employer',
                'password'          => bcrypt('password'),
                'street_addr'       => 'Jl. Demo No. 1, Padang',
                'phone_number'      => '081234567890',
                'email_verified_at' => now(),
                'user_type'         => 'employer',
                'status'            => 'active',
            ]
        );
        if (!$user->hasRole('employer')) {
            $user->assignRole('employer');
        }

        return Employer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_perusahaan'      => 'PT Karir Sukses Mandiri',
                'deskripsi_perusahaan' => 'Perusahaan demo untuk sidang Tugas Akhir.',
                'industriType_id'      => $industri->id,
                'alamat_perusahaan'    => 'Jl. Khatib Sulaiman No. 99, Padang',
                'telp_perusahaan'      => '07517123456',
                'website'              => 'https://karirsukses.test',
                'verification_status'  => 'approved',
                'verified_at'          => now()->subDays(30),
                'verified_by'          => $admin->id,
                'verification_note'    => 'Disetujui untuk keperluan demo sidang.',
            ]
        );
    }

    private function seedContract(Employer $employer, User $admin): void
    {
        EmployerContract::updateOrCreate(
            ['employer_id' => $employer->id, 'status' => 'active'],
            [
                'tanggal_mulai'    => now()->subMonths(1),
                'tanggal_berakhir' => now()->addYear(),
                'mou_file'         => 'contracts/demo-mou.pdf',
                'catatan'          => 'Kontrak demo — memberikan akses posting lowongan tanpa membership.',
                'created_by'       => $admin->id,
            ]
        );
    }

    private function seedJob(Employer $employer, Proses $proses): Job
    {
        $job = Job::updateOrCreate(
            ['employer_id' => $employer->id, 'nama_pekerjaan' => 'Software Engineer'],
            [
                'posisi'               => 'Junior Software Engineer',
                'requirement'          => '<p>Menguasai PHP/Laravel atau JavaScript. Fresh graduate dipersilakan.</p>',
                'deskripsi_pekerjaan'  => '<p>Mengembangkan aplikasi web internal perusahaan.</p>',
                'alamat'               => 'Padang',
                'ekspektasi_gaji'      => 5000000,
                'worktime'             => 'Full Time',
                'application_deadline' => now()->addMonth(),
                'status'               => 'active',
            ]
        );

        Step::firstOrCreate(
            ['job_id' => $job->id, 'urutan' => 1],
            ['proses_id' => $proses->id, 'deskripsi' => 'Verifikasi dokumen administrasi pelamar.']
        );

        return $job;
    }

    private function seedJobFair(): JobFair
    {
        return JobFair::updateOrCreate(
            ['nama' => 'Job Fair Pusat Karir Sidang 2026'],
            [
                'deskripsi'       => 'Job fair demo untuk sidang Tugas Akhir Pusat Karir.',
                'lokasi'          => 'Aula Convention Hall, Kampus Limau Manis',
                'tanggal_mulai'   => now()->subDays(1)->toDateString(),
                'tanggal_selesai' => now()->addDays(1)->toDateString(),
                'status'          => 'active',
                'kuota'           => 20,
            ]
        );
    }

    private function attachJobToFair(JobFair $fair, Job $job, Employer $employer): void
    {
        $pivot = DB::table('job_fair_job')
            ->where('job_fair_id', $fair->id)
            ->where('job_id', $job->id)
            ->first();

        $payload = [
            'employer_id'  => $employer->id,
            'status'       => 'approved',
            'lokasi_booth' => 'Booth A1 — Dekat Pintu Masuk',
            'kode_booth'   => 'BOOTH-DEMO1',
        ];

        if ($pivot) {
            DB::table('job_fair_job')->where('id', $pivot->id)->update($payload + ['updated_at' => now()]);
        } else {
            $fair->jobs()->attach($job->id, $payload);
        }
    }

    private function seedJobseeker(JobseekerType $type): Jobseeker
    {
        $user = User::updateOrCreate(
            ['email' => 'demo.jobseeker@pusatkarir.test'],
            [
                'first_name'        => 'Demo',
                'last_name'         => 'Pelamar',
                'password'          => bcrypt('password'),
                'street_addr'       => 'Jl. Pelamar No. 2, Padang',
                'phone_number'      => '081298765432',
                'email_verified_at' => now(),
                'user_type'         => 'mahasiswa',
                'status'            => 'active',
            ]
        );
        if (!$user->hasRole('mahasiswa')) {
            $user->assignRole('mahasiswa');
        }

        return Jobseeker::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name'        => 'Demo',
                'last_name'         => 'Pelamar',
                'jenis_kelamin'     => 'Laki-laki',
                'ttl'               => '2002-01-01',
                'jobseeker_type_id' => $type->id,
            ]
        );
    }

    private function seedAttendance(JobFair $fair, Jobseeker $jobseeker): void
    {
        JobFairAttendance::updateOrCreate(
            ['job_fair_id' => $fair->id, 'jobseeker_id' => $jobseeker->id],
            [
                'kode_qr'       => 'ATT-DEMO1',
                'checked_in_at' => now()->subHours(2),
            ]
        );
    }
}
