<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('physical_progress', function(Blueprint $table){
            $table->id();
            $table->bigInteger("project_id")->unsigned();
            $table->json("visitor_details")->nullable();
            $table->string("from_date")->nullable();
            $table->string("to_date")->nullable();
            $table->string("current_status")->nullable();
            $table->string("authority_name")->nullable();
            $table->string("authority_email")->nullable();
            $table->string("authority_contact")->nullable();
            $table->longText("activity_performed")->nullable();
            $table->string("physical_progress")->nullable();
            $table->json("document_uploads")->nullable();
            $table->timestamps();

            $table->foreign("project_id")
                    ->references("projectID")
                    ->on("project_details");

        });

    }


    public function down(){
        Schema::dropIfExists('physical_progress');
    }
    
};
