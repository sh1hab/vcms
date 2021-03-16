@extends('layouts.app')

@section('content')
    <h1 style="text-align:center"></h1>

    <div class="sidenav_coursePanel">

    </div>

    <div class="main_coursePanel">
        <p style="font-size:20px;">Meetings :</p>
        <table class="table table-striped table-responsive-sm">
            <thead>
            {{--            <th>--}}
            <th>Serial</th>
            <th>Start time</th>
            <th>Zoom URL</th>
            <th>Agenda</th>
            <th>ID</th>
            <th>Password</th>
            <th></th>

            </thead>
            <tbody>
            @for( $i=0; $i< count($meetings); $i++ )
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{ $meetings[$i]['start_at'] }}</td>
                    @if($meetings[$i]['status'] != 'completed')
                        <td><a href="{{ $meetings[$i]['join_url'] }}">{{ $meetings[$i]['join_url'] }}</a></td>
                    @else
                        <td>meeting completed</td>
                    @endif
                    <td>{{ $meetings[$i]['agenda'] }}</td>
                    @if($meetings[$i]['status'] != 'completed')
                        <td>{{$meetings[$i]['items']['id']}}</td>
                        <td>{{$meetings[$i]['items']['pwd']}}</td>
                    @else
                        <td tabindex="3">meeting completed</td>
                        <td></td>
                    @endif
                    {{--                    <td>{{$meetings[$i]['items']['id']}}</td>--}}
                    {{--                    <td>{{$meetings[$i]['items']['pwd']}}</td>--}}
                    {{--                    @if(Date('Y-m-d H:i:s') > $meetings[$i]['start_at'])--}}
                    {{--                        <td><button class="btn" onclick="">Join meeting</button></td>--}}
                    {{--                    @endif--}}
                </tr>
            @endfor
            </tbody>
        </table>
    </div>

@endsection
