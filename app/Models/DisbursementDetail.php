<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\models\{Program, ProjectDetail, TownList};


class DisbursementDetail extends Model
{

    use HasFactory;


    protected $table = "disbursement_details";

    public $incrementing = false;


    protected $fillable = [
        "ID",
        "ProjectID",
        "Code",
        "FinancingType",
        "Name",
        "ProgrammeID",
        "Stopped",
        "DateOfSigningFinancialAgreementBoard",
        "approved_date",
        "Disbursement",
        "DisbursementPercentage",
        "townID",
        "TDFContractedCost",
        "TDFMatchApproved"
    ];


    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, "ProjectID");
    }


    public function program()
    {
        return $this->belongsTo(Program::class, "ProgrammeID");
    }


    public function town()
    {
        return $this->belongsTo(TownList::class, "townID");
    }
}
