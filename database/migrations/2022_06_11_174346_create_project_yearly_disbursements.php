<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('project_yearly_disbursements', function(Blueprint $table){
            $table->id("id");
            $table->bigInteger("prog_id")->unsigned();
            $table->bigInteger("project_id")->unsigned();
            $table->string("project_name")->nullable();
            $table->string("date_year")->nullable();
            $table->string("loan")->nullable();
            $table->string("loan_pc")->nullable();
            $table->string("softloan")->nullable();
            $table->string("softloan_pc")->nullable();
            $table->string("grants")->nullable();
            $table->string("grant_pc")->nullable();
            $table->string("total")->nullable();
            $table->string("total_pc")->nullable();

            $table->foreign("prog_id")
                    ->references("ID")
                    ->on("programs");

            $table->foreign("project_id")
                    ->references("projectID")
                    ->on("project_details");

        });

    }


    public function down(){
        Schema::dropIfExists('project_yearly_disbursements');
    }

};
