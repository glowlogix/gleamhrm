<?php

namespace App\Http\Controllers;

use App\Faq;
use App\FaqCategory;
use Illuminate\Http\Request;
use Session;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq_categories = FaqCategory::with('faqs')->get();

        return view('help.faq')->with('faq_categories', $faq_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $faq = Faq::where('question', $request->question)->first();

        if ($faq == null) {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->category_id = $request->category;
            $faq->save();

            Session::flash('success', 'Faq is created successfully');
        } else {
            Session::flash('error', 'Faq with this question is already exist');
        }

        return redirect()->route('faq.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $faq = Faq::find($request->faq_id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->category_id = $request->category;
        $faq->save();

        Session::flash('success', 'FAQ is updated successfully');

        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $faq = Faq::find($request->faq_id);
        $faq->delete();

        Session::flash('success', 'FAQ is deleted successfully');

        return redirect()->route('faq.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function faqCategoryStore(Request $request)
    {
        $faq_category = FaqCategory::where('name', $request->category_name)->first();

        if ($faq_category == null) {
            $faq_category = new FaqCategory();
            $faq_category->name = $request->category_name;
            $faq_category->save();

            Session::flash('success', 'Faq category is created successfully');
        } else {
            Session::flash('error', 'Faq category with this name is already exist');
        }

        return redirect()->route('faq.index');
    }
}
