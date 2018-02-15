public function findjob(Request $request){
        $data=Job::select('title','id')->where('category_id',$request->id)->take(20)->get();
        return response()->json($data);
    }