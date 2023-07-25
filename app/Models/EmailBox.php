<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailBox extends Model
{
    use HasFactory;

    protected $table = 'email_box';
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tujuan',
        'subjek',
        'isi',
        'status',
        'tanggal_kirim',
        'tipe',
        
    ];

    
}
