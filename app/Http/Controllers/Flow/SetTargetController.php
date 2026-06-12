<?php

namespace App\Http\Controllers\Flow;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\ProjectActivity;
use App\Models\ProjectDataSQ;
use App\Models\ProjectReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetTargetController extends Controller
{
    public function lockTarget(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
        ]);

        $data = [
            "is_locked" => true,
            "locked_by_user_id" => Auth::id(),
            "locked_at" => Carbon::now(),
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Locked Succesfully');
    }
    public function unLockTarget(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
        ]);

        $data = [
            "is_locked" => false,
            "locked_by_user_id" => null,
            "locked_at" => null,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Unlocked Succesfully');
    }
    public function addBudget(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
            'approved_budget' => 'required',
        ]);

        $data = [
            "approved_budget" => $request->approved_budget,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Budget Updated Succesfully');
    }
    public function addApprovedCost(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
            'approved_cost' => 'required',
        ]);

        $data = [
            "approved_cost" => $request->approved_cost,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Updated Succesfully');
    }

    public function addContractualCost(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
            'contractual_cost' => 'required',
        ]);

        $data = [
            "contractual_cost" => $request->contractual_cost,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Updated Succesfully');
    }
    public function addAggrementDate(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
            'aggrement_date' => 'required',
        ]);

        $data = [
            "aggrement_date" => $request->aggrement_date,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Updated Succesfully');
    }

    public function addPhysicalProgress(Request $request)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
            'project_id' => 'required',
            'physical_progress' => 'required',
        ]);

        $data = [
            "physical_progress" => $request->physical_progress,
        ];
        ProjectDataSQ::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'fiscal_year' => $request->fiscal_year
            ],
            $data
        );

        return redirect()->back()->with('success-v2', 'Updated Succesfully');
    }

    public function deleteActivity($activity_id)
    {

        if (!Auth::user()->can(["Set Target"])) {
            toastr()->error("You dont have required access");
            return redirect()->route("home");
        }

        //check if all milestones are deleted
        if (Milestone::where("project_activity_id", $activity_id)->count() > 0) {
            return redirect()->back()
                ->with('error', 'All milestones need to be deleted !');
        }

        ProjectActivity::find($activity_id)->delete();
        Milestone::where("project_activity_id", $activity_id)->delete();

        return redirect()->back()
            ->with('success', 'Activity deleted successfully');
    }
    public function deleteMilestone($milestone_id)
    {

        if (!Auth::user()->can(["Set Target"])) {
            toastr()->error("You dont have required access");
            return redirect()->route("home");
        }

        Milestone::find($milestone_id)->delete();

        return redirect()->back()
            ->with('success', 'Milestone deleted successfully');
    }


    public function deleteAllProjectData(Request $request)
    {

        if (!Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'ED'])) {
            toastr()->error("You dont have required access");
            return redirect()->route("home");
        }

        $this->validate($request, [
            'project_id' => 'required',
        ]);

        //-- only if all milestones are removed
        //check if all milestones are deleted
        if (ProjectActivity::where("project_id", $request->project_id)->count() > 0) {
            return redirect()->back()
                ->with('error', 'All activity & milestones need to be deleted !');
        }


        ProjectActivity::where('project_id',   $request->project_id)->delete();
        ProjectDataSQ::where('project_id',   $request->project_id)->delete();
        ProjectReview::where('project_id',   $request->project_id)->delete();





        return redirect()->back()->with('success-v2', 'Deleted Succesfully');
    }
}
