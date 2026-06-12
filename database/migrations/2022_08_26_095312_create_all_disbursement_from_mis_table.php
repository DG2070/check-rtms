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
        Schema::create('all_disbursement_from_mis', function (Blueprint $table) {
            $table->id("id");
            $table->bigInteger("ActivityID")->nullable()->default(null);
            $table->string("Date")->nullable()->default(null);
            $table->string("nepali_year")->nullable()->default(null);
            $table->string("nepali_month")->nullable()->default(null);
            $table->string("nepali_day")->nullable()->default(null);
            $table->string("Amount")->nullable()->default(null);
            $table->string("TransactionTypeID")->nullable()->default(null);
            $table->string("PaymentType")->nullable()->default(null);
            $table->string("Balance")->nullable()->default(null);
            $table->string("IsDisbursement")->nullable()->default(null);
            $table->string("IsRepayment")->nullable()->default(null);
            $table->string("IsIntCap")->nullable()->default(null);
            $table->string("MicrobankTransactionType")->nullable()->default(null);
            $table->string("SN")->nullable()->default(null);
            $table->string("Code")->nullable()->default(null);
            $table->string("ProjectName")->nullable()->default(null);
            $table->string("Name")->nullable()->default(null);
            $table->string("TownName")->nullable()->default(null);
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
        Schema::dropIfExists('all_disbursement_from_mis');
    }
};
