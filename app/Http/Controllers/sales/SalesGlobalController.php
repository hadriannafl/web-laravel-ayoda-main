<?php

namespace App\Http\Controllers\sales;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class SalesGlobalController extends Controller
{
    public function index()
    {
        return view('pages.sales.salesglobal.index');
    }

    public function getData(Request $request)
    {
        $filterYear = $request->input('year');
        $yearNow = date('Y');

        $year = $filterYear ?? $yearNow;

        $dataSalesGlobal = DB::table('orders')
            ->selectRaw("
                YEAR(delivery_date) AS year,
                MONTHNAME(delivery_date) AS month,
                MONTH(delivery_date) AS month_number,
                SUM(dpp) AS net_sales_total,
                COUNT(id) AS invoice_count,
                COUNT(DISTINCT company_id) AS customer_count
            ")
            ->whereRaw("YEAR(delivery_date) = $year")
            ->groupByRaw("YEAR(delivery_date), MONTHNAME(delivery_date)")
            ->orderByRaw("MONTH(delivery_date)");

        // data for table
        if ($request->ajax()) {
            return DataTables::of($dataSalesGlobal)
                ->editColumn('net_sales_total', function ($dataSalesGlobal) {
                    return 'IDR ' . number_format($dataSalesGlobal->net_sales_total, 0, ',', '.')."";
                })
                ->addColumn('action', function ($dataSalesGlobal) {
                    return '<div x-data="{ modalOpen: false }">
                                <button class="btn btn-xs btn-modal bg-indigo-500 hover:bg-indigo-600 text-white" 
                                    @click.prevent="modalOpen = true" aria-controls="scrollbar-modal"
                                    data-year="' . $dataSalesGlobal->year . '" data-month-number="' . $dataSalesGlobal->month_number . '"
                                    data-month="' . $dataSalesGlobal->month . '" data-net-total="' . 'IDR ' . number_format($dataSalesGlobal->net_sales_total, 0, ',', '.') . '"
                                    data-customer-count="' . $dataSalesGlobal->customer_count . '" data-invoice-count="' . $dataSalesGlobal->invoice_count . '">
                                    View
                                </button>
                                <!-- Modal backdrop -->
                                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                    x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-out duration-100"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    aria-hidden="true" x-cloak></div>
                                <!-- Modal dialog -->
                                <div id="feedback-modal"
                                    class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                    role="dialog" aria-modal="true" x-show="modalOpen"
                                    x-transition:enter="transition ease-in-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in-out duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
                                    <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
                                        @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                        <!-- Modal header -->
                                        <div class="px-5 py-3 border-b border-slate-200">
                                            <div class="flex justify-between items-center">
                                                <div class="font-semibold text-slate-800">Sales Global Detail</div>
                                                <button class="text-slate-400 hover:text-slate-500"
                                                    @click="modalOpen = false">
                                                    <div class="sr-only">Close</div>
                                                    <svg class="w-4 h-4 fill-current">
                                                        <path
                                                            d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Modal content -->
                                        <div class="modal-content text-xs">
                                            
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="px-5 py-4 border-t border-slate-200">
                                            <div class="flex flex-wrap justify-end space-x-2">
                                                <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        // data for chart
        $arrayLabel = [];
        $arrayData = [];

        foreach ($dataSalesGlobal->get() as $key => $value) {
            $label = substr($value->month, 0, 3) . ' ' . $value->year;
            array_push($arrayLabel, $label);
            array_push($arrayData, $value->net_sales_total * 1);
        }

        return response()->json([
            'labels' => $arrayLabel,
            'data' => $arrayData
        ]);
    }
    public function getDetail($year, $month)
    {
        $dataDetailSalesGlobal = DB::table('orders')
            ->leftJoin('companies', 'orders.company_id', 'companies.id')
            ->leftJoin('salesmen', 'orders.idsalesman', 'salesmen.idsales')
            ->select('orders.id', 'orders.delivery_date', 'orders.inv_number', 'companies.name', 'salesmen.name as salesname', 'orders.dpp')
            ->whereRaw("YEAR(delivery_date) = $year and MONTH(delivery_date)=$month")
            ->orderBy('orders.delivery_date', 'asc')
            ->get()->toArray();

        return $dataDetailSalesGlobal;
    }
}
