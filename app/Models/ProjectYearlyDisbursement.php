<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Program, ProjectDetail};


class ProjectYearlyDisbursement extends Model{

    use HasFactory;

    protected $table = "project_yearly_disbursements";

    public $incrementing = false;

    protected $fillable = [
                                "id",
                                "prog_id",
                                "project_id",
                                "project_name",
                                "date_year",
                                "loan",
                                "loan_pc",
                                "softloan",
                                "softloan_pc",
                                "grants",
                                "grant_pc",
                                "total",
                                "total_pc"
                            ];

    public function program(){
        return $this->belongsTo(Program::class, "prog_id");
    }


    public function project(){
        return $this->belongsTo(ProjectDetail::class, "project_id");
    }


}
