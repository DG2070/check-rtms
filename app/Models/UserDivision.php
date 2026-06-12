<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDivision extends Model
{
    use HasFactory;

    protected $fillable = [
    'department_id',
    'name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

}
