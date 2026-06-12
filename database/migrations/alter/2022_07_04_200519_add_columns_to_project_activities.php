<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(){

        Schema::table('project_activities', function (Blueprint $table){
            $table->string('pme_main_responsibility')->nullable()->after("remark");
            $table->string('pme_supportive_responsibility')->nullable()->after("pme_main_responsibility");
        });

    }

    public function down(){
        Schema::table('project_activities', function (Blueprint $table){
            $table->dropColumn('pme_main_responsibility');
            $table->dropColumn('pme_supportive_responsibility');
        });
    }

};
