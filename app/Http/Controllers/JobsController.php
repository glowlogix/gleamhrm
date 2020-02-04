<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Job;
use App\Skill;
use App\Traits\MetaTrait;
use Illuminate\Http\Request;
use Session;

class JobsController extends Controller
{
    use MetaTrait;

    public function index()
    {
        $this->meta['title'] = 'Jobs';
        $jobs = Job::with('department', 'designation', 'branch')->get();

        return view('admin.jobs.index', $this->metaResponse())->with('jobs', $jobs)->with('skills', Skill::all());
    }

    public function create()
    {
        $this->meta['title'] = 'Create Job';

        return view('admin.jobs.create', $this->metaResponse())->with('designations', Designation::all())->with('departments', Department::all())->with('branches', Branch::all())->with('skills', Skill::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required',
            'designation_id' => 'required',
            'branch_id'      => 'required',
            'department_id'  => 'required',
            'description'    => 'required',
            //            'skills' => 'required',
        ]);
        Job::create([
            'title'          => $request->title,
            'branch_id'      => $request->branch_id,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'description'    => $request->description,
            'skill'          => json_encode($request->skills),
        ]);

        Session::flash('success', 'job is created successfully');

        return redirect()->route('job.index');
    }

    public function edit($id)
    {
        $this->meta['title'] = 'Update Job';
        $job = Job::find($id);

        return view('admin.jobs.edit', $this->metaResponse())->with('job', $job)->with('designations', Designation::all())->with('departments', Department::all())->with('branches', Branch::all())->with('skills', Skill::all());
    }

    public function update(Request $request, $id)
    {
        $job = Job::find($id);
        $job->title = $request->title;
        $job->branch_id = $request->branch_id;
        $job->department_id = $request->department_id;
        $job->designation_id = $request->designation_id;
        $job->description = $request->description;
        $job->skill = json_encode($request->skills);
        $job->save();
        Session::flash('success', 'job is updated successfully');

        return redirect()->route('job.index');
    }

    public function destroy($id)
    {
        $job = Job::where('id', $id)->first();
        $job->delete();
        Session::flash('success', 'Job deleted successsfuly.');

        return redirect()->back();
    }

    public function getSkillsByJob($jobId)
    {
        $job = Job::where('id', $jobId)->first();
        $skills = Skill::whereIn('id', json_decode($job->skill))->get()->pluck('skill_name');

        return $skills->toJson();
    }
}
