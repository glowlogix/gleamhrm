<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::all();

        return view('admin.departments.index')->with('departments', $departments);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'department_name' => 'required',
            'status' => 'required'
        ]);
        $department_exist = Department::where('department_name', $request->department_name)->first();
        if ($department_exist == null) {
            $department = Department::create([
                'department_name' => $request->department_name,
                'status' => $request->status
            ]);
            Session::flash('success', 'Department is created successfully');
        } else {
            Session::flash('error', 'Department with this name already exist');
        }
        return redirect()->route('departments.index');
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        $department->department_name = $request->department_name;
        $department->status = $request->status;
        $department->save();
        Session::flash('success', 'Department is updated successfully');
        return redirect()->route('departments.index');
    }

    public function delete(Request $request, $id)
    {
        $department = Department::find($id);
        $department->delete();
        Session::flash('success', 'Department deleted successfully.');
        return redirect()->route('departments.index');
    }
}
