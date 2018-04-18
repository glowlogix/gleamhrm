<?php

namespace App\Http\Controllers;
use Session;
use DB;
use File;

use Illuminate\Http\Request;
use App\Http\Requests;

class DocumentsController extends Controller
{
    public function index(){
        return view('admin.docs.index');
    }

    public function uploadDocs(Request $request){
           $this->validate($request, [
           'docs.*'=>'required|mimes:doc,docx,pdf|max:2000'
           ]);
           $files = $request->file('docs');           
          foreach($files as $file){
           
          $filename = $file->getClientOriginalName();
           
          $extension = $file->getClientOriginalExtension();
          $path = $file->store('files');
          DB::table('uploads')->insert([
            'filename' => $filename,
            'filepath' => $path
           ]);

          }
          Session::flash('success','File is upploaded succesfully');
          return redirect()->back();
    }
}
