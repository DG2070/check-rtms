<?php

namespace App\Http\Controllers\Settings\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\UserDivision;
use App\Models\UserSection;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index()
    {
        $data["departments"] =  Department::whereNot("name", "")->get();
        return view("settings.department.index", [
            "departments" => $data["departments"]
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        // check if already in db
        if (Department::where("name", $request->name)->exists()) {
            toastr()->error("Department Already Exists");
            return redirect()->back();
        }
        Department::create(['name' => $request->name]);

        return redirect()->route("settings.department.index")->with('success-v2', 'Created successfully');
    }
    public function update(Request $request, Department $department)
    {
        // check if already in db
        if (Department::where("name", $request->name)->exists()) {
            toastr()->error("Department Already Exists");
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required'
        ]);
        $department->name =  $request->name;
        $department->save();
        return redirect()->route("settings.department.index")->with('success-v2', 'Updated successfully');
    }
    public function delete(Department $department)
    {
        $department->delete();
        return redirect()->route("settings.department.index")->with('success-v2', 'Deleted successfully');
    }


    public function singleDepartment($department_id)
    {
        $department = Department::find($department_id);
        if ($department) {
            $data["divisons"] =  UserDivision::where('department_id', $department_id)->whereNot("name", "")->get();
            return view("settings.department.division.index", [
                "department" => $department,
                "divisons" => $data["divisons"]
            ]);
        }

        return redirect()->route('home');
    }

    public function addNewDivison($department_id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        //check department
        $department = Department::find($department_id);
        if (!$department) {
            return redirect()->route("settings.department.index")->with('error-v2', 'Departments not found');
        }

        // check if already in db
        if (UserDivision::where("name", $request->name)->exists()) {
            toastr()->error("Division Name Already Exists");
            return redirect()->back();
        }
        UserDivision::create([
            'department_id' => $department_id,
            'name' => $request->name,
        ]);

        return redirect()->route("settings.department.divison.index", [$department_id])->with('success-v2', 'Created successfully');
    }


    public function deleteDivison($department_id, UserDivision $divison)
    {
        $divison->delete();
        return redirect()->route("settings.department.divison.index", [$department_id])->with('success-v2', 'Deleted successfully');
    }

    public function singleSection(Department $department, UserDivision $userdivison)
    {

        $data["usersections"] =  UserSection::where('department_id', $department->id)
            ->where('division_id', $userdivison->id)
            ->whereNot("name", "")->get();

        return view("settings.department.division.section.index", [
            "department" => $department,
            "userdivison" => $userdivison,
            "usersections" => $data["usersections"]
        ]);
    }
    public function addNewSection(Department $department, UserDivision $userdivison, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        // check if already in db
        if (UserSection::where("name", $request->name)->exists()) {
            toastr()->error("Section Name Already Exists");
            return redirect()->back();
        }

        UserSection::create([
            'department_id' => $department->id,
            'division_id' => $userdivison->id,
            'name' => $request->name,
        ]);

        return redirect()->route("settings.department.divison.section.index", [$department, $userdivison])->with('success-v2', 'Created successfully');
    }
    public function deleteSection(Department $department, UserDivision $userdivison, UserSection $usersection)
    {
        $usersection->delete();
        return redirect()->route("settings.department.divison.section.index", [$department, $userdivison])->with('success-v2', 'Deleted successfully');
    }
}
