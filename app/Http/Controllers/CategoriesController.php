<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
use App\Traits\MetaTrait;

class CategoriesController extends Controller
{
    use MetaTrait;
    
    public function index(){

        $this->meta['title'] = 'Categories';        
    	return view('admin.categories.index',$this->metaResponse())->with('categories',Category::all());
    }
    public function create(){

        $this->meta['title'] = 'Create Category';                
    	return view('admin.categories.create',$this->metaResponse());
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

        $this->meta['title'] = 'Update Category';                        
        $category=Category::find($id);
        return view('admin.categories.edit',$this->metaResponse())->with('category',$category);
        
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
