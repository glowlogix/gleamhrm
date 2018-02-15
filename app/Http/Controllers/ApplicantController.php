<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Category;
use App\Job;
use Session;
use Auth;

class ApplicantController extends Controller
{
    public function index(){
        return view('admin.applicants.index')->with('applicants',Applicant::all()->with('job')->get());
    }
    public function create(){
    	return view('applicant.create')->with('categories',Category::all())->with('jobs',Job::all());
    }
    public function singleApplicant($id){
        $applicant=Applicant::find($id);
        return view('admin.applicants.single')->with('applicant',$applicant);
    }

    public function findjob(Request $request){
        $data=Job::select('title','id')->where('category_id',$request->id)->take(20)->get();
        return response()->json($data);
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'name' => 'required',
    		'fname' => 'required',
    		'avatar' => 'required|image',
    		'city' => 'required',
    		'cv' => 'required|mimes:doc,docx,pdf',
    		'job_status' => 'required'
    	]);
        $avatar = $request->avatar;
        $avatar_new_name = time().$avatar->getClientOriginalName();
        $avatar->move('uploads/applicants/image', $avatar_new_name);

        $cv=$request->cv;
        $cv_new_name=time().$cv->getClientOriginalName();
        $cv->move('uploads/applicants/cv', $cv_new_name);
    	$applicant= Applicant::create([

    		'name' => $request->name,
    		'fname' => $request->fname,
    		'avatar' => 'uploads/applicants/image/' . $avatar_new_name,
    		'cv' => 'uploads/applicants/cv/' . $cv_new_name,
    		'city' =>$request->city,
    		'job_status' => $request->job_status,
            'job_id' => $request->job,
            'category_id'=>$request->category
    	]);
         Session::flash('success','application is submitted succesfully');
        return redirect()->back();

    }

    public function single_Cat_Job($id)
    {
        $applicants=\DB::table('Applicants')->where('category_id',$id)->get();
       
        return view('admin.applicants.singleCategoryJobs')->with('applicants',$applicants);
    }

  //  public function singleApplicant($id)
    //{
     //   return view('admin.applicants.singleapplicant')->with('applicants',Applicant::find($id));
    //}

    public function destroy($id)
    {
        $applicant=Applicant::find($id);
        $applicant->delete();
        Session::flash('sucess','Applicant deleted successfuly.');
        return redirect()->back();
    }

    public function trashed()
    {
        $applicants=Applicant::onlyTrashed()->get();
        return view('admin.applicants.trashed')->with('applicants', $applicants);

    }

    public function kill($id)
    {
        $applicant=Applicant::withTrashed()->where('id', $id)->first();
        $applicant->forceDelete();

        Session::flash('success','Applicant Deleted permanently.');
        return redirect()->back();
    }

    public function restore($id)
    {
        $applicant=Applicant::withTrashed()->where('id', $id)->first();
        $applicant->restore();
        Session::flash('success','Seccessfuly Restored the applicant');
        return redirect()->back();
    }


}
