@extends('layouts.app')

@section('content')



<form class="" 
<?php if(Session::get('e_sts')==1){?> 
  action="/update_quiz" <?php }else{ ?>
    action="/create_quiz" 
  <?php } ?>
 style="padding-left:7%;padding-right:7%" method="post" enctype="multipart/form-data">
  <div style="text-align:center">
    <h1>Course Name : {{ $course_details[0]->c_name }}</h1><br>
    
    <h3>Marks : 10 <span style="padding-left:10%">Time : 10mins</span> </h3><br>
    <h3 >Quiz Name : <input type="text" name="quiz_name" 
    <?php if(Session::get('e_sts')==1){?> 
      value="{{$quiz_name[0]->quiz_name}}" <?php }else{ ?>
    value="" 
  <?php } ?>
     class="" style="width:30%"></h3><br>
  </div>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <?php if(Session::get('e_sts')==1) {?>
    @for($i=0,$j=1;$i< count($data) ;$i++,$j++)
    

  <label for="" class="mr-sm-2">{{$j}}.</label>
  <input type="text" class="" placeholder="Question {{$j}}" name="q{{$j}}" style="width:60%" value="{{$data[$i]->q_text}}"><br>
  <div style="padding:2%">
  
    <input type="radio" name="qq{{$j}}" value="1" <?php if($data[$i]->q_ans==1){?> checked <?php } ?>><input type="text" class="" placeholder="Option 1" name="q{{$j}}_optn1" value="{{$data[$i]->op_text}}"> <input type="hidden" name="_token{{$j}}" value="{{$i++}}"><br>
    <input type="radio" name="qq{{$j}}" value="2" <?php if($data[$i]->q_ans==2){?> checked <?php } ?>><input type="text" class="" placeholder="Option 1" name="q{{$j}}_optn2" value="{{$data[$i]->op_text}}"> <input type="hidden" name="_token{{$j}}" value="{{$i++}}"><br>
    <input type="radio" name="qq{{$j}}" value="3" <?php if($data[$i]->q_ans==3){?> checked <?php } ?>><input type="text" class="" placeholder="Option 1" name="q{{$j}}_optn3" value="{{$data[$i]->op_text}}"> <input type="hidden" name="_token{{$j}}" value="{{$i++}}"><br>
    <input type="radio" name="qq{{$j}}" value="4" <?php if($data[$i]->q_ans==4){?> checked <?php } ?>><input type="text" class="" placeholder="Option 1" name="q{{$j}}_optn4" value="{{$data[$i]->op_text}}"><br>
  </div>
@endfor 
<?php } else{ ?>
    @for($i=1;$i<=10;$i++)
  
<label for="" class="mr-sm-2">{{$i}}.</label>
  <input type="text" class="" placeholder="Question {{$i}}" name="q{{$i}}" style="width:60%" ><br>
  <div style="padding:2%">
  
    <input type="radio" name="qq{{$i}}" value="1"><input type="text" class="" placeholder="Option 1" name="q{{$i}}_optn1" ><br>
    <input type="radio" name="qq{{$i}}" value="2"><input type="text" class="" placeholder="Option 1" name="q{{$i}}_optn2" ><br>
    <input type="radio" name="qq{{$i}}" value="3"><input type="text" class="" placeholder="Option 1" name="q{{$i}}_optn3" ><br>
    <input type="radio" name="qq{{$i}}" value="4"><input type="text" class="" placeholder="Option 1" name="q{{$i}}_optn4" ><br>
  </div>
@endfor
<?php } ?>
<input type="submit" name="createBtn" 
<?php if(Session::get('e_sts')==1){?> 
  value="Update Quiz" <?php }else{ ?>
    value="create Quiz"
  <?php } ?>
 class="btn btn-success" style="width:70%"> 
</form>

@endsection
