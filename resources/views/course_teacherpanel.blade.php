@extends('layouts.app')

@section('content')
<h1 style="text-align:center"> {{$course_name[0]->c_name}} </h1>     



<div class="sidenav_coursePanel">
  <p id="sidenavT_text">Materials<br>--------------------</p>
  @foreach($material_list as $dt)
    <a href="http://127.0.0.1:8000{{$dt->m_path}}">{{$dt->m_name}}</a><br>
  @endforeach 
  
  <p id="sidenavT_text">Assignments<br>--------------------</p>
  @foreach($assignment_list as $dt)
    <a href="http://127.0.0.1:8000{{$dt->a_path}}">{{$dt->a_name}}</a> <a href="http://127.0.0.1:8000/view_assignment/{{$course_name[0]->c_id}}/{{$dt->a_id}}" class="btn btn-primary">view</a><br>
  @endforeach 
  <p id="sidenavT_text">Quiz<br>--------------------</p>
  @foreach($quiz_list as $dt)
    <a href="http://127.0.0.1:8000/edit_quiz/{{$dt->quiz_id}}/{{$course_name[0]->c_id}}">{{$dt->quiz_name}}</a><br>
  @endforeach 
  <a href="http://127.0.0.1:8000/create_quiz/{{$course_name[0]->c_id}}" class="btn btn-primary" style="color:white;">Create a Quiz</a>

</div>

<div class="main_coursePanel">
<p style="font-size:20px;">Upload :</p>
  <form method="post" enctype="multipart/form-data" action="/teacher_upload" id="borderStyle" >

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <input type="file" class="form-control" name="m_name">
    </div>
    
      <input type="radio" class="" name="m_radio" value="material"> Material       
      
    
    
      <input type="radio" class="" name="m_radio" value="assignment"> Assignment
      
    
    
    <input type="submit" style="width:100%" class="btn btn-success" value="Upload">
  </form>
</div>


<div class="sidenavR_coursePanel">
  <p id="sidenavT">Notifications</p>
   
  

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Course Name</th>
        <th>Student Image</th>
        <th>Student Details</th>
        <th>Action</th>
      </tr>
    </thead>
   
</div>


@endsection