<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AttendanceListController extends Controller
{
    public function index()
    {
        return view('pages.hr.attendancelist.attendancelists.index');
    }

    public function getData(Request $request)
    {
        $user = Auth::user()->employee_id;
        $startdate = $request->input('from');
        $enddate = $request->input('to');
    
        $dataAbsenQuery = DB::table('employee_attendances')
            ->select(
                'employee_attendances.idemployee',
                'employee_attendances.lastentry',
                'employee_attendances.sdate',
                'employee_attendances.edate',
                'employee_attendances.hourcalc',
                'employee_attendances.latecalc'
            )
            ->where('idemployee' ,$user);
    
        if ($startdate && $enddate) {
            $dataAbsenQuery->whereDate('employee_attendances.lastentry', '>=', $startdate)
                ->whereDate('employee_attendances.lastentry', '<=', $enddate);
        }
        
        $dataAbsen = $dataAbsenQuery->orderBy('lastentry', 'DESC');
    
        if ($request->ajax()) {
            return DataTables::of($dataAbsen)
                ->editColumn('lastentry', function ($dataAbsen) {
                    return date('Y-m-d', strtotime($dataAbsen->lastentry));
                })
                ->editColumn('sdate', function ($dataAbsen) {
                    return date('H:i:s', strtotime($dataAbsen->sdate));
                })
                ->editColumn('edate', function ($dataAbsen) {
                    return date('H:i:s', strtotime($dataAbsen->edate));
                })
                ->make();
        }
    }
}
