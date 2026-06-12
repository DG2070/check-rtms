<?php

namespace App\Http\Controllers\Settings\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (!Auth::user()->hasAnyRole(['Sysqube-Super-Admin'])) {
                toastr()->error("You dont have required access");
                return redirect()->route("home");
            }
            return $next($request);
        });
    }
    public function index()
    {
        $data["roles"] =  Role::whereNot("name", "")->get();
        return view("settings.role.index", [
            "roles" => $data["roles"]
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        // check if already in db
        if (Role::where("name", $request->name)->exists()) {
            toastr()->error("Role Already Exists");
            return redirect()->back();
        }
        Role::create(['name' => $request->name]);

        return redirect()->route("settings.role.index")->with('success-v2', 'Created successfully');
    }
    public function update(Request $request, Role $role)
    {
        if ($role->name == "Super-Admin" || $role->name == "Sysqube-Super-Admin") {
            toastr()->error("Unable to do that");
            return redirect()->back();
        }
        // check if already in db
        if (Role::where("name", $request->name)->exists()) {
            toastr()->error("Role Already Exists");
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required'
        ]);
        $role->name =  $request->name;
        $role->save();
        return redirect()->route("settings.role.index")->with('success-v2', 'Updated successfully');
    }
    public function delete(Role $role)
    {
        if ($role->name == "Super-Admin" || $role->name == "Sysqube-Super-Admin") {
            toastr()->error("Unable to do that");
            return redirect()->back();
        }
        $role->delete();
        return redirect()->route("settings.role.index")->with('success-v2', 'Deleted successfully');
    }
}
