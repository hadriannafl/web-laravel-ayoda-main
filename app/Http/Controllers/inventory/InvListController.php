<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvListController extends Controller
{
    public function index()
    {
        return view('pages.inventory.invlist.index');
    }

    public function getData(Request $request)
    {
        $dataInvList = DB::table('products')
            ->select('*');
        if ($request->ajax()) {
            return DataTables::of($dataInvList)
            ->editColumn('global_stock', function ($dataInvList) {
                return number_format($dataInvList->global_stock, 0, ',', '.')."";
            })
            ->editColumn('broken_stock', function ($dataInvList) {
                return number_format($dataInvList->broken_stock, 0, ',', '.')."";
            })
            ->editColumn('purchased', function ($dataInvList) {
                return number_format($dataInvList->purchased, 0, ',', '.')."";
            })
            ->editColumn('reserved_so', function ($dataInvList) {
                return number_format($dataInvList->reserved_so, 0, ',', '.')."";
            })
            ->editColumn('nett_stock', function ($dataInvList) {
                return number_format($dataInvList->nett_stock, 0, ',', '.')."";
            })
            ->make();
        }
    }
}
