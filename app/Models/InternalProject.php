<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class InternalProject extends Model
{
    use
        HasFactory,
        SoftDeletes;
    protected $fillable = [
        "name",
        "fiscal_year",
        "created_by_user_id",
        "deleted_by_user_id",
    ];
}
