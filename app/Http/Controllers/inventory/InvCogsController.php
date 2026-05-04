<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvCogsController extends Controller
{
    public function index()
    {
        return view('pages.inventory.cogs.index');
    }

    public function getData(Request $request)
    {
        $dataCogs = DB::table('cogs')
            ->select('*');
        if ($request->ajax()) {
            return DataTables::of($dataCogs)
            ->editColumn('cogs_previous', function ($dataCogs) {
                return number_format($dataCogs->cogs_previous, 4, '.', ',')."";
            })
            ->editColumn('cogs_now', function ($dataCogs) {
                return number_format($dataCogs->cogs_now, 4, '.', ',')."";
            })
            ->editColumn('min_po', function ($dataCogs) {
                return number_format($dataCogs->min_po, 4, '.', ',')."";
            })
            ->editColumn('max_po', function ($dataCogs) {
                return number_format($dataCogs->max_po, 4, '.', ',')."";
            })
            ->editColumn('last_purchase_price', function ($dataCogs) {
                return number_format($dataCogs->last_purchase_price, 4, '.', ',')."";
            })
            ->make();
        }
    }
}
