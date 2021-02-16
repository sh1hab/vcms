@extends('layouts.app')

@section('content')

<div class="container" style="padding-left:15%;padding-right:15%">
<h1 style="text-align:center;">Registration From</h1><br>
<ul class="nav nav-tabs" style="font-size:20px">
            <li class="active"><a data-toggle="tab" href="#student">Student</a></li>
            <li style="padding-left:20px"><a data-toggle="tab" href="#teacher">Teacher</a></li>
  </ul>
    <div class="tab-content">
        <div id="student" class="tab-pane active">
            <form method="post" enctype="multipart/form-data" action="/signup_student" id="borderStyleReg">

            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                <input type="text" name="s_name" value="" class="form-control" placeholder="Student Name" required><br>
                <input type="text" name="s_email" value="" class="form-control" placeholder="Email" required><br>
                <input type="password" name="s_password" value="" class="form-control" placeholder="Password" required><br>
                <input type="text" name="s_varsityid" value="" class="form-control" placeholder="Student ID" required><br>
                <input type="text" name="s_age" value="" class="form-control" placeholder="Age" required><br>
                <input type="text" name="s_gender" value="" class="form-control" placeholder="Gender" required><br>
                <input type="text" name="s_dept" value="" class="form-control" placeholder="Department" required><br>
                <input type="text" name="s_varsity" value="" class="form-control" placeholder="University" required><br>
                <input type="text" name="s_term" value="" class="form-control" placeholder="Term" required><br>
                <input type="file" name="s_img" class="form-control" required>*Max Size 2MB<br>
                
                <input type="submit" name="" class="btn btn-primary" value="Sign up" style="width:100%;"><br>
            </form>
        </div>
        <div id="teacher" class="tab-pane fade" >
            <form method="post" enctype="multipart/form-data" action="/signup_teacher" id="borderStyleReg">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <input type="text" name="t_name" value="" class="form-control" placeholder="Teacher Name" required><br>
                <input type="text" name="t_email" value="" class="form-control" placeholder="Email" required><br>
                <input type="password" name="t_password" value="" class="form-control" placeholder="Password" required><br>
                <input type="text" name="t_age" value="" class="form-control" placeholder="Age" required><br>
                <input type="text" name="t_gender" value="" class="form-control" placeholder="Gender" required><br>
                <input type="text" name="t_dept" value="" class="form-control" placeholder="Department" required><br>
                <input type="text" name="t_varsity" value="" class="form-control" placeholder="University" required><br>
                <input type="text" name="t_deg" value="" class="form-control" placeholder="Designation" required><br>
                <input type="file" name="t_img" class="form-control" required>*Max Size 2MB<br>
                
                <input type="submit" name="" class="btn btn-primary" value="Sign up" style="width:100%;"><br>
            </form>
        </div>
    </div>
    </div>
    cool
    
@endsection