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
        return view('admin.users.index')->with('users',User::all());
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email'
        ]);
       $user=User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'admin' => $request->admin,
            'password' => Hash::make($request->password)
            //'password' =>$request->password
        ]);

        Session::flash('success', 'user added successfuly.');
        return redirect()->route('users');
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
}
