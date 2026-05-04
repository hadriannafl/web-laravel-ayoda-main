<?php

namespace App\Http\Controllers\google;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    public function index()
    {   
        return view('pages.google.google-calendar.index');
    }
}
