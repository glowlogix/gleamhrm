<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;
use App\Traits\MetaTrait;
use Calendar;
use App\Leave;
use App\Employee;
use DB;



class UsersController extends Controller
{

   use MetaTrait;
    
   public function index()
    {
        $this->meta['title'] = 'User Permitions';                        
        return view('admin.users.index',$this->metaResponse())->with('users',User::all());
    }
    
    public function dashboard()
    {
        $this->meta['title'] = 'Dashboard';
        $data = DB::table('employees')->get(); 
        $events = [];
        foreach($data as $employee){
            $employee_id = $employee->id;
            $currentDate = date('Y-m-d');
            $attendance =  DB::select(DB::raw("SELECT * FROM attandances WHERE DATE_FORMAT(checkintime, '%Y-%m-%d') = '$currentDate' And employee_id = '$employee_id'")); 
            $leave  = DB::select(DB::raw("SELECT * FROM leaves WHERE DATE_FORMAT(datefrom, '%Y-%m-%d') = '$currentDate' And employee_id = '$employee_id'"));

            if($data->count()){

              foreach ($attendance as $key => $value) {

                $events[] = Calendar::event(

                    "present"."\n".$employee->fullname,

                    true,
                    new \DateTime($value->checkintime),

                    new \DateTime($value->checkouttime.' +1 day'),
                    $value->employee_id,
                    [
                        'color' => 'green'
                    ]
                );

            }
            foreach ($leave as $key => $value) {

                $events[] = Calendar::event(

                    $value->leave_type."\n".$employee->fullname,

                    true,
                    new \DateTime($value->datefrom),

                    new \DateTime($value->dateto.' +1 day'),
                    $value->employee_id,
                    [
                        'color' => 'orange'
                    ]
                );

            }
            }
        }                                
        $calendar = Calendar::addEvents($events)
           ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => 'function(event) {
                console.log(event);
                var type = event.title.split("\n")[0];
                var id = event.id;
                
                $("#attendance").val(type);
                $("#myModal").modal("toggle");
                // $.ajaxSetup({
                //     headers: {
                //       "X-CSRF-TOKEN": $(meta[name=csrf-token]).attr("content")
                //     }
                //   });
                $("#update").on("click",function(){

                    $.ajax({
                        method: "POST", 
                        url: "attendance/update/"+id, 
                        data: {
                            "type" : type,
                            "id" : id,
                            "_token": "{!! csrf_token() !!}",
                            }, 
                            success: function(response){ 
                                console.log(response); 
                                },
                                error: function(jqXHR, textStatus, errorThrown) { 
                                    console.log(JSON.stringify(jqXHR));
                                    console.log("AJAX error: " + textStatus + " : " + errorThrown);
                                }

                                })

                                });


                            }'
        ]);
        return view('admin.dashboard.index',$this->metaResponse(),['calendar' => $calendar]);
        
    }

    public function create()
    {
        $this->meta['title'] = 'Add User';                                
        return view('admin.users.create',$this->metaResponse());
    }

    public function edit(Request $request,$id){

        $this->meta['title'] = 'User Update';
        $user = User::find($id);
        return view('admin.users.edit',$this->metaResponse())->with(['user' => $user]);
    }

    public function update(Request $request,$id){
        
        $user = User::find($id);  
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->admin){
            $user->admin = $request->admin;
        }
        else{
            $user->admin  = 0;
        }
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        Session::flash('success', 'User updated successfuly.');
        return redirect()->route('users'); 
    }
        

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
       $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->admin,
            'password' => Hash::make($request->password),
            'status' => 1
        ]);

        Session::flash('success', 'user added successfuly.');
        return redirect()->route('users');
    }

    public function delete($id)
    {
        $user= User::find($id);
        $user->delete();

        Session::flash('success','User is deleted successfully.');
        return redirect()->back();
    }

     public function Admin($id){
        $user= User::find($id);
        $user->admin=1;
        $user->save();
        Session::flash('success', 'Seccessfuly changed users permissions.');
        return redirect()->back();

    }
    public function Not_Admin($id){
        $user= User::find($id);
        $user->admin=0;
        $user->save();
        Session::flash('success', 'Seccessfuly changed users permissions.');
        return redirect()->back();
    }

   

 
}
