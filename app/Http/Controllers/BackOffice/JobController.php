<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = trim((string) $request->input('q', ''));

        $query = Job::with(['employer', 'posisi'])->withCount('applications');

        match ($filter) {
            'active' => $query->where('status', 'active'),
            'closed' => $query->where('status', 'closed'),
            'trashed' => $query->onlyTrashed(),
            default => $query->withTrashed(),
        };

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pekerjaan', 'like', "%{$search}%")
                  ->orWhereHas('posisi', fn ($p) => $p->where('nama_posisi', 'like', "%{$search}%"))
                  ->orWhereHas('employer', fn ($e) => $e->where('nama_perusahaan', 'like', "%{$search}%"));
            });
        }

        $jobs = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => Job::withTrashed()->count(),
            'active' => Job::where('status', 'active')->count(),
            'closed' => Job::where('status', 'closed')->count(),
            'trashed' => Job::onlyTrashed()->count(),
        ];

        return view('backoffice.job.index', compact('jobs', 'filter', 'search', 'counts'));
    }

    public function show($id)
    {
        $job = Job::withTrashed()
            ->with(['employer', 'posisi', 'steps.proses', 'applications.jobseeker'])
            ->findOrFail($id);

        return view('backoffice.job.show', compact('job'));
    }

    public function destroy($id)
    {
        $job = Job::withTrashed()->findOrFail($id);

        $pendingCount = $job->applications()->where('status', 'pending')->count();
        if ($pendingCount > 0) {
            return back()
                ->with('error', "Tidak dapat menghapus lowongan: masih ada {$pendingCount} lamaran yang sedang diproses. Selesaikan atau tolak lamaran tersebut terlebih dahulu.");
        }

        $job->delete();

        return back()->with('success', 'Lowongan berhasil dihapus. Riwayat lamaran tetap tersimpan.');
    }

    public function restore($id)
    {
        $job = Job::onlyTrashed()->findOrFail($id);
        $job->restore();

        return back()->with('success', 'Lowongan berhasil dipulihkan.');
    }
}
