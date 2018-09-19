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
        $data = DB::table('uploads')->get();
        return view('admin.docs.index',['files' => $data]);
    }

    public function uploadDocs(Request $request){
        $this->validate($request, [
            'docs.*'=>'required|mimes:doc,docx,pdf|max:2000',
            'application_name' => 'required'
        ]);

        $files = $request->file('docs');    
        $application_name = $request->application_name;
        foreach($files as $file){

            $Uniquefilename = uniqid().$file->getClientOriginalName();
            $filename = $file->getClientOriginalName();;
            $path = public_path('storage/public/');

            $fileObject = $file->move($path, $Uniquefilename);
            if($fileObject){
                DB::table('uploads')->insert([
                    'filename' => $Uniquefilename,
                    'originalname' => $filename,
                    'status' => 1      
                ]);
            }
        }
        Session::flash('success','File is upploaded succesfully');
        return redirect()->back();
    }

    public function statusChange(Request $request,$id){
        $data = DB::table('uploads')->where('id',$id)->first();
        $status = $request->upload_status;
        $row = DB::table('uploads')
        ->where('id', $id)
        ->update(['status' => $status]);

        if($row){
            Session::flash('success','Status is change succesfully');            
        }
        return redirect()->back();
    }
}
