<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_data_s_q_s', function (Blueprint $table) {
            $table->string("physical_progress")->nullable()->default(null)->after("approved_budget");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_data_s_q_s', function (Blueprint $table) {
            $table->dropColumn('physical_progress');
        });
    }
};
