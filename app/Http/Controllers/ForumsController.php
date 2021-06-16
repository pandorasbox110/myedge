<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Section;
use DB;
use App\Forum;

class ForumsController extends Controller
{
   
    public function index(Request $request)
    {
        $type='forum';
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        $results = Forum::paginatedSearch($keyword,$currentuser);
        return view('messages.forums.index',compact('results','type','keyword'));
    }


    public function create()
    {
        $type='forum';
        $currentuser=Auth::user();
        if($currentuser->userType->name == 'Institute Admin'){ // get all class of the institute
            $sections=Section::where('status',1)
                             ->whereHas('user',function($q) use($currentuser){
                                   $q->where('institute_id',$currentuser->institute_id);
                             })
                             ->orWhere('added_by',$currentuser->id)
                             ->get();
        }else if($currentuser->userType->name == 'Teacher'){
            $sections=Section::where('added_by',$currentuser->id)->get();
        }
        
        return view('messages.forums.create',compact('type','sections','currentuser'));
    }


    public function store(Request $request)
    {
        $has_exceptions = DB::transaction(function() use($request) {

            Forum::create([
                            'post' => request('editor_input'),  
                            'audience'=>request('audience'),
                            'can_comment'=>request('comment'),
                            'added_by'=> request('current_user'),
                            'is_deleted'=>0  
                        ]);

       });

       
       // Return the transaction response.
       $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
       return response()->json($response);
    }


    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

 
    public function destroy($id)
    {
        //
    }
}
