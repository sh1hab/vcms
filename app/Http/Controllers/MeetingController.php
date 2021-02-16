<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Illuminate\Support\Facades\Input; //to use this Input::get('tag')
use Illuminate\Support\Facades\Redirect; // to use this Redirect::to('url')
use App\Application;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function authorize($ability, $arguments = [])
    {

    }


}
