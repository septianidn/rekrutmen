<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employer';
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'deskripsi_perusahaan',
        'industriType_id',
        'alamat_perusahaan',
        'telp_perusahaan',
        'website',
        'logo',
        'dokumen_legalitas',
        'verification_status',
        'verified_at',
        'verification_note',
        'verified_by',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'industriType_id' => 'integer',
        'verified_at' => 'datetime',
        'verified_by' => 'integer',
    ];

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function industriTypes(): HasMany
    {
        return $this->hasMany(IndustriType::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industriType(): BelongsTo
    {
        return $this->belongsTo(IndustriType::class, 'industriType_id');
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(EmployerChangeRequest::class);
    }

    public function pendingChangeRequest(): ?EmployerChangeRequest
    {
        return $this->changeRequests()->pending()->latest()->first();
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(EmployerContract::class);
    }

    public function activeMemberships()
    {
        return $this->pembayarans()
            ->activeMembership()
            ->with('membership')
            ->orderByDesc('tgl_berakhir')
            ->get();
    }

    public function activeMembership(): ?Pembayaran
    {
        return $this->activeMemberships()->first();
    }

    public function activeContract(): ?EmployerContract
    {
        return $this->contracts()->active()->latest('tanggal_berakhir')->first();
    }

    public function hasActiveContract(): bool
    {
        return $this->activeContract() !== null;
    }

    public function canPostJob(): bool
    {
        if ($this->hasActiveContract()) {
            return true;
        }

        return $this->activeMemberships()
            ->contains(fn ($p) => $p->membership && $p->membership->can_post_job);
    }

    public function canPostArticle(): bool
    {
        if ($this->hasActiveContract()) {
            return true;
        }

        return $this->activeMemberships()
            ->contains(fn ($p) => $p->membership && $p->membership->can_post_article);
    }
}
