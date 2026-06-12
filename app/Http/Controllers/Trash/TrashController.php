<?php

namespace App\Http\Controllers\Trash;

use App\Helper\DisbursementFilter;
use App\Helper\FiscalYear;
use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Made for playground
 */

class TrashController extends Controller
{
    public function index()
    {
        // $project_ids = [1,2,5];
        // foreach ($project_ids as $project_id) {
        //     //-- remove
        //     ProjectDataSQ::where('project_id', $project_id)->delete();
        // }
        $project_ids = [];
        foreach (ProjectDataSQ::all() as $projectdatasq) {
            if ($projectdatasq->FT < $projectdatasq->approved_budget) {
                array_push($project_ids, $projectdatasq->project_id);
            }
        }
        return $project_ids;
        return view("trash.index",);
    }
}
