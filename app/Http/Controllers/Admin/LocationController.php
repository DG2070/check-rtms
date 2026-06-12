<?php

namespace App\Http\Controllers\Admin;

use App\Helper\FunctionUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TownList;


class LocationController extends Controller{


    public function index(Request $request){

        $data["locations"] = TownList::select(["TownName", "Province", "District"])->get();        

        return view('admin.locations.index', $data);

    }

}
