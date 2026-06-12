<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\ActivityDetail;
use App\Models\Program;
use App\Models\ProjectDetail;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(SearchRequest $request)
    {

        // return ActivityDetail::where(
        //     "Name",
        //     'LIKE',
        //     '%' . $request->search_query . '%'
        // )
        //     ->orWhere("NameLong", 'LIKE', '%' . $request->search_query . '%')
        //     ->orWhere("TownName", 'LIKE', '%' . $request->search_query . '%')
        //     ->orWhere("Specification", 'LIKE', '%' . $request->search_query . '%')
        //     ->select(["projectID", "Name", "NameLong", "TownName", "Specification"])
        //     ->get();
        $search_datas = [];
        //seach in programs
        foreach (Program::where(
            "Name",
            'LIKE',
            '%' . $request->search_query . '%'
        )
            ->orWhere("Code", 'LIKE', '%' . $request->search_query . '%')
            ->orWhere("NameLong", 'LIKE', '%' . $request->search_query . '%')
            ->orWhere("FinancingAgency", 'LIKE', '%' . $request->search_query . '%')
            ->orWhere(
                "CreatedDate",
                'LIKE',
                '%' . $request->search_query . '%'
            )
            ->orWhere(
                "UpdatedDate",
                'LIKE',
                '%' . $request->search_query . '%'
            )
            ->select(["ID", "Name", "NameLong", "Code", "FinancingAgency"])
            ->get() as $program) {
            array_push($search_datas, [
                "type_field" => "program",
                "data" => $program->toArray()
            ]);
        }

        //Search in projects
        foreach (ProjectDetail::where(
                "Name",
                'LIKE',
                '%' . $request->search_query . '%'
            )
            ->orWhere("NameLong", 'LIKE', '%' . $request->search_query . '%')
            ->orWhere("TownName", 'LIKE', '%' . $request->search_query . '%')
            ->orWhere(
                "Specification",
                'LIKE',
                '%' . $request->search_query . '%'
            )
            ->select(["projectID", "programID", "Name", "NameLong", "TownName", "Specification"])
            ->get() as $project) {
            array_push($search_datas, [
                "type_field" => "project",
                "data" => $project->toArray()
            ]);
        }

        // return $search_datas;
        return view(
            "admin.search.index",
            ["search_datas" => $search_datas]
        );
    }
}
