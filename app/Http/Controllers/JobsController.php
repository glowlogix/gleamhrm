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
    	return view('admin.jobs.create',$this->metaResponse())->with('job_positions', JobPosition::all());
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
        return redirect()->back();
    } 
    public function edit($id)
    {
        $this->meta['title'] = 'Update Job';                                                                        
        $job=Job::find($id);
        return view('admin.jobs.edit',$this->metaResponse())->with('job',$job)->with('job_positions', JobPosition::all());

    }
    public function update($id , Request $request)
    {
        $job=job::find($id);
        /*if($request->featured)
        {
            $featured=$request->featured;
            $new_featured= time().$featured->getClientOriginalName();
            $featured->move('uploads/jobs',$new_featured);
            $job->featured=$new_featured;
        }*/

        $job->title=$request->title;
        $job->city = $request->city;
        
        $job->description=$request->description;
        $job->job_position_id= $request->job_position_id;
        $job->save();
        Session::flash('success','job is created succesfully');
        return redirect()->back();
    }

    public function singleJobPositionJobs($id){
        $this->meta['title'] = 'Jobs';                                                                                
        $jobs = Job::where('job_position_id',$id)->with('category')->get();
        return view('admin.jobs.singleJobPositionJobs',$this->metaResponse())->with('jobs',$jobs);
    }
}
