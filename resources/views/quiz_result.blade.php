@extends('layouts.app')

@section('content')

<div style="text-align:center;color:white;background-color:#38b559;padding-top:15px;padding-bottom:6px;border-radius:7px">
<h1>Course Name : {{$course_name[0]->c_name}}</h1>
    <h3 >Quiz Name : {{$quiz_name[0]->quiz_name}}</h3><br>
    <h3>Marks : 10 <span style="padding-left:10%">Time : 10mins</span> </h3>
    <h3  style="color:yellow;font-size:30px;">Scores : <span style="padding-left:0%"> {{$points}}</span> </h3>
  </div>

<div style="padding-left:7%;padding-top:2%">
    

@for($j=1,$i=0;$i< count($data) ;$i=$i+4,$j++)

  <label for="" class="mr-sm-2">{{$j}}. {{$data[$i]->q_text}} </label>
  <div style="padding-left:2%">
  
    Ans : {{$data[$i]->op_text}}  <br>
  </div><br>

@endfor
</div>

@endsection