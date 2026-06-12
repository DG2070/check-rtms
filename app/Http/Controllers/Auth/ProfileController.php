<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function resetPassword()
    {
        return view('auth.profile.reset-password');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            toastr()->success('Password updated successfully!');
            return redirect()->route('home');
        } else {
            toastr()->error('Current password is incorrect!');
            return redirect()->back();
        }
    }
    public function profile()
    {
        //Get current user and pass it to the view
        $user = Auth::user();
        return view('auth.profile.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        // check name for required and email for required, email as well as unique
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = auth()->user();
        if ($user->email == "admin@sysqube.com" || $user->name == "root@tdf.org.np") {
            return redirect()->back()->with('error-v2', 'Cant Change system accounts');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        toastr()->success('Profile updated successfully!');
        return redirect()->route('home');
    }
}
