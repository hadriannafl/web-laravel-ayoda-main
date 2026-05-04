<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $userId = Auth::user()->id;
        $dataMenu = DB::table('m_list_menu')->select('*')->where('user_id', $userId)->first();
        return view('layouts.app', compact('dataMenu'));
    }
}
