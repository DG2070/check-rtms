<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{

    use
        HasFactory,
        SoftDeletes;


    protected $table = "timelines";

    protected $fillable = ["milestone_id", "timeline", "progress_input_data", "remarks"];

    protected $casts = [
        'timeline' => 'array',
        'progress_input_data' => 'array',
        'remarks' => 'array'
    ];

    public function milestone()
    {
        return $this->belongsTo(Milestone::class, "milestone_id");
    }
}