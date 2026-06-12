<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    
    public function up(){

        Schema::create('activity_details', function(Blueprint $table){
            $table->id();
            $table->bigInteger("programID")->unsigned();
            $table->string("programName")->nullable();
            $table->bigInteger("projectID")->unsigned();
            $table->string("projectName")->nullable();
            $table->bigInteger("townId")->unsigned();
            $table->string("TownName")->nullable();
            $table->string("activityCode")->nullable();
            $table->string("Type")->nullable();
            $table->string("FinancingType")->nullable();
            // $table->string("ProjectName")->nullable();
            $table->string("DateOfSigningFinancialAgreementTDF")->nullable();
            $table->string("TDFMatchApproved")->nullable();
            $table->string("GoNMatchApproved")->nullable();
            $table->string("MunicipalityMatchApproved")->nullable();
            $table->string("UserCommitteeMatchApproved")->nullable();
            $table->string("EstimateTotal1")->nullable();
            $table->string("TDFMatchEstimate1")->nullable();
            $table->string("TDFMatchContracted")->nullable();
            $table->string("GoNMatchContracted")->nullable();
            $table->string("UserCommitteeMatchContracted")->nullable();
            $table->string("MunicipalityMatchContracted")->nullable();
            $table->string("ContractedTotal")->nullable();
            $table->string("DateOfStart")->nullable();
            $table->string("TdfPfsGrant")->nullable();
            $table->string("MunicipalityPfsContribution")->nullable();
            $table->string("GonPfsContribution")->nullable();
            $table->string("ApprovedTotal")->nullable();
            $table->string("TotalPfsCost")->nullable();

            $table->foreign("programID")
                    ->references("ID")
                    ->on("programs");

            $table->foreign("projectID")
                    ->references("projectID")
                    ->on("project_details");

            $table->foreign("townId")
                    ->references("ID")
                    ->on("town_lists");

        });

    }

    public function down(){
        Schema::dropIfExists('activity_details');
    }

};
