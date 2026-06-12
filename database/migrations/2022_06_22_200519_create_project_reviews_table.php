<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('project_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_id");
            $table->json("progress");
            $table->json("target");
            $table->json("remarks");
            $table->timestamps();

            $table->foreign("project_id")
                    ->references("projectID")
                    ->on("project_details");
        });

    }

    public function down(){
        Schema::dropIfExists('project_reviews');
    }

};
