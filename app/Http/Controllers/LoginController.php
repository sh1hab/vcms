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

class LoginController extends Controller
{
    public function student_login(Request $request){
        //for quiz timer
        session()->put('quiz_start',0);
        
        $s_email = $request->input('s_email');
        $s_password = $request->input('s_password');
        $result = DB::select("select s_id,s_name,s_password from student_info where s_email=? ",[$s_email]);
        //return $result[0]->s_id;
        if($result){
            if($s_password == $result[0]->s_password){
                //for check auth
                $request->session()->put('loginData',$request->input());
                //for show name on top
                $request->session()->put('name',$result[0]->s_name);
                $request->session()->put('id',$result[0]->s_id);
                $request->session()->put('role','s');
                return redirect('/student_panel');
            }
        }
        return view('login',['message'=>'*You enter wrong email or password']);
        
    }
    public function teacher_login(Request $request){
        
        $t_email = $request->input('t_email');
        $t_password = $request->input('t_password');
        $result = DB::select("select t_id,t_name,t_password from teacher_info where t_email=? ",[$t_email]);
        //return $result[0]->s_password;
        if($result){
            if($t_password == $result[0]->t_password){
                //for check auth
                $request->session()->put('loginData',$request->input());
                //for show name on top
                $request->session()->put('name',$result[0]->t_name);
                $request->session()->put('id',$result[0]->t_id);
                $request->session()->put('role','t');
                return redirect('/teacher_panel');
            }
        }
        return view('login',['message'=>'*You enter wrong email or password']);
        
    }
    public function logout(){

        session()->forget('loginData');
        //return session()->get('loginData');
        return redirect('/');
    }
}
