<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Helper\DateConverter;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 *  All disbursement data as per MIS (along with exact day,month,year of disbursement)
 *  it wont duplicate system table/db with old data
 *  pulls data till date
 *
 * Author:Kishor Shrestha (winneecreztha@gmail.com)
 */

class MakeFetchAndAllDisburmentFromMisRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;

    protected string $apiEndpoint;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $end_year = Carbon::now()->year . "-" . Carbon::now()->month . "-" . Carbon::now()->day;
        $this->apiEndpoint = env('MIS_URL', 'http://mis.tdf.org.np')."/api/tdf_data/getTdfDisbursementDatabydate?username=tdf_apiuser&password=tdF@piUs3r2o22&start=1800-04-01&end=" . $end_year;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //-- Increase memory limit
            ini_set('memory_limit', '256M');

            //-- Fetch Disbursement Data
            $response = Http::withoutVerifying()
                ->withOptions([
                    'verify' => false,
                    'config' => [
                        // 'cookies' => true,
                        'curl' => [
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_SSL_VERIFYPEER => false
                        ]
                    ]
                ])
                ->get($this->apiEndpoint);
            $disbursement = $response->json($key = null);

            //*****************************************************/
            foreach (collect($disbursement["disbursment_bydate"])->chunk(100) as $disbursements) {
                //-- Dispatch Job with delay of x seconds
                UploadDisbursementInBatch::dispatch($disbursements)->delay(now()->addRealSeconds(5));
            }
        } catch (\Throwable $th) {
            report($th);
        }
    }
}