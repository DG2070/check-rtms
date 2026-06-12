<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('project_activities', function(Blueprint $table){
            $table->id();
            $table->bigInteger("project_id")->unsigned();
            $table->string("activity")->nullable();
            $table->string("main_responsibility")->nullable();
            $table->string("supportive_responsibility")->nullable();
            $table->string("remark")->nullable();
            $table->timestamps();

            $table->foreign("project_id")
                    ->references("projectID")
                    ->on("project_details");

        });

    }


    public function down(){
        Schema::dropIfExists('project_activities');
    }

};
