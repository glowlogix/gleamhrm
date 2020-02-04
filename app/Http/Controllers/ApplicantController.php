<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Job;
use App\Mail\Reminder;
use App\Skill;
use App\Traits\MetaTrait;
use Illuminate\Http\Request;
use Mail;
use Session;

class ApplicantController extends Controller
{
    use MetaTrait;

    public function index()
    {
        $this->meta['title'] = 'Applicants';
        $applicants = Applicant::with('job')->where('recruited', 0)->take(10)->get();

        return view('admin.applicants.index', $this->metaResponse())->with('applicants', $applicants);
    }

    /**
     * @return $this
     */
    public function create()
    {
        $Jobs = Job::with('designation')->get();

        return view('applicant.create')->with('')->with('jobs', $Jobs)->with('skills', Skill::all());
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function singleApplicant($id)
    {
        $applicant = Applicant::find($id);

        return view('admin.applicants.single')->with('applicant', $applicant);
    }

    public function findjob(Request $request)
    {
        $data = Job::select('title', 'id')->where('category_id', $request->id)->take(20)->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'position'   => 'required',
            'name'       => 'required',
            'fname'      => 'required',
            'avatar'     => 'required|image',
            'city'       => 'required',
            'cv'         => 'required|mimes:doc,docx,pdf,txt',
            'job_status' => 'required',
        ]);

        $avatar = $request->avatar;
        $avatar_new_name = time().$avatar->getClientOriginalName();
        $avatar->move('storage/uploads/applicants/image', $avatar_new_name);

        $cv = $request->cv;
        $cv_new_name = time().$cv->getClientOriginalName();
        $cv->move('storage/uploads/applicants/cv', $cv_new_name);

        Applicant::create([
            'name'       => $request->name,
            'fname'      => $request->fname,
            'email'      => $request->email,
            'avatar'     => 'storage/uploads/applicants/image/'.$avatar_new_name,
            'cv'         => 'storage/uploads/applicants/cv/'.$cv_new_name,
            'city'       => $request->city,
            'job_status' => $request->job_status,
            'job_id'     => $request->position,
            // 'job_position_id'=>$request->job_position_id,
            'recruited' => 0,
        ]);

        /*Mail::to($request->email)->send(new Reminder);*/
        Session::flash('success', 'application is submitted successfully');

        return redirect()->back();
    }

    public function single_Cat_Job($id)
    {
        $applicants = \DB::table('Applicants')->where('category_id', $id)->get();

        return view('admin.applicants.singleCategoryJobs')->with('applicants', $applicants);
    }

    // public function singleApplicant($id)
    // {
    //     return view('admin.applicants.singleapplicant')->with('applicants',Applicant::find($id));
    // }

    public function destroy($id)
    {
        $applicant = Applicant::find($id);
        $applicant->delete();
        Session::flash('sucess', 'Applicant deleted successfully.');

        return redirect()->back();
    }

    public function trashed()
    {
        $this->meta['title'] = 'Trash Applicants';
        $applicants = Applicant::onlyTrashed()->get();

        return view('admin.applicants.trashed', $this->metaResponse())->with('applicants', $applicants);
    }

    public function kill($id)
    {
        $applicant = Applicant::withTrashed()->where('id', $id)->first();
        $applicant->forceDelete();

        Session::flash('success', 'Applicant deleted permanently.');

        return redirect()->back();
    }

    public function restore($id)
    {
        $applicant = Applicant::withTrashed()->where('id', $id)->first();
        $applicant->restore();
        Session::flash('success', 'Successfully Restored the applicant');

        return redirect()->back();
    }

    public function hire($id)
    {
        $applicant = Applicant::find($id);
        $applicant->recruited = 1;
        $applicant->save();

        return redirect()->back();
    }

    public function retire($id)
    {
        $applicant = Applicant::find($id);
        $applicant->recruited = 0;
        $applicant->save();

        return redirect()->back();
    }

    public function hiredApplicants()
    {
        $this->meta['title'] = 'Hired Applicants';
        $applicants = Applicant::where('recruited', 1)->take(10)->get();

        return view('admin.applicants.hiredApplicants', $this->metaResponse())->with('applicants', $applicants);
    }
}
