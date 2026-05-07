<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Pembayaran;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class PembayaranController extends Controller
{
    public function index()
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        $memberships = Membership::orderBy('harga')->get();

        $pendingPembayaran = $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_PENDING)
            ->latest()
            ->first();

        if ($pendingPembayaran) {
            $this->refreshPendingStatus($pendingPembayaran);
            if ($pendingPembayaran->status !== Pembayaran::STATUS_PENDING) {
                $pendingPembayaran = null;
            }
        }

        $activeMemberships = $employer->activeMemberships();
        $activePembayaran = $activeMemberships->first();
        $activeContract = $employer->activeContract();
        $hasJobAccess = $employer->canPostJob();
        $hasArticleAccess = $employer->canPostArticle();

        $history = $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->with('membership')
            ->latest()
            ->limit(10)
            ->get();

        return view('frontoffice.employer.membership.index', compact(
            'memberships',
            'activeMemberships',
            'activePembayaran',
            'activeContract',
            'pendingPembayaran',
            'history',
            'hasJobAccess',
            'hasArticleAccess',
        ));
    }

    public function checkout(Request $request)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        $data = $request->validate([
            'membership_id' => 'required|exists:membership,id',
        ]);

        if ($employer->hasActiveContract()) {
            return redirect()->route('employer.membership.index')
                ->with('info', 'Akun Anda terdaftar sebagai mitra kerja sehingga tidak memerlukan pembayaran membership.');
        }

        $membership = Membership::findOrFail($data['membership_id']);

        // Block only if this tier adds nothing new on top of what employer already has
        $tierAddsJob = $membership->can_post_job && !$employer->canPostJob();
        $tierAddsArticle = $membership->can_post_article && !$employer->canPostArticle();
        if (!$tierAddsJob && !$tierAddsArticle) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Akses dari paket ini sudah tercakup oleh membership aktif Anda.');
        }

        // Block buying the exact same tier twice (would just extend a duplicate)
        if ($employer->activeMemberships()->contains('membership_id', $membership->id)) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Paket ini sudah aktif. Tunggu sampai periode berakhir untuk memperbarui.');
        }

        $existingPending = $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_PENDING)
            ->latest()
            ->first();

        if ($existingPending) {
            $this->refreshPendingStatus($existingPending);
        }

        if ($existingPending
            && $existingPending->status === Pembayaran::STATUS_PENDING
            && $existingPending->membership_id === (int) $data['membership_id']
            && $existingPending->snap_token
            && $existingPending->created_at->gt(now()->subHours(1))
        ) {
            return view('frontoffice.employer.membership.checkout', [
                'pembayaran' => $existingPending,
                'snapToken'  => $existingPending->snap_token,
            ]);
        }

        if ($existingPending && $existingPending->status === Pembayaran::STATUS_PENDING) {
            $existingPending->update(['status' => Pembayaran::STATUS_GAGAL]);
        }

        $orderId = sprintf('PAY-MEM-%d-%d', $employer->id, now()->timestamp);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $membership->harga,
            ],
            'item_details' => [[
                'id'       => 'membership-' . $membership->id,
                'price'    => (int) $membership->harga,
                'quantity' => 1,
                'name'     => $membership->nama_membership,
            ]],
            'customer_details' => [
                'first_name' => $employer->nama_perusahaan,
                'email'      => Auth::user()->email,
                'phone'      => $employer->telp_perusahaan,
            ],
        ];

        $this->configureMidtrans();

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Throwable $e) {
            Log::error('Midtrans snap token error', ['error' => $e->getMessage(), 'order_id' => $orderId]);
            return redirect()->route('employer.membership.index')
                ->with('error', 'Gagal membuat sesi pembayaran. Coba lagi atau hubungi admin.');
        }

        $pembayaran = Pembayaran::create([
            'employer_id'       => $employer->id,
            'kategori'          => Pembayaran::KATEGORI_MEMBERSHIP,
            'membership_id'     => $membership->id,
            'amount'            => $membership->harga,
            'status'            => Pembayaran::STATUS_PENDING,
            'midtrans_order_id' => $orderId,
            'snap_token'        => $snapToken,
        ]);

        return view('frontoffice.employer.membership.checkout', [
            'pembayaran' => $pembayaran,
            'snapToken'  => $snapToken,
        ]);
    }

    public function resumeCheckout(Pembayaran $pembayaran)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer && $pembayaran->employer_id === $employer->id, 403);

        $this->refreshPendingStatus($pembayaran);

        if ($pembayaran->status !== Pembayaran::STATUS_PENDING || !$pembayaran->snap_token) {
            return redirect()->route('employer.membership.index')
                ->with('info', 'Pembayaran ini sudah tidak dalam status menunggu.');
        }

        return view('frontoffice.employer.membership.checkout', [
            'pembayaran' => $pembayaran,
            'snapToken'  => $pembayaran->snap_token,
        ]);
    }

    public function cancelPending(Pembayaran $pembayaran)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer && $pembayaran->employer_id === $employer->id, 403);

        if ($pembayaran->status !== Pembayaran::STATUS_PENDING) {
            return redirect()->route('employer.membership.index')
                ->with('info', 'Pembayaran ini sudah tidak dalam status menunggu.');
        }

        $pembayaran->update(['status' => Pembayaran::STATUS_GAGAL]);

        return redirect()->route('employer.membership.index')
            ->with('success', 'Pembayaran dibatalkan. Anda dapat memilih paket kembali.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        $required = ['order_id', 'status_code', 'gross_amount', 'signature_key', 'transaction_status'];
        foreach ($required as $key) {
            if (!isset($payload[$key])) {
                return response()->json(['message' => 'Missing field: ' . $key], 400);
            }
        }

        $expected = hash('sha512',
            $payload['order_id']
            . $payload['status_code']
            . $payload['gross_amount']
            . config('midtrans.server_key')
        );

        if (!hash_equals($expected, $payload['signature_key'])) {
            Log::warning('Midtrans webhook signature mismatch', ['order_id' => $payload['order_id']]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pembayaran = Pembayaran::where('midtrans_order_id', $payload['order_id'])->first();
        if (!$pembayaran) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'] ?? null;

        DB::transaction(function () use ($pembayaran, $transactionStatus, $fraudStatus, $payload) {
            if (in_array($transactionStatus, ['capture', 'settlement'], true)
                && (!$fraudStatus || $fraudStatus === 'accept')) {
                if ($pembayaran->status !== Pembayaran::STATUS_LUNAS) {
                    $start = now()->toDateString();
                    $durasi = $pembayaran->membership?->durasi_hari ?? 365;
                    $end = Carbon::parse($start)->addDays($durasi)->toDateString();

                    $pembayaran->update([
                        'status'                  => Pembayaran::STATUS_LUNAS,
                        'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                        'paid_at'                 => now(),
                        'tgl_mulai'               => $start,
                        'tgl_berakhir'            => $end,
                    ]);

                    NotificationService::send(
                        $pembayaran->employer->user_id,
                        'membership_activated',
                        'Membership Aktif',
                        'Pembayaran berhasil. Membership ' . ($pembayaran->membership->nama_membership ?? '-')
                            . ' aktif sampai ' . Carbon::parse($end)->format('d M Y') . '.',
                        route('employer.membership.index'),
                    );
                }
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'], true)) {
                $pembayaran->update([
                    'status'                  => $transactionStatus === 'expire'
                        ? Pembayaran::STATUS_EXPIRED
                        : Pembayaran::STATUS_GAGAL,
                    'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                ]);

                NotificationService::send(
                    $pembayaran->employer->user_id,
                    'membership_payment_failed',
                    'Pembayaran Gagal',
                    'Pembayaran membership tidak berhasil (' . $transactionStatus . '). Silakan coba lagi.',
                    route('employer.membership.index'),
                );
            }
        });

        return response()->json(['message' => 'OK']);
    }

    protected function configureMidtrans(): void
    {
        MidtransConfig::$serverKey    = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
        MidtransConfig::$isSanitized  = (bool) config('midtrans.is_sanitized');
        MidtransConfig::$is3ds        = (bool) config('midtrans.is_3ds');
    }

    protected function refreshPendingStatus(Pembayaran $pembayaran): void
    {
        if ($pembayaran->status !== Pembayaran::STATUS_PENDING || !$pembayaran->midtrans_order_id) {
            return;
        }

        $this->configureMidtrans();

        try {
            $status = MidtransTransaction::status($pembayaran->midtrans_order_id);
        } catch (\Throwable $e) {
            Log::warning('Midtrans status check failed', [
                'order_id' => $pembayaran->midtrans_order_id,
                'error'    => $e->getMessage(),
            ]);
            return;
        }

        $tx = is_object($status) ? ($status->transaction_status ?? null) : ($status['transaction_status'] ?? null);
        $fraud = is_object($status) ? ($status->fraud_status ?? null) : ($status['fraud_status'] ?? null);
        $transactionId = is_object($status) ? ($status->transaction_id ?? null) : ($status['transaction_id'] ?? null);

        if (in_array($tx, ['settlement', 'capture'], true) && (!$fraud || $fraud === 'accept')) {
            $start = now()->toDateString();
            $durasi = $pembayaran->membership?->durasi_hari ?? 365;
            $end = Carbon::parse($start)->addDays($durasi)->toDateString();

            $pembayaran->update([
                'status'                  => Pembayaran::STATUS_LUNAS,
                'midtrans_transaction_id' => $transactionId,
                'paid_at'                 => now(),
                'tgl_mulai'               => $start,
                'tgl_berakhir'            => $end,
            ]);
        } elseif (in_array($tx, ['expire', 'cancel', 'deny'], true)) {
            $pembayaran->update([
                'status'                  => $tx === 'expire'
                    ? Pembayaran::STATUS_EXPIRED
                    : Pembayaran::STATUS_GAGAL,
                'midtrans_transaction_id' => $transactionId,
            ]);
        }
    }
}
