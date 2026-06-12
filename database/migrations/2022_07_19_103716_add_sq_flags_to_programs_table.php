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
        Schema::table('programs', function (Blueprint $table) {
            $table->string("fiscal_year")->nullable()->default(null);
            $table->boolean("uses_sq_system")->default(false);
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
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('fiscal_year');
            $table->dropColumn('uses_sq_system');
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
};
