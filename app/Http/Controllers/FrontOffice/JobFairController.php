<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobFair;
use App\Models\JobFairAttendance;
use App\Models\JobFairBoothScan;
use App\Models\JobFairJob;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobFairController extends Controller
{
    // =========================================================
    // EMPLOYER METHODS
    // =========================================================

    public function employerIndex()
    {
        $jobFairs = JobFair::where('status', 'active')->latest()->get();
        $employer = Auth::user()->employer;

        $registeredMap = DB::table('job_fair_job')
            ->where('employer_id', $employer->id)
            ->get()
            ->groupBy('job_fair_id');

        return view('frontoffice.employer.job-fair.index', compact('jobFairs', 'employer', 'registeredMap'));
    }

    public function employerShow(JobFair $jobFair)
    {
        $employer = Auth::user()->employer;
        $jobs = $employer->jobs;

        $registeredJobIds = DB::table('job_fair_job')
            ->where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->pluck('job_id')
            ->toArray();

        $registrations = JobFairJob::with('job')
            ->where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->get();

        return view('frontoffice.employer.job-fair.show', compact('jobFair', 'jobs', 'registeredJobIds', 'registrations'));
    }

    public function employerRegister(Request $request, JobFair $jobFair)
    {
        $request->validate(['job_id' => 'required|exists:job,id']);

        $employer = Auth::user()->employer;
        $job = $employer->jobs()->findOrFail($request->job_id);

        if (!$jobFair->isActive()) {
            return back()->with('error', 'Job fair ini belum dibuka atau sudah berakhir.');
        }

        if (!$jobFair->tanggal_mulai->isFuture()) {
            return back()->with('error', 'Pendaftaran sudah ditutup: job fair telah dimulai.');
        }

        if ($jobFair->jobs()->wherePivot('job_id', $job->id)->exists()) {
            return back()->with('error', 'Lowongan ini sudah terdaftar di job fair ini.');
        }

        if (!$jobFair->hasCapacity()) {
            return back()->with('error', 'Kuota job fair sudah penuh.');
        }

        $jobFair->jobs()->attach($job->id, [
            'employer_id' => $employer->id,
            'status' => 'pending',
        ]);

        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin->id,
                'job_fair_registration',
                'Pendaftaran Job Fair Baru',
                "{$employer->nama_perusahaan} mendaftarkan lowongan {$job->nama_pekerjaan} ke {$jobFair->nama}.",
                route('backoffice.job-fair.show', $jobFair)
            );
        }

        return back()->with('success', 'Lowongan berhasil didaftarkan. Menunggu persetujuan admin.');
    }

    public function employerCancel(JobFair $jobFair, $jobId)
    {
        $employer = Auth::user()->employer;

        $jobFair->jobs()
            ->wherePivot('employer_id', $employer->id)
            ->wherePivot('job_id', $jobId)
            ->detach($jobId);

        return back()->with('success', 'Pendaftaran dibatalkan.');
    }

    public function updateBoothLokasi(Request $request, JobFair $jobFair, $pivotId)
    {
        $request->validate(['lokasi_booth' => 'required|string|max:100']);

        $employer = Auth::user()->employer;

        $pivot = JobFairJob::where('id', $pivotId)
            ->where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        if ($jobFair->tanggal_mulai->isPast()) {
            return back()->with('error', 'Lokasi booth tidak dapat diubah setelah job fair dimulai.');
        }

        $kode_booth = $pivot->kode_booth ?? 'BOOTH-' . strtoupper(Str::random(5));

        $pivot->update([
            'lokasi_booth' => $request->lokasi_booth,
            'kode_booth'   => $kode_booth,
        ]);

        return back()->with('success', 'Lokasi booth diperbarui.');
    }

    public function employerQueue(JobFair $jobFair)
    {
        $employer = Auth::user()->employer;

        $boothIds = JobFairJob::where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->where('status', 'approved')
            ->pluck('id');

        $scans = JobFairBoothScan::with(['jobseeker.user', 'job', 'jobFairJob'])
            ->whereIn('job_fair_job_id', $boothIds)
            ->orderBy('created_at')
            ->get()
            ->groupBy('status');

        $this->expireStaleEntries($jobFair, $scans->flatten());

        // Map (jobseeker_id, job_id) → application_id so the queue view can
        // link "Selesai" scans straight to the regular application pipeline.
        $selesaiScans = $scans['selesai'] ?? collect();
        $applicationMap = [];
        if ($selesaiScans->isNotEmpty()) {
            $applicationMap = Application::whereIn('jobseeker_id', $selesaiScans->pluck('jobseeker_id'))
                ->whereIn('job_id', $selesaiScans->pluck('job_id'))
                ->get(['id', 'jobseeker_id', 'job_id'])
                ->mapWithKeys(fn ($a) => [$a->jobseeker_id . '-' . $a->job_id => $a->id])
                ->toArray();
        }

        return view('frontoffice.employer.job-fair.queue', compact('jobFair', 'scans', 'applicationMap'));
    }

    public function employerScanForm(JobFair $jobFair)
    {
        return view('frontoffice.employer.job-fair.scan', compact('jobFair'));
    }

    public function employerScan(Request $request, JobFair $jobFair)
    {
        $request->validate(['kode_qr' => 'required|string']);

        $employer = Auth::user()->employer;

        $attendance = JobFairAttendance::where('kode_qr', $request->kode_qr)
            ->where('job_fair_id', $jobFair->id)
            ->firstOrFail();

        $boothIds = JobFairJob::where('job_fair_id', $jobFair->id)
            ->where('employer_id', $employer->id)
            ->pluck('id');

        $scan = JobFairBoothScan::whereIn('job_fair_job_id', $boothIds)
            ->where('jobseeker_id', $attendance->jobseeker_id)
            ->whereIn('status', ['dipanggil', 'sedang_diproses'])
            ->first();

        if (!$scan) {
            return back()->with('error', 'Tidak ada antrian aktif untuk kode QR ini.');
        }

        $scan->update(['status' => 'selesai', 'selesai_at' => now()]);

        Application::firstOrCreate(
            ['jobseeker_id' => $scan->jobseeker_id, 'job_id' => $scan->job_id],
            ['tanggal_apply' => today(), 'status' => 'pending']
        );

        NotificationService::send(
            $attendance->jobseeker->user_id,
            'job_fair_selesai',
            'Interaksi Job Fair Selesai',
            "Interaksi Anda dengan {$employer->nama_perusahaan} telah selesai. Lamaran Anda telah dicatat.",
            route('jobseeker.job-fair.show', $jobFair)
        );

        return back()->with('success', 'Interaksi selesai dan lamaran telah dicatat.');
    }

    public function employerCall(Request $request, JobFairBoothScan $scan)
    {
        $employer = Auth::user()->employer;

        $pivot = JobFairJob::where('id', $scan->job_fair_job_id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        if ($scan->status !== 'menunggu') {
            return back()->with('error', 'Jobseeker ini tidak dalam status menunggu.');
        }

        $scan->update(['status' => 'dipanggil', 'dipanggil_at' => now()]);

        NotificationService::send(
            $scan->jobseeker->user_id,
            'job_fair_called',
            'Giliran Anda Dipanggil',
            "Giliran Anda di booth {$employer->nama_perusahaan}" .
                ($pivot->lokasi_booth ? " — {$pivot->lokasi_booth}" : '') . ". Segera hadir.",
            route('jobseeker.job-fair.qr', $scan->job_fair_id)
        );

        return back()->with('success', 'Jobseeker berhasil dipanggil.');
    }

    public function employerMarkAbsent(Request $request, JobFairBoothScan $scan)
    {
        $employer = Auth::user()->employer;

        JobFairJob::where('id', $scan->job_fair_job_id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        if (!$scan->canMarkAbsent()) {
            return back()->with('error', 'Cooldown belum selesai.');
        }

        $scan->update(['status' => 'tidak_hadir', 'tidak_hadir_at' => now()]);

        NotificationService::send(
            $scan->jobseeker->user_id,
            'job_fair_absent',
            'Anda Ditandai Tidak Hadir',
            "Anda ditandai tidak hadir di booth {$employer->nama_perusahaan}.",
            route('jobseeker.job-fair.show', $scan->job_fair_id)
        );

        return back()->with('success', 'Jobseeker ditandai tidak hadir.');
    }

    public function employerReactivate(Request $request, JobFairBoothScan $scan)
    {
        $employer = Auth::user()->employer;

        JobFairJob::where('id', $scan->job_fair_job_id)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        if ($scan->status !== 'tidak_hadir') {
            return back()->with('error', 'Hanya entri tidak hadir yang dapat diaktifkan kembali.');
        }

        $scan->update(['status' => 'menunggu', 'tidak_hadir_at' => null]);

        return back()->with('success', 'Antrian jobseeker diaktifkan kembali.');
    }

    // =========================================================
    // JOBSEEKER METHODS
    // =========================================================

    public function studentIndex()
    {
        $jobFairs = JobFair::where('status', 'active')->latest()->get();
        return view('frontoffice.jobseeker.job-fair.index', compact('jobFairs'));
    }

    public function studentShow(JobFair $jobFair)
    {
        $jobs = $jobFair->jobs()
            ->wherePivot('status', 'approved')
            ->where('job.status', 'active')
            ->with('employer')
            ->get();

        $jobseeker = Auth::user()->jobseeker;
        $appliedJobIds = $jobseeker
            ? $jobseeker->applications()->pluck('job_id')->toArray()
            : [];

        $attendance = $jobseeker
            ? JobFairAttendance::where('job_fair_id', $jobFair->id)
                ->where('jobseeker_id', $jobseeker->id)
                ->first()
            : null;

        return view('frontoffice.jobseeker.job-fair.show', compact('jobFair', 'jobs', 'appliedJobIds', 'attendance'));
    }

    public function jobseekerRegister(Request $request, JobFair $jobFair)
    {
        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker) {
            return back()->with('error', 'Anda harus melengkapi profil terlebih dahulu sebelum mendaftar job fair.')
                         ->with('redirect_profile', route('jobseeker.profile.edit'));
        }

        if (!$jobFair->isActive()) {
            return back()->with('error', 'Job fair ini tidak aktif.');
        }

        $exists = JobFairAttendance::where('job_fair_id', $jobFair->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->exists();

        if ($exists) {
            return redirect()->route('jobseeker.job-fair.qr', $jobFair)
                ->with('info', 'Anda sudah terdaftar di job fair ini.');
        }

        $kode_qr = 'ATT-' . strtoupper(Str::random(5));
        while (JobFairAttendance::where('kode_qr', $kode_qr)->exists()) {
            $kode_qr = 'ATT-' . strtoupper(Str::random(5));
        }

        JobFairAttendance::create([
            'job_fair_id'  => $jobFair->id,
            'jobseeker_id' => $jobseeker->id,
            'kode_qr'      => $kode_qr,
        ]);

        return redirect()->route('jobseeker.job-fair.qr', $jobFair)
            ->with('success', 'Berhasil mendaftar. Berikut QR Code Anda.');
    }

    public function jobseekerQr(JobFair $jobFair)
    {
        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker) {
            return redirect()->route('jobseeker.profile.edit')
                ->with('error', 'Lengkapi profil Anda terlebih dahulu untuk mengakses QR job fair.');
        }

        $attendance = JobFairAttendance::where('job_fair_id', $jobFair->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->firstOrFail();

        $myScans = JobFairBoothScan::with(['job', 'jobFairJob.employer'])
            ->where('job_fair_id', $jobFair->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->get();

        // Map job_id → application_id for selesai scans so the jobseeker can
        // jump from the booth result to the regular "my application" progress.
        $applicationMap = [];
        $selesaiScans = $myScans->where('status', 'selesai');
        if ($selesaiScans->isNotEmpty()) {
            $applicationMap = Application::where('jobseeker_id', $jobseeker->id)
                ->whereIn('job_id', $selesaiScans->pluck('job_id'))
                ->pluck('id', 'job_id')
                ->toArray();
        }

        return view('frontoffice.jobseeker.job-fair.qr', compact('jobFair', 'attendance', 'myScans', 'applicationMap'));
    }

    public function jobseekerCheckin(Request $request)
    {
        $request->validate(['kode_fair' => 'required|string']);

        $jobFair = JobFair::findOrFail($request->kode_fair);
        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker) {
            return back()->with('error', 'Anda harus melengkapi profil terlebih dahulu.')
                         ->with('redirect_profile', route('jobseeker.profile.edit'));
        }

        $attendance = JobFairAttendance::where('job_fair_id', $jobFair->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->firstOrFail();

        if ($attendance->isCheckedIn()) {
            return redirect()->route('jobseeker.job-fair.qr', $jobFair)
                ->with('info', 'Anda sudah check-in sebelumnya.');
        }

        $attendance->update(['checked_in_at' => now()]);

        return redirect()->route('jobseeker.job-fair.qr', $jobFair)
            ->with('success', 'Check-in berhasil. Selamat datang!');
    }

    public function boothScan(Request $request)
    {
        $request->validate([
            'kode_booth' => 'required|string',
            'job_id'     => 'required|exists:job,id',
        ]);

        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker) {
            return back()->with('error', 'Anda harus melengkapi profil terlebih dahulu.')
                         ->with('redirect_profile', route('jobseeker.profile.edit'));
        }

        $pivot = JobFairJob::where('kode_booth', $request->kode_booth)
            ->where('status', 'approved')
            ->firstOrFail();

        $jobFair = $pivot->jobFair;

        $attendance = JobFairAttendance::where('job_fair_id', $jobFair->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->first();

        if (!$attendance || !$attendance->isCheckedIn()) {
            return back()->with('error', 'Anda harus check-in di pintu masuk terlebih dahulu.');
        }

        if (!$jobFair->isActive() || $jobFair->tanggal_mulai->isFuture() || $jobFair->tanggal_selesai->isPast()) {
            return back()->with('error', 'Job fair tidak sedang berlangsung.');
        }

        $jobInBooth = JobFairJob::where('id', $pivot->id)
            ->where('job_id', $request->job_id)
            ->exists();

        if (!$jobInBooth) {
            return back()->with('error', 'Posisi tidak tersedia di booth ini.');
        }

        $duplicate = JobFairBoothScan::where('job_fair_job_id', $pivot->id)
            ->where('jobseeker_id', $jobseeker->id)
            ->whereNotIn('status', ['selesai', 'tidak_hadir'])
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'Anda sudah memiliki antrian aktif di booth ini.');
        }

        JobFairBoothScan::create([
            'job_fair_id'     => $jobFair->id,
            'job_fair_job_id' => $pivot->id,
            'jobseeker_id'    => $jobseeker->id,
            'job_id'          => $request->job_id,
            'status'          => 'menunggu',
        ]);

        return redirect()->route('jobseeker.job-fair.qr', $jobFair)
            ->with('success', 'Berhasil masuk antrian booth. Tunggu dipanggil.');
    }

    public function boothJobs(Request $request)
    {
        $pivot = JobFairJob::where('kode_booth', $request->kode_booth)
            ->where('status', 'approved')
            ->first();

        if (!$pivot) {
            return response()->json([]);
        }

        return response()->json([
            ['id' => $pivot->job_id, 'nama_pekerjaan' => $pivot->job->nama_pekerjaan],
        ]);
    }

    public function jobseekerAck(Request $request, JobFairBoothScan $scan)
    {
        $jobseeker = Auth::user()->jobseeker;

        if (!$jobseeker || $scan->jobseeker_id !== $jobseeker->id) {
            abort(403);
        }

        if ($scan->status !== 'dipanggil') {
            return back()->with('error', 'Status tidak valid untuk konfirmasi ini.');
        }

        $scan->update(['status' => 'sedang_diproses']);

        $pivot = $scan->jobFairJob;
        NotificationService::send(
            $pivot->employer->user_id,
            'job_fair_ack',
            'Jobseeker Sedang Menuju Booth',
            "{$jobseeker->first_name} {$jobseeker->last_name} sedang menuju booth Anda.",
            route('employer.job-fair.queue', $scan->job_fair_id)
        );

        return back()->with('success', 'Konfirmasi dikirim. Segera menuju booth.');
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function expireStaleEntries(JobFair $jobFair, $scans): void
    {
        if (!$jobFair->tanggal_selesai->isPast()) {
            return;
        }

        $staleIds = $scans->whereIn('status', ['menunggu', 'dipanggil'])->pluck('id');

        if ($staleIds->isEmpty()) {
            return;
        }

        JobFairBoothScan::whereIn('id', $staleIds)->update(['status' => 'tidak_hadir']);

        foreach ($scans->whereIn('id', $staleIds) as $scan) {
            NotificationService::send(
                $scan->jobseeker->user_id,
                'job_fair_closed',
                'Job Fair Telah Berakhir',
                "Job fair \"{$jobFair->nama}\" telah berakhir. Interaksi Anda belum selesai.",
                route('jobseeker.job-fair.index')
            );
        }
    }
}
