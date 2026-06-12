<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Helper\DateConverter;
use Illuminate\Bus\Queueable;
use App\Models\AllDisbursementFromMis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UploadDisbursementInBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $disbursements)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //-- Increase memory limit
        ini_set('memory_limit', '256M');

        foreach ($this->disbursements as $disbursement) {
            //check if already in table
            if (
                AllDisbursementFromMis::where("ActivityID", $disbursement["ActivityID"])
                    ->where("ActivityID", $disbursement["ActivityID"])
                    ->where("Date", $disbursement["Date"])
                    ->where("Amount", $disbursement["Amount"])
                    ->where("TransactionTypeID", $disbursement["TransactionTypeID"])
                    ->where("PaymentType", $disbursement["PaymentType"])
                    ->where("Balance", $disbursement["Balance"])
                    ->count() == 0
            ) {

                //convert english date to nepali date

                $disbursement_date = Carbon::parse($disbursement["Date"]);
                $nepali_date = DateConverter::fromEnglishDate(
                    $disbursement_date->year,
                    $disbursement_date->month,
                    $disbursement_date->day,
                )->toNepaliDateArray();

                $disbursement["nepali_year"] = $nepali_date["year"];
                $disbursement["nepali_month"] = $nepali_date["month"];
                $disbursement["nepali_day"] = $nepali_date["day"];

                AllDisbursementFromMis::insert([$disbursement]);
            }
        }
    }
}
