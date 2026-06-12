<?php

namespace App\Http\Controllers\Settings\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
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
        $data["permissions"] =  Permission::orderBy("created_at")->get();
        return view("settings.permissions.index", [
            "permissions" => $data["permissions"]
        ]);
    }
    public function storePermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        // check if permission already exists
        if (Permission::where("name", $request->name)->exists()) {
            toastr()->error("Permission already exists");
            return redirect()->back();
        }
        Permission::create(['name' => $request->name]);

        return redirect()->route("settings.permission.index")->with('success-v2', 'Created successfully');;
    }
    public function updatePermission(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $permission->name =  $request->name;
        $permission->save();
        return redirect()->route("settings.permission.index")->with('success-v2', 'Updated successfully');;
    }
    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->route("settings.permission.index")->with('success-v2', 'Deleted successfully');;
    }
}
