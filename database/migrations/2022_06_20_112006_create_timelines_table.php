<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("milestone_id")->unsigned();
            $table->json("timeline")->nullable();
            $table->timestamps();

            $table->foreign("milestone_id")
                ->references("id")
                ->on("milestones");
        });

    }


    public function down(){
        Schema::dropIfExists('timelines');
    }

};
