@extends('layouts.app')

@section('content')
    <h1 style="text-align:center">  </h1>

    <div class="sidenav_coursePanel">

    </div>

    <div class="main_coursePanel">
        <p style="font-size:20px;">Meetings :</p>
        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th>Start time</th>
                <th>Zoom URL</th>
                <th>Agenda</th>
{{--                <th>Action</th>--}}
            </tr>
            </thead>
            <tbody>
            @for( $i=0; $i< count($meetings); $i++ )
                <tr>
                    <td>{{ $meetings[$i]['start_time'] }}</td>
                    <td><a href="{{ $meetings[$i]['join_url'] }}">{{ $meetings[$i]['join_url'] }}</a></td>
                    <td>{{ $meetings[$i]['agenda'] }}</td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>

@endsection
