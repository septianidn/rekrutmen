<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Membership;
use App\Models\Pembayaran;
use App\Services\NotificationService;
use Illuminate\Http\Request;
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

        $awaitingVerification = $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_AWAITING_VERIFICATION)
            ->with('membership', 'account')
            ->latest()
            ->first();

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
            'awaitingVerification',
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

        if ($this->hasAwaitingVerification($employer)) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Anda masih memiliki pembayaran manual yang menunggu verifikasi admin. Tunggu hingga diproses sebelum membuat pembayaran baru.');
        }

        $membership = Membership::findOrFail($data['membership_id']);

        // Block only if this tier adds nothing new on top of what employer already has
        // (whether that access came from a mitra contract or an active membership).
        $tierAddsJob = $membership->can_post_job && !$employer->canPostJob();
        $tierAddsArticle = $membership->can_post_article && !$employer->canPostArticle();
        if (!$tierAddsJob && !$tierAddsArticle) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Akses dari paket ini sudah Anda miliki melalui mitra kerja atau membership aktif.');
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
                $pembayaran->activate($payload['transaction_id'] ?? null);
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

    public function manualCheckout(Membership $membership)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        if ($this->membershipAddsNothing($employer, $membership)) {
            return redirect()->route('employer.membership.index')
                ->with('info', 'Akses dari paket ini sudah Anda miliki melalui mitra kerja atau membership aktif.');
        }

        if ($this->hasAwaitingVerification($employer)) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Pembayaran manual sebelumnya masih menunggu verifikasi admin.');
        }

        if ($employer->activeMemberships()->contains('membership_id', $membership->id)) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Paket ini sudah aktif. Tunggu sampai periode berakhir untuk memperbarui.');
        }

        $accounts = Account::active()->orderBy('nama_bank')->get();

        if ($accounts->isEmpty()) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Belum ada rekening pembayaran yang tersedia. Hubungi admin.');
        }

        return view('frontoffice.employer.membership.manual-checkout', compact('membership', 'accounts'));
    }

    public function submitManual(Request $request, Membership $membership)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        if ($this->membershipAddsNothing($employer, $membership)) {
            return redirect()->route('employer.membership.index')
                ->with('info', 'Akses dari paket ini sudah Anda miliki melalui mitra kerja atau membership aktif.');
        }

        if ($this->hasAwaitingVerification($employer)) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Pembayaran manual sebelumnya masih menunggu verifikasi admin.');
        }

        $data = $request->validate([
            'account_id'     => 'required|exists:account,id',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $account = Account::active()->findOrFail($data['account_id']);

        // Cancel any leftover Midtrans pending — employer is committing to manual now.
        $existingPending = $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_PENDING)
            ->latest()
            ->first();
        if ($existingPending) {
            $existingPending->update(['status' => Pembayaran::STATUS_GAGAL]);
        }

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'local');

        $orderId = sprintf('PAY-MAN-%d-%d', $employer->id, now()->timestamp);

        Pembayaran::create([
            'employer_id'       => $employer->id,
            'kategori'          => Pembayaran::KATEGORI_MEMBERSHIP,
            'membership_id'     => $membership->id,
            'amount'            => $membership->harga,
            'metode_pembayaran' => Pembayaran::METODE_MANUAL,
            'status'            => Pembayaran::STATUS_AWAITING_VERIFICATION,
            'midtrans_order_id' => $orderId,
            'account_id'        => $account->id,
            'bukti_transfer'    => $path,
        ]);

        return redirect()->route('employer.membership.index')
            ->with('success', 'Bukti transfer berhasil diunggah. Pembayaran sedang menunggu verifikasi admin (biasanya 1x24 jam kerja).');
    }

    protected function hasAwaitingVerification($employer): bool
    {
        return $employer->pembayarans()
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_AWAITING_VERIFICATION)
            ->exists();
    }

    /**
     * A membership adds nothing when every access it grants is already held by
     * the employer (via an active mitra contract or another active membership).
     */
    protected function membershipAddsNothing($employer, Membership $membership): bool
    {
        $addsJob = $membership->can_post_job && !$employer->canPostJob();
        $addsArticle = $membership->can_post_article && !$employer->canPostArticle();

        return !$addsJob && !$addsArticle;
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
            $pembayaran->activate($transactionId);
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
