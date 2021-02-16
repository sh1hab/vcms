<?php

namespace App\Http\Controllers;


use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // to use Database (DB::select("query"))
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Auth;

class ViewAssignmentController extends Controller
{
    public function load_view_assignmentpanel($c_id,$a_id){
        $t_id = session()->get('id');
        session()->put('c_id',$c_id);
        $course_name = DB::select("SELECT c_id,c_name FROM course_list WHERE c_id=?",[$c_id]);
        $assignment_name = DB::select("SELECT a_id,a_name FROM give_assignment WHERE a_id=?",[$a_id]);
        
        $s_list = DB::select("SELECT * FROM student_info INNER JOIN submit_assignment on student_info.s_id=submit_assignment.s_id WHERE submit_assignment.a_id=? AND submit_assignment.c_id=?",[$a_id,$c_id]);
        //$assignment_list = DB::select("select * from give_assignment where t_id=? and c_id=?",[$t_id,$c_id]);
        
        return view('view_assignment',array('course_name'=>$course_name,'assignment_name'=>$assignment_name,'s_list'=>$s_list ));
        //return session()->get('c_id');
    }
}
