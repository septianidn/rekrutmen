<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    public const KATEGORI_MEMBERSHIP = 'membership';
    public const KATEGORI_EVENT = 'event';

    public const STATUS_PENDING = 'pending';
    public const STATUS_LUNAS = 'lunas';
    public const STATUS_GAGAL = 'gagal';
    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'employer_id',
        'kategori',
        'membership_id',
        'employer_event_id',
        'amount',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'snap_token',
        'tgl_mulai',
        'tgl_berakhir',
        'paid_at',
    ];

    protected $casts = [
        'employer_id' => 'integer',
        'membership_id' => 'integer',
        'employer_event_id' => 'integer',
        'amount' => 'decimal:2',
        'tgl_mulai' => 'date',
        'tgl_berakhir' => 'date',
        'paid_at' => 'datetime',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function isLunas(): bool
    {
        return $this->status === self::STATUS_LUNAS;
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
}
