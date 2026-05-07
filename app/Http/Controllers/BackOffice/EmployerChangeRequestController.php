<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\EmployerChangeRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerChangeRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', EmployerChangeRequest::STATUS_PENDING);
        $allowed = [
            EmployerChangeRequest::STATUS_PENDING,
            EmployerChangeRequest::STATUS_APPROVED,
            EmployerChangeRequest::STATUS_DECLINED,
        ];
        if (!in_array($status, $allowed, true)) {
            $status = EmployerChangeRequest::STATUS_PENDING;
        }

        $requests = EmployerChangeRequest::with(['employer.user', 'reviewer'])
            ->where('status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            EmployerChangeRequest::STATUS_PENDING  => EmployerChangeRequest::where('status', EmployerChangeRequest::STATUS_PENDING)->count(),
            EmployerChangeRequest::STATUS_APPROVED => EmployerChangeRequest::where('status', EmployerChangeRequest::STATUS_APPROVED)->count(),
            EmployerChangeRequest::STATUS_DECLINED => EmployerChangeRequest::where('status', EmployerChangeRequest::STATUS_DECLINED)->count(),
        ];

        return view('backoffice.employer-change-request.index', compact('requests', 'status', 'counts'));
    }

    public function show(EmployerChangeRequest $changeRequest)
    {
        $changeRequest->load(['employer.user', 'employer.industriType', 'reviewer']);
        $diff = $this->buildDiff($changeRequest);

        return view('backoffice.employer-change-request.show', compact('changeRequest', 'diff'));
    }

    public function approve(EmployerChangeRequest $changeRequest)
    {
        if (!$changeRequest->isPending()) {
            return redirect()->route('backoffice.employer-change-request.show', $changeRequest)
                ->with('info', 'Permintaan ini sudah diproses.');
        }

        $employer = $changeRequest->employer;
        $payload = $changeRequest->payload ?? [];

        $updates = [];
        foreach (['nama_perusahaan', 'alamat_perusahaan'] as $field) {
            if (array_key_exists($field, $payload)) {
                $updates[$field] = $payload[$field];
            }
        }

        if (!empty($payload['logo'])) {
            if ($employer->logo) {
                Storage::disk('public')->delete($employer->logo);
            }
            $finalLogo = str_replace('change-requests/logos/', 'logos/', $payload['logo']);
            Storage::disk('public')->move($payload['logo'], $finalLogo);
            $updates['logo'] = $finalLogo;
        }

        if (!empty($payload['dokumen_legalitas'])) {
            if ($employer->dokumen_legalitas) {
                Storage::delete($employer->dokumen_legalitas);
            }
            $finalDoc = str_replace('change-requests/dokumen-legalitas/', 'dokumen-legalitas/', $payload['dokumen_legalitas']);
            Storage::move($payload['dokumen_legalitas'], $finalDoc);
            $updates['dokumen_legalitas'] = $finalDoc;
        }

        if (!empty($updates)) {
            $employer->update($updates);
        }

        $changeRequest->update([
            'status'      => EmployerChangeRequest::STATUS_APPROVED,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        NotificationService::send(
            $employer->user_id,
            'employer_change_approved',
            'Perubahan Profil Disetujui',
            'Permintaan perubahan profil perusahaan Anda telah disetujui dan diterapkan.',
            route('employer.profile')
        );

        return redirect()->route('backoffice.employer-change-request.index')
            ->with('success', 'Perubahan profil disetujui dan diterapkan.');
    }

    public function decline(Request $request, EmployerChangeRequest $changeRequest)
    {
        if (!$changeRequest->isPending()) {
            return redirect()->route('backoffice.employer-change-request.show', $changeRequest)
                ->with('info', 'Permintaan ini sudah diproses.');
        }

        $data = $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $payload = $changeRequest->payload ?? [];
        if (!empty($payload['logo'])) {
            Storage::disk('public')->delete($payload['logo']);
        }
        if (!empty($payload['dokumen_legalitas'])) {
            Storage::delete($payload['dokumen_legalitas']);
        }

        $changeRequest->update([
            'status'      => EmployerChangeRequest::STATUS_DECLINED,
            'admin_note'  => $data['admin_note'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        NotificationService::send(
            $changeRequest->employer->user_id,
            'employer_change_declined',
            'Perubahan Profil Ditolak',
            'Permintaan perubahan profil ditolak. Catatan admin: ' . $data['admin_note'],
            route('employer.profile.edit')
        );

        return redirect()->route('backoffice.employer-change-request.index')
            ->with('success', 'Permintaan perubahan ditolak.');
    }

    public function serveProposedDocument(EmployerChangeRequest $changeRequest)
    {
        $path = $changeRequest->payload['dokumen_legalitas'] ?? null;
        if (!$path) {
            abort(404);
        }
        return Storage::download($path, basename($path));
    }

    public function serveProposedLogo(EmployerChangeRequest $changeRequest)
    {
        $path = $changeRequest->payload['logo'] ?? null;
        if (!$path) {
            abort(404);
        }
        return Storage::disk('public')->download($path, basename($path));
    }

    protected function buildDiff(EmployerChangeRequest $changeRequest): array
    {
        $employer = $changeRequest->employer;
        $payload = $changeRequest->payload ?? [];
        $rows = [];

        foreach (EmployerChangeRequest::GATED_FIELDS as $field) {
            if (!array_key_exists($field, $payload)) {
                continue;
            }
            $rows[$field] = [
                'current'  => $employer->{$field},
                'proposed' => $payload[$field],
            ];
        }

        return $rows;
    }
}
