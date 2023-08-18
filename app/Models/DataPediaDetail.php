<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPediaDetail extends Model
{
    use HasFactory;

    protected $table = 'data_pedia_detail';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data_pedia_id',
        'value',
        'label',
        'publish',
    ];
    
  

}
