@extends('layouts.app')

@section('content')
    <h1 style="text-align:center">  </h1>

    <div class="sidenav_coursePanel">


    </div>

    <div class="main_coursePanel">
        <p style="font-size:20px;">Upload :</p>
        <form method="post" enctype="multipart/form-data" action="{{ route('zoom.create') }}" id="borderStyle">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Topic *
                    <input type="text" required class="form-control" name="topic">
                </label>
            </div>

            <div class="form-group">
                <label>Agenda *
                    <input type="text" required class="form-control" name="agenda">
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="date" required class="form-control" name="start_time">
                </label>
            </div>

            <input type="submit" style="width:100%" class="btn btn-success" value="Create">
        </form>
    </div>

@endsection
