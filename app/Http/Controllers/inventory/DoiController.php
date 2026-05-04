<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DoiController extends Controller
{
    public function index()
    {
        return view('pages.inventory.doi.index');
    }

    public function getData(Request $request)
    {
        $dataDoi = DB::table('t_dois')
            ->select('*')
            ->orderBy('idrec');

        if ($request->input('year') != null) {
            $dataDoi = $dataDoi->where('t_dois.year', $request->year);
        }

        if ($request->ajax()) {
            return DataTables::of($dataDoi)
            ->editColumn('cogsm', function ($dataDoi) {
                return number_format($dataDoi->cogsm, 0, ',', '.')."";
            })    
            ->editColumn('cogsy', function ($dataDoi) {
                return number_format($dataDoi->cogsy, 0, ',', '.')."";
            })    
            ->editColumn('invma', function ($dataDoi) {
                return number_format($dataDoi->invma, 0, ',', '.')."";
            })
            ->make();
        }
    }
}
