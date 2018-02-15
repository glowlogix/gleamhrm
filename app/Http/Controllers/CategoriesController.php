<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
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
}
