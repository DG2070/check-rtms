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
            $table->bigInteger('approved_budget')->change();
            $table->bigInteger('FT')->change();
            $table->bigInteger('FP')->change();
            $table->bigInteger('PT')->change();
            $table->bigInteger('PP')->change();
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
            //
        });
    }
};
