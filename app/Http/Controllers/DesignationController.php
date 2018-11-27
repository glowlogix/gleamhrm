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
        return view('admin.designations.index')->with('designations',$designations);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'designation_name' => 'required',
        ]);
        $designations_exist=Designation::where('designation_name',$request->designation_name)->first();
        if($designations_exist == null){
            Designation::create([
                'designation_name' => $request->designation_name,
            ]);
            Session::flash('success','Designation is created successfully');
            return redirect()->route('designations.index');
        }
        else
        {
            Session::flash('error','Designation with this name Already Exist');
            return redirect()->route('designations.index');
        }

    }
    public function update (Request $request ,$id)
    {
        $designation=Designation::find($id);
        $designation->designation_name = $request->name;
        $designation->save();
        Session::flash('success','Designation Name is updated successfully');
        return redirect()->route('designations.index');
    }
    public function delete(Request $request ,$id)
    {
        $designation = Designation::find($id);
        $designation->delete();
        Session::flash('success','Designation deleted successfully.');
        return redirect()->route('designations.index');
    }

}
