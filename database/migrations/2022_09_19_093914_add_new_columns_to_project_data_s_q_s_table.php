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
            $table->string("approved_cost")->nullable()->default(null)->after('PP');
            $table->string("contractual_cost")->nullable()->default(null)->after('approved_cost');
            $table->string("aggrement_date")->nullable()->default(null)->after('contractual_cost');
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
            $table->dropColumn('approved_cost');
            $table->dropColumn('contractual_cost');
            $table->dropColumn('aggrement_date');
        });
    }
};
