<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Section;
use App\AssignedProduct;
use App\SectionSubject;
use App\SectionSubjectScale;
use App\SectionStudent;
use App\User;
use App\QuestionType;
use App\CreatedSubject;
use App\MySubject;
use App\Lesson;
use App\Topic;
use App\SubjectAssessment;
use App\Question;
use App\Answer;
use App\AssessmentQuestion;
use App\AssessmentStudent;
use App\SubmittedAssessment;
use App\SectionTeacher;
use Storage;

class SectionsController extends Controller
{
    
    public function databaseEdit(){
            
        $datas=Topic::get();
        
        foreach($datas as $data){
            
            Topic::where('id',$data->id)
                 ->update([
                                'content'=>str_replace("https://myedge.edupowerpublishing.comhttps://myedge.edupowerpublishing.com", "https://myedge.edupowerpublishing.com", $data->content)
                          ]);
        }
            
    }
    
    /*SECTION*/
    //display of classes/sections
    public function index(Request $request)
    {   
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        if($currentuser->userType->name == 'Student'){
            
            //student all uploaded/publish class that enroll by this student 
            $results = Section::paginatedSearchStudent($keyword,$currentuser->id);
            
        }elseif(Auth::user()->userType->name == 'Teacher'){
            
            //teacher - those class that create by here self or shared by there co teacher
            $results = Section::paginatedSearch($keyword,$currentuser);
            
        }else if(Auth::user()->userType->name == 'Institute Admin'){
            
            //insti admin - those class that is uploded and create by the teacher of there institute
            $results = Section::paginatedSearchInstiAdmin($keyword,$currentuser);
        } 
        
        //add parent
        
        //return $results;
        return view('sections.index', compact('results', 'keyword'));
      
    }

    //create new section
    public function create()
    {
        $data=null;
        return view('sections.create',compact('data'));
    }


    //store sections

