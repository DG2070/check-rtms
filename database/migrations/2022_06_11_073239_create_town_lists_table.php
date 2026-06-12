<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::create('town_lists', function(Blueprint $table){
            $table->id("ID");
            $table->string("TownName")->nullable();
            $table->string("Province")->nullable();
            $table->string("District")->nullable();
            $table->string("district_code")->nullable();
            $table->string("mun_code")->nullable();
        });

    }


    public function down(){
        Schema::dropIfExists('town_lists');
    }


};
