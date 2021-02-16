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

class StudentPanelController extends Controller
{
    ///jokhon student_panel page load hobe
    public function load_student_panel(){
        //return "in";
        $s_id=session()->get('id');
        $s_term = DB::select("select s_term from student_info where s_id=? ",[$s_id]);//string-array(pblm)
        $c_term = $s_term[0]->s_term;//convert array to string

        //dropdown list er jonno
        $teacher_list = DB::select("select DISTINCT t_name from teacher_info order by t_name ");
        $varsity_list = DB::select("select DISTINCT t_varsity from teacher_info order by t_varsity ");

        $course_list = DB::select("select DISTINCT c_name from course_list order by c_name ");
        //end
        $course_sugg = DB::select("select * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_term=?",[$c_term] );
        $take_course = DB::select("select * from take_course where s_id=?",[$s_id]);
        $course_name_list = DB::select("SELECT course_list.c_id,course_list.c_name FROM take_course INNER JOIN course_list on take_course.c_id=course_list.c_id where take_course.s_id=? and take_course.r_sts='1' ",[$s_id,]);



        $search_course=null;
        //return session()->get('loginData');

        //only data return korbe...
        //return array('course_sugg'=>$course_sugg);
        return view('student_panel',array('teacher_list'=>$teacher_list,'varsity_list'=>$varsity_list,'course_list'=>$course_list,'course_sugg'=>$course_sugg,'search_course'=>$search_course,'take_course'=>$take_course,'course_name_list'=>$course_name_list));

    }

    public function search_course(Request $request){
        $s_id=session()->get('id');
        $course_name = $request->input('course_name');
        $teacher_name = $request->input('teacher_name');
        $varsity = $request->input('varsity');
        $search_course=null;
        if($course_name && $varsity && $teacher_name)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_name=? and course_list.c_varsity=? and teacher_info.t_name=? ",[$course_name,$varsity,$teacher_name]);
        else if($course_name && $varsity)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_name=? and course_list.c_varsity=? ",[$course_name,$varsity]);
        else if($course_name && $teacher_name)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_name=? and teacher_info.t_name=? ",[$course_name,$teacher_name]);
        else if($teacher_name && $varsity)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_varsity=? and teacher_info.t_name=?",[$teacher_name,$varsity]);
        else if($teacher_name)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where teacher_info.t_name=? ",[$teacher_name]);
        else if( $varsity)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_varsity=? ",[$varsity]);
        else if($course_name)
            $search_course = DB::select("SELECT * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_name=? ",[$course_name]);

        $c_term="1-1";

        $teacher_list = DB::select("select DISTINCT t_name from teacher_info order by t_name ");
        $varsity_list = DB::select("select DISTINCT t_varsity from teacher_info order by t_varsity ");
        $course_list = DB::select("select DISTINCT c_name from course_list order by c_name ");
        $course_sugg = DB::select("select * from course_list INNER JOIN teacher_info on course_list.t_id=teacher_info.t_id where course_list.c_term=?",[$c_term] );
        $take_course = DB::select("select * from take_course where s_id=?",[$s_id]);
        $course_name_list = DB::select("SELECT c_name FROM take_course INNER JOIN course_list on take_course.c_id=course_list.c_id where take_course.s_id=? and take_course.r_sts='1' ",[$s_id,]);


            //only data return korbe...
            //return array('search_course'=>$search_course);
            return view('student_panel',array('teacher_list'=>$teacher_list,'varsity_list'=>$varsity_list,'course_list'=>$course_list,'course_sugg'=>$course_sugg,'search_course'=>$search_course,'take_course'=>$take_course,'course_name_list'=>$course_name_list));


           // return view('student_panel',array('search_course'=>$search_course));
    }
    public function send_request($s_id,$c_id,$t_id){
        $r_sts=0;// 0 means rqst send...
        DB::insert("insert into take_course (s_id,c_id,t_id,r_sts) values(?,?,?,?)",[$s_id,$c_id,$t_id,$r_sts]);
        return redirect('/student_panel');

    }
}
