<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;

class MenuSettingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $datauser = DB::table('users')->select('users.id', 'users.username')->get();
        $dataMenu = DB::table('users')->select('*')->first();
        if (!empty($search)) {
            $dataMenu = DB::table('users')->select('*')->where('id', $search)->first();
        }
        return view('pages.setupmenu.index', compact('datauser', 'dataMenu', 'search'));
    }

    public function update(Request $request, $userId)
    {
        if ($request) {
            DB::table('users')->where('id', $userId)->update([
                'kanban' => $request->input('kanban'),
                'hr' => $request->input('hr'),
                'hr_1' => $request->input('hr_1'),
                'hr_2' => $request->input('hr_2'),
                'hr_3' => $request->input('hr_3'),
                'hr_4' => $request->input('hr_4'),
                'hr_5' => $request->input('hr_5'),
                'hr_6' => $request->input('hr_6'),
                'hr_7' => $request->input('hr_7'),
                'hr_8' => $request->input('hr_8'),
                'hr_9' => $request->input('hr_9'),
                'hr_10' => $request->input('hr_10'),
                'hr_11' => $request->input('hr_11'),
                'ga' => $request->input('ga'),
                'ga_1' => $request->input('ga_1'),
                'ga_2' => $request->input('ga_2'),
                'ga_3' => $request->input('ga_3'),
                'ga_4' => $request->input('ga_4'),
                'ga_5' => $request->input('ga_5'),
                'ga_6' => $request->input('ga_6'),
                'ga_7' => $request->input('ga_7'),
                'ga_8' => $request->input('ga_8'),
                'ga_9' => $request->input('ga_9'),
                'ga_10' => $request->input('ga_10'),
                'ga_11' => $request->input('ga_11'),
                'ga_12' => $request->input('ga_12'),
                'ga_13' => $request->input('ga_13'),
                'ga_14' => $request->input('ga_14'),
                'ga_15' => $request->input('ga_15'),
                'ga_16' => $request->input('ga_16'),
                'ga_17' => $request->input('ga_17'),
                'ga_18' => $request->input('ga_18'),
                'ga_19' => $request->input('ga_19'),
                'ga_20' => $request->input('ga_20'),
                'ga_21' => $request->input('ga_21'),
                'ga_22' => $request->input('ga_22'),
                'ga_23' => $request->input('ga_23'),
                'ga_24' => $request->input('ga_24'),
                'ga_25' => $request->input('ga_25'),
                'ga_26' => $request->input('ga_26'),
                'master_data' => $request->input('master_data'),
                'md_1' => $request->input('md_1'),
                'md_2' => $request->input('md_2'),
                'md_3' => $request->input('md_3'),
                'md_4' => $request->input('md_4'),
                'md_5' => $request->input('md_5'),
                'md_6' => $request->input('md_6'),
                'md_7' => $request->input('md_7'),
                'md_8' => $request->input('md_8'),
                'md_9' => $request->input('md_9'),
                'md_10' => $request->input('md_10'),
                'md_11' => $request->input('md_11'),
                'md_12' => $request->input('md_12'),
                'md_13' => $request->input('md_13'),
                'md_14' => $request->input('md_14'),
                'md_15' => $request->input('md_15'),
                'md_16' => $request->input('md_16'),
                'md_17' => $request->input('md_17'),
                'md_18' => $request->input('md_18'),
                'md_19' => $request->input('md_19'),
                'md_20' => $request->input('md_20'),
                'md_21' => $request->input('md_21'),
                'md_22' => $request->input('md_22'),
                'md_23' => $request->input('md_23'),
                'md_24' => $request->input('md_24'),
                'md_25' => $request->input('md_25'),
                'md_26' => $request->input('md_26'),
                'md_27' => $request->input('md_27'),
                'md_28' => $request->input('md_28'),
                'md_29' => $request->input('md_29'),
                'md_30' => $request->input('md_30'),
                'md_31' => $request->input('md_31'),
                'md_32' => $request->input('md_32'),
                'calendar' => $request->input('calendar'),
                'company_calendar' => $request->input('company_calendar'),
                'google' => $request->input('google'),
                'google_calendar' => $request->input('google_calendar'),
            ]);

            alert()->success('Success', 'List Menu has been Setup');
            return to_route('menu-setting');
        } else {
            alert()->error('Error', 'Error Field User Not Fill');
            return to_route('menu-setting');
        }
    }
}
