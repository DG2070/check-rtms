<?php

namespace App\Models;

use App\Helper\DateConverter;
use App\Helper\FiscalYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{DisbursementDetail, Program, ProjectActivity, PhysicalProgress, TownList};
use App\Models\ProjectYearlyDisbursement;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDetail extends Model
{


    use HasFactory, SoftDeletes;

    protected $table = "project_details";

    protected $primaryKey = 'projectID';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        "projectID",
        "Name",
        "programID",
        "NameLong",
        "townID",
        "TownName",
        "Specification",
        "InitialTalksHeldWithClientAboutProjectIdeas",
        "ClientConsultedInProjectIdentificationSelection",
        "ClientProvidedWithStandardSetOfDocuments",
        "RequestForFinancingInclStudyReceivedOrAssessed",
        "BudgetEstimateForStudyCost",
        "DateOfApplicationReceived",
        "FirstStFieldVisitImplementedIfRequired",
        "PreAppraisalReportInitiated",
        "ClientDebtBearingCapacityAssessed",
        "ClientOnConditionsOfFinancingOfStudyAdviced",
        "PreAppraisalCompleted",
        "DateOfApplicationConfirmed",
        "DateOfProjectStop",
        "FT",
        "FP",
        "fiscal_year",
        "uses_sq_system",
    ];

    //need to remove FT FP we use ProjectDataSQ Modal

    public function program()
    {
        return $this->belongsTo(Program::class, "programID", "ID");
    }


    public function town()
    {
        return $this->belongsTo(TownList::class,"townID", "ID");
    }


    public function progress()
    {
        return $this->hasMany(PhysicalProgress::class, "project_id", "projectID");
    }


    public function lastProgress()
    {
        return $this->hasOne(PhysicalProgress::class, "project_id", "projectID")->latest();
    }


    public function projectActivity()
    {
        return $this->hasMany(ProjectActivity::class, "project_id", "projectID");
    }


    public function disbursement()
    {
        return $this->hasMany(DisbursementDetail::class, "ProjectID", "projectID");
    }


    public function lastDisbursement()
    {
        return $this->hasOne(DisbursementDetail::class, "ProjectID", "projectID")->latest("approved_date");
    }

    public function projectReview()
    {
        return $this->hasOne(ProjectReview::class, "project_id", "projectID");
    }

    public function projectYearlyDisbursement()
    {
        return $this->hasOne(ProjectYearlyDisbursement::class, "ProjectID", "projectID");
    }
    public function projectYearlyDisbursementSum()
    {
        return $this->hasMany(ProjectYearlyDisbursement::class, "project_id", "projectID")->select("date_year", "total")->distinct("date_year")->pluck("total")->sum();
    }

    public function projectDataSQ()
    {
        return $this->hasMany(ProjectDataSQ::class, "project_id", "projectID");
    }

    public function curentFiscialYearProjectDataSQ()
    {
        return $this->hasOne(ProjectDataSQ::class, "project_id", "projectID")->ofMany(
            [],
            function ($q) {
                $q->where('fiscal_year', FiscalYear::curentFiscalYear());
            }
        );
    }
    public function activityDetail()
    {
        return $this->hasMany(ActivityDetail::class, "projectID", "projectID");
    }
}
