<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
class CategoriesController extends Controller
{
    public function index(){
    	return view('admin.categories.index')->with('categories',Category::all());
    }
    public function create(){
    	return view('admin.categories.create');
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'name' =>'required'
    	]);
    	$category= new Category;
    	$category->name=$request->name;
    	$category->save();
    	return redirect()->back();
    }
    public function edit($id)
    {
        $category=Category::find($id);
        return view('admin.categories.edit')->with('category',$category);
        
    }
    public function update($id, Request $request)
    {
        $category=Category::find($id);
        $category->name=$request->name;
        $category->save();
        Session::flash('success', 'Category updated successfully.');
        return redirect()->back();


    }
    public function delete($id)
    {
        $category=Category::find($id);
        $category->delete();
        Session::flash('success','User is deleted successfully.');
        return redirect()->back();
    }

}
