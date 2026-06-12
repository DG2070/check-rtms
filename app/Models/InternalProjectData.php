<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalProjectData extends Model
{
    use
        HasFactory,
        SoftDeletes;

    protected $casts = [
        'main_responsibility' => 'array',
        'supportive_responsibility' => 'array',
        'timeline_target' => 'array',
        'timeline_progress' => 'array',
        'timeline_remarks' => 'array',
        'timeline_disbursement_progress' => 'array'
    ];

    protected $fillable = [
        "internal_project_id",
        "fiscal_year",
        "approved_budget",
        "activity_milestone",
        "performance_indicator",
        "main_responsibility",
        "supportive_responsibility",
        "remark",
        "is_text",
        "timeline_target",
        "timeline_progress",
        "timeline_remarks",
        "timeline_disbursement_progress",
        "progress",
        "pme_target_review",
        "pme_target_remarks",
        "created_by_user_id",
        "is_locked",
        "locked_by_user_id",
        "locked_at",
        "deleted_by_user_id",
    ];
}
