<?php

namespace App\Http\Controllers;

use App\User;


use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // to use Database (DB::select("query"))
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Auth;

class RegistrationController extends Controller
{
    public function signup_teacher(Request $request){
        $t_name = $request->input('t_name');
        $t_email = $request->input('t_email');
        $t_password = $request->input('t_password');
        $t_age = $request->input('t_age');
        $t_gender = $request->input('t_gender');
        $t_dept = $request->input('t_dept');
        $t_varsity = $request->input('t_varsity');
        $t_deg = $request->input('t_deg');
        //for image
        $t_img="Null";
        
        $this->validate($request, [
            't_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $image = $request->file('t_img');
        $t_img = rand().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/img');
        $image->move($destinationPath, $t_img);
        $t_img = "/"."img"."/".$t_img;

        DB::insert("insert into teacher_info (t_name,t_email,t_password,t_age,t_gender,t_dept,t_varsity,t_des,t_img) values(?,?,?,?,?,?,?,?,?)",[$t_name,$t_email,$t_password,$t_age,$t_gender,$t_dept,$t_varsity,$t_deg,$t_img] );
        //return back()->with('success','Image Upload successfully');   
        //Session::put('header_code','1');
        return view('index');

    } 
    public function signup_student(Request $request){
        $s_name = $request->input('s_name');
        $s_email = $request->input('s_email');
        $s_password = $request->input('s_password');
        $s_varsityid = $request->input('s_varsityid');
        $s_age = $request->input('s_age');
        $s_gender = $request->input('s_gender');
        $s_dept = $request->input('s_dept');
        $s_varsity = $request->input('s_varsity');
        $s_term = $request->input('s_term');
        //for image
        $s_img="Null";
        
        $this->validate($request, [
            's_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $image = $request->file('s_img');
        $s_img = rand().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/img');
        $image->move($destinationPath, $s_img);
        $s_img = "/"."img"."/".$s_img;


        DB::insert("insert into student_info (s_name,s_email,s_password,s_varsityid,s_age,s_gender,s_dept,s_varsity,s_term,s_img) values(?,?,?,?,?,?,?,?,?,?)",[$s_name,$s_email,$s_password,$s_varsityid,$s_age,$s_gender,$s_dept,$s_varsity,$s_term,$s_img] );
        //return back()->with('success','Image Upload successfully');   
        //Session::put('header_code','1');
        return view('index');

    }
}
