<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Virtual Class Room</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/chakri_chai.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/classroom.css') }}" rel="stylesheet">
    <style>


    </style>
    <script type="text/javascript">
        function myFunction(i, j) {
            if (j == 0) {
                i = i - 1;
                j = 60;
            }
            if (j == 50) {
                var ff = document.getElementById("submit_quiz");
                ff.submit();
            }

            j = j - 1;
            setTimeout(function () {
                document.getElementById("timer").innerHTML = i + " : " + j;
                myFunction(i, j);
            }, 1000);

        }
    </script>
</head>

<body
    <?php
    $v = Session::get('quiz_start');
    if($v == 1){ ?>
    onload="myFunction(9,60)"<?php
    }
    ?>
>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="{{ url('/') }}" style="color:blue;font-weight:bold;font-size:25px">
            VCMS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest

                    @if(!Session::has('loginData'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/reg') }}">Register</a>
                        </li>

                    @else

                    <!-- After login DropdownList -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                               style="color:blue;">
                                {{Session::get('name')}} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <!-- <a class="dropdown-item" href="{{ url('/') }}">Home</a> -->
                                <a class="dropdown-item"
                                   <?php if(Session::get('role') == 's'){ ?>
                                   href="/student_panel"
                                   <?php } else{ ?>
                                   href="/teacher_panel"
                                <?php } ?>
                                >
                                    Dashboard
                                </a>
                                <a class="dropdown-item"
                                   <?php if(Session::get('role') == 's'){ ?>
                                   href="/student_profile"
                                   <?php } else{ ?>
                                   href="/teacher_profile"
                                <?php } ?>
                                >
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{ url('/logout') }}" style="color:red">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                                <form id="panel-form" action="/company_panel" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>


                    @endif
                @endguest
            </ul>
        </div>

    </nav>
    <div class="container">

        <main class="py-4">
            @yield('content')

        </main>

    </div>

<!-- @guest
    <h3></h3>
@else
    <div class="footer">
    <h3>© Copyrights 2019 | Chakri Chai</h3>
    <h4>Find your right jobs.</h4>
    </div>

@endguest -->
</div>
</body>
</html>


