<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalProgress extends Model{

    use HasFactory;

    protected $table = "physical_progress";

    protected $guarded = ["id"];

    protected $casts = [
        "visitor_details" => 'array',
        "document_uploads" => 'array'
    ];


    public function project(){
        return $this->belongsTo(ProjectDetail::class, "project_id", "projectID");
    }


}
