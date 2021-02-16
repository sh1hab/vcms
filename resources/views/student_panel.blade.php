@extends('layouts.app')

@section('content')

    <h1 style="text-align:center"> WELCOME TO YOUR DASHBOARD</h1>      

<div class="sidenavS">
  <p id="sidenavT">Course List<br>------------</p>
  @foreach($course_name_list as $dt)
  <a href="{{url('course_studentpanel')}}/{{$dt->c_id}}">{{$dt->c_name}}</a>
  @endforeach
  
</div>
<br>
<div class="mainS">
Search Course : 

<form method="post" enctype="multipart/form-data" class="form-inline" action="/search_course">
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
  <div class="form-group">
    
  <select name="course_name" class="form-control">
        <option value="">-- Select Course --</option>
        @foreach($course_list as $course)
        <option value="{{$course->c_name}}">{{$course->c_name}}</option>
        @endforeach
  </select>
  </div>
  <div class="form-group">
  <select name="teacher_name" class="form-control">
        <option value="">-- Select Teacher --</option>
        @foreach($teacher_list as $teacher)
        <option value="{{$teacher->t_name}}">{{$teacher->t_name}}</option>
        @endforeach
  </select>
  </div>
  <div class="form-group">
  <select name="varsity" class="form-control">
        <option value="">-- Select University --</option>
        @foreach($varsity_list as $varsity)
        <option value="{{$varsity->t_varsity}}">{{$varsity->t_varsity}}</option>
        @endforeach
  </select>
  </div><br><br>
  <input type="submit" class="btn btn-success" value="Search" style="width:100%">
</form>


<table class="table table-striped">
    <thead>
      <tr>
        <th>Course Details</th>
        <th>Teacher Details</th>
        
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <!-- check the current url reqst is search_course??? -->
  @if(\Request::is('search_course'))
    
  @foreach($search_course as $dt)
      <tr>
        <td>{{ $dt->c_no }}<br><span style="font-weight:bolder;color:blue;font-size:17px">{{ $dt->c_name }}</span><br>Credit : {{$dt->c_credit}}<br>Term : {{$dt->c_term}}</td>
        
        <td><span style="font-weight:bolder;">{{ $dt->t_name }}</span><br>{{ $dt->t_des }},{{ $dt->c_dept }}<br>{{ $dt->t_varsity }}</td>
       
        <td><br>
        
                {{Session::put('i','0')}}
                @foreach($take_course as $dt2)
                  @if($dt2->c_id == $dt->c_id)
                  
                    {{Session::put('i','1')}} 
                    @if($dt2->r_sts == 0)
                    <p class="btn btn-danger">Wait for response</p>
                    @break;
                    @else
                    <p class="btn btn-danger">Already Taken</p>
                    @break;
                    @endif
                  @endif
                @endforeach
                <?php if( Session::get('i')== 0){ ?>
                <a class="btn btn-primary" href="{{url('send_rqst')}}/{{Session::get('id')}}/{{$dt->c_id}}/{{$dt->t_id}}">Request</a>
                <?php } ?>
        
        
        </td>

      </tr>
      @endforeach
      @endif
      
    </tbody>
  </table>
  
  <div>Suggestions : </div>
  <div class="row">
  <!--Array length use count(arrayName) -->
  @for ($i=0;$i< count($course_sugg) ;$i++) 
  @if($i > 3)
  @break;
  @endif
    <div class="col-md-4">
        <div class="thumbnail" style="text-align: center;">
           
            <img src="{{ asset('img/online_course.png') }}" style="width:150px;height: 150px">
            <div class="caption" style="text-align: center;">
                <p>
                    <span id="">{{ $course_sugg[$i]->c_name }}</span><br>
                    <span id="">{{ $course_sugg[$i]->t_name }}</span><br>
                    <span id="">{{ $course_sugg[$i]->t_des }}</span>,
                    <span id="">{{ $course_sugg[$i]->c_dept }}</span><br>
                    <span id="">{{ $course_sugg[$i]->c_varsity }}</span>
                </p>
                
                {{Session::put('i','0')}}
                @foreach($take_course as $dt)
                  @if($dt->c_id == $course_sugg[$i]->c_id)
                  
                    {{Session::put('i','1')}} 
                    @if($dt->r_sts == 0)
                    <p class="btn btn-danger">Wait for response</p>
                    @break;
                    @else
                    <p class="btn btn-danger">Already Taken</p>
                    @break;
                    @endif
                  @endif
                @endforeach
                <?php if( Session::get('i')== 0){ ?>
                <a class="btn btn-primary" href="{{url('send_rqst')}}/{{Session::get('id')}}/{{$course_sugg[$i]->c_id}}/{{$course_sugg[$i]->t_id}}">Request</a>
                <?php } ?>
            
            </div>
            
        </div>
      
    </div>
   
    @endfor


</div>


</div>
@endsection