<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Team;
use Illuminate\Http\Request;
use Session;

class TeamController extends Controller
{
    public function index()
    {
        $departments = Department::where('status', 'Active')->get();
        $teams = Team::with('department')->get();
        $employees = Employee::where('status', '!=', '0')->get();

        return view('admin.teams.index')->with('departments', $departments)->with('teams', $teams)->with('employees', $employees);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'team_name'     => 'required',
            'department_id' => 'required',
            'status'        => 'required',
        ]);
        $team_exist = Team::where('name', $request->team_name)->first();
        if ($team_exist == null) {
            $team = Team::create([
                'name'          => $request->team_name,
                'department_id' => $request->department_id,
                'status'        => $request->status,
            ]);
            Session::flash('success', 'Team is created successfully');
        } else {
            Session::flash('error', 'Team with this name already exist');
        }

        return redirect()->route('teams.index');
    }

    public function update(Request $request, $id)
    {
        $team = Team::find($id);
        $team->department_id = $request->dept_id;
        $team->name = $request->name;
        $team->status = $request->status;
        $team->save();
        Session::flash('success', 'Team is updated successfully');

        return redirect()->route('teams.index');
    }

    public function delete(Request $request, $id)
    {
        $team = Team::find($id);
        $team->delete();
        Session::flash('success', 'Team deleted successfully.');

        return redirect()->route('teams.index');
    }
}
