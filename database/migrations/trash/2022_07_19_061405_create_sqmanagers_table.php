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
        Schema::create('sqmanagers', function (Blueprint $table) {
            $table->id();
            $table->string("fiscal_year");
            $table->bigInteger("program_id")->nullable()->default(null);
            $table->bigInteger("project_id")->nullable()->default(null);
            $table->boolean("used_sq_system")->default(true);
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
        Schema::dropIfExists('sqmanagers');
    }
};
