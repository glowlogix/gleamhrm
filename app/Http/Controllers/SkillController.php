<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeSkill;
use App\Skill;
use Illuminate\Http\Request;
use Session;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        $employees = Employee::where('status', '!=', '0')->get();

        return view('admin.skills.index')->with('skills', $skills)->with('employees', $employees);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'skill_name'  => 'required',
            'status'      => 'required',
            'description' => 'required',
        ]);
        $skill_exist = Skill::where('skill_name', $request->skill_name)->first();
        if ($skill_exist == null) {
            Skill::create([
                'skill_name'  => $request->skill_name,
                'status'      => $request->status,
                'description' => $request->description,
            ]);
            Session::flash('success', 'Skill is created successfully');
        } else {
            Session::flash('error', 'Skill with this name already exist');
        }

        return redirect()->route('skill.index');
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);
        $skill->skill_name = $request->skill_name;
        $skill->status = $request->status;
        $skill->description = $request->description;
        $skill->save();
        Session::flash('success', 'Skill is updated successfully');

        return redirect()->route('skill.index');
    }

    public function delete(Request $request, $id)
    {
        $skill = Skill::where('id', $id);
        $skill->delete();
        Session::flash('success', 'Skill deleted successfully.');

        return redirect()->route('skill.index');
    }

    //

    public function assign(Request $request)
    {
        $this->validate($request, [
            'skill_id'    => 'required',
            'employee_id' => 'required',
        ]);
        $employee_exist = EmployeeSkill::where('skill_id', $request->skill_id)->where('employee_id', $request->employee_id)->first();
        if ($employee_exist == null) {
            EmployeeSkill::create([
                'skill_id'    => $request->skill_id,
                'employee_id' => $request->employee_id,
            ]);
            Session::flash('success', 'Skill assigned successfully');

            return redirect()->route('skill.index');
        } else {
            Session::flash('error', 'Skill already assigned this employee');

            return redirect()->route('skill.index');
        }
    }

    public function assign_edit($id)
    {
        $skill_name = Skill::where('id', $id)->first();
        $assigned_employees = EmployeeSkill::with('employee')->where('skill_id', $id)->get();

        return view('admin.skills.skill_assign_edit')->with('assigned_employees', $assigned_employees)->with('skill_name', $skill_name);
    }

    public function unassign(Request $request, $id)
    {
        $unassign_skill = EmployeeSkill::where('id', $id)->first();
        $unassign_skill->delete();
        Session::flash('success', 'Skill unassigned from employee successfully.');

        return redirect()->back();
    }

    //
}
