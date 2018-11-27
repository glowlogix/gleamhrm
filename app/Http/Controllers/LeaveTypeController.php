<?php

namespace App\Http\Controllers;

use App\LeaveType;
use Illuminate\Http\Request;
use Session;
class LeaveTypeController extends Controller
{
    public function index()
    {
        $leave_types = LeaveType::all();

        return view('admin.leave_types.index')->with('leave_types',$leave_types);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'short_name' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
        $leave_exist=LeaveType::where('name',$request->name)->orwhere('short_name',$request->short_name)->first();
        if($leave_exist == null){
            LeaveType::create([
                'short_name' => $request->short_name,
                'name' => $request->name,
                'amount' => $request->amount,
                 'status' => $request->status,
            ]);
            Session::flash('success','Leave Type is created succesfully');
            return redirect()->route('leave_type.index');
        }
        else
        {
            Session::flash('error','Leave Type with this name Already Exist');
            return redirect()->route('leave_type.index');
        }

    }
    public function update (Request $request ,$id)
    {
        $leave_type=LeaveType::find($id);
        $leave_type->short_name = $request->short_name;
        $leave_type->name = $request->name;
        $leave_type->amount = $request->amount;
        $leave_type->status = $request->status;
        $leave_type->save();
        Session::flash('success','Leave Type is updated Successfully');
        return redirect()->route('leave_type.index');
    }
    public function delete(Request $request ,$id)
    {
        $leave_type = LeaveType::find($id);
        $leave_type->delete();
        Session::flash('success','Leave Type deleted successfully.');
        return redirect()->route('leave_type.index');
    }

}
