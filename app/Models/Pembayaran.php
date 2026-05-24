<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    public const KATEGORI_MEMBERSHIP = 'membership';
    public const KATEGORI_EVENT = 'event';

    public const STATUS_PENDING = 'pending';
    public const STATUS_AWAITING_VERIFICATION = 'awaiting_verification';
    public const STATUS_LUNAS = 'lunas';
    public const STATUS_GAGAL = 'gagal';
    public const STATUS_EXPIRED = 'expired';

    public const METODE_MIDTRANS = 'midtrans';
    public const METODE_MANUAL = 'manual';

    protected $fillable = [
        'employer_id',
        'kategori',
        'membership_id',
        'employer_event_id',
        'amount',
        'metode_pembayaran',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'snap_token',
        'account_id',
        'bukti_transfer',
        'admin_note',
        'verified_by',
        'verified_at',
        'tgl_mulai',
        'tgl_berakhir',
        'paid_at',
    ];

    protected $casts = [
        'employer_id' => 'integer',
        'membership_id' => 'integer',
        'employer_event_id' => 'integer',
        'account_id' => 'integer',
        'verified_by' => 'integer',
        'amount' => 'decimal:2',
        'tgl_mulai' => 'date',
        'tgl_berakhir' => 'date',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isLunas(): bool
    {
        return $this->status === self::STATUS_LUNAS;
    }

    public function isAwaitingVerification(): bool
    {
        return $this->status === self::STATUS_AWAITING_VERIFICATION;
    }

    public function isManual(): bool
    {
        return $this->metode_pembayaran === self::METODE_MANUAL;
    }

    public function isActive(): bool
    {
        return $this->isLunas()
            && $this->kategori === self::KATEGORI_MEMBERSHIP
            && $this->tgl_berakhir
            && $this->tgl_berakhir->isFuture();
    }

    public function scopeActiveMembership(Builder $query): Builder
    {
        return $query->where('kategori', self::KATEGORI_MEMBERSHIP)
            ->where('status', self::STATUS_LUNAS)
            ->whereDate('tgl_berakhir', '>=', now()->toDateString());
    }

    /**
     * Mark the payment as paid, set membership window, and notify employer.
     * Idempotent: re-calling on an already-lunas pembayaran is a no-op.
     *
     * @param  string|null  $transactionId  Midtrans transaction id (null for manual).
     * @param  int|null     $verifiedBy     Admin user id (null for automated Midtrans).
     */
    public function activate(?string $transactionId = null, ?int $verifiedBy = null): bool
    {
        if ($this->isLunas()) {
            return false;
        }

        $start = now()->toDateString();
        $durasi = $this->membership?->durasi_hari ?? 365;
        $end = Carbon::parse($start)->addDays($durasi)->toDateString();

        $updates = [
            'status'        => self::STATUS_LUNAS,
            'paid_at'       => now(),
            'tgl_mulai'     => $start,
            'tgl_berakhir'  => $end,
        ];

        if ($transactionId) {
            $updates['midtrans_transaction_id'] = $transactionId;
        }
        if ($verifiedBy) {
            $updates['verified_by'] = $verifiedBy;
            $updates['verified_at'] = now();
        }

        $this->update($updates);

        if ($this->employer && $this->employer->user_id) {
            NotificationService::send(
                $this->employer->user_id,
                'membership_activated',
                'Membership Aktif',
                'Pembayaran berhasil. Membership ' . ($this->membership->nama_membership ?? '-')
                    . ' aktif sampai ' . Carbon::parse($end)->format('d M Y') . '.',
                route('employer.membership.index'),
            );
        }

        return true;
    }
}
