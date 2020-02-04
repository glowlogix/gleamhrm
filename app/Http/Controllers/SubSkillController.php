<?php

namespace App\Http\Controllers;

use App\Skill;
use App\SubSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubSkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();

        return view('admin.skills.sub_skill')->with('skills', $skills);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'sub_skill_name' => 'required',
        ]);
        $sub_skill_exist = SubSkill::where('sub_skill_name', $request->sub_skill_name)->where('skill_Id', $request->skill_id)->first();
        if ($sub_skill_exist == null) {
            SubSkill::create([
                'sub_skill_name' => $request->sub_skill_name,
                'skill_id'       => $request->skill_id,
            ]);
            Session::flash('success', 'Sub-Skill added successfully');
        } else {
            Session::flash('error', 'This sub-skill already exist in this parent skill');
        }

        return redirect()->route('sub_skill.index');
    }

    public function edit($id)
    {
        $skill_name = Skill::find($id);
        $sub_skills = SubSkill::where('skill_id', $id)->get();

        return view('admin.skills.sub_skill_edit')->with('sub_skills', $sub_skills)->with('skill_name', $skill_name);
    }

    public function delete($id)
    {
        $sub_skill = SubSkill::find($id);
        $sub_skill->delete();
        Session::flash('success', 'Sub-Skill deleted successfully');

        return redirect()->back();
    }

    public function sub_edit(Request $request, $id)
    {
        $sub_skill = SubSkill::find($id);
        $sub_skill->sub_skill_name = $request->sub_skill_name;
        $sub_skill->save();
        Session::flash('success', 'Sub-Skill updated successfully');

        return redirect()->back();
    }
}
