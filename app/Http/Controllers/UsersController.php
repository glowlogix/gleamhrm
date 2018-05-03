<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;
use App\Traits\MetaTrait;



class UsersController extends Controller
{

   use MetaTrait;
    
   public function index()
    {
        $this->meta['title'] = 'User Permitions';                        
        return view('admin.users.index',$this->metaResponse())->with('users',User::all());
    }

    public function dashboard()
    {
        $this->meta['title'] = 'Dashboard';                                
        return view('admin.dashboard.index',$this->metaResponse());
        
    }

    public function create()
    {
        $this->meta['title'] = 'Add User';                                
        return view('admin.users.create',$this->metaResponse());
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
