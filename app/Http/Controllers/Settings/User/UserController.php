<?php

namespace App\Http\Controllers\Settings\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\UserDivision;
use App\Models\UserSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index()
    {
        $data["users"] =  User::with(["departments", "roles", "permissions"])
            ->whereNotIn("email", ["admin@sysqube.com", "root@tdf.org.np"])
            ->get();

        return view("settings.user.index", [
            "users" => $data["users"]
        ]);
    }
    public function add()
    {
        $data["departments"] =  Department::get();
        $data["divisons"] =  UserDivision::get();
        $data["sections"] =  UserSection::get();
        $data["roles"] =  Role::whereNotIn("name", ["Super-Admin", "Sysqube-Super-Admin"])->get();
        $data["permissions"] =  Permission::get();

        return view("settings.user.add", [
            "departments" => $data["departments"],
            "divisons" => $data["divisons"],
            "sections" => $data["sections"],
            "roles" => $data["roles"],
            "permissions" => $data["permissions"],
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);

        // check if already in db
        if (user::where("email", $request->email)->exists()) {
            toastr()->error("Email Already Exists");
            return redirect()->back();
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        if ($request->has("department") && $request->department != "") {
            $user->departments()->attach($request->department);
        }
        if ($request->has("divison") && $request->divison != "") {
            $user->divisons()->attach($request->divison);
        }

        if ($request->has("section") && $request->section != "") {
            $user->sections()->attach($request->section);
        }

        if ($request->has("role") && $request->role != "") {
            $user->assignRole($request->role);
        }

        return redirect()->route('settings.user.index')
            ->with('success', 'User created successfully');
    }
    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('settings.user.index')
            ->with('success', 'User deleted successfully');
    }
    public function singleUserEditPage(User $user)
    {
        $user = User::with(["departments", "roles", "permissions"])->whereId($user->id)->first();

        $data["departments"] =  Department::get();
        $data["divisons"] =  UserDivision::get();
        $data["sections"] =  UserSection::get();
        $data["roles"] =  Role::whereNotIn("name", ["Super-Admin", "Sysqube-Super-Admin"])->get();
        $data["permissions"] =  Permission::get();

        return view("settings.user.edit", [
            "departments" => $data["departments"],
            "divisons" => $data["divisons"],
            "sections" => $data["sections"],
            "roles" => $data["roles"],
            "permissions" => $data["permissions"],
            "user" => $user,
        ]);
    }
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($user->email == "admin@sysqube.com" || $user->name == "root@tdf.org.np") {
            return redirect()->back()->with('error-v2', 'Cant Change system accounts');
        }

        $user->name =  $request->name;
        $user->email =  $request->email;
        if ($request->has("password") && $request->password != "") {
            $user->password = Hash::make($request->password);
        }
        if ($request->has("department") && $request->department != "") {
            $user->departments()->detach();
            $user->departments()->attach($request->department);
        }
        if ($request->has("divison") && $request->divison != "") {
            $user->divisons()->detach();
            $user->divisons()->attach($request->divison);
        }
        if ($request->has("section") && $request->section != "") {
            $user->sections()->detach();
            $user->sections()->attach($request->section);
        }
        if ($request->has("role") && $request->role != "") {
            $user->roles()->detach();
            $user->assignRole($request->role);
        }
        $user->save();

        return redirect()->back()->with('success-v2', 'Updated successfully');
    }
    public function addPermissionToUser(Request $request, User $user)
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $user->permissions()->detach();
        //add new permissions
        $user->givePermissionTo([$request->permissions]);

        return redirect()->back()->with('success-v2', 'Updated successfully');
    }
}
