<?php

namespace App\Http\Controllers;

use App\Designation;
use Illuminate\Http\Request;
use Session;

class DesignationController extends Controller
{

    public function index()
    {
        $designations = Designation::all();
        return view('admin.designations.index')->with('designations', $designations);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'designation_name' => 'required',
            'status' => 'required',
        ]);
        $designations_exist = Designation::where('designation_name', $request->designation_name)->first();
        if ($designations_exist == null) {
            Designation::create([
                'designation_name' => $request->designation_name,
                'status' => $request->status,
            ]);
            Session::flash('success', 'Designation is created successfully');
        } else {
            Session::flash('error', 'Designation with this name already exist');
        }
        return redirect()->route('designations.index');

    }

    public function update(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->designation_name = $request->name;
        $designation->status = $request->status;
        $designation->save();
        Session::flash('success', 'Designation name is updated successfully');
        return redirect()->route('designations.index');
    }

    public function delete(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->delete();
        Session::flash('success', 'Designation deleted successfully.');
        return redirect()->route('designations.index');
    }

}
