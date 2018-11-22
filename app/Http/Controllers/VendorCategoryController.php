<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\VendorCategory;
use Illuminate\Http\Request;
use Session;

class VendorCategoryController extends Controller
{
    public function index()
    {
        $vendor_category = VendorCategory::all();
        return view('admin.vendors.vendor_category')->with('vendor_category',$vendor_category);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'required',
        ]);
        $category_exist=VendorCategory::where('category_name',$request->category_name)->first();
        if($category_exist == null){
            $vendor_category = VendorCategory::create([
                'category_name' => $request->category_name,
            ]);
            Session::flash('success','Vendor Category is created successfully');
            return redirect()->route('vendor_category.index');
        }
        else
        {
            Session::flash('error','Vendor Category with this name Already Exist');
            return redirect()->route('vendor_category.index');
        }

    }
    public function update (Request $request ,$id)
    {
        $vendor_category=VendorCategory::find($id);
        $vendor_category->category_name = $request->category_name;
        $vendor_category->save();
        Session::flash('success','Vendor Category is updated successfully');
        return redirect()->route('vendor_category.index');
    }
    public function delete(Request $request ,$id)
    {
        $vendor_category = VendorCategory::find($id);
        $vendor_category->delete();
        Session::flash('success','Vendor Category deleted successfully.');
        return redirect()->route('vendor_category.index');
    }
}
