<?php

namespace App\Http\Controllers;

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
        $jobs = Job::all();

        return view('admin.jobs.index',$this->metaResponse())->with('jobs',$jobs);
    }

    public function create(){
        $this->meta['title'] = 'Create Job';                                                                
    	return view('admin.jobs.create',$this->metaResponse());
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'title' => 'required',
            'city' => 'required',
            'description' => 'required',
        ]);
        
        $job=Job::create([
            'title' => $request->title,
            'city' => $request->city,
            'description' => $request->description,
        ]);

        Session::flash('success','job is created succesfully');
        return redirect()->route('job.index');
    }

    public function edit($id)
    {
        $this->meta['title'] = 'Update Job';                                                                        
        $job=Job::find($id);
        return view('admin.jobs.edit',$this->metaResponse())->with('job',$job);

    }

    public function update($id , Request $request)
    {
        $job=Job::find($id);
 
        $job->title = $request->title;
        $job->city = $request->city;
        $job->description = $request->description;
        $job->save();
        Session::flash('success','job is updated succesfully');
        return redirect()->route('job.index');
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        $job->delete();
        Session::flash('success','Job deleted successfuly.');
        return redirect()->back();
    }
}
