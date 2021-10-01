<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\AttendanceSummary;
use App\Branch;
use App\Designation;
use App\Employee;
use App\Job;
use App\Leave;
use App\Mail\FeedbackMail;
use App\Mail\Reminder;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;

class DashboardController extends Controller
{
    use MetaTrait;

    public function index()
    {
        $this->meta['title'] = 'Applicants';
        $dates = [];
        $applicants = Applicant::where('recruited', 0)->count();
        $male = Employee::where('gender', 'Male')->count();
        $female = Employee::where('gender', 'Female')->count();
        $months = ['January' => '1', 'February' => '2', 'March' => '3', 'April' => '4', 'May' => '5', 'June' => '6', 'July' => '7', 'August' => '8', 'September' => '9', 'October' => '10', 'November' => '11', 'December' => '12'];
        $attArr = [];
        $counts = [];

        foreach ($months as $month) {
            if (Auth::user()->isAllowed('DashboardController:index')) {
                $employees = Employee::all();
            } else {
                $employees = Employee::where('id', Auth::user()->id)->get();
            }
            foreach ($employees as $employee) {
                $weekend = Branch::where('id', $employee->branch_id)->first();
                $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, Carbon::now()->year);
                $days = 0;
                for ($i = 1; $i <= $numberOfDays; $i++) {
                    $now = Carbon::now();
                    $date = Carbon::parse($i.'-'.$month.'-'.$now->year)->toDateString();
                    if (in_array(Carbon::parse($date)->format('l'), json_decode($weekend->weekend)) == false) {
                        $days += 1;
                    }
                }
                $counts[$month][$employee->id] = (AttendanceSummary::where('employee_id', $employee->id)->whereRaw('MONTH(date) = ?', $month)->whereRaw('YEAR(date) = ?', date('Y'))->count() / $days) * 100;
            }
        }

        $averageAttendance = [];
        foreach ($counts as $date => $array) {
            if (Auth::user()->isAllowed('DashboardController:index')) {
                $employeesCount = Employee::all()->count();
            } else {
                $employeesCount = Employee::where('id', Auth::user()->id)->count();
            }
            $averageAttendance[] = round((array_sum($array) / $employeesCount), 2);
        }
        // $averageAttendance = [5,10,15,8,11,6,20,18,16,25,12,21];

        $averageAttendance = json_encode($averageAttendance);
        $Chartmonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $chartMonths = json_encode($Chartmonths);

        $Designations = Designation::all();
        $chartEmployee = [];
        $DesignationName = [];
        foreach ($Designations as $Designation) {
            $chartEmp = Employee::where('designation', $Designation->designation_name)->count();
            if ($chartEmp > 0) {
                $chartEmployee[] = $chartEmp;
                $DesignationName[] = $Designation->designation_name;
            }
        }
        $replace = ['[', ']'];
        $DesignationName = json_encode($DesignationName);
        $designationSeries = json_encode($chartEmployee);

        if (Auth::user()->isAllowed('DashboardController:index')) {
            return view('admin.dashboard.index', $this->metaResponse())
            ->with('employee', Employee::orderBy('joining_date', 'Desc')->take(5)->get())
            ->with('totalemployees', Employee::where('employment_status', 'permanent')->orwhere('employment_status', 'probation')->get())
            ->with('designationSeries', $designationSeries)
            ->with('DesignationName', $DesignationName)
            ->with('averageAttendance', $averageAttendance)
            ->with('chartMonths', $chartMonths)
            ->with('male', $male)
            ->with('female', $female)
            ->with('applicants', $applicants);
        } else {
            $approvedLeaves = Leave::where('employee_id', Auth::user()->id)->where('status', 'Approved')->count();
            $rejectedLeaves = Leave::where('employee_id', Auth::user()->id)->where('status', 'Declined')->count();
            $pendingLeaves = Leave::where('employee_id', Auth::user()->id)->where('status', 'pending')->count();

            return view('admin.dashboard.index', $this->metaResponse())
            ->with('averageAttendance', $averageAttendance)
            ->with('chartMonths', $chartMonths)
            ->with('applicants', $applicants)
            ->with('approvedLeaves', $approvedLeaves)
            ->with('rejectedLeaves', $rejectedLeaves)
            ->with('pendingLeaves', $pendingLeaves);
        }
    }

    //    Help
    public function contact()
    {
        return view('help.contact_us', $this->metaResponse());
    }

    /**
     * @return $this
     */
    public function create()
    {
        return view('applicant.create')->with('jobs', Job::all());
    }

    /**
     * @param $id
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
        // dd($request);
        $this->validate($request, [
            'name'       => 'required',
            'fname'      => 'required',
            'avatar'     => 'required|image',
            'city'       => 'required',
            'cv'         => 'required|mimes:doc,docx,pdf,txt',
            'job_status' => 'required',
        ]);

        $avatar = $request->avatar;
        $avatar_new_name = time().$avatar->getClientOriginalName();
        $avatar->move('uploads/applicants/image', $avatar_new_name);

        $cv = $request->cv;
        $cv_new_name = time().$cv->getClientOriginalName();
        $cv->move('uploads/applicants/cv', $cv_new_name);

        $applicant = Applicant::create([
            'name'       => $request->name,
            'fname'      => $request->fname,
            'email'      => $request->email,
            'avatar'     => 'uploads/applicants/image/'.$avatar_new_name,
            'cv'         => 'uploads/applicants/cv/'.$cv_new_name,
            'city'       => $request->city,
            'job_status' => $request->job_status,
            'job_id'     => $request->job_id,
            // 'job_position_id'=>$request->job_position_id,
            'recruited' => 0,
        ]);

        /*Mail::to($request->email)->send(new Reminder);*/
        Session::flash('success', 'application is submitted succesfully');

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

        Session::flash('success', 'Applicant Deleted permanently.');

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

    public function contact_us(Request $request)
    {
        $data = ['name' => "$request->name", 'messages' => "$request->message", 'email' => "$request->email"];

        try {
            Mail::to($request->email)->send(new FeedbackMail($request->name, $request->message, Auth::user()->official_email));
            Session::flash('success', 'Email Sent To the HR');
        } catch (\Exception $e) {
            Session::flash('error', 'Email Not Send Please Set Email Configuration In .env File');
        }

        return redirect()->back();
    }
}
