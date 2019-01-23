<?php

namespace App\Http\Controllers;

use File;
use Session;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\MetaTrait;
use App\Document;

class DocumentsController extends Controller
{
    use MetaTrait;

    public function index()
    {
        $this->meta['title'] = 'Documnents';
        $data = Document::get();
        return view('admin.docs.index', ['files' => $data], $this->metaResponse());
    }

    public function createDocs(Request $request)
    {
        return view('admin.docs.upload');
    }

    public function editDocument(Request $request, $id)
    {
        $document = Document::find($id);
        return view('admin.docs.edit', ['document' => $document]);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            // 'document' => 'required',
            'upload_status' => 'required'
        ]);

        $document = Document::find($id);

        if ($request->document != "") {
            $document_file = time() . '_' . $request->document->getClientOriginalName();
            $request->document->move('storage/documents/', $document_file);
            $document->url = 'storage/documents/' . $document_file;
        }

        $document->name = $request->document_name;
        $document->status = $request->upload_status;
        $document->save();

        Session::flash('success', 'Document is updated successfully');

        return redirect()->route('documents');
    }

    public function deleteDocument(Request $request, $id)
    {
        Document::find($id)->delete();

        Session::flash('success', 'Document is deleted successfully');

        return redirect()->back();
    }


    public function uploadDocs(Request $request)
    {
        $this->validate($request, [
            'document' => 'required|mimes:doc,docx,pdf|max:2000',
            'document_name' => 'required'
        ]);
        $arr = array();

        $arr = [
            'name' => $request->document_name,
        ];

        if ($request->document != "") {
            $document = time() . '_' . $request->document->getClientOriginalName();
            $request->document->move('storage/documents/', $document);
            $arr['url'] = 'storage/documents/' . $document;
        }

        Document::insert($arr);

        Session::flash('success', 'File is uploaded successfully');
        return redirect()->route('documents');
    }
}
