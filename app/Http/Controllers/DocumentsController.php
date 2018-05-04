<?php

namespace App\Http\Controllers;

use DB;
use File;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;

class DocumentsController extends Controller
{
    use MetaTrait;
    
    public function index(){

        $this->meta['title'] = 'Upload Documnents';        
        $data = DB::table('documents')->get();
        return view('admin.docs.index',['files' => $data],$this->metaResponse());
    }

    public function createDocs(Request $request){
        return view('admin.docs.upload');
    }

    public function uploadDocs(Request $request){
        $this->validate($request, [
            'documents.*' => 'required|mimes:doc,docx,pdf|max:2000',
            'document_name' => 'required'
        ]);

        $files = $request->file('documents');
        $document_name = $request->document_name;
        foreach ($files as $file) {

            $Uniquefilename = time().$file->getClientOriginalName();
            $path = public_path('storage/public/');

            $fileObject = $file->move($path, $Uniquefilename);
            if ($fileObject) {
                DB::table('documents')->insert([
                    'url' => $Uniquefilename,
                    'name' => $document_name
                ]);
            }
        }
        Session::flash('success', 'File is upploaded succesfully');
        return redirect()->route('documents.upload');
    }

    public function statusChange(Request $request,$id){
        DB::table('documents')->where('id',$id)->first();
        $status = $request->upload_status;
        DB::table('documents')
        ->where('id', $id)
        ->update(['status' => $status]);
        
        Session::flash('success','Status is change succesfully');            
        
        return redirect()->back();
    }
}
