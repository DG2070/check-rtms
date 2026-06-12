<?php

namespace App\Http\Controllers\Playground;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProjectDataSQ;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Jobs\UploadDisbursementInBatch;

class PlaygroundController extends Controller
{
    public function playgrounOne()
    {


        return $this->toCheckApprovedDataAndFTMismatch();


        // try {
        //     $this->makeFetchAllDisbursement();
        // } catch (\Throwable $th) {
        //     Log::debug($th);
        //     report($th);
        // }
    }


    function toCheckApprovedDataAndFTMismatch()
    {
        $data = [];
        $project_data_sq = ProjectDataSQ::with([
            'project' => function ($query) {
                $query->select('projectID', 'Name', 'programID');
            },
            'project.program' => function ($query) {
                $query->select('ID', 'Name', 'NameLong');
            }
        ])->where(function ($query) {
            $query->where('fiscal_year', '80/81');
        })
            ->get();

        foreach ($project_data_sq as $item) {
            if ($item->approved_budget != $item->FT) {
                array_push($data, $item);
            }
        }
        return $data;
    }


    protected function makeFetchAllDisbursement()
    {
        $end_year = Carbon::now()->year . "-" . Carbon::now()->month . "-" . Carbon::now()->day;
        $url = "http://tdf.softavi.com/api/tdf_data/getTdfDisbursementDatabydate?username=tdf_apiuser&password=tdF@piUs3r2o22&start=1800-04-01&end=" . $end_year;
        // Log::debug($url);
        // return;
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
            ->get($url);
        $disbursement = $response->json($key = null);


        //*****************************************************/

        // $disbursements = collect($disbursement["disbursment_bydate"]);

        foreach (collect($disbursement["disbursment_bydate"])->chunk(100) as $disbursements) {
            // return gettype($disbursements);
            //-- Dispatch Job with delay of x seconds
            UploadDisbursementInBatch::dispatch($disbursements)->delay(now()->addRealSeconds(5));
        }
    }
}
