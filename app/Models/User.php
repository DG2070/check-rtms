<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password'
    ];


    protected $hidden = [
        'password',
        'remember_token'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function departments()
    {
        return $this->belongsToMany('App\Models\Department');
    }
    public function divisons()
    {
        return $this->belongsToMany('App\Models\UserDivision');
    }
    public function sections()
    {
        return $this->belongsToMany('App\Models\UserSection');
    }
}
