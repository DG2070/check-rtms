<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ProjectDetail, ActivityDetail};

use Illuminate\Database\Eloquent\SoftDeletes;


class Program extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = "programs";

    public $incrementing = false;
    public $primaryKey = "ID";



    protected $fillable = [
        "ID",
        "Name",
        "NameLong",
        "Code",
        "FinancingAgency",
        "DateOfAgreementAdjustment",
        "FundLoan",
        "FundSoftLoan",
        "FundGrant",
        "InterestForAdministration",
        "ServiceChargeStudy",
        "ServiceChargeConstruction",
        "ServiceChargeSupervision",
        "DateOfFinancingAgreement",
        "DateOfFundsDisbursed",
        "ProgrammeInterest",
        "ProgrammeCapitalisation",
        "ProgrammeMaturity",
        "ProgrammeConstantAnnuity",
        "ProgrammeGracePeriod",
        "LoanActivityInterest",
        "LoanActivityCapitalisation",
        "LoanActivityMaturityMin",
        "LoanActivityMaturityMax",
        "LoanActivityConstantAnnuity",
        "LoanActivityGracePeriodMin",
        "LoanActivityGracePeriodMax",
        "SoftLoanActivityInterest",
        "SoftLoanActivityCapitalisation",
        "SoftLoanActivityMaturityMin",
        "SoftLoanActivityMaturityMax",
        "SoftLoanActivityConstantAnnuity",
        "SoftLoanActivityGracePeriodMin",
        "SoftLoanActivityGracePeriodMax",
        "ProgrammePeriod",
        "ProgrammeFundAllocation",
        "FundsAllocatedInForeignCurrency",
        "FundsAllocatedInLocalCurrency",
        "ProgrammeFundAllocationStructure",
        "FundsAllocatedAsGrantsInLocalCurrency",
        "ProgrammeFundUtilizationStructure",
        "TdfLoansForConstructionActivities",
        "TdfSoftLoansForConstructionActivities",
        "TdfGrantsForConstructionActivities",
        "LossProvisionForTdfLoans",
        "InstallmentsPerYear",
        "Loaninstallments",
        "Softloaninstallments",
        "Currency",
        "TemplateID",
        "grantfund",
        "studygrantfund",
        "supervisiongrantfund",
        "constructiongrantfund",
        "loanfund",
        "softloanfund",
        "CreatedDate",
        "UpdatedDate",

        "fiscal_year",
        "uses_sq_system",
    ];


    public function project()
    {
        return $this->hasMany(ProjectDetail::class, "programID", "ID");
    }


    public function activity()
    {
        return $this->hasMany(ActivityDetail::class, "programID");
    }
}
