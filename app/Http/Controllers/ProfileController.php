<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $employee = Employee::where('id', Auth::user()->id)->first();

        return view('admin.users.profile')->with('employee', $employee);
    }

    public function update(Request $request)
    {
        if (! (Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('error', 'Your current password does not matches with the password you provided. Please try again.');
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password'     => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully !');
    }

    public function updatePic(Request $request)
    {
        $employee = Employee::find(Auth::user()->id);
        if ($request->picture != '') {
            $picture = time().'_'.$request->picture->getClientOriginalName();
            $request->picture->move('storage/employees/profile/', $picture);
            $employee->picture = 'storage/employees/profile/'.$picture;
        }
        $employee->save();

        return redirect()->route('profile.index')->with('success', 'Profile is updated Successfully');
    }
}
