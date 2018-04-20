<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;



class UsersController extends Controller
{
   public function index()
    {
        
        return view('admin.users.index',['title' => 'User Permitions'])->with('users',User::all());
    }

    public function create()
    {
        return view('admin.users.create',['title' => 'Add User']);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
       $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->admin,
            'password' => Hash::make($request->password),
            'status' => 1
            //'password' =>$request->password
        ]);

        Session::flash('success', 'user added successfuly.');
        return redirect()->route('users');
    }

    public function delete($id)
    {
        $user= User::find($id);
        $user->delete();

        Session::flash('success','User is deleted successfully.');
        return redirect()->back();
    }

     public function Admin($id){
        $user= User::find($id);
        $user->admin=1;
        $user->save();
        Session::flash('success', 'Seccessfuly changed users permissions.');
        return redirect()->back();

    }
    public function Not_Admin($id){
        $user= User::find($id);
        $user->admin=0;
        $user->save();
        Session::flash('success', 'Seccessfuly changed users permissions.');
        return redirect()->back();
    }

    public function ActivateUser($id){
        $user= User::find($id);
        $user->status=1;
        $user->save();
        Session::flash('success', 'User is Activated Seccessfuly.');
        return redirect()->back();
    }

    public function DisableUser($id){
        $user= User::find($id);
        $user->status=0;
        $user->save();
        Session::flash('success', 'User is disabled Seccessfuly.');
        return redirect()->back();
    }
}
