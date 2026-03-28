<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'membership_id',
        'tgl_mulai',
        'tgl_berakhir',
        'account_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'membership_id' => 'integer',
        'tgl_mulai' => 'date',
        'tgl_berakhir' => 'date',
        'nomor_rekening' => 'integer',
        'account_id' => 'integer',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
