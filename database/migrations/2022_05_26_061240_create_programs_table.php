<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('programs', function(Blueprint $table){
            $table->id('ID');
            $table->string("Name")->nullable();
            $table->string("NameLong")->nullable();
            $table->string("Code")->nullable();
            $table->string("FinancingAgency")->nullable();
            $table->string("DateOfAgreementAdjustment")->nullable();
            $table->string("FundLoan")->nullable();
            $table->string("FundSoftLoan")->nullable();
            $table->string("FundGrant")->nullable();
            $table->string("InterestForAdministration")->nullable();
            $table->string("ServiceChargeStudy")->nullable();
            $table->string("ServiceChargeConstruction")->nullable();
            $table->string("ServiceChargeSupervision")->nullable();
            $table->string("DateOfFinancingAgreement")->nullable();
            $table->string("DateOfFundsDisbursed")->nullable();
            $table->string("ProgrammeInterest")->nullable();
            $table->string("ProgrammeCapitalisation")->nullable();
            $table->string("ProgrammeMaturity")->nullable();
            $table->string("ProgrammeConstantAnnuity")->nullable();
            $table->string("ProgrammeGracePeriod")->nullable();
            $table->string("LoanActivityInterest")->nullable();
            $table->string("LoanActivityCapitalisation")->nullable(); 
            $table->string("LoanActivityMaturityMin")->nullable(); 
            $table->string("LoanActivityMaturityMax")->nullable(); 
            $table->string("LoanActivityConstantAnnuity")->nullable(); 
            $table->string("LoanActivityGracePeriodMin")->nullable(); 
            $table->string("LoanActivityGracePeriodMax")->nullable(); 
            $table->string("SoftLoanActivityInterest")->nullable(); 
            $table->string("SoftLoanActivityCapitalisation")->nullable(); 
            $table->string("SoftLoanActivityMaturityMin")->nullable(); 
            $table->string("SoftLoanActivityMaturityMax")->nullable(); 
            $table->string("SoftLoanActivityConstantAnnuity")->nullable(); 
            $table->string("SoftLoanActivityGracePeriodMin")->nullable(); 
            $table->string("SoftLoanActivityGracePeriodMax")->nullable(); 
            $table->string("ProgrammePeriod")->nullable(); 
            $table->string("ProgrammeFundAllocation")->nullable(); 
            $table->string("FundsAllocatedInForeignCurrency")->nullable(); 
            $table->string("FundsAllocatedInLocalCurrency")->nullable(); 
            $table->string("ProgrammeFundAllocationStructure")->nullable(); 
            $table->string("FundsAllocatedAsGrantsInLocalCurrency")->nullable(); 
            $table->string("ProgrammeFundUtilizationStructure")->nullable(); 
            $table->string("TdfLoansForConstructionActivities")->nullable(); 
            $table->string("TdfSoftLoansForConstructionActivities")->nullable(); 
            $table->string("TdfGrantsForConstructionActivities")->nullable(); 
            $table->string("LossProvisionForTdfLoans")->nullable(); 
            $table->string("InstallmentsPerYear")->nullable(); 
            $table->string("Loaninstallments")->nullable(); 
            $table->string("Softloaninstallments")->nullable(); 
            $table->string("Currency")->nullable();
            $table->string("TemplateID")->nullable(); 
            $table->string("grantfund")->nullable(); 
            $table->string("studygrantfund")->nullable();
            $table->string("supervisiongrantfund")->nullable(); 
            $table->string("constructiongrantfund")->nullable(); 
            $table->string("loanfund")->nullable(); 
            $table->string("softloanfund")->nullable(); 
            $table->string("CreatedDate")->nullable();
            $table->string("UpdatedDate")->nullable();
        });

    }


    public function down(){
        Schema::dropIfExists('programs');
    }

};
