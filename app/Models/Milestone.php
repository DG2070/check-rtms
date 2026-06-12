<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ProjectActivity};

use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{

    use
        HasFactory,
        SoftDeletes;


    protected $table = "milestones";

    protected $fillable = [
        "project_activity_id",
        "milestone",
        "performance_indicator",
        "is_text",
        "remark",
        "attachment",

        "order",
    ];


    public function projectActivity()
    {
        return $this->belongsTo(ProjectActivity::class, "project_activity_id");
    }

    public function timeline()
    {
        return $this->hasOne(Timeline::class, 'milestone_id');
    }
}
