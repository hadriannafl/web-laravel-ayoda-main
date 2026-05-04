<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AttendanceListAllController extends Controller
{
    public function index()
    {
        return view('pages.hr.attendancelist.attendancelist-all.index');
    }

    public function getData(Request $request)
    {
        $startdate = $request->input('from');
        $enddate = $request->input('to');
        $dataAbsenQuery = DB::table('employee_attendances')
            ->leftJoin('m_employees', 'employee_attendances.idemployee', 'm_employees.idemployee')
            ->select(
                'employee_attendances.idemployee',
                'employee_attendances.lastentry',
                'employee_attendances.sdate',
                'employee_attendances.edate',
                'employee_attendances.hourcalc',
                'employee_attendances.latecalc',
                'm_employees.first_name as employee'
            );
        
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

    public function getDashboard(Request $request)
    {
        $date = date('Y-m-d');

        $dataAbsenQuery = DB::table('employee_attendances')
            ->leftJoin('m_employees', 'employee_attendances.idemployee', 'm_employees.idemployee')
            ->select(
                'employee_attendances.idemployee',
                'employee_attendances.lastentry',
                'employee_attendances.sdate',
                'employee_attendances.edate',
                'employee_attendances.hourcalc',
                'employee_attendances.latecalc',
                'm_employees.first_name as employee',
                'm_employees.last_name'
            )->whereDate('employee_attendances.lastentry', $date);

        $dataAbsen = $dataAbsenQuery->orderBy('lastentry', 'DESC');

        if ($request->ajax()) {
            return DataTables::of($dataAbsen)
            ->editColumn('employee', function ($dataAbsen) {
                return $dataAbsen->employee . ' ' . $dataAbsen->last_name;
            })
            ->editColumn('lastentry', function ($dataAbsen) {
                return date('Y-m-d', strtotime($dataAbsen->lastentry));
       })
                ->make();
        }
    }

}
