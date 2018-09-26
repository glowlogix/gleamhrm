<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobPosition;
use Session;
use App\Traits\MetaTrait;

class JobPositionsController extends Controller
{
    use MetaTrait;
    
    public function index(){

        $this->meta['title'] = 'JobPositions';        
    	return view('admin.job_positions.index',$this->metaResponse())->with('job_positions',JobPosition::all());
    }
    public function create(){

        $this->meta['title'] = 'Create JobPosition';                
    	return view('admin.job_positions.create',$this->metaResponse());
    }

    public function store(Request $request){
    	$this->validate($request,[
            'name' =>'required',
    		'city' =>'required'
    	]);
    	$job_position= new JobPosition;
        $job_position->name=$request->name;
        $job_position->address=$request->address;
    	$job_position->city=$request->city;
    	$job_position->save();
        Session::flash('success', 'JobPosition Added successfully.');
        return redirect()->back();
    }
    public function edit($id)
    {

        $this->meta['title'] = 'Update JobPosition';                        
        $job_position=JobPosition::find($id);
        return view('admin.job_positions.edit',$this->metaResponse())->with('job_position',$job_position);
        
    }
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name' =>'required',
            'city' =>'required'
        ]);
        $job_position=JobPosition::find($id);
        $job_position->name=$request->name;
        $job_position->address=$request->address;
        $job_position->city=$request->city;
        $job_position->save();
        Session::flash('success', 'JobPosition updated successfully.');
        return redirect()->back();


    }
    public function delete($id)
    {
        $job_position=JobPosition::find($id);
        $job_position->delete();
        Session::flash('success','User is deleted successfully.');
        return redirect()->back();
    }

}
