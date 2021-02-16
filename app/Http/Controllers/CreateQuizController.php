<?php

namespace App\Http\Controllers;


use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //to use Database (DB::select("query"))
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Auth;

class CreateQuizController extends Controller
{
    public function load_quizpanel($c_id){
        session()->put('e_sts',0);
        session()->put('c_id',$c_id);
        $course_details = DB::select("select * from course_list where c_id=? ",[$c_id]);

        return view('create_quiz',array('course_details'=>$course_details));
    }
    public function edit_quiz($quiz_id,$c_id){
        //return "OK";
        session()->put('c_id',$c_id);
        session()->put('e_sts',1);
        //for quiz timer
        session()->put('quiz_start',1);

        session()->put('quiz_id',$quiz_id);
        
        $quiz_name = DB::select("SELECT * FROM quiz_list where quiz_id=?",[$quiz_id]);
        $course_details = DB::select("SELECT * FROM course_list where c_id=?",[$c_id]);
        $data = DB::select("SELECT * FROM question_list inner JOIN questions_options on question_list.q_id=questions_options.q_id WHERE question_list.quiz_id=?",[$quiz_id]);
        //return "OK";
        return view('create_quiz',array('data'=>$data,'quiz_name'=>$quiz_name,'course_details'=>$course_details));
        
    }
    public function create_quiz(Request $request){
        session()->put('e_sts',0);
        $c_id = session()->get('c_id');
        $quiz_name = $request->input('quiz_name');
        DB::insert(" insert into quiz_list (quiz_name,c_id) value(?,?)",[$quiz_name,$c_id]);
        $quiz_id =  DB::select("select count(*) as ID from quiz_list");
        //return $quiz_id[0]->ID;
        for($i=1;$i <= 10;$i++){
            $q_text = $request->input('q'.$i);
            $q_ans = $request->input('qq'.$i);
            DB::insert(" insert into question_list (q_text,q_ans,quiz_id) value(?,?,?)",[$q_text,$q_ans,$quiz_id[0]->ID]);
            $q_id =  DB::select("select count(*) as ID from question_list");
            
            for($j=1;$j <= 4;$j++){
                $op_text = $request->input('q'.$i.'_optn'.$j);
                
                DB::insert(" insert into questions_options (op_text,q_id) value(?,?)",[$op_text,$q_id[0]->ID]);
            
            }
        }
        return redirect()->back();
    }
    public function update_quiz(Request $request){
        session()->put('e_sts',0);
        $c_id = session()->get('c_id');
        $quiz_id = session()->get('quiz_id');
        $quiz_name = $request->input('quiz_name');
        DB::update(" update quiz_list set quiz_name=? where quiz_id=? ",[$quiz_name,$quiz_id]);
        $data = DB::select("SELECT * FROM question_list inner JOIN questions_options on question_list.q_id=questions_options.q_id WHERE question_list.quiz_id=?",[$quiz_id]);
        
        //return $quiz_id[0]->ID;
        for($i=0,$j=1;$i< count($data) ;$i++,$j++){
            $q_text = $request->input('q'.$j);
            $q_ans = $request->input('qq'.$j);
            DB::update(" update question_list set q_text=?,q_ans=? where q_id=?",[$q_text,$q_ans,$data[$i]->q_id]);
            //$q_id =  DB::select("select count(*) as ID from question_list");
            
            for($k=1;$k <= 4;$k++,$i++){
                $op_text = $request->input('q'.$j.'_optn'.$k);
                
                DB::update(" update questions_options set op_text=? where op_id=?",[$op_text,$data[$i]->op_id]);
            
            }
            $i--;
        }
        return redirect('/course_teacherpanel/'.$c_id);
        return $this->load_quizpanel($c_id);
        //return redirect()->back();
    }
    
    public function test(Request $request){
        return "ok";
    }
}
