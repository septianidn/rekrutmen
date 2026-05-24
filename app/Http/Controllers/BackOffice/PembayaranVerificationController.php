<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranVerificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', Pembayaran::STATUS_AWAITING_VERIFICATION);
        $allowed = [
            Pembayaran::STATUS_AWAITING_VERIFICATION,
            Pembayaran::STATUS_LUNAS,
            Pembayaran::STATUS_GAGAL,
        ];
        if (!in_array($status, $allowed, true)) {
            $status = Pembayaran::STATUS_AWAITING_VERIFICATION;
        }

        $pembayarans = Pembayaran::with(['employer.user', 'membership', 'account', 'verifier'])
            ->where('metode_pembayaran', Pembayaran::METODE_MANUAL)
            ->where('status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            Pembayaran::STATUS_AWAITING_VERIFICATION => Pembayaran::where('metode_pembayaran', Pembayaran::METODE_MANUAL)
                ->where('status', Pembayaran::STATUS_AWAITING_VERIFICATION)->count(),
            Pembayaran::STATUS_LUNAS => Pembayaran::where('metode_pembayaran', Pembayaran::METODE_MANUAL)
                ->where('status', Pembayaran::STATUS_LUNAS)->count(),
            Pembayaran::STATUS_GAGAL => Pembayaran::where('metode_pembayaran', Pembayaran::METODE_MANUAL)
                ->where('status', Pembayaran::STATUS_GAGAL)->count(),
        ];

        return view('backoffice.pembayaran-verification.index', compact('pembayarans', 'status', 'counts'));
    }

    public function show(Pembayaran $pembayaran)
    {
        abort_unless($pembayaran->isManual(), 404);
        $pembayaran->load(['employer.user', 'membership', 'account', 'verifier']);

        return view('backoffice.pembayaran-verification.show', compact('pembayaran'));
    }

    public function approve(Pembayaran $pembayaran)
    {
        abort_unless($pembayaran->isManual(), 404);

        if (!$pembayaran->isAwaitingVerification()) {
            return redirect()->route('backoffice.pembayaran-verification.show', $pembayaran)
                ->with('info', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $pembayaran->activate(transactionId: null, verifiedBy: Auth::id());

        return redirect()->route('backoffice.pembayaran-verification.index')
            ->with('success', 'Pembayaran disetujui. Membership employer telah diaktifkan.');
    }

    public function reject(Request $request, Pembayaran $pembayaran)
    {
        abort_unless($pembayaran->isManual(), 404);

        if (!$pembayaran->isAwaitingVerification()) {
            return redirect()->route('backoffice.pembayaran-verification.show', $pembayaran)
                ->with('info', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $data = $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        if ($pembayaran->bukti_transfer) {
            Storage::disk('local')->delete($pembayaran->bukti_transfer);
        }

        $pembayaran->update([
            'status'         => Pembayaran::STATUS_GAGAL,
            'admin_note'     => $data['admin_note'],
            'verified_by'    => Auth::id(),
            'verified_at'    => now(),
            'bukti_transfer' => null,
        ]);

        if ($pembayaran->employer && $pembayaran->employer->user_id) {
            NotificationService::send(
                $pembayaran->employer->user_id,
                'membership_payment_rejected',
                'Pembayaran Ditolak',
                'Pembayaran manual Anda ditolak. Catatan admin: ' . $data['admin_note'],
                route('employer.membership.index'),
            );
        }

        return redirect()->route('backoffice.pembayaran-verification.index')
            ->with('success', 'Pembayaran ditolak. Employer telah dinotifikasi.');
    }

    public function serveBukti(Pembayaran $pembayaran)
    {
        abort_unless($pembayaran->isManual() && $pembayaran->bukti_transfer, 404);
        abort_unless(Storage::disk('local')->exists($pembayaran->bukti_transfer), 404);

        return Storage::disk('local')->response($pembayaran->bukti_transfer);
    }
}
