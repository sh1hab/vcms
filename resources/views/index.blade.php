@extends('layouts.app')

@section('content')

<div style="text-align:center;"> 
<?php
//include "../resources/views/templates/image_slide.php"; ?> 

    <div class="container">

    <div class="w3-container">
    <h2>WELCOME TO VIRTUAL CLASS ROOM WEBSITE</h2>
    <p>Find your desire courses here. </p>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">

            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="/img/online_courses.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">In this online class you can easily search for the courses of your choice.</p>  
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="/img/document_share.png" alt="Card image cap" >
                <div class="card-body">
                  <p class="card-text">In this classroom teachers will be able to provide their 
                  course related slides, PDFs, videos,  even topic related links for students 
                  which will ensure a modern learning environment.</p> 
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="/img/online_exam.jpg" alt="Card image cap" >
                <div class="card-body">
                  <p class="card-text">There is no alternative to online exams to understand 
                  how students are learning as a result of teaching in online classes. 
                  Through which teachers will be able to assess the knowledge of students.</p> 
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="/img/assignment.jpg" alt="Card image cap" >
                <div class="card-body">
                  <p class="card-text">Assignments enrich the quality of students 
                  knowledge based on relevant reading in a related subject after teaching a specific subject.</p> 
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="/img/video.jpg" alt="Card image cap" >
                <div class="card-body">
                  <p class="card-text">Assignments enrich the quality of students 
                  knowledge based on relevant reading in a related subject after teaching a specific subject.</p> 
                </div>
              </div>
            </div>

            </div>
        </div>
    </div>
    
    </div>
</div>

    
@endsection