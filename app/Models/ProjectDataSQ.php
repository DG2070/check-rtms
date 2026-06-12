<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDataSQ extends Model
{
    use
        HasFactory,
        SoftDeletes;

    protected $fillable = [
        "project_id",
        "fiscal_year",
        "approved_budget",
        "FT",
        "FP",
        "PT",
        "PP",
        "is_locked",
        "locked_by_user_id",
        "locked_at",
        "deleted_by_user_id",

        "physical_progress",

        "approved_cost",
        "contractual_cost",
        "aggrement_date",
    ];


    public function user()
    {
        return $this->hasOne(User::class, "id", "locked_by_user_id");
    }
    public function lockedUser()
    {
        return $this->hasOne(User::class, "id", "locked_by_user_id");
    }

    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, "project_id", "projectID");
    }

}
