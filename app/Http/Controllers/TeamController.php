<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        if(Auth::user()) {
            dd(Auth::user());
        }else{
            dd("not connected");
        }

    }
}