    public function store(Request $request)
    {
        $has_exceptions = DB::transaction(function() use($request) {

            if(request('id')){//edit
                    //file
                     //cover image
                    if (request('image') != null) {
                        $path = Storage::disk('public')->put('class.images', request('image'));
                        // $image='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$path;
                        $image='/storage/'.$path;

                        Section::where('id',request('id'))
                             ->update([
                                          'image' => $image,
                                      ]);
                    }
                    
                    Section::where('id',request('id'))
                         ->update([
                                    'name'=> request('name'),
                                    'start_date'=> request('start_date'),
                                    'grade_id'=> request('grade_id'),
                                    'end_date'=> request('end_date'),
                                    'updated_by'=>request('current_user'),
                                 ]);


            }else{//create
                
                $image=null;
                if (request('image') != null) {
                    $path = Storage::disk('public')->put('class.images', request('image'));
                    // $image='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$path;
                    $image='/storage/'.$path;
                }

                Section::create([

                                'name'=> request('name'),
                                'start_date'=> request('start_date'),
                                'grade_id'=> request('grade_id'),
                                'end_date'=> request('end_date'),
                                'added_by'=>request('current_user'),
                                'image'  => $image,
                                'status'=>0, 
                                'is_deleted'=>0  
                            ]);
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }


    //Instruction of classes
    public function show($id)
    {
        $type='instruction';
        $section=Section::with('grade')->where('id',$id)->first();
        
        if(Auth::user()->userType->name == 'Teacher'){
            return view('sections.view',compact('section','type'));
        }else{
            return view('sections.view2',compact('section','type'));
        }
        
    }


    public function edit($id)
    {
        $data=Section::where('id',$id)->where('is_deleted',0)->first();
        return view('sections.create',compact('data'));
    }

    public function delete(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            Section::where('id',request('id'))
                   ->update([
                              'is_deleted' => 1,
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function status(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            Section::where('id',request('id'))
                   ->update([
                              'status' => request('status'),
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function shared(Request $request, $id){
        
        
        $keyword = $request->keyword;
        $results = SectionTeacher::whereHas('user',function($q) use($keyword){
                                        $q->where('name', 'LIKE', '%'.$keyword.'%')
                                          ->orWhere('email', 'LIKE', '%'.$keyword.'%');
                                     })
                                 ->where('section_id',$id)
                                 ->where('is_deleted',0)
                                 ->paginate(10);
                                 
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);
        
        return view('sections.shared', compact('results', 'keyword','id'));
        
    }
    
    public function share(Request $request,$id){
        
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        $section=Section::where('id',$id)->first();
        $shareusers=SectionTeacher::where('section_id',$id)->where('is_deleted',0)->get();
        $shareuserids=[];
        foreach($shareusers as $shareuser){
            $shareuserids[]=$shareuser->teacher_id;
        }
        $results=User::where(function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('email', 'LIKE', '%'.$keyword.'%');
                        })
                     ->where('institute_id',$currentuser->institute_id)
                     ->whereHas('userType',function($q){
                           $q->whereIn('name',['Teacher','Institute Admin']);
                       })
                     ->whereNotIn('id',$shareuserids)
                     ->where('id','!=',$currentuser->id)
                     ->paginate(10);
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 10
        ]);
        
        //return $results;  
        return view('sections.share', compact('results', 'keyword','id','section')); 
    }
    
    
    public function shareStore(Request $request){

        $has_exceptions = DB::transaction(function() use($request) {

            for ($i=0; $i < count(request('users')) ; $i++) { 

                SectionTeacher::create([
                                            'section_id'         =>request('section_id'),
                                            'teacher_id'         =>request('users')[$i],
                                            'create_priv'        =>request('editpriv')[$i],
                                            'edit_priv'           =>request('editpriv')[$i],
                                            'delete_priv'         =>request('deletepriv')[$i],
                                            'assign_prev'         =>request('asignpriv')[$i],
                                            'added_by'           =>request('current_user'),
                                            'is_deleted'         =>0,
                                        ]);   
            }
        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
     public function shareRemove(Request $request){

        $has_exceptions = DB::transaction(function() use($request) {
            
            SectionTeacher::where('id',request('id'))
                          ->update([
                                  'is_deleted' => 1,
                                ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    /*SUBJECTS*/

    public function subjectIndex(Request $request, $id){
        
        $type='subject';
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        $section=Section::with([
                                    'grade',
                                    'sectionTeacher'=>function($q) use($currentuser){
                                        $q->where('teacher_id',$currentuser->id)
                                          ->where('is_deleted',0);   
                                    }
                               ])
                        ->where('id',$id)
                        ->first();
                        
        if($currentuser->userType->name == 'Student' || Auth::user()->userType->name == 'Institute Admin'){
            
            //display  all uploaded/publish subject that enroll by this student 
            $targetStat=[1];
            
        }elseif(Auth::user()->userType->name == 'Teacher'){
            
            //teacher - those subject that create by here self or shared by there co teacher 
            $targetStat=[0,1];
        }
        
        $results=SectionSubject::paginatedSearch($keyword,$id,$targetStat); 
        //add insti. admin
        //add parent
        
        return view('sections.subjects.index',compact('section','results','type','keyword'));
    }

    public function subjectCreate(Request $request, $id){
        
        $type='subject';
        $section=Section::with('grade')->where('id',$id)->first();
        $data=null;
        return view('sections.subjects.create',compact('section','type','data'));
    }

    public function subjectEdit($section_id,$id){

        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $data=SectionSubject::where('id',$id)->where('is_deleted',0)->first();
        return view('sections.subjects.create',compact('section','type','data'));
    }

    public function subjectStore(Request $request){
        //for created subject only the scorm subject is d=for develop
        $has_exceptions = DB::transaction(function() use($request) {

            if(request('id')){//edit 
                
                $subject=SectionSubject::where('id',request('id'))->first();
                
                if (request('image') != null) {
                    $path = Storage::disk('public')->put('class.images', request('image'));
                    // $image='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$path;
                    $image='/storage/'.$path;
                    
                    SectionSubject::where('id',request('id'))
                                  ->update([
                                                'image'=>$image,
                                           ]);
                }
                
                SectionSubject::where('id',request('id'))
                              ->update([
                                            'updated_by'=>request('current_user'),
                                       ]);
                CreatedSubject::where('id',$subject->MySubject->subject_id)
                              ->update([
                                            'name'=>request('subject_name'),
                                            'updated_by'=>request('current_user'),
                                       ]);

                SectionSubjectScale::where('section_subject_id',request('id'))
                                   ->update([
                                                'is_deleted'=>1,
                                            ]);

                for ($i=0; $i < count(request('category')) ; $i++) { 

                    if(request('scale_id')[$i]){
                        SectionSubjectScale::where('id',request('scale_id')[$i])
                                           ->update([
                                                        'name'=>request('category')[$i],
                                                        'weight'=>request('weight')[$i],
                                                        'is_deleted'=>0,
                                                    ]);
                    }else{
                        SectionSubjectScale::create([
                                                        'name'=>request('category')[$i],
                                                        'weight'=>request('weight')[$i],
                                                        'section_subject_id'=>request('id'),
                                                        'is_deleted'=>0,
                                                    ]); 
                    }  
                }


                  
            }else{//create
                
                $image=null;
                if (request('image') != null) {
                    $path = Storage::disk('public')->put('subject.images', request('image'));
                    // $image='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$path;
                    $image='/storage/'.$path;
                }
                if(request('subject_id')){
                    $my_subject=request('subject_id');
                }else{

                    //create subject
                    $subject_id=CreatedSubject::create([
                                                                    'name' => request('subject_name'),
                                                                    'added_by'=> request('current_user'),
                                                                    'is_deleted'=>0,
                                                               ])->id;
                    //assign created subject
                    $my_subject=MySubject::create([
                                        'subject_id' => $subject_id,
                                        'assignee'=> request('current_user'),
                                        'assignor'=> request('current_user'),
                                        'is_deleted'=>0,
                                       ])->id;
                }

                $section_subject_id=SectionSubject::create([
                                                                'image'=>$image,
                                                                'section_id'=> request('section_id'),
                                                                'my_subject_id'=> $my_subject,
                                                                'added_by'=> request('current_user'),
                                                                'status'=>0,
                                                                'is_deleted'=>0,
                                                                
                                                            ])->id;

                for ($i=0; $i < count(request('category')) ; $i++) { 

                    SectionSubjectScale::create([
                                                    'name'=>request('category')[$i],
                                                    'weight'=>request('weight')[$i],
                                                    'section_subject_id'=>$section_subject_id,
                                                    'is_deleted'=>0,
                                                ]);   
                }
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);

    }

    public function subjectDelete(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            SectionSubject::where('id',request('id'))
                   ->update([
                              'is_deleted' => 1,
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function subjectStatus(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            SectionSubject::where('id',request('id'))
                   ->update([
                              'status' => request('status'),
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }

    /*lessons "CREATE OWN SUBJECT AUTHORING TOOL"*/

    //lesson
    public function subjectLessons(Request $request, $id,$subject_id,$lesson_id){

        $type='subject';
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        $section=Section::with([
                                    'grade',
                                    'sectionTeacher'=>function($q) use($currentuser){
                                                $q->where('teacher_id',$currentuser->id)
                                                  ->where('is_deleted',0);   
                                            }
                                ])
                        ->where('id',$id)
                        ->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $created_id=$subject->mySubject->createdSubject->id;
        
        if($currentuser->userType->name == 'Student' || Auth::user()->userType->name == 'Institute Admin'){
            
            //display  all uploaded/publish lesson that enroll by this student 
            $targetStat=[1];
            
        }elseif(Auth::user()->userType->name == 'Teacher'){
            
            //teacher - those lesson that created by here self (to add those class shared by other teacher/ inst admin )
            $targetStat=[0,1];
        }
        
        $lessons=Lesson::with([
                                'topic'=>function($q) use($targetStat){
                                        $q->where('is_deleted',0)
                                          ->whereIn('status',$targetStat);
                                    }
                              ])
                       ->where('created_subject_id',$created_id)
                       ->whereIn('status',$targetStat)
                       ->where('is_deleted',0)
                       ->get();
        $lesson=null;
        $results=[];
        if(count($lessons) > 0){//with lessons
            if($lesson_id == 'null'){

                $lesson=Lesson::where('id',$lessons[0]->id)->first();

            }else{//lesson 1 default null lesson id
                $lesson=Lesson::where('id',$lesson_id)->first();
            }

            $results=Topic::where(function($q) use($keyword) {
                                    $q->where('name','LIKE', '%'.$keyword.'%');
                                })
                                ->where('is_deleted',0)
                                ->where('lesson_id',$lesson->id)
                                ->whereIn('status',$targetStat)
                                ->paginate(10);

            $results->appends([
                        'keyword' => $keyword,
                        'search_pagination' => 10
                    ]);
        }
        return view('sections.subjects.lessons.index',compact('section','subject','type','lessons','lesson','results','keyword'));
    }

    public function subjectLessonStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            if(request('lesson_id')){//edit 
                Lesson::where('id',request('lesson_id'))
                      ->update([
                                    'name'       => request('lesson'),
                                    'updated_by' => request('current_user'),
                               ]);

            }else{//create

                Lesson::create([
                                    'name'                  => request('lesson'),
                                    'created_subject_id'    =>request('subject_id'),
                                    'added_by'              => request('current_user'),
                                    'status'=>0,
                                    'is_deleted'            => 0,
                              ]);
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);

    }

    public function getSubjectLesson(Request $request){
        $result=Lesson::where('id',request('lesson_id'))->first();
        return response()->json($result);
    }

    public function subjectLessonDelete(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            Lesson::where('id',request('id'))
                   ->update([
                              'is_deleted' => 1,
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function subjectLessonStatus(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {
            
            Lesson::where('id',request('id'))
                   ->update([
                              'status' => request('status'),
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }

    //topic
    public function lessonTopicStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            if(request('topic_id')){//edit 
                
                if(request('content_type') === 'doc'){//file
                
                    $file=request('topic')->storeAs('topics',request('topic')->getClientOriginalName(),'public');
                    // $path='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$file;
                    $path='/storage/'.$file;
                
                }else{

                    $path=request('topic');
                }

                Topic::where('id',request('topic_id'))
                     ->update([
                                    'name'     => request('name'),
                                    'content'  => $path,
                                    'updated_by' => request('current_user'),
                              ]);
            }else{//create

                if(request('content_type') === 'doc'){//file
                
                    $file=request('topic')->storeAs('topics',request('topic')->getClientOriginalName(),'public');
                    // $path='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$file;
                    $path='/storage/'.$file;
                
                }else{

                    $path=request('topic');

                }

                Topic::create([
                                    'name'                  => request('name'),
                                    'content_type'          => request('content_type'),
                                    'content'               => $path,
                                    'lesson_id'             => request('lesson_id'),
                                    'added_by'              => request('current_user'),
                                    'status'=>0,
                                    'is_deleted'            => 0,
                              ]);
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);

    }

    public function lessonTopicView(Request $request){

        $results=Topic::where('id',request('topic_id'))->first();
        return response()->json($results);

    }

    public function lessonTopicDelete(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            Topic::where('id',request('id'))
                   ->update([
                              'is_deleted' => 1,
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function lessonTopicStatus(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {
            
            Topic::where('id',request('id'))
                   ->update([
                              'status' => request('status'),
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }

    public function getSubject(Request $request){

        $response=SectionSubject::where('section_id',request('id'))
                                ->where('created_by',request('user'))
                                ->get();

        return response()->json($response);
    }

    //Assessments

    public function subjectAssessmentIndex(Request $request, $section_id,$subject_id,$assessment_id){

        $type='subject';
        $keyword = $request->keyword;
        $currentuser=Auth::user();
        $question_types=QuestionType::where('is_deleted',0)->get();
        $section=Section::with([
                                    'grade',
                                    'sectionTeacher'=>function($q) use($currentuser){
                                                $q->where('teacher_id',$currentuser->id)
                                                  ->where('is_deleted',0);   
                                            }
                                ])
                        ->where('id',$section_id)
                        ->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessments=SubjectAssessment::where('section_subject_id',$subject_id)
                                          ->where('is_deleted',0)
                                          ->whereIn('status',[0,1])
                                          ->get();
        $assessment=null;
        $results=[];
        if(count($assessments) > 0){//with question
            if($assessment_id == 'null'){
                //add questions 
                $assessment=SubjectAssessment::where('id',$assessments[0]->id)
                              ->first();

            }else{//question 1 default null question id
                $assessment=SubjectAssessment::where('id',$assessment_id)
                              ->first();
            }
            $results=AssessmentQuestion::whereHas('question',function($q) use($keyword){
                                            $q->where('tag','LIKE', '%'.$keyword.'%')
                                              ->orWhereHas('questionType',function($q) use($keyword){
                                                $q->where('name','LIKE', '%'.$keyword.'%');
                                              });
                                        })
                                ->where('is_deleted',0)
                                ->where('subject_assessment_id',$assessment->id)
                                ->paginate(10);

            $results->appends([
                        'keyword' => $keyword,
                        'search_pagination' => 10
                    ]);
        }
        return view('sections.subjects.assessments.index',compact('section','assessments','type','keyword','subject','assessment','question_types','results'));
    }
    
    public function subjectAssessmentIndexStudents(Request $request, $section_id,$subject_id,$assessment_id){
        
        $keyword = $request->keyword;
        $type='subject';
        $keyword = $request->keyword;
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $currentuser=Auth::user();
        $results=SubjectAssessment::with([
                                            'assessmentStudent'=>function($s) use($currentuser){
                                                $s->where('student_id',$currentuser->id)
                                                  ->where('is_deleted',0);
                                            }
                                         ])
                                  ->where(function($q) use($keyword) {
                                        $q->where('name', 'LIKE', '%'.$keyword.'%')
                                          ->orWhere('topic', 'LIKE', '%'.$keyword.'%')
                                          ->orWhere('mode', 'LIKE', '%'.$keyword.'%')
                                          ->orWhereHas('sectionSubjectScale',function($q) use($keyword){
                                                $q->where('name','LIKE', '%'.$keyword.'%');
                                            });
                                    })
                                  ->whereHas('assessmentStudent',function($q) use($currentuser){
                                            $q->where('student_id',$currentuser->id)
                                              ->where('is_deleted',0);
                                    })
                                  ->where('section_subject_id',$subject_id)
                                  ->where('is_deleted',0)
                                  ->where('status',1)
                                  ->paginate(10);
        
        $results->appends([
                        'keyword' => $keyword,
                        'search_pagination' => 10
                    ]);
       // return $results; 
        return view('sections.subjects.assessments.index-student',compact('section','type','keyword','subject','results','assessment_id'));
    }

    public function subjectAssessmentCreate(Request $request, $section_id,$subject_id){

        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::with([
                                        'mySubject',
                                      ])
                               ->where('id',$subject_id)
                               ->first();
        return view('sections.subjects.assessments.create',compact('section','type','data','subject'));
    }

    public function subjectAssessmentStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            if(request('id')){//edit 
                
                SubjectAssessment::where('id',request('id'))
                                 ->update([
                                                'name'                      => request('title'),
                                                'topic'                     =>request('topic'),
                                                'mode'                      =>request('mode'),
                                                'instruction'               =>request('htmleditor_value'),
                                                'section_subject_scale_id'  =>request('scale_id'),
                                                'start_date'                =>request('start_date'),
                                                'end_date'                  =>request('end_date'),
                                                'updated_by' => request('current_user'),
                                          ]);
            }else{//create

                SubjectAssessment::create([
                                            'name'                      => request('title'),
                                            'topic'                     =>request('topic'),
                                            'mode'                      =>request('mode'),
                                            'instruction'               =>request('htmleditor_value'),
                                            'section_subject_id'        =>request('subject_id'),
                                            'section_subject_scale_id'  =>request('scale_id'),
                                            'start_date'                =>request('start_date'),
                                            'end_date'                  =>request('end_date'),
                                            'added_by'                  => request('current_user'),
                                            'status'                    => 0,
                                            'is_deleted'                => 0,
                                        ]);
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);

    }

    public function getGradeScale(Request $request){

        $results=SectionSubjectScale::where('section_subject_id',request('subject_id'))
                                    ->where('is_deleted',0)
                                    ->get();

        return response()->json($results);
    }

    public function subjectGetAssessment(Request $request){

        $results=SubjectAssessment::where('id',request('assessment_id'))
                                  ->where('is_deleted',0)
                                  ->first();
        return response()->json($results);
    }
    
    public function subjectGetAssessment2($section_id,$subject_id,$assessment_id){

        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $result=SubjectAssessment::with([
                                            'assessmentQuestion'=>function($q){
                                                $q->where('is_deleted',0);
                                            },
                                            'assessmentQuestion.question'=>function($q){
                                                $q->where('is_deleted',0);
                                            },
                                            'assessmentQuestion.question.questionType',
                                            'assessmentQuestion.question.answer'
                                        ])
                                    ->whereHas('assessmentQuestion',function($q){
                                         $q->where('is_deleted',0)
                                           ->whereHas('question',function($q){
                                                 $q->where('is_deleted',0);
                                            });
                                    })
                                    // ->whereHas('assessmentQuestion.question',function($q){
                                    //      $q->where('is_deleted',0);
                                    // })
                                  ->where('id',$assessment_id)
                                  ->where('is_deleted',0)
                                  ->first();
      //  return $result;
        return view('sections.subjects.assessments.view-assessment',compact('section','subject','result','type'));
    }

    public function subjectAssessmentDelete(Request $request){

        $has_exceptions = DB::transaction(function() use($request) {
            
            SubjectAssessment::where('id',request('id'))
                             ->update([
                                'is_deleted' => 1,
                            ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function subjectAssessmentStatus(Request $request){

        $has_exceptions = DB::transaction(function() use($request) {
            
            SubjectAssessment::where('id',request('id'))
                             ->update([
                                        'status' => request('status'),
                                     ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function subjectAnswerAssessment($section_id,$subject_id,$assessment_id){
        
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $currentuser=Auth::user();
        $result=SubjectAssessment::with([
                                            'assessmentQuestion'=>function($q){
                                                $q->where('is_deleted',0);
                                            },
                                            'assessmentQuestion.question'=>function($q){
                                                $q->where('is_deleted',0);
                                            },
                                            'assessmentQuestion.question.questionType',
                                            'assessmentQuestion.question.answer',
                                            'assessmentStudent'=>function($s) use($currentuser){
                                                $s->where('student_id',$currentuser->id)
                                                  ->where('is_deleted',0);
                                            }
                                        ])
                                    ->whereHas('assessmentQuestion',function($q){
                                         $q->where('is_deleted',0)
                                           ->whereHas('question',function($q){
                                                 $q->where('is_deleted',0);
                                            });
                                    })
                                    // ->whereHas('assessmentQuestion.question',function($q){
                                    //      $q->where('is_deleted',0);
                                    // })
                                  ->where('id',$assessment_id)
                                  ->where('is_deleted',0)
                                  ->first();
      //  return $result;
        return view('sections.subjects.assessments.view-assessment-student',compact('section','subject','result','type'));
    }
    
    

    // QUESTIONS
    public function getQuestionType(){

        $results=QuestionType::where('is_deleted',0)->get();
        return response()->json($results);
    }

    public function assessmentQuestionStore(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {
            
            if(request('question_id')){
                
                Question::where('id',request('question_id'))
                        ->update([
                                    'question_type_id'  => request('question_type_id'),
                                    'tag'               => request('tag'),
                                    'point'             => request('point'),
                                    'question'          => request('question'),
                                    'updated_by'        => request('current_user'),
                                 ]);
                if(request('answer')){
                
                    for ($i=0; $i < count(request('answer')) ; $i++) { 
                        
                        $ext = pathinfo(request('answer')[$i], PATHINFO_EXTENSION);
                        if($ext == 'png' || $ext == 'jpg' || $ext=='jpeg'){
                            
                            $path1 = Storage::disk('public')->put('mutiplechoice', request('answer')[$i]);
                            $image1='/storage/'.$path1;
                            
                            Answer::where('id',request('answer_id')[$i])
                              ->update([
                                            'answer'        =>$image1,
                                            'partner'       =>request('partner')[$i] ?? null,
                                            'is_correct'    =>request('is_correct')[$i] ?? 0,
                                            'is_deleted'    =>0,
                                        ]);
                        }else{
                            
                            Answer::where('id',request('answer_id')[$i])
                              ->update([
                                            'answer'        =>request('answer')[$i],
                                            'partner'       =>request('partner')[$i] ?? null,
                                            'is_correct'    =>request('is_correct')[$i] ?? 0,
                                            'is_deleted'    =>0,
                                        ]);
                        }   
                    }    
                }
                
            }else{//create
            
                $id=Question::create([
                                        'question_type_id'  => request('question_type_id'),
                                        'tag'               => request('tag'),
                                        'point'             => request('point'),
                                        'question'          => request('question'),
                                        'added_by'          => request('current_user'),
                                        'is_deleted'        => 0,        
                                    ])->id;
                                    
                if(request('answer')){
                    
                    for ($i=0; $i < count(request('answer')) ; $i++) { 
    
                        $ext = pathinfo(request('answer')[$i], PATHINFO_EXTENSION);
                        if($ext == 'png' || $ext == 'jpg' || $ext=='jpeg'){
                            
                            $path1 = Storage::disk('public')->put('mutiplechoice', request('answer')[$i]);
                            $image1='/storage/'.$path1;
                            
                            Answer::create([
                                            'question_id'   =>$id,
                                            'answer'        =>$image1,
                                            'partner'       =>request('partner')[$i] ?? null,
                                            'is_correct'    =>request('is_correct')[$i] ?? 0,
                                            'is_deleted'    =>0,
                                        ]);
                        }else{
                            
                            Answer::create([
                                            'question_id'   =>$id,
                                            'answer'        =>request('answer')[$i],
                                            'partner'       =>request('partner')[$i] ?? null,
                                            'is_correct'    =>request('is_correct')[$i] ?? 0,
                                            'is_deleted'    =>0,
                                        ]);
                        }   
                        
                           
                    }
                }
                
                AssessmentQuestion::create([
                                            'subject_assessment_id'     =>request('assessment_id'),
                                            'question_id'               =>$id,
                                            'added_by'                  => request('current_user'),
                                            'is_deleted'                => 0, 
                                       ]);
            }

        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    //get question from question bank
    public function getQuestionBank(Request $request,$section_id,$subject_id,$assessmentid,$userid){
        
        $keyword = $request->keyword;
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessments=AssessmentQuestion::where('subject_assessment_id',$assessmentid)->get();
        $qids=[];
        
        foreach($assessments as $assessment){
            $qids[]=$assessment->question_id;
        }
        
        $results=Question::with([
                                    'questionType'
                                ])
                         ->where(function($q) use($keyword) {
                            $q->where('tag', 'LIKE', '%'.$keyword.'%')
                              ->orWhere('point','LIKE', '%'.$keyword.'%')
                              ->orWhereHas('questionType',function($q) use($keyword){
                                    $q->where('name','LIKE', '%'.$keyword.'%');
                                });
                          })
                         ->where('added_by',$userid)
                         ->whereNotIn('id',$qids)
                         ->paginate(10);
        
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 2
        ]);
        
        return view('sections.subjects.assessments.question-bank',compact('keyword','section','subject','results','type','assessmentid'));
    }
    
    public function assessmentQuestionBankStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            for ($i=0; $i < count(request('questions')) ; $i++) { 
                
                AssessmentQuestion::create([
                                            'subject_assessment_id'     =>request('assessment_id'),
                                            'question_id'               =>request('questions')[$i],
                                            'added_by'                  =>request('current_user'),
                                            'is_deleted'                => 0, 
                                       ]);  
            }
        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
        
    }
    
    public function deleteQuestion(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {
            
            AssessmentQuestion::where('id',request('id'))
                              ->update([
                                            'is_deleted' => 1,
                                        ]);  

        });

        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    public function getQuestion(Request $request){
        
        $result=Question::with([
                                    'answer',
                                    'questionType'
                               ])
                        ->where('id',request('id'))
                        ->first();
                        
        return response()->json($result);
    }
    
    public function studentAssessment(Request $request,$section_id,$subject_id,$assessmentid){
        
        $keyword = $request->keyword;
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessment=SubjectAssessment::where('id',$assessmentid)->first();
        
        $results=AssessmentStudent::where('subject_assessment_id',$assessmentid)
                                  ->whereHas('user',function($q) use($keyword){
                                      $q->where('name','LIKE', '%'.$keyword.'%')
                                        ->orWhere('email','LIKE', '%'.$keyword.'%');
                                   })
                                  ->where('is_deleted',0)
                                  ->paginate(10);
        
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 2
        ]);
        
        return view('sections.subjects.assessments.user-assessment',compact('keyword','section','subject','results','type','assessmentid','assessment'));
    }
    
    public function assignAssessment(Request $request,$section_id,$subject_id,$assessmentid){
        
        $keyword = $request->keyword;
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessment=SubjectAssessment::where('id',$assessmentid)->first();
        $assigns=AssessmentStudent::where('subject_assessment_id',$assessmentid)->where('is_deleted',0)->get();
        $assignid=[];
        foreach($assigns as $assign){
            $assignid[]=$assign->student_id;
        }
        // edit
        $results=SectionStudent::with([
                                        'user'
                                      ])       
                               ->where('section_id',$section_id)
                               ->whereNotIn('student_id',$assignid)
                               ->whereHas('user',function($q) use($keyword){
                                  $q->where('name','LIKE', '%'.$keyword.'%')
                                    ->orWhere('email','LIKE', '%'.$keyword.'%');
                               })
                              ->paginate(10);
      //  return $results;
        $results->appends([
            'keyword' => $keyword,
            'search_pagination' => 2
        ]);
        
        return view('sections.subjects.assessments.assign-assessment',compact('keyword','section','subject','results','type','assessmentid','assessment'));
    }
    
    public function assignAssessmentStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            for ($i=0; $i < count(request('students')) ; $i++) { 

                AssessmentStudent::create([
                                            'subject_assessment_id'     => request('assessment_id'),
                                            'student_id'                => request('students')[$i],
                                            'added_by'                  => request('current_user'),
                                            'status'                    => 'To be completed',
                                            'is_deleted'                => 0, 
                                       ]);  
            }
        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
        
    }
    
    public function unassignAssessmentStore(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {

            for ($i=0; $i < count(request('students')) ; $i++) { 
                
                $sid=AssessmentStudent::where('subject_assessment_id',request('assessment_id'))
                                      ->where('student_id',request('students')[$i])
                                      ->where('is_deleted',0)
                                      ->first();
                                      
                AssessmentStudent::where('subject_assessment_id',request('assessment_id'))
                                 ->where('student_id',request('students')[$i])
                                 ->update([
                                             'is_deleted'  => 1
                                          ]);
                
                SubmittedAssessment::where('assessment_student_id',$sid->id)
                                   ->where('subject_assessment_id',request('assessment_id'))
                                   ->update([
                                                'is_deleted'  => 1
                                            ]);
            }
        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
        
    }
    
    //submit assessment by student
    public function subjectAssessmentSubmit(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {
            
            
            $assessmentStudent=AssessmentStudent::where('student_id',request('current_user'))
                                                ->where('subject_assessment_id',request('view_assessment_id'))
                                                ->where('is_deleted',0)
                                                ->first();
                                                
            for ($i=0; $i < count(request('question_id')) ; $i++) { 
                
                $correctbolen=0;
                $ans1=null;
                $ans2=null;
                $apoint=0;
                
                $correct=Answer::whereHas('question.questionType',function($q){
	                                  $q->where('name','!=','Essay');
	                               })
                                ->where('question_id',request('question_id')[$i])
                                ->where('is_correct',1)
                                ->first();
                
                if($correct){
                    //strip the correct answer
                    $ans1 = preg_replace('/\s*/', '', $correct->answer);
                    $ans1 = strtolower($ans1);
                    
                    //strip the stud answer
                    $ans2 = preg_replace('/\s*/', '', request('answer')[$i]);
                    $ans2 = strtolower($ans2);
                    
                    if($ans1 == $ans2){
                        $correctbolen=1;
                        $apoint=request('qpoint')[$i];
                    }
                }
                
                // add matching type
                SubmittedAssessment::create([
                                                'subject_assessment_id'     => request('view_assessment_id'),
                                                'assessment_student_id'     => $assessmentStudent->id,
                                                'question_id'               => request('question_id')[$i],
                                                'answer'                    => request('answer')[$i],
                                                'point'                     => request('qpoint')[$i],
                                                'apoint'                    => $apoint,
                                                'added_by'                  => request('current_user'),
                                                'is_correct'                => $correctbolen,
                                                'is_deleted'                => 0,
                                                'ans1'                      => $ans1,
                                                'ans2'                      => $ans2,
                                            ]);
            }
            
            AssessmentStudent::where('student_id',request('current_user'))
                             ->where('subject_assessment_id',request('view_assessment_id'))
                             ->update([
                                        'status' => 'Submitted',
                                      ]);
        });

       // Return the transaction response.
       $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
       return response()->json($response);
    }
    
    public function subjectGetSubmittedAssessment(Request $request,$section_id,$subject_id,$assessment_id){
        
        $keyword = $request->keyword;
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessment=SubjectAssessment::where('id',$assessment_id)->first();
        
        $results=AssessmentStudent::where('subject_assessment_id',$assessment_id)
                                  ->where('status','!=','To be completed')
                                  ->where(function($q) use($keyword) {
                                        $q->where('status', 'LIKE', '%'.$keyword.'%')
                                          ->orWhereHas('user',function($q) use($keyword){
                                               $q->where('name', 'LIKE', '%'.$keyword.'%')
                                                 ->orWhere('email', 'LIKE', '%'.$keyword.'%');
                                            });
                                    })
                                  ->where('is_deleted',0)
                                  ->paginate(10);
                                    
        $results->appends([
                        'keyword' => $keyword,
                        'search_pagination' => 10
                    ]);
                    
        return view('sections.subjects.assessments.submitted-assessment',compact('section','subject','assessment','results','type','keyword'));
    }
    
    public function subjectViewSubmittedAssessment(Request $request,$section_id,$subject_id,$user_id,$assessment_id){
        
        $keyword = $request->keyword;
        $type='subject';
        $section=Section::with('grade')->where('id',$section_id)->first();
        $subject=SectionSubject::where('id',$subject_id)->first();
        $assessment=SubjectAssessment::where('id',$assessment_id)->first();
        
        $result=SubmittedAssessment::with([
                                            'question'
                                          ])
                                   ->where('subject_assessment_id',$assessment_id)
                                   ->where('added_by',$user_id)
                                   ->orderby('id')
                                   ->get();
        $total=0;
        $over=0;
        foreach($result as $d){
            $total=$total + $d->apoint;
            $over=$over + $d->point;
        } 
        //return  $result;            
        return view('sections.subjects.assessments.view-submitted-assessment',compact('section','subject','assessment','result','user_id','type','keyword','total','over'));
    }
    
    public function subjectAssessmentGrade(Request $request){
        
        $has_exceptions = DB::transaction(function() use($request) {
            
            
            for ($i=0; $i < count(request('apoint')) ; $i++) { 
                
                SubmittedAssessment::where('id',request('submitted_id')[$i])
                                   ->update([
                                                'apoint' => request('apoint')[$i],
                                            ]);
                
            }
            
            AssessmentStudent::where('student_id',request('student_id'))
                             ->where('subject_assessment_id',request('view_assessment_id'))
                             ->update([
                                        'status' => 'Graded',
                                      ]);
        });

       // Return the transaction response.
       $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
       return response()->json($response);
    }
    
    /*STUDENTS*/

    public function studentIndex(Request $request,$id){

        $type='student';
        $section=Section::with('grade')->where('id',$id)->first();
        $added_by=User::where('id',$section->added_by)->first();
        $institute_id=$added_by->institute_id;
        $keyword = $request->keyword;
        $user_type='Student';
        $enrollStudents=[];

        $students=SectionStudent::where('section_id',$section->id)
                                ->where('is_deleted',0)
                                ->get();
        foreach ($students as $key => $student) {
            $enrollStudents[]=$student->student_id;
        }
        //get all enroll student in the class or section
        $results=User::paginateSearchUserOfInstituteEnroll($keyword,$institute_id,$user_type,$enrollStudents);
        return view('sections.students.index',compact('section','results','type','keyword'));
    }

    public function studentCreate(Request $request, $id){

        $type='student';
        $section=Section::with('grade')->where('id',$id)->first();
        $added_by=User::where('id',$section->added_by)->first();
        $institute_id=$added_by->institute_id;
        $user_type='Student';
        $keyword = $request->keyword;
        $enrollStudents=[];
        $students=SectionStudent::where('section_id',$section->id)
                                ->where('is_deleted',0)
                                ->get();
        foreach ($students as $key => $student) {
            $enrollStudents[]=$student->student_id;
        }
        
        //get all stident of the institute
        $results=User::paginateSearchUserOfInstitute($keyword,$institute_id,$user_type,$enrollStudents,$section->grade_id);
        return view('sections.students.create',compact('section','type','results','keyword'));
    }

    public function studentsStore(Request $request){

        $has_exceptions = DB::transaction(function() use($request) {

            for ($i=0; $i < count(request('students')) ; $i++) { 

                SectionStudent::create([
                                            'section_id'         =>request('section_id'),
                                            'student_id'         =>request('students')[$i],
                                            'created_by'         =>request('current_user'),
                                            'is_deleted'         =>0,
                                        ]);   
            }
        });
        
        // Return the transaction response.
        $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
        return response()->json($response);
    }
    
    /*RECORDS*/
    
    
    public function recordIndex(Request $request,$section_id){
        
        $type='record';
        $keyword = $request->keyword;
        $section=Section::where('id',$section_id)->first();
        $results=SectionStudent::whereHas('user',function($q) use($keyword){
                                       $q->where('name','LIKE', '%'.$keyword.'%')
                                         ->orWhere('email','LIKE', '%'.$keyword.'%');
                                })
                               ->where('section_id',$section_id)
                               ->where('is_deleted',0)
                               ->paginate(10);
        
        $results->appends([
          'keyword' => $keyword,
          'search_pagination' => 10,
       ]);
      
       return view('sections.records.index',compact('results','type','keyword','section'));
        
    }
    
    //record of every subject 
    public function recordSubject($section_id,$id){
        
        $section=Section::where('id',$section_id)->first();
        //get subject scale
        $scales=SectionSubjectScale::with([     'subjectAssessment'=>function($q){
                                                    $q->where('mode', 'graded');
                                                },
                                                'subjectAssessment.assessmentStudent.submittedAssessment'
                                                // 'sectionSubject.section.sectionStudent'=>function($q){
                                                //     $q->orderBy('student_id');
                                                // },
                                                //'sectionSubject.section.sectionStudent.user.submittedAssessment'
                                                
                                          ])
                                    ->where('section_subject_id',$id)
                                    ->where('is_deleted',0)
                                    ->orderBy('id')
                                    ->get();
        $students=SectionStudent::where('section_id',$section_id)->get();
        $results=[];
        $studresult=[];
        $assessmentresult=[];
        $gtotal=0;
        $average=0;
        foreach($students as $student){
            foreach($scales as $scale){
                foreach($scale->subjectAssessment as $assessment){
                
                    //get all submitted assessment
                    $score=AssessmentStudent::with([
                                                        'submittedAssessment'
                                                   ])
                                            ->where('subject_assessment_id',$assessment->id)
                                            ->where('student_id',$student->student_id)
                                            ->where('status','Graded')
                                            ->first();
                                              
                    $assessmentresult[]=$score;
                    if($score){
                        if($score->over_score > 0){
                            $temp=$score->total_score / $score->over_score;
                            $gtotal= $gtotal + $temp; 
                        }  
                    }
                }
                $studresult[]=$assessmentresult;
                $assessmentresult=[];
                $gtotal=$gtotal * $scale->weight;
                $average=$average + $gtotal;
                $gtotal=0;
            }
            $results[]=array($student,$studresult,round($average,2));
            $studresult=[];
            $average=0;
        }
       // return $results;
        
        return view('sections.records.subject-report',compact('scales','section','results'));
           
    }
    
    
    public function recorsdSubject($section_id,$id){
        
        $section=Section::where('id',$section_id)->first();
        //get subject scale
        $scales=SectionSubjectScale::with([     'subjectAssessment.assessmentStudent'=>function($q) use($section_id){
                                                    $q->whereIn('student_id',[DB::raw('(select student_id from section_students where section_id = "'.$section_id.'")')]);
                                                },
                                                // 'subjectAssessment.assessmentStudent.submittedAssessment'
                                                'subjectAssessment.assessmentStudent.user'
                                                
                                          ])
                                   ->where('section_subject_id',$id)
                                   //insert mode of assessments
                                   ->where('is_deleted',0)
                                   ->orderBy('id')
                                   ->get();
        return $scales;
        //get all student of subject in class
        $students=SectionStudent::where('section_id',$section_id)->get();
        //assessment of
        
                                
        return view('sections.records.subject-report',compact('scales','section'));
    }
    
    //for admin, inti admin and teacher
    public function recordStudentView($id){
        
        $type='record';
        $result=SectionStudent::where('id',$id)
                              ->first();
        $section=Section::where('id',$result->section_id)->first();
        $subjects=SectionSubject::with([    
                                            'sectionSubjectScale.subjectAssessment.assessmentStudent'=>function($q) use($result){
                                                $q->where('status','Graded')
                                                  ->where('student_id',$result->student_id)
                                                  ->where('is_deleted',0);
                                            },
                                            'sectionSubjectScale.subjectAssessment.submittedAssessment'=>function($q) use($result){
                                                $q->where('added_by',$result->student_id)
                                                  ->where('is_deleted',0);
                                            }
                                        ])
                                ->where('section_id',$result->section_id)
                                ->where('is_deleted',0)
                                ->get();
                                
        
        
       //return $subjects;
        
        return view('sections.records.view',compact('result','type','subjects','section'));
        
        
    }
    
    // for student or my records
    public function recordStudentView2($section_id){
        
        $type='record';
        $section=Section::where('id',$section_id)->first();
        $result=SectionStudent::where('student_id',Auth::user()->id)
                              ->first();
        
        $subjects=SectionSubject::with([    
                                            'sectionSubjectScale.subjectAssessment.assessmentStudent'=>function($q){
                                                $q->where('status','Graded')
                                                  ->where('student_id',Auth::user()->id);
                                            },
                                            'sectionSubjectScale.subjectAssessment.submittedAssessment'=>function($q) use($result){
                                                $q->where('added_by',Auth::user()->id);
                                            }
                                        ])
                                ->where('section_id',$section_id)
                                ->where('is_deleted',0)
                                ->where('status',1)
                                ->get();
                                
        
        
        //return $subjects;
        
        return view('sections.records.view',compact('result','type','subjects','section'));
        
        
    }
    
    public function updateDatabase(){
        
        $submitteds=SubmittedAssessment::get();
        return $submitteds;
        foreach($submitteds as $submitted){
            
            $assessmentStudent=AssessmentStudent::where('student_id',$submitted->added_by)
                                                ->where('subject_assessment_id',$submitted->subject_assessment_id)
                                                ->first();
            //return $assessmentStudent;                                 
            SubmittedAssessment::where('id',$submitted->id)
                               ->update([
                                            'assessment_student_id'=>$assessmentStudent->id ?? '0'
                                        ]);
            
            
        }
    }
}