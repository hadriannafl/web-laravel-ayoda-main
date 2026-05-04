<?php

namespace App\Http\Controllers\ManagementReport;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ArDaysController extends Controller
{
    public function index()
    {
        return view('pages.management-report.ar-days.index');
    }

    public function getData(Request $request)
    {
        $dataAr = DB::table('t_ar_days')
            ->select('*');
        if ($request->ajax()) {
            return DataTables::of($dataAr)
                ->editColumn('paidinvt',function($dataAr){
                    return 'IDR ' . number_format($dataAr->paidinvt, 0, ',', '.');
                })
                ->editColumn('unpaidinvt',function($dataAr){
                    return 'IDR ' . number_format($dataAr->unpaidinvt, 0, ',', '.');
                })
                ->make();
        }
    }
}
