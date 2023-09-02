<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProdi extends Model
{
    use HasFactory;

    protected $table = 'admin_prodi';
   
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kode_prodi_id',
       
        
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi_id', 'kode_prodi');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
