<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('milestones', function(Blueprint $table){
            $table->id();
            $table->bigInteger("project_activity_id")->unsigned();
            $table->string("milestone")->nullable();
            $table->string("performance_indicator")->nullable();
            $table->string("is_text")->nullable();
            $table->timestamps();

            $table->foreign("project_activity_id")
                    ->references("id")
                    ->on("project_activities");

        });

    }


    public function down(){
        Schema::dropIfExists('milestones');
    }

};
