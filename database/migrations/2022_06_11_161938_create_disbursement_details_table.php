<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('disbursement_details', function(Blueprint $table){
            $table->id("ID");
            $table->bigInteger("ProjectID")->unsigned();
            $table->string("Code")->nullable();
            $table->string("FinancingType")->nullable();
            $table->string("Name")->nullable();
            $table->bigInteger("ProgrammeID")->unsigned();
            $table->string("Stopped")->nullable();
            $table->string("DateOfSigningFinancialAgreementBoard")->nullable();
            $table->string("approved_date")->nullable();
            $table->string("Disbursement")->nullable();
            $table->string("DisbursementPercentage")->nullable();
            $table->bigInteger("townID")->unsigned();
            $table->string("TDFContractedCost")->nullable();
            $table->string("TDFMatchApproved")->nullable();

            $table->foreign("projectID")
                    ->references("projectID")
                    ->on("project_details");

            $table->foreign("ProgrammeID")
                    ->references("ID")
                    ->on("programs");

            $table->foreign("townId")
                    ->references("ID")
                    ->on("town_lists");

        });

    }


    public function down(){
        Schema::dropIfExists('disbursement_details');
    }

};
