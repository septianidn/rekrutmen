<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\EmployerContract;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerContractController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', EmployerContract::STATUS_ACTIVE);
        $allowed = [
            EmployerContract::STATUS_ACTIVE,
            EmployerContract::STATUS_EXPIRED,
            EmployerContract::STATUS_REVOKED,
        ];
        if (!in_array($status, $allowed, true)) {
            $status = EmployerContract::STATUS_ACTIVE;
        }

        $contracts = EmployerContract::with(['employer.user', 'creator'])
            ->where('status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            EmployerContract::STATUS_ACTIVE  => EmployerContract::where('status', EmployerContract::STATUS_ACTIVE)->count(),
            EmployerContract::STATUS_EXPIRED => EmployerContract::where('status', EmployerContract::STATUS_EXPIRED)->count(),
            EmployerContract::STATUS_REVOKED => EmployerContract::where('status', EmployerContract::STATUS_REVOKED)->count(),
        ];

        return view('backoffice.employer-contract.index', compact('contracts', 'status', 'counts'));
    }

    public function create()
    {
        $employers = Employer::where('verification_status', 'approved')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('backoffice.employer-contract.form', [
            'contract' => new EmployerContract(),
            'employers' => $employers,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employer_id'      => 'required|exists:employer,id',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'mou_file'         => 'required|file|mimes:pdf|max:10240',
            'can_post_job'     => 'nullable|boolean',
            'can_post_article' => 'nullable|boolean',
            'catatan'          => 'nullable|string|max:1000',
        ]);

        $canPostJob = $request->boolean('can_post_job');
        $canPostArticle = $request->boolean('can_post_article');
        if (!$canPostJob && !$canPostArticle) {
            return back()->withInput()
                ->withErrors(['can_post_job' => 'Pilih minimal satu hak kontrak: posting lowongan atau artikel.']);
        }

        $path = $request->file('mou_file')->store('mou-files');

        $contract = EmployerContract::create([
            'employer_id'      => $data['employer_id'],
            'tanggal_mulai'    => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'mou_file'         => $path,
            'can_post_job'     => $canPostJob,
            'can_post_article' => $canPostArticle,
            'catatan'          => $data['catatan'] ?? null,
            'status'           => EmployerContract::STATUS_ACTIVE,
            'created_by'       => Auth::id(),
        ]);

        $contract->load('employer');

        NotificationService::send(
            $contract->employer->user_id,
            'employer_contract_created',
            'Status Mitra Kerja Aktif',
            'Akun perusahaan Anda terdaftar sebagai mitra kerja sampai '
                . $contract->tanggal_berakhir->format('d M Y')
                . '. Anda dapat memposting ' . $this->scopeLabel($contract)
                . ' tanpa membayar membership.',
            route('employer.membership.index'),
        );

        return redirect()->route('backoffice.employer-contract.index')
            ->with('success', 'Kontrak mitra kerja berhasil dibuat.');
    }

    public function show(EmployerContract $contract)
    {
        $contract->load(['employer.user', 'creator']);
        return view('backoffice.employer-contract.show', compact('contract'));
    }

    public function edit(EmployerContract $contract)
    {
        $employers = Employer::where('verification_status', 'approved')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('backoffice.employer-contract.form', [
            'contract' => $contract,
            'employers' => $employers,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, EmployerContract $contract)
    {
        $data = $request->validate([
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'mou_file'         => 'nullable|file|mimes:pdf|max:10240',
            'can_post_job'     => 'nullable|boolean',
            'can_post_article' => 'nullable|boolean',
            'catatan'          => 'nullable|string|max:1000',
            'status'           => 'required|in:active,expired,revoked',
        ]);

        $canPostJob = $request->boolean('can_post_job');
        $canPostArticle = $request->boolean('can_post_article');
        if (!$canPostJob && !$canPostArticle) {
            return back()->withInput()
                ->withErrors(['can_post_job' => 'Pilih minimal satu hak kontrak: posting lowongan atau artikel.']);
        }

        $updates = [
            'tanggal_mulai'    => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'can_post_job'     => $canPostJob,
            'can_post_article' => $canPostArticle,
            'catatan'          => $data['catatan'] ?? null,
            'status'           => $data['status'],
        ];

        if ($request->hasFile('mou_file')) {
            if ($contract->mou_file) {
                Storage::delete($contract->mou_file);
            }
            $updates['mou_file'] = $request->file('mou_file')->store('mou-files');
        }

        $contract->update($updates);

        return redirect()->route('backoffice.employer-contract.index')
            ->with('success', 'Kontrak mitra kerja diperbarui.');
    }

    public function revoke(EmployerContract $contract)
    {
        if ($contract->status !== EmployerContract::STATUS_ACTIVE) {
            return redirect()->route('backoffice.employer-contract.show', $contract)
                ->with('info', 'Kontrak ini sudah tidak aktif.');
        }

        $contract->update(['status' => EmployerContract::STATUS_REVOKED]);

        NotificationService::send(
            $contract->employer->user_id,
            'employer_contract_revoked',
            'Status Mitra Kerja Dibatalkan',
            'Status mitra kerja perusahaan Anda telah dibatalkan oleh admin. '
                . 'Untuk terus memposting lowongan/artikel, silakan berlangganan membership.',
            route('employer.membership.index'),
        );

        return redirect()->route('backoffice.employer-contract.index')
            ->with('success', 'Kontrak mitra kerja dibatalkan.');
    }

    public function serveMou(EmployerContract $contract)
    {
        if (!$contract->mou_file) {
            abort(404);
        }
        return Storage::download($contract->mou_file, basename($contract->mou_file));
    }

    private function scopeLabel(EmployerContract $contract): string
    {
        $parts = [];
        if ($contract->can_post_job) {
            $parts[] = 'lowongan';
        }
        if ($contract->can_post_article) {
            $parts[] = 'artikel';
        }
        return implode(' dan ', $parts);
    }
}
