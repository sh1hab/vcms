<?php

namespace App\Http\Controllers;


use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // to use Database (DB::select("query"))
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Auth;

class QuizTestController extends Controller
{
    public function load_quiztest($quiz_id,$c_id){
        //for quiz timer
        session()->put('quiz_start',1);

        session()->put('quiz_id',$quiz_id);
        session()->put('c_id',$c_id);
        $quiz_name = DB::select("SELECT * FROM quiz_list where quiz_id=?",[$quiz_id]);
        $course_name = DB::select("SELECT * FROM course_list where c_id=?",[$c_id]);
        $data = DB::select("SELECT * FROM question_list inner JOIN questions_options on question_list.q_id=questions_options.q_id WHERE question_list.quiz_id=?",[$quiz_id]);
    
        return view('quiz_test',array('data'=>$data,'quiz_name'=>$quiz_name,'course_name'=>$course_name));
    }
    public function submit_quiz(Request $request){
        //for quiz timer
        session()->put('quiz_start',0);
        
        $quiz_id = session()->get('quiz_id');
        $c_id = session()->get('c_id');
        $s_id = session()->get('id');
        $points = 0;
        $quiz_name = DB::select("SELECT * FROM quiz_list where quiz_id=?",[$quiz_id]);
        $course_name = DB::select("SELECT * FROM course_list where c_id=?",[$c_id]);
        $data = DB::select("SELECT * FROM question_list inner JOIN questions_options on question_list.q_id=questions_options.q_id WHERE question_list.quiz_id=?",[$quiz_id]);
        
        for($j=1,$i=0;$j <= 10;$i=$i+4,$j++){
            $q_ans = $request->input('qq'.$j);
            $real_q_ans =  DB::select("select q_ans from question_list where q_id=?",[$data[$i]->q_id]);
            //return $real_q_ans[0]->q_ans;
            if($q_ans == $real_q_ans[0]->q_ans){
                $points++;
            }

        }
        //return $points;
        return view('quiz_result',array('data'=>$data,'points'=>$points,'quiz_name'=>$quiz_name,'course_name'=>$course_name));
    
    
    
    
    }
}
