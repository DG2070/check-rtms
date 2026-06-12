<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('project_details', function(Blueprint $table){
            $table->id("projectID");
            $table->bigInteger("programID")->unsigned();
            $table->string("Name")->nullable();
            $table->string("NameLong")->nullable();
            $table->bigInteger("townID")->unsigned();
            $table->string("TownName")->nullable();
            $table->string("Specification")->nullable();
            $table->string("InitialTalksHeldWithClientAboutProjectIdeas")->nullable();
            $table->string("ClientConsultedInProjectIdentificationSelection")->nullable();
            $table->string("ClientProvidedWithStandardSetOfDocuments")->nullable();
            $table->string("RequestForFinancingInclStudyReceivedOrAssessed")->nullable();
            $table->string("BudgetEstimateForStudyCost")->nullable();
            $table->string("DateOfApplicationReceived")->nullable();
            $table->string("FirstStFieldVisitImplementedIfRequired")->nullable();
            $table->string("PreAppraisalReportInitiated")->nullable();
            $table->string("ClientDebtBearingCapacityAssessed")->nullable();
            $table->string("ClientOnConditionsOfFinancingOfStudyAdviced")->nullable();
            $table->string("PreAppraisalCompleted")->nullable();
            $table->string("DateOfApplicationConfirmed")->nullable();
            $table->string("DateOfProjectStop")->nullable();

            $table->foreign("programID")
                    ->references("ID")
                    ->on("programs");

            $table->foreign("townID")
                    ->references("ID")
                    ->on("town_lists");

        });

    }


    public function down(){
        Schema::dropIfExists('project_details');
    }

};
