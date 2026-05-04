<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TurnOverController extends Controller
{
    public function index()
    {
        return view('pages.inventory.turnover.index');
    }
}
