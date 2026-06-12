<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Jobs\MakeFetchAllApiData;
use App\Jobs\MakeFetchAndAllDisburmentFromMisRequest;
use App\Trait\LoadDataFromServer;
use App\Trait\LoadDisbursementFromServer;
use Illuminate\Http\Request;

class SettingsApiController extends Controller
{
    use LoadDataFromServer, LoadDisbursementFromServer;

    public function index()
    {
        return view("settings.api.index");
    }

    public function fetchTdfData()
    {
        // $this->allApiData();
        MakeFetchAllApiData::dispatch();

        return redirect()->back()->with("success-v2", "TDF Data Syn Started");
    }
    public function fetchAllDisbursementData()
    {
        // return  $this->actualMisDisbursementDataWithDateMonthYear();
        MakeFetchAndAllDisburmentFromMisRequest::dispatch();

        return redirect()->back()->with("success-v2", "Disbursement Data Sync Started");
    }
}
