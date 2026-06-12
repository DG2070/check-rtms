<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Program, ProjectDetail, TownList};


class ActivityDetail extends Model
{

    use HasFactory;

    protected $table = "activity_details";


    protected $fillable = [
        "programID",
        "programName",
        "projectID",
        "projectName",
        "townId",
        "TownName",
        "activityCode",
        "Type",
        "FinancingType",
        // "ProjectName",
        "DateOfSigningFinancialAgreementTDF",
        "TDFMatchApproved",
        "GoNMatchApproved",
        "MunicipalityMatchApproved",
        "UserCommitteeMatchApproved",
        "EstimateTotal1",
        "TDFMatchEstimate1",
        "TDFMatchContracted",
        "GoNMatchContracted",
        "UserCommitteeMatchContracted",
        "MunicipalityMatchContracted",
        "ContractedTotal",
        "DateOfStart",
        "TdfPfsGrant",
        "MunicipalityPfsContribution",
        "GonPfsContribution",
        "ApprovedTotal",
        "TotalPfsCost"
    ];


    public function program()
    {
        return $this->belongsTo(Program::class, "programID");
    }


    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, "projectID");
    }


    public function town()
    {
        return $this->belongsTo(TownList::class, "townId");
    }
    public function allDisbursementDataFromMis()
    {
        return $this->hasMany(AllDisbursementFromMis::class,"Code", "activityCode");
    }

    public function allProjectDisbursementData()
    {
        return $this->hasMany(AllDisbursementFromMis::class,"Code", "activityCode")->where("IsDisbursement",1);
    }

    public function allDisbursementFromMisOnlyDisbursement()
    {
        return $this->hasMany(AllDisbursementFromMis::class,"Code", "activityCode")->where("IsDisbursement",1);
    }

    //curently not using this even if it works
    public function allDisbursementFromMisOnlyDisbursementAmount()
    {
        return $this->hasMany(AllDisbursementFromMis::class,"Code", "activityCode")->where("IsDisbursement",1)->distinct("Date")->pluck("Amount")->sum();
    }
}
