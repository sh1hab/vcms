@extends('layouts.app')

@section('content')


<div class="container" style="padding-left:15%;padding-right:15%">
<h1 style="text-align:center;">Login</h1><br>
<p style="color:red">{{$message}}</p>
<ul class="nav nav-tabs" style="font-size:20px">
            <li class="active"><a data-toggle="tab" href="#student">Student</a></li>
            <li style="padding-left:20px"><a data-toggle="tab" href="#teacher">Teacher</a></li>
  </ul>
    <div class="tab-content">
        <div id="student" class="tab-pane active">
            <form method="post" enctype="multipart/form-data" action="/student_login" id="borderStyleReg">

            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                <input type="text" name="s_email" value="" class="form-control" placeholder="Student Email" required><br>
                <input type="password" name="s_password" value="" class="form-control" placeholder="Student Password" required><br>
                
                <input type="submit" name="" class="btn btn-primary" value="login " style="width:100%;"><br>
            </form>
        </div>
        <div id="teacher" class="tab-pane fade" >
            <form method="post" enctype="multipart/form-data" action="/teacher_login" id="borderStyleReg">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <input type="text" name="t_email" value="" class="form-control" placeholder="Teacher Email" required><br>
                <input type="password" name="t_password" value="" class="form-control" placeholder="Teacher Password" required><br>
                
                <input type="submit" name="" class="btn btn-primary" value="login" style="width:100%;"><br>
            </form>
        </div>
    </div>
    </div>
        
@endsection