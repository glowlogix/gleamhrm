<?php

namespace App\Http\Controllers;

use App\Country;
use App\Vendor;
use App\VendorCategory;
use Illuminate\Http\Request;
use Session;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();

        return view('admin.vendors.index')->with('vendors', $vendors);
    }

    public function create()
    {
        $vendor_categories = VendorCategory::all();

        return view('admin.vendors.create')->with('vendor_categories', $vendor_categories)->with('countries', Country::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'contact_title' => 'required',
            'contact_name'  => 'required',
            //          'mobile' => 'required',
            //          'fax' => 'required',
            //          'country' => 'required',
            //          'postal' => 'required',
            //          'address' => 'required',
            //          'city' => 'required',

        ]);
        $vendor = Vendor::create([
            'company_name'       => $request->name,
            'contact_name'       => $request->contact_name,
            'contact_title'      => $request->contact_title,
            'email'              => $request->email,
            'address'            => $request->address,
            'city'               => $request->city,
            'postal_code'        => $request->postal,
            'country'            => $request->country,
            'mobile'             => $request->mobile,
            'fax'                => $request->fax,
            'vendor_category_id' => $request->vendor_category_id,

        ]);
        Session::flash('success', 'Vendor is created successfully');

        return redirect()->route('vendors.index');
    }

    public function edit($id)
    {
        $vendor = Vendor::where('id', $id)->first();

        return view('admin.vendors.edit')->with('vendor', $vendor)->with('vendor_categories', VendorCategory::all());
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        $vendor->company_name = $request->name;
        $vendor->contact_name = $request->contact_name;
        $vendor->contact_title = $request->contact_title;
        $vendor->email = $request->email;
        $vendor->address = $request->address;
        $vendor->city = $request->city;
        $vendor->postal_code = $request->postal;
        $vendor->country = $request->country;
        $vendor->mobile = $request->mobile;
        $vendor->fax = $request->fax;
        $vendor->vendor_category_id = $request->vendor_category_id;
        $vendor->save();
        Session::flash('success', 'Vendor is updated successfully');

        return redirect()->route('vendors.index');
    }

    public function delete(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        Session::flash('success', 'Vendor deleted successfully.');

        return redirect()->route('vendors.index');
    }
}
