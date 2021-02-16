@extends('layouts.app')

@section('content')
<h1 style="text-align:center"> {{$course_name[0]->c_name}} </h1>  <br>
<h4 style="text-align:center;color:blue">Assignment Name : {{$assignment_name[0]->a_name}} </h4>  <br>
<div style="text-align:center;padding-left:10%;padding-right:10%">

<table class="table table-striped" style=";text-align:center">
    <thead>
      <tr class="btn-success">
        <th>Student Details</th>
        <th>File</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach($s_list as $dt)
    <tr>
        <td>{{$dt->s_name}}<br>{{$dt->s_dept}},{{$dt->s_varsity}}<br>{{$dt->s_term}}</td>
        <td><a href="http://127.0.0.1:8000{{$dt->sa_path}}">{{$dt->sa_name}}</a></td>
        
        
      </tr>
      @endforeach
    </tbody>
</table>
</div>
@endsection