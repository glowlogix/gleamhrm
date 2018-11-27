<?php

namespace App\Http\Controllers;

use App\Department;
use App\Team;
use Illuminate\Http\Request;
use Session;

class TeamController extends Controller
{

    public function index()
    {
        $departments = Department::all();
        $teams=Team::with('department')->get();
        return view('admin.teams.index')->with('departments',$departments)->with('teams',$teams);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'team_name' => 'required',
            'department_id' => 'required'
        ]);
        $team_exist=Team::where('name',$request->team_name)->first();
        if($team_exist == null){
            $team = Team::create([
                'name' => $request->team_name,
                'department_id' => $request->department_id
            ]);
            Session::flash('success','Team is created successfully');
            return redirect()->route('teams.index');
        }
        else
        {
            Session::flash('error','Team with this name Already Exist');
            return redirect()->route('teams.index');
        }

    }
    public function update (Request $request ,$id)
    {
        $team=Team::find($id);
        $team->department_id = $request->dept_id;
        $team->name = $request->name;
        $team->save();
        Session::flash('success','Team is updated successfully');
        return redirect()->route('teams.index');
    }
    public function delete(Request $request ,$id)
    {
        $team = Team::find($id);
        $team->delete();
        Session::flash('success','Team deleted successfully.');
        return redirect()->route('teams.index');
    }
}
