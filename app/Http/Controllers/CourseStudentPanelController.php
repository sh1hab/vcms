<?php

namespace App\Http\Controllers;


use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // to use Database (DB::select("query"))
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Auth;

class CourseStudentPanelController extends Controller
{
    public function load_course_studentpanel($c_id){
        $s_id = session()->get('id');
        session()->put('c_id',$c_id);
        $course_name = DB::select("SELECT * FROM course_list WHERE c_id=?",[$c_id]);
        $quiz_list = DB::select("SELECT * FROM quiz_list WHERE c_id=?",[$c_id]);
        $material_list = DB::select("SELECT * FROM take_course INNER JOIN course_materials on take_course.c_id=course_materials.c_id WHERE take_course.s_id=?",[$s_id]);
        $assignment_list = DB::select("SELECT * FROM take_course INNER JOIN give_assignment on take_course.c_id=give_assignment.c_id WHERE take_course.s_id=?",[$s_id]);
        return view('course_studentpanel',array('course_name'=>$course_name,'quiz_list'=>$quiz_list,'material_list'=>$material_list,'assignment_list'=>$assignment_list ));
        //return session()->get('c_id');
    }
    public function submit_assignment(Request $request){
        $s_id = session()->get('id');
        $c_id = session()->get('c_id');
        
        if( $file = $request->file('a_name') ){
            $a_id = $request->input('a_id');
            //$material_name = $request->file('m_name');
            $a_name=$file->getClientOriginalName();
            //$material_path = rand().'.'.$material->getClientOriginalExtension();
            $destinationPath = public_path('/my_files');
            $file->move($destinationPath, $a_name);
            $a_path = "/"."my_files"."/".$a_name;
            //return $material_path;
        
            DB::insert(" insert into submit_assignment (sa_name,sa_path,c_id,a_id,s_id) value(?,?,?,?,?) ",[$a_name,$a_path,$c_id,$a_id,$s_id]);
            
            return redirect()->back();
        }
    
        
        // $result = DB::select("select t_dept,t_varsity from teacher_info where t_id=? ",[$t_id]);//
        // $c_no = $request->input('c_no');
        // $c_name = $request->input('c_name');
        // $c_credit = $request->input('c_credit');
        // $c_dept = $result[0]->t_dept;
        // $c_varsity = $result[0]->t_varsity;
        // $c_term = $request->input('c_term');
        // DB::insert("insert into course_list (c_no,c_name,c_credit,c_dept,c_varsity,c_term,t_id) values(?,?,?,?,?,?,?)",[$c_no,$c_name,$c_credit,$c_dept,$c_varsity,$c_term,$t_id] );
        // return back()->with('success','Image Upload successfully');   
        //Session::put('header_code','1');
        //return redirect('/teacher_panel');

    }
}
