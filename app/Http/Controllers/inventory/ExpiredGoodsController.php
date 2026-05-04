<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpiredGoodsController extends Controller
{
    public function index()
    {
        return view('pages.inventory.expiredgoods.index');
    }

    public function getData(Request $request)
    {
        $dataExpiredGoods = DB::table('t_inventory_expired_goods')
        ->select('*')
        ->orderBy('t_inventory_expired_goods.expdate', 'asc');
        if ($request->ajax()) {
            return DataTables::of($dataExpiredGoods)
            ->addColumn('label', function ($dataExpiredGoods) {

                $thirtyDays = new DateTime("now");
                $thirtyDays->modify('+30 day');
                $onetenDays = new DateTime("now");
                $onetenDays->modify('+180 day');
                $toYears = new DateTime("now");
                $toYears->modify('+365 day');
                $expdate = new DateTime($dataExpiredGoods->expdate);
                
                // black <= 30 days
                // red 31 - 180 days
                // yellow 181 - 365 days
                // green >365 days
                    if ($expdate <= $thirtyDays) {
                        $color = 'black';
                    } else if ($expdate > $thirtyDays and $expdate <= $onetenDays) {
                        $color = 'red';
                    } else if ($expdate > $onetenDays and $expdate <= $toYears) {
                        $color = 'yellow';
                    } else if ($expdate > $toYears) {
                        $color = 'green';
                    }
                    return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
                })
                ->editColumn('qty', function ($dataExpiredGoods) {
                    return number_format($dataExpiredGoods->qty, 0, '', '');
                    // diatas ini artinya nampilin angka dgn 4 digit decimal
                    // angka decimal nya dipisahin pake koma
                    // ribuan nya dipisahin pake titik
                })
                ->rawColumns(['label'])
                ->make();
        }
    }
}
