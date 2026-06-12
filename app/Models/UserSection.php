<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'division_id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
