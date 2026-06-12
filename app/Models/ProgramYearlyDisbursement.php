<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;


class ProgramYearlyDisbursement extends Model{

    use HasFactory;

    protected $table = "program_yearly_disbursements";

    public $incrementing = false;

    protected $fillable = [
                                "id",
                                "program_id",
                                "program_name",
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
        return $this->belongsTo(Program::class, "program_id");
    }


}
