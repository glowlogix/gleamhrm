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

        return view('admin.leave_types.index')->with('leave_types', $leave_types);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
        $leave_exist = LeaveType::where('name', $request->name)->first();
        if ($leave_exist == null) {
            LeaveType::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);
            Session::flash('success', 'Leave type is created successfully');

        } else {
            Session::flash('error', 'Leave type with this name already exist');
        }
        return redirect()->route('leave_type.index');

    }

    public function update(Request $request, $id)
    {
        $leave_type = LeaveType::find($id);
        $leave_type->name = $request->name;
        $leave_type->amount = $request->amount;
        $leave_type->status = $request->status;
        $leave_type->save();
        Session::flash('success', 'Leave type is updated successfully');
        return redirect()->route('leave_type.index');
    }

    public function delete(Request $request, $id)
    {
        $leave_type = LeaveType::find($id);
        $leave_type->delete();
        Session::flash('success', 'Leave type deleted successfully.');
        return redirect()->route('leave_type.index');
    }

}
