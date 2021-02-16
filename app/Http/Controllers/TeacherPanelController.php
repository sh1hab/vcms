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

class TeacherPanelController extends Controller
{
    public function load_teacher_panel(){
        $t_id = session()->get('id');
        //return $t_id;
        $course_list = DB::select("select c_id,c_name from course_list where t_id=? ",[$t_id]);
        $noti_list = DB::select("SELECT * FROM student_info INNER JOIN take_course INNER JOIN course_list on student_info.s_id=take_course.s_id and take_course.c_id=course_list.c_id where take_course.t_id=? and r_sts='0' order by srl desc",[$t_id]);
        //return $course_list;
        return view('teacher_panel',array('course_list'=>$course_list,'noti_list'=>$noti_list));

    }
    public function create_course(Request $request){
        $t_id = session()->get('id');
        $result = DB::select("select t_dept,t_varsity from teacher_info where t_id=? ",[$t_id]);//
        $c_no = $request->input('c_no');
        $c_name = $request->input('c_name');
        $c_credit = $request->input('c_credit');
        $c_dept = $result[0]->t_dept;
        $c_varsity = $result[0]->t_varsity;
        $c_term = $request->input('c_term');
        DB::insert("insert into course_list (c_no,c_name,c_credit,c_dept,c_varsity,c_term,t_id) values(?,?,?,?,?,?,?)",[$c_no,$c_name,$c_credit,$c_dept,$c_varsity,$c_term,$t_id] );
        //return back()->with('success','Image Upload successfully');   
        //Session::put('header_code','1');
        return redirect('/teacher_panel');

    }

    public function accept_request($srl,$r_sts){
        $r_sts=1;
        DB::update("update take_course set r_sts=? where srl=? ",[$r_sts,$srl]);
        return redirect('/teacher_panel');

    }
    public function delete_request($srl){
       
        DB::delete("delete from take_course where srl=? ",[$srl]);
        return redirect('/teacher_panel');

    }
}
