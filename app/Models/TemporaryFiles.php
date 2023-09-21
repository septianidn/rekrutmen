<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryFiles extends Model
{
    use HasFactory;

    protected $table = 'temporary_files';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'folder',
       'filename'
    ];

 
}
