<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvAgingController extends Controller
{
    public function index()
    {
        return view('pages.inventory.invaging.index');
    }

    public function getData(Request $request)
    {
        $dataInvAging = DB::table('inventory_agings')
            ->select('*')
            ->orderBy('inventory_agings.inventory_name', 'asc');
        if ($request->ajax()) {
            return DataTables::of($dataInvAging)
            ->editColumn('open_balance', function ($dataInvAging) {
                return number_format($dataInvAging->open_balance, 0, ',', '.')."";
            })    
            ->editColumn('total', function ($dataInvAging) {
                return number_format($dataInvAging->total, 0, ',', '.')."";
            })    
            ->editColumn('d0', function ($dataInvAging) {
                return number_format($dataInvAging->d0, 0, ',', '.')."";
            })    
            ->editColumn('d30', function ($dataInvAging) {
                return number_format($dataInvAging->d30, 0, ',', '.')."";
            })    
            ->editColumn('d60', function ($dataInvAging) {
                return number_format($dataInvAging->d60, 0, ',', '.')."";
            })    
            ->editColumn('d90', function ($dataInvAging) {
                return number_format($dataInvAging->d90, 0, ',', '.')."";
            })    
            ->editColumn('d120', function ($dataInvAging) {
                return number_format($dataInvAging->d120, 0, ',', '.')."";
            })    
            ->make();
        }
    }
}