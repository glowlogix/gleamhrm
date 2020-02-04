<?php

namespace App\Http\Controllers;

use App\OfficeLocation;
use App\Traits\MetaTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class OfficeLocationController extends Controller
{
    use MetaTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->meta['title'] = 'Office Locations';
        $office_locations = OfficeLocation::all();

        return view('admin.office_locations.index', $this->metaResponse())->with('office_locations', $office_locations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Office Location';

        return view('admin.office_locations.create', $this->metaResponse());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'status' => 'required',
            'timing_start' => 'required',
            'timing_off'   => 'required|after:timing_start',
            'address'      => 'required',
            'phone_number' => 'required',
        ]);

        $office_location = OfficeLocation::create([
            'name' => $request->name,
            // 'status' => $request->status,
            'timing_start' => Carbon::parse($request->timing_start),
            'timing_off'   => Carbon::parse($request->timing_off),
            'address'      => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        Session::flash('success', 'OfficeLocation is created successfully');

        return redirect()->route('offices');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\OfficeLocation $officeLocation
     *
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeLocation $officeLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\OfficeLocation $officeLocation
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Update OfficeLocation';
        $office_location = OfficeLocation::find($id);

        return view('admin.office_locations.edit', $this->metaResponse())->with('office_location', $office_location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\OfficeLocation      $officeLocation
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'         => 'required',
            'status'       => 'required',
            'timing_start' => 'required',
            'timing_off'   => 'required|after:timing_start',
            'address'      => 'required',
            'phone_number' => 'required',
        ]);

        $office_location = OfficeLocation::find($id);
        $office_location->name = $request->name;
        $office_location->status = $request->status;
        $office_location->timing_start = Carbon::parse($request->timing_start);
        $office_location->timing_off = Carbon::parse($request->timing_off);
        $office_location->address = $request->address;
        $office_location->phone_number = $request->phone_number;

        $office_location->save();

        Session::flash('success', 'Office location is updated successfully');

        return redirect()->route('offices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\OfficeLocation $officeLocation
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $office_location = OfficeLocation::find($id);
        $office_location->delete();
        Session::flash('success', 'OfficeLocation deleted successfully.');

        return redirect()->back();
    }
}
