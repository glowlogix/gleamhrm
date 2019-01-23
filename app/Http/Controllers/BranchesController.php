<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;
use Session;
use Carbon\Carbon;

class BranchesController extends Controller
{
    use MetaTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $weekDays = [
        "Monday" => "Monday",
        "Tuesday" => "Tuesday",
        "Wednesday" => "Wednesday",
        "Thursday" => "Thursday",
        "Friday" => "Friday",
        "Saturday" => "Saturday",
        "Sunday" => "Sunday",
    ];

    public function index()
    {
        $this->meta['title'] = 'Branches';
        $branches = Branch::all();

        return view('admin.branches.index', $this->metaResponse())->with('branches', $branches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Branch';
        return view('admin.branches.create', $this->metaResponse())->with('weekDays', $this->weekDays);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'status' => 'required',
            'timing_start' => 'required',
            'timing_off' => 'required|after:timing_start',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        Branch::create([
            'name' => $request->name,
            // 'status' => $request->status,
            'timing_start' => Carbon::parse($request->timing_start),
            'timing_off' => Carbon::parse($request->timing_off),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'weekend' => json_encode($request->weekend)
        ]);

        Session::flash('success', 'Branch is created successfully');
        return redirect()->route('branch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch $officeLocation
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $officeLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch $officeLocation
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $this->meta['title'] = 'Update Branch';
        $office_location = Branch::find($id);
        return view('admin.branches.edit', $this->metaResponse())->with('office_location', $office_location)->with('weekDays', $this->weekDays);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Branch $officeLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'timing_start' => 'required',
            'timing_off' => 'required|after:timing_start',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        $office_location = Branch::find($id);
        $office_location->name = $request->name;
        $office_location->status = $request->status;
        $office_location->timing_start = Carbon::parse($request->timing_start);
        $office_location->timing_off = Carbon::parse($request->timing_off);
        $office_location->address = $request->address;
        $office_location->phone_number = $request->phone_number;
        $office_location->weekend = json_encode($request->weekend);

        $office_location->save();

        Session::flash('success', 'Branch is updated successfully');
        return redirect()->route('branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch $officeLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        Session::flash('success', 'Branch deleted successfully.');
        return redirect()->back();
    }
}
