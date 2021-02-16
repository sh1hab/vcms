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
    <a href="http://127.0.0.1:8000{{$dt->a_path}}">{{$dt->a_name}}</a><br>
  @endforeach 
  <p id="sidenavT_text">Quiz<br>--------------------</p>
  @foreach($quiz_list as $dt)
    <a href="http://127.0.0.1:8000/quiz_test/{{$dt->quiz_id}}/{{$course_name[0]->c_id}}">{{$dt->quiz_name}}</a><br>
  @endforeach 
</div>

<div class="main_coursePanel">
<p style="font-size:20px;">Submit Assignment :</p>
  <form method="post" enctype="multipart/form-data" action="/submit_assignment" id="borderStyle" >

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <select name="a_id" class="form-control" required>
        <option value="">-- Select Assignment --</option>
        @foreach($assignment_list as $dt)
        <option value="{{$dt->a_id}}">{{$dt->a_name}}</option>
        @endforeach
  </select><br>
    <div class="form-group">
      <input type="file" class="form-control" name="a_name">
    </div>
    
      
    
    
    <input type="submit" style="width:100%" class="btn btn-success" value="Submit">
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