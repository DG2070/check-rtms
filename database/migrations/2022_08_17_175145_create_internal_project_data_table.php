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
        Schema::create('internal_project_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("internal_project_id");
            $table->string("fiscal_year")->nullable()->default(null);
            $table->string("approved_budget")->nullable()->default(null);
            $table->longText("activity_milestone")->nullable()->default(null);
            $table->string("performance_indicator")->nullable()->default(null);
            $table->json("main_responsibility")->nullable()->default(null);
            $table->json("supportive_responsibility")->nullable()->default(null);
            $table->string("remark")->nullable()->default(null);
            $table->string("is_text")->nullable()->default(null);


            $table->json("timeline_target")->nullable()->default(null);
            $table->json("timeline_progress")->nullable()->default(null);
            $table->json("timeline_remarks")->nullable()->default(null);

            $table->string("progress")->nullable()->default(null);
            $table->string("pme_target_review")->nullable()->default(null);
            $table->string("pme_target_remarks")->nullable()->default(null);

            $table->bigInteger('created_by_user_id')->nullable()->default(null);

            $table->boolean('is_locked')->default(false);
            $table->bigInteger('locked_by_user_id')->nullable()->default(null);
            $table->string('locked_at')->nullable()->default(null);

            $table->bigInteger('deleted_by_user_id')->nullable()->default(null);
            $table->softDeletes();
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
        Schema::dropIfExists('internal_project_data');
    }
};
