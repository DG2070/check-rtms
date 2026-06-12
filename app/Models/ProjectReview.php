<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectDetail;


class ProjectReview extends Model
{

    use HasFactory;


    protected $table = "project_reviews";


    protected $casts = [
        "progress" => "array",
        "target"   => "array",
        "remarks"  => "array"
    ];


    protected $fillable = ["project_id", "progress", "target", "remarks", "fiscal_year"];


    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, "project_id", "projectID");
    }
}
