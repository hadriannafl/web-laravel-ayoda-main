<?php

namespace App\Http\Controllers\kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BudgetingController extends Controller
{
    public function index()
    {
        $salesId = Auth::user()->sales_id;
        return view('pages.kpi.budget.index');
    }

    public function getData(Request $request)
    {
        $salesId = Auth::user()->sales_id;
        $year = $request->input('year');
        $dataBudget = DB::table('crm_sales_budget')
        ->leftJoin('users', 'crm_sales_budget.sales_id', 'users.sales_id')
        ->select('crm_sales_budget.id', 'crm_sales_budget.sales_id', 'crm_sales_budget.periode', 'crm_sales_budget.b_sales', 'crm_sales_budget.b_customer', 'crm_sales_budget.b_customer_qty', 'crm_sales_budget.b_product', 'crm_sales_budget.b_product_qty', 'crm_sales_budget.b_offering', 'crm_sales_budget.created_at', 'crm_sales_budget.updated_at', 'users.username')
        ->where('crm_sales_budget.sales_id', $salesId)->orderBy('created_at', 'desc');

        if ($year != null) {
            $dataBudget = $dataBudget->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = '$year'");
        }

        if ($request->ajax()) {
            return DataTables::of($dataBudget)
                ->editColumn('periode', function ($dataBudget) {
                    return date('Y F', strtotime($dataBudget->periode));
                })
                ->editColumn('updated_at', function ($dataBudget) {
                    return date('Y-m-d', strtotime($dataBudget->updated_at));
                })
                ->editColumn('b_sales', function ($dataBudget) {
                    return number_format($dataBudget->b_sales, 0, ',', '.')."";
                })
                ->editColumn('b_customer', function ($dataBudget) {
                    return number_format($dataBudget->b_customer, 0, ',', '.')."";
                })
                ->editColumn('b_product', function ($dataBudget) {
                    return number_format($dataBudget->b_product, 0, ',', '.')."";
                })
                ->editColumn('b_offering', function ($dataBudget) {
                    return number_format($dataBudget->b_offering, 0, ',', '.')."";
                })
                ->addColumn('action', function ($dataBudget) {
                    return '
                    <div x-data="{ modalOpen: false }">
                        <button class="btn btn-edit bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                            aria-controls="feedback-modal" data-id="' . $dataBudget->id . '" data-sales="' . $dataBudget->sales_id . '"
                            data-periode="' . $dataBudget->periode . '" data-b_sales="' . $dataBudget->b_sales . '" data-b_customer="' . $dataBudget->b_customer . '"
                            data-b_product="' . $dataBudget->b_product . '" data-b_offering="' . $dataBudget->b_offering . '" data-users="' . $dataBudget->username . '"
                            data-b_product_qty="' . $dataBudget->b_product_qty . '" data-b_customer_qty="' . $dataBudget->b_customer_qty . '">Change</button>
                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true"
                            x-cloak></div>
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
                            <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                @keydown.escape.window="modalOpen = false">
                                <!-- Modal header -->
                                <div class="px-5 py-3 border-b border-slate-200">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-slate-800">Change Budgeting</div>
                                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                            <div class="sr-only">Close</div>
                                            <svg class="w-4 h-4 fill-current">
                                                <path
                                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                    <!-- Modal content -->
                                    <div class="modal-content text-xs space-y-3">
                                            
                                    </div>
                            </div>
                        </div>
                </div>';
                })
                ->rawColumns(['action'])
                ->make();
            }
    }

    public function getData1(Request $request)
    {
        $salesId = Auth::user()->sales_id;
        $year = $request->input('year');

        $dataBudget1 = DB::table('crm_sales_budget')
        ->selectRaw("
        DATE_FORMAT(crm_sales_budget.periode, '%Y') AS year,
        SUM(b_sales) AS sales,
        SUM(b_customer) AS cust,
        SUM(b_customer_qty) AS cust1,
        SUM(b_product) AS product,
        SUM(b_product_qty) AS product1,
        SUM(b_offering) AS offer,
        SUM(b_sales + b_customer + b_product + b_offering ) AS total 
        ")
        ->whereRaw("crm_sales_budget.sales_id = '$salesId'")
        ->groupBy('year')
        ->orderBy('year', 'desc');

        if ($year != null) {
            $dataBudget1 = $dataBudget1->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = '$year'");
        }

        if ($request->ajax()) {
            return DataTables::of($dataBudget1)
                ->editColumn('sales', function ($dataBudget1) {
                    return number_format($dataBudget1->sales, 0, ',', '.')."";
                })
                ->editColumn('cust', function ($dataBudget1) {
                    return number_format($dataBudget1->cust, 0, ',', '.')."";
                })
                ->editColumn('product', function ($dataBudget1) {
                    return number_format($dataBudget1->product, 0, ',', '.')."";
                })
                ->editColumn('offer', function ($dataBudget1) {
                    return number_format($dataBudget1->offer, 0, ',', '.')."";
                })
                ->editColumn('total', function ($dataBudget1) {
                    return number_format($dataBudget1->total, 0, ',', '.')."";
                })
                ->make();
            }
    }

    public function create(Request $request)
    {   
        $date = $request->input('periode');

        $date1 = date('Y-m',strtotime($date));

        $salesId = Auth::user()->sales_id;

        $validatedCreate = DB::table('crm_sales_budget')
        ->select('crm_sales_budget.sales_id', 'crm_sales_budget.periode'
        )->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y-%m') = '$date1' and crm_sales_budget.sales_id = '$salesId'")->first();

        // dd($validatedCreate);

        if (empty($validatedCreate)) {
            $dataBudget = DB::table('crm_sales_budget')->insert([
                'sales_id' => $request->input('sales_id'),
                'periode' => $request->input('periode'),
                'b_sales' => $request->input('b_sales'),
                'b_customer' => $request->input('b_customer'),
                'b_product' => $request->input('b_product'),
                'b_offering' => $request->input('b_offering'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            alert()->success('Success', 'Anual Budget has been created');
            return to_route('budget');
        } else {
            alert()->error('Error', 'Month and Year are already exist');
            return to_route('budget');
        }
    }

    public function update(Request $request, $budgetId)
    {
        // $date = $request->input('periode1');

        // $date1 = date('Y-m',strtotime($date));;

        // $salesId = Auth::user()->sales_id;

        // $validatedCreate = DB::table('crm_sales_budget')
        // ->select('crm_sales_budget.sales_id', 'crm_sales_budget.periode'
        // )->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y-%m') = '$date1' and crm_sales_budget.sales_id = '$salesId'")->first();

        if ($request) {
            $dataBudget = DB::table('crm_sales_budget')->where('crm_sales_budget.id', $budgetId)->update([
                'sales_id' => $request->input('sales_id1'),
                'periode' => $request->input('periode1'),
                'b_sales' => $request->input('b_sales1'),
                'b_customer' => $request->input('b_customer1'),
                'b_customer_qty' => $request->input('b_customer_qty_1'),
                'b_product' => $request->input('b_product1'),
                'b_product_qty' => $request->input('b_product_qty_1'),
                'b_offering' => $request->input('b_offering1'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            alert()->success('Success', 'Anual Budget has been updated');
            return to_route('budget');
        } else {
            alert()->error('Error', 'Month and Year are already exist');
            return to_route('budget');
        }
    }
}
