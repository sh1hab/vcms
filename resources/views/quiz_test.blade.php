@extends('layouts.app')

@section('content')
<script>

</script>
<div  style="text-align:center;color:white;background-color:#38b559;padding-top:15px;padding-bottom:6px;border-radius:7px">
    <h1>Course Name : {{$course_name[0]->c_name}}</h1>
    <h3 >Quiz Name : {{$quiz_name[0]->quiz_name}}</h3><br>
    <h3>Marks : 10 <span style="padding-left:10%">Time : 10mins</span> </h3>
    <h4 id="timer"></h4>  
  </div>

  <form id="submit_quiz" class="" action="/submit_quiz" style="padding-left:7%;padding-right:7%;padding-top:2%" method="post" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@for($i=0,$j=1;$i< count($data) ;$i++,$j++)

  <label for="" class="mr-sm-2">{{$j}}. {{$data[$i]->q_text}} </label>
  <div style="padding-left:2%">
  
    <input type="radio" name="qq{{$j}}" value="1"> {{$data[$i]->op_text}} <input type="hidden" name="_token{{$j}}" value="{{$i++}}"> <br>
    <input type="radio" name="qq{{$j}}" value="2"> {{$data[$i]->op_text}} <input type="hidden" name="_token{{$j}}" value="{{$i++}}"> <br>
    <input type="radio" name="qq{{$j}}" value="3"> {{$data[$i]->op_text}} <input type="hidden" name="_token{{$j}}" value="{{$i++}}"> <br>
    <input type="radio" name="qq{{$j}}" value="4"> {{$data[$i]->op_text}} <br>
  </div><br>

@endfor
<input type="submit" name="createBtn" value="Submit" class="btn btn-success" style="width:70%"> 
</form>

@endsection