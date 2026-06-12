<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    
    public function up(){

        Schema::create('program_yearly_disbursements', function(Blueprint $table){
            $table->id("id");
            $table->bigInteger("program_id")->unsigned();
            $table->string("program_name")->nullable();
            $table->string("date_year")->nullable();
            $table->string("loan")->nullable();
            $table->string("loan_pc")->nullable();
            $table->string("softloan")->nullable();
            $table->string("softloan_pc")->nullable();
            $table->string("grants")->nullable();
            $table->string("grant_pc")->nullable();
            $table->string("total")->nullable();
            $table->string("total_pc")->nullable();

            $table->foreign("program_id")
                    ->references("ID")
                    ->on("programs");

        });

    }

    
    public function down(){
        Schema::dropIfExists('program_yearly_disbursements');
    }

};
