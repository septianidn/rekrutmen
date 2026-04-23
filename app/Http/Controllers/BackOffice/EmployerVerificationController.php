<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerVerificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            $status = 'pending';
        }

        $employers = Employer::with(['user', 'industriType'])
            ->where('verification_status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending' => Employer::where('verification_status', 'pending')->count(),
            'approved' => Employer::where('verification_status', 'approved')->count(),
            'rejected' => Employer::where('verification_status', 'rejected')->count(),
        ];

        return view('backoffice.employer-verification.index', compact('employers', 'status', 'counts'));
    }

    public function show(Employer $employer)
    {
        $employer->load(['user', 'industriType', 'verifier']);
        return view('backoffice.employer-verification.show', compact('employer'));
    }

    public function approve(Employer $employer)
    {
        if ($employer->verification_status === 'approved') {
            return redirect()->route('backoffice.employer-verification.show', $employer)
                ->with('info', 'Employer sudah terverifikasi.');
        }

        $employer->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_note' => null,
        ]);

        NotificationService::send(
            $employer->user_id,
            'employer_verified',
            'Verifikasi Disetujui',
            'Selamat, akun perusahaan Anda telah diverifikasi. Anda sekarang dapat memposting lowongan.',
            route('employer.index'),
        );

        return redirect()->route('backoffice.employer-verification.index')
            ->with('success', 'Employer berhasil diverifikasi.');
    }

    public function serveDocument(Employer $employer)
    {
        if (!$employer->dokumen_legalitas) {
            abort(404);
        }

        return Storage::download($employer->dokumen_legalitas, basename($employer->dokumen_legalitas));
    }

    public function reject(Request $request, Employer $employer)
    {
        $data = $request->validate([
            'verification_note' => 'required|string|max:1000',
        ]);

        $employer->update([
            'verification_status' => 'rejected',
            'verification_note' => $data['verification_note'],
            'verified_at' => null,
            'verified_by' => Auth::id(),
        ]);

        NotificationService::send(
            $employer->user_id,
            'employer_rejected',
            'Verifikasi Ditolak',
            'Pengajuan verifikasi Anda ditolak. Catatan: ' . $data['verification_note'],
            route('employer.cek_verifikasi'),
        );

        return redirect()->route('backoffice.employer-verification.index')
            ->with('success', 'Pengajuan employer ditolak.');
    }
}
