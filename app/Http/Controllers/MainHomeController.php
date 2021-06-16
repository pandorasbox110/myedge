<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Institute;
use App\User;
use Storage;
use Config;
use DB;
use App\RegisterToken;
use Mail;
use App\Mail\SendMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\UserImport;
use App\Grade;
use App\UserType;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportUserInstitute;
use App\ActivityLog;


class MainHomeController extends Controller
{

    public function index()
    {

        if(Auth::user()){
            // check user
            if(Auth::user()->status == 2){

                //random tocken
                $seedletter = str_split('abcdefghijklmnopqrstuvwxyz');
                // probably optional since array_is randomized; this may be redundant
                shuffle($seedletter);
                $randletter = '';
                foreach (array_rand($seedletter, 2) as $k)
                {
                    $randletter .= $seedletter[$k];
                }
                //generating the numeric character for verification code
                $seednumber = str_split('1234567890');
                shuffle($seednumber);
                $randnumber = '';
                foreach (array_rand($seednumber, 2) as $k)
                {
                    $randnumber .= $seednumber[$k];
                }
                $random=str_shuffle($randletter.$randnumber);

                //save token
                $tokenid=RegisterToken::create([
                                        'token'      => $random,
                                        'is_deleted' => 0,
                                      ])->id;

                $email=Auth::user()->email;
                //$link='http://myedgetestsiteversion2.edupowerpublishing.com/account/verify/'.$tokenid.'/'.Auth::user()->id;
                $link=env('APP_URL').'/account/verify/'.$tokenid.'/'.Auth::user()->id;
                $data = array('link'=>$link,'email'=>$email);

                Mail::send('dashboards.verify-email', $data, function($message) use ($email) {
                    $message->to($email,'')->subject('Welcome to MyEDGE Learning');
                    $message->from('noreply.myedge@edupowerpublishing.com','Welcome to MyEDGE Learning');
                });
            }

            if(Auth::user()->userType->name == 'Admin'){

                return view('dashboards.home-admin');

            }elseif(Auth::user()->userType->name == 'Teacher' || Auth::user()->userType->name == 'Institute Admin' || Auth::user()->userType->name == 'Student'){

                return view('dashboards.home-teacher');

            }else{

                return view('dashboards.home');

            }

        }else{//without login user

            //return view('homes.home');
            return view('homes.index');
        }
    }

    public function indexs()
    {

        ActivityLog::create([
                                'user_id'       => Auth::user()->id,
                                'activity'      => 'login',
                                'is_deleted'    => 0,
                            ]);
        return redirect('/home');
    }

    public function sampleEbook(){

        return view('homes.sample-ebook');
    }

    public function uploadImage(Request $request){

        if (request('imageFile')) {

            $path3 = Storage::disk('public')->put('editor/images', request('imageFile'));
            // $image='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$path3;
            $image=env('APP_URL').'/storage/'.$path3;


            return response()->json($image);

        }else{
            return response()->json('error');
        }
    }

    public function uploadVideo(Request $request){

        if (request('videoFile')) {

            $file=request('videoFile')->storeAs('editor/videoaudio',request('videoFile')->getClientOriginalName(),'public');
            // $path='http://myedgetestsiteversion2.edupowerpublishing.com/storage/'.$file;
            $path=env('APP_URL').'/storage/'.$file;


            return response()->json($path);

        }else{
            return response()->json('error');
        }
    }

    public function profile(){

        $profile=User::where('id',Auth::user()->id)->first();
        return view('dashboards.profile',compact('profile'));
    }

    //verify account
    public function verifyAccount($id,$uid){

        $check=RegisterToken::where('id',$id)->first();

        if($check){
            if($check->is_deleted == 1){
                $result='Token already used';
            }else{
                $result='Congratulation!,Your account is already verified';
                RegisterToken::where('id',$id)->update(['is_deleted'=>1]);
                User::where('id',$uid)->update(['status'=>1]);

            }
        }else{
            $result='Sorry you token was not match!';
        }

        return view('dashboards.verify-account',compact('result'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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


    /*Add ons function*/

    //get institute
    public function getInstitute(){

        $currentuser=Auth::user();

        if($currentuser->userType->name == 'Institute Admin'){

            $results=Institute::where('id',$currentuser->institute_id)
                              ->where('is_deleted',0)
                              ->get();

        }else{

            $results=Institute::where('is_deleted',0)->get();

        }
        return response()->json($results);
    }

    //self register
    public function getInstituteSelf(){

        $results=Institute::where('is_deleted',0)->get();
        return response()->json($results);
    }

    public function getCreatedUser(Request $request){

        $currentuser=Auth::user();
        if(request('utype') == 'teacher'){

            $results=User::where('added_by',$currentuser->id)
                         ->where('user_type_id',4)
                         ->where('is_deleted',0)
                         ->get();
            $result=count($results);
            $data=array((int)$currentuser->create_num_teacher, $result,$currentuser->userType->name);

        }else if(request('utype') == 'student'){

            $results=User::where('added_by',$currentuser->id)
                         ->where('user_type_id',5)
                         ->where('is_deleted',0)
                         ->get();
            $result=count($results);
            $data=array((int)$currentuser->create_num_student, $result,$currentuser->userType->name);
        }

        return response()->json($data);
    }

    //import user
    public function importUser(){

        $user_type ='Import User';
        return view('users.import',compact('user_type'));
    }

    public function importUserStore(Request $request){
        $has_exceptions = DB::transaction(function() use($request) {

            $file=$request->file('file');

            if(Auth::user()->userType->name == 'Admin'){
                Excel::import(new ImportUser,$file);
            }else{
                Excel::import(new ImportUserInstitute,$file);
            }
            $users=UserImport::where('is_deleted',0)->where('first_name','!=','first_name')->get();

            foreach($users as $user){

                $grade=Grade::where('name',$user->grade)->first();
                $usertype=UserType::where('name',$user->user_type)->first();
                User::create([
                                'first_name'        => $user->first_name,
                                'last_name'         => $user->last_name,
                                'name'              => $user->first_name . ' '. $user->last_name,
                                'email'             => $user->email,
                                'password'          => Hash::make('myedge'),
                                'user_type_id'      => $usertype->id,
                                'status'            => 1,
                                'institute_id'      => $user->institute_id,
                                'grade_id'          => $grade->id ?? 0,
                                'create_num_teacher'=> $user->create_num_teacher ?? 0,
                                'create_num_student'=> $user->create_num_student ?? 0,
                                'create_num_parent' => $user->create_num_parent ?? 0,
                                'added_by'          => $user->added_by,
                             ]);
            }

            UserImport::where('is_deleted',0)
                       ->where('first_name','!=','first_name')
                       ->update([
                                    'is_deleted'=>1,
                               ]);

       });

       // Return the transaction response.
       $response = array('status' => (!$has_exceptions) ? 'saved' : 'not_saved');
       return response()->json($response);
    }
}
