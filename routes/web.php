<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    session()->put('quiz_start',0);
    return view('index');
});
Route::get('/reg', function () {
    return view('reg');
});


Route::get('/view_assignment/{c_id}/{a_id}', 'ViewAssignmentController@load_view_assignmentpanel')->middleware('customAUTH');

Route::get('/course_studentpanel/{c_id}', 'CourseStudentPanelController@load_course_studentpanel')->middleware('customAUTH');
Route::post('/submit_assignment', 'CourseStudentPanelController@submit_assignment')->middleware('customAUTH');


Route::get('/create_quiz/{c_id}', 'CreateQuizController@load_quizpanel')->middleware('customAUTH');
Route::get('/edit_quiz/{quiz_id}/{c_id}', 'CreateQuizController@edit_quiz')->middleware('customAUTH');
Route::get('/quiz_test/{quiz_id}/{c_id}', 'QuizTestController@load_quiztest')->middleware('customAUTH');

Route::post('/submit_quiz', 'QuizTestController@submit_quiz')->middleware('customAUTH');
Route::post('/create_quiz', 'CreateQuizController@create_quiz')->middleware('customAUTH');
Route::post('/update_quiz', 'CreateQuizController@update_quiz')->middleware('customAUTH');
Route::post('/lala', 'QuizTestController@test')->middleware('customAUTH');



Route::get('/course_teacherpanel/{c_id}', 'CourseTeacherPanelController@load_course_teacherpanel')->middleware('customAUTH');
Route::post('/teacher_upload', 'CourseTeacherPanelController@upload');
Route::get('/login', function () {
    return view('login',['message'=>'']);
});

Route::get('/logout', 'LoginController@logout');

Route::get('/student_panel', 'StudentPanelController@load_student_panel')->middleware('customAUTH');
Route::get('/send_rqst/{s_id}/{c_id}/{t_id}', 'StudentPanelController@send_request')->middleware('customAUTH');
Route::get('/accept_rqst/{srl}/{r_sts}', 'TeacherPanelController@accept_request')->middleware('customAUTH');
Route::get('/delete_rqst/{srl}', 'TeacherPanelController@delete_request')->middleware('customAUTH');
Route::post('/student_login', 'LoginController@student_login');
Route::post('/teacher_login', 'LoginController@teacher_login');
Route::post('/search_course', 'StudentPanelController@search_course');
Route::get('/teacher_panel', 'TeacherPanelController@load_teacher_panel')->middleware('customAUTH');

Route::post('/create_course','TeacherPanelController@create_course');

Route::post('/signup_teacher','RegistrationController@signup_teacher');
Route::post('/signup_student','RegistrationController@signup_student');

Route::group([
    'prefix' => 'zoom',
], function () {
    Route::get('list', 'ZoomMeetingController@list')->name('zoom.list');
    Route::get('create', 'ZoomMeetingController@create');
    Route::post('save', 'ZoomMeetingController@save')->name('zoom.create');
    Route::get('past/meeting/{meetingID}/details', 'ZoomMeetingController@pastMeetingDetails');
    Route::get('/meeting/', function(){
        return view('meeting');
    });

});
