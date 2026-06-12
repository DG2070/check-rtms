<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    
    public function up(){

        Schema::create('program_disbursement_summary', function(Blueprint $table){
            $table->id("id");
            $table->bigInteger("program_id")->unsigned();
            $table->string("program_name")->nullable();
            $table->string("total_disbursement_amount")->nullable();
            $table->string("total_principal_amount")->nullable();
            $table->string("total_interest_amount")->nullable();

            $table->foreign("program_id")
                    ->references("ID")
                    ->on("programs");
        });

    }

    
    public function down(){
        Schema::dropIfExists('program_disbursement_summary');
    }

};
