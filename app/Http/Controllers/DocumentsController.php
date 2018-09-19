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

    public function createDocs(Request $request){
        return view('admin.docs.upload');
    }

    public function editDocument(Request $request,$id){
        $document = DB::table('documents')->where('id',$id)->first();
        return view('admin.docs.edit',['document'=>$document]);
    }

    public function updateDocument(Request $request,$id){

        $this->validate($request, [
            'documentname' => 'required',
            'upload_status' => 'required'
        ]);

        DB::table('documents')->where('id',$id)->first();
        $status = $request->upload_status;
        $name = $request->documentname;
        DB::table('documents')
        ->where('id', $id)
        ->update(['status' => $status,'name' => $name]);
        
        Session::flash('success','Document is updated succesfully');            
        
        return redirect()->route('documents.upload');
    }

    public function deleteDocument(Request $request,$id){
        DB::table('documents')->where('id',$id)->delete();
        
        Session::flash('success','Document is deleted succesfully');            
        
        return redirect()->back();
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
}
