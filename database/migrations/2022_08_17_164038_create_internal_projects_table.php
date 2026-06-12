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
        Schema::create('internal_projects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("fiscal_year")->nullable()->default(null);
            $table->bigInteger('created_by_user_id')->nullable()->default(null);
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
        Schema::dropIfExists('internal_projects');
    }
};
