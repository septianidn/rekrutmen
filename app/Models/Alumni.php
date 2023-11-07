<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Alumni extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'alumni';
    public $primaryKey = 'nim';
    public $incrementing = false;
    protected $guard = 'alumni';
    protected $password = 'pin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim',
        'email',
        'nama',
        'kode_prodi_id',
        'thn_masuk',
        'tempat_lahir',
        'thn_lulus',
        'tanggal_lahir',
        'pin',
        'nomor_handphone',
        'periode_wisuda',
        'status_tc',
        'tipe_masuk',
        'nik',
        'npwp',
        'judul_tesis',
        'sent_pin'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    
    public function getAuthPassword()
    {
        return $this->pin;
    }

    public function setPasswordAttribute()
    {
        $this->attributes['pin'];
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi_id');
    }
}
