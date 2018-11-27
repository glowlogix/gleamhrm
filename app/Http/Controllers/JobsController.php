<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use Illuminate\Http\Request;
use App\Job;
use App\JobPosition;
use Session;
use App\Traits\MetaTrait;

class JobsController extends Controller
{
    use MetaTrait;
    
    public function index(){

        $this->meta['title'] = 'Jobs';                                                        
        $jobs = Job::with('department','designation','branch')->get();
        return view('admin.jobs.index',$this->metaResponse())->with('jobs',$jobs);
    }

    public function create(){
        $this->meta['title'] = 'Create Job';                                                                
    	return view('admin.jobs.create',$this->metaResponse())->with('designations',Designation::all())->with('departments',Department::all())->with('branches',Branch::all());
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'title' => 'required',
            'designation_id' => 'required',
            'branch_id' => 'required',
            'department_id' => 'required',
            'description' => 'required',
        ]);
        
        $job=Job::create([
            'title' => $request->title,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'description' => $request->description,
        ]);

        Session::flash('success','job is created succesfully');
        return redirect()->route('job.index');
    }

    public function edit($id)
    {
        $this->meta['title'] = 'Update Job';                                                                        
        $job=Job::find($id);
        return view('admin.jobs.edit',$this->metaResponse())->with('job',$job)->with('designations',Designation::all())->with('departments',Department::all())->with('branches',Branch::all());
    }

    public function update(Request $request,$id)
    {
        $job=Job::find($id);
        $job->title = $request->title;
        $job->branch_id = $request->branch_id;
        $job->department_id = $request->department_id;
        $job->designation_id = $request->designation_id;
        $job->description = $request->description;
        $job->save();
        Session::flash('success','job is updated succesfully');
        return redirect()->route('job.index');
    }

    public function destroy($id)
    {
        $job = Job::where('id',$id)->first();
        $job->delete();
        Session::flash('success','Job deleted successfuly.');
        return redirect()->back();
    }
}
