<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'street_addr',
        'user_type',
        'status',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function konselor() {
        return $this->hasOne(Konselor::class, 'user_id', 'id');
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function jobseeker(): HasOne
    {
        return $this->hasOne(Jobseeker::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    



}