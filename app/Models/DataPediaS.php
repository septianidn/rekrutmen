<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPediaS extends Model
{
    use HasFactory;

    protected $table = 'data_pedias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'label',
        'parent_id',
    ];
    
   
}
