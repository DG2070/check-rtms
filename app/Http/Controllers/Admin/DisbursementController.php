<?php

namespace App\Http\Controllers\Admin;

use App\Helper\FunctionUtils;
use App\Http\Controllers\Controller;
use App\Models\AllDisbursementFromMis;
use Illuminate\Http\Request;
use App\Models\DisbursementDetail;


class DisbursementController extends Controller
{


    public function disbursementsIndex(Request $request)
    {

        // search_query
        if ($request->has('search_query') && $request->search_query != '') {
            $disbursements = AllDisbursementFromMis::where(
                "ActivityID",
                'LIKE',
                '%' . $request->search_query . '%'
            )
                ->orWhere("Date", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("nepali_year", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("Code", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("ProjectName", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("Name", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("TownName", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("MicrobankTransactionType", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("TransactionTypeID", 'LIKE', '%' . $request->search_query . '%')
                ->orWhere("Amount", 'LIKE', '%' . $request->search_query . '%')
                ->orderByDesc("Date")->paginate(50);
        } else {

            $disbursements = AllDisbursementFromMis::orderByDesc("Date")->paginate(50);
        }

        return view("admin.disbursements.index", [
            "disbursements" => $disbursements

        ]);
    }
    // public function index(Request $request){

    //     // $all_data = FunctionUtils::allApiData();
    //     // $disbursements = FunctionUtils::getApiDisbursements($all_data);

    //     $data["disbursements"] = DisbursementDetail::select(["Code", "approved_date", "Disbursement", "DisbursementPercentage"])
    //                                                 ->get();

    //     if($request->has('activity') && $request->activity != ''):
    //         $disbursements = collect($data["disbursements"])->where('Code', $request->activity)->toArray();
    //     endif;

    //     return view("admin.disbursements.index", compact("data"));

    // }


    public function physicalProgress(Request $request)
    {

        return view("admin.progress.physical-progress");
    }


    public function programReportPerformanceport(Request $request)
    {

        return view("admin.progress.program-report-performance");
    }


    public function progressReportPerformance(Request $request)
    {

        return view("admin.progress.progress-report-performance");
    }


    public function programReportInput(Request $request)
    {

        return view("admin.progress.program-report-input");
    }


    public function progressReprogressReportInput(Request $request)
    {

        return view("admin.progress.progress-report-input");
    }
}
