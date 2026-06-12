<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {

        $permission = Permission::get();
        $roles = Role::orderBy('id', 'DESC')->whereNot("id", 1)->paginate(10);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->title = explode('-', $permission->name)[0];
            // $permission->sub_title = explode('-', $permission->name)[1];
        }
        $grouped_permissions = $permissions->groupBy('title');
        return view('roles.create', compact('grouped_permissions'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        if ($id == 1) {
            toastr()->error("You can't edit this role");
            return redirect()->back();
        }
        $role = Role::find($id);
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->title = explode('-', $permission->name)[0];
            $permission->sub_title = explode('-', $permission->name)[1];
        }
        $grouped_permissions = $permissions->groupBy('title');
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'grouped_permissions', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        if ($id == 1) {
            toastr()->error("You can't edit this role");
            return redirect()->back();
        }
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        if ($id == 1) {
            toastr()->error("You can't edit this role");
            return redirect()->back();
        }
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
