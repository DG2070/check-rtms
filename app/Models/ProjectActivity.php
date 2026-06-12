<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ProjectDetail, Milestone};

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectActivity extends Model
{

    use
        HasFactory,
        SoftDeletes;

    protected $table = "project_activities";

    protected $fillable = [
        "project_id", "activity", "main_responsibility", "supportive_responsibility", "remark",
        "pme_main_responsibility",
        "pme_supportive_responsibility",
        "fiscal_year",
    ];

    protected $casts = [
        'main_responsibility' => 'array',
        'supportive_responsibility' => 'array',
    ];


    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, "project_id", "projectID");
    }


    public function milestone()
    {
        return $this->hasMany(Milestone::class, "project_activity_id");
    }

    // public function main_responsibility()
    // {
    //     return $this->hasMany(Milestone::class, "project_activity_id");
    // }
}
