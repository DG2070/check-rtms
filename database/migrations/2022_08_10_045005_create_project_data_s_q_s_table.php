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
        Schema::create('project_data_s_q_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("project_id");
            $table->string("fiscal_year")->nullable()->default(null);
            $table->string("approved_budget")->nullable()->default(null);
            $table->string('FT')->nullable()->default(null);
            $table->string('FP')->nullable()->default(null);
            $table->string('PT')->nullable()->default(null);
            $table->string('PP')->nullable()->default(null);
            $table->boolean('is_locked')->default(false);
            $table->bigInteger('locked_by_user_id')->nullable()->default(null);
            $table->string('locked_at')->nullable()->default(null);
            $table->softDeletes();
            $table->bigInteger('deleted_by_user_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_data_s_q_s');
    }
};
