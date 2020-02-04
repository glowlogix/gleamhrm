<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Team;
use App\TeamMember;
use Illuminate\Http\Request;
use Session;

class TeamMembersController extends Controller
{
    public function index()
    {
        $teams = Team::with('department')->get();
        $employees = Employee::where('status', '!=', '0')->get();

        return view('admin.teams.team_member')->with('teams', $teams)->with('employees', $employees);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'team_member' => 'required',
        ]);
        $member_exist = TeamMember::where('employee_id', $request->team_member)->where('team_id', $request->team_id)->first();
        if ($member_exist == null) {
            TeamMember::create([
                'employee_id' => $request->team_member,
                'team_id'     => $request->team_id,
            ]);
            Session::flash('success', 'Member added to team successfully');
        } else {
            Session::flash('error', 'This employee already exist in this team');
        }

        return redirect()->route('teams.index');
    }

    public function edit($id)
    {
        $team_name = Team::find($id);
        $team_members = TeamMember::with('employee')->where('team_id', $id)->get();

        return view('admin.teams.team_member_edit')->with('team_members', $team_members)->with('team_name', $team_name);
    }

    public function delete($id)
    {
        $member_name = TeamMember::where('id', $id);
        $member_name->delete();
        Session::flash('success', 'Employee deleted from team successfully');

        return redirect()->back();
    }
}
