<?php

namespace App\Http\Controllers;

use App\Platform;
use Illuminate\Http\Request;
use Session;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platform = Platform::first();

        return view('admin.platform.index')->with('platform', $platform);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $platform = Platform::first();

        return view('admin.platform.edit')->with('platform', $platform);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $platform = Platform::first();

        if ($platform == '') {
            $platform = new Platform();
            $platform->name = $request->name;
            $platform->website = $request->website;
            if ($request->logo != '') {
                $logo = time().'_'.$request->logo->getClientOriginalName();
                $request->logo->move('storage/companylogo/', $logo);
                $platform->logo = 'storage/companylogo/'.$logo;
            }
            $platform->email = $request->email;
            $platform->hr_email = $request->hr_email;
            $platform->mobile_no = $request->mobile_no;
            $platform->phone_no = $request->phone_no;
            $platform->save();
        } else {
            $platform->name = $request->name;
            $platform->website = $request->website;
            if ($request->logo != '') {
                $logo = time().'_'.$request->logo->getClientOriginalName();
                $request->logo->move('storage/companylogo/', $logo);
                $platform->logo = 'storage/companylogo/'.$logo;
            }
            $platform->email = $request->email;
            $platform->hr_email = $request->hr_email;
            $platform->mobile_no = $request->mobile_no;
            $platform->phone_no = $request->phone_no;
            $platform->save();
        }
        Session::flash('success', 'Platform details are updated successfully');

        return redirect()->route('admin.platform.index');
    }
}
