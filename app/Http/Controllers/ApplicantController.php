<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Category;
use App\Job;
use Session;
use Auth;
use Mail;
use App\Mail\Reminder;
use App\Http\Requests;

class ApplicantController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->meta['title'] = 'Applicants';

        $applicants = Applicant::where('recruited', 0)->take(10)->get();
        return view('admin.applicants.index',$this->meta)->with('applicants',$applicants);
    }

    /**
     * @return $this
     */
    public function create()
    {
    	return view('applicant.create')->with('categories',Category::all())->with('jobs',Job::all());
    }

    /**
     * @param $id
     * @return $this
     */
    public function singleApplicant($id)
    {
        $applicant=Applicant::find($id);
        return view('admin.applicants.single')->with('applicant',$applicant);
    }

    public function findjob(Request $request)
    {
        $data=Job::select('title','id')->where('category_id',$request->id)->take(20)->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
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
            'email' =>$request->email,
    		'avatar' => 'uploads/applicants/image/' . $avatar_new_name,
    		'cv' => 'uploads/applicants/cv/' . $cv_new_name,
    		'city' =>$request->city,
    		'job_status' => $request->job_status,
            'job_id' => $request->job,
            'category_id'=>$request->category,
            'recruited' => 0
    	]);
                  
       /* Mail::to($request->email)->send(new Reminder);*/
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
        return view('admin.applicants.trashed',['title' => 'Trash Applicants'])->with('applicants', $applicants);
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

    public function hire($id)
    {
        $applicant=Applicant::find($id);
        $applicant->recruited=1;
        $applicant->save();
        return redirect()->back();
    }
    
    public function retire($id)
    {
        $applicant=Applicant::find($id);
        $applicant->recruited=0;
        $applicant->save();
        return redirect()->back();
    }

    public function hiredApplicants()
        {
            $applicants = Applicant::where('recruited', 1)->take(10)->get();
            return view('admin.applicants.hiredApplicants',['title' => 'Hired Applicants'])->with('applicants',$applicants);
        }





}
