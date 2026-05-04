<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use App\Models\DataFeed;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Yajra\DataTables\Facades\DataTables;
    use App\Helpers\Helper;

    class DashboardController extends Controller
    {

        /**
         * Displays the dashboard screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function index(Request $request)
        {
            $dataFeed = new DataFeed();

            $userId = Auth::user()->id;
            $salesId = Auth::user()->sales_id;
            $today = date('Y-m-d');
            $tomorrow = date('Y-m-d', strtotime($today . "+1 days"));
            $tomorrow5days = date('Y-m-d', strtotime($today . "+5 days"));

            $role = DB::table('users')->select('users.role', 
            DB::raw("
                case
                    when users.role = 100 then 'Administrator'
                    when users.role = 101 then 'Global Director'
                    when users.role = 102 then 'Specific Director'
                    when users.role = 200 then 'Sales Director'
                    when users.role = 201 then 'Sales Manager'
                    when users.role = 202 then 'Sales Supervisor'
                    when users.role = 203 then 'Salesman'
                    when users.role = 300 then 'Logistics Director'
                    when users.role = 301 then 'Logistics Manager'
                    when users.role = 302 then 'Logistics Supervisor'
                    when users.role = 303 then 'Logistics Staff'
                    when users.role = 500 then 'Purchasing Director'
                    when users.role = 501 then 'Purchasing Manager'
                    when users.role = 502 then 'Purchasing Supervisor'
                    when users.role = 503 then 'Purchasing Staff'
                    when users.role = 600 then 'HR Director'
                    when users.role = 601 then 'HR Manager'
                    when users.role = 602 then 'HR Supervisor'
                    when users.role = 603 then 'HR Staff'
                    when users.role = 700 then 'IT Director'
                    when users.role = 701 then 'IT Manager'
                    when users.role = 702 then 'IT Supervisor'
                    when users.role = 703 then 'IT Staff'
                    when users.role = 800 then 'Finance Director'
                    when users.role = 801 then 'Finance Manager'
                    when users.role = 802 then 'Finance Supervisor'
                    when users.role = 803 then 'Finance Staff'
                    when users.role = 900 then 'Accounting Director'
                    when users.role = 901 then 'Accounting Manager'
                    when users.role = 902 then 'Accounting Supervisor'
                    when users.role = 903 then 'Accounting Staff'
                    when users.role = 1000 then 'GA Director'
                    when users.role = 1001 then 'GA Manager'
                    when users.role = 1002 then 'GA Supervisor'
                    when users.role = 1003 then 'GA Staff'
                    else 'unknown role'
                end as role_name
            "))->get();
    
            $dataCalendarsQuery = DB::table('calendar')
                ->leftJoin('calendar_users', 'calendar.idrec', 'calendar_users.id_calendar')
                ->join('calendar_color', 'calendar_color.id', 'calendar.id_calendar_color')
                ->join('colors', 'colors.id', 'calendar_color.id_color')
                ->select(
                    'calendar.calendar_name',
                    'calendar.start_time',
                    'calendar_color.color_tag',
                    'colors.value_color'
                )
                ->whereRaw("(calendar.add_by = $userId or calendar_users.id_user in ($userId))")
                ->groupBy('calendar.idrec');

            $dataCalendars = [
                'today' => (clone $dataCalendarsQuery)->whereDate('calendar.start_time', $today)->orderBy('calendar.start_time')->get(),
                'tomorrow' => (clone $dataCalendarsQuery)->whereDate('calendar.start_time', '>=', $tomorrow)->whereDate('calendar.start_time', '<=', $tomorrow5days)->orderBy('calendar.start_time')->get()
            ];

            $dataOfferingQuery = DB::table('offerings')
                ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
                ->join('offering_color', 'offering_color.id', 'offerings.id_offering_color')
                ->join('colors', 'colors.id', 'offering_color.id_color')
                ->select(
                    'offerings.id',
                    'offerings.id_offerings',
                    'offerings.company_id',
                    'offerings.pic',
                    'offerings.id_offering_color',
                    'offerings.start_time',
                    'offerings.end_time',
                    'offerings.created_at',
                    'offerings.add_by',
                    'offerings.notes',
                    'offerings.notulens',
                    'colors.value_color',
                    'offering_color.color_tag',
                    'company_pics.phone_number_1',
                    'company_pics.phone_number_2',
                    'company_pics.email',
                    'company_pics.name'
                )
                ->groupBy('offerings.id');

            $dataOfferingQuery->whereRaw("offerings.add_by = $userId");

            $dataOffering = [
                'today' => (clone $dataOfferingQuery)->whereDate('offerings.start_time', $today)->orderBy('offerings.start_time')->get(),
                'tomorrow' => (clone $dataOfferingQuery)->whereDate('offerings.start_time', '>=', $tomorrow)->whereDate('offerings.start_time', '<=', $tomorrow5days)->orderBy('offerings.start_time')->get()
            ];

            $dataOngoingOrders = DB::table('t_ongoing_order')->select('*')->orderBy('t_ongoing_order.name', 'desc')->get();

            return view('pages/dashboard/dashboard', compact('dataFeed', 'dataCalendars', 'dataOffering', 'role', 'dataOngoingOrders'));
        }

        /**
         * Displays the analytics screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function analytics()
        {
            return view('pages/dashboard/analytics');
        }

        /**
         * Displays the fintech screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function fintech()
        {
            return view('pages/dashboard/fintech');
        }

        public function getData(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesGlobalQuery = DB::table('orders')
                ->selectRaw("
                    YEAR(delivery_date) AS year,
                    MONTHNAME(delivery_date) AS month,
                    MONTH(delivery_date) AS month_number,
                    SUM(dpp) AS net_sales_total,
                    COUNT(id) AS invoice_count,
                    COUNT(DISTINCT company_id) AS customer_count
                ")
                ->whereRaw("YEAR(delivery_date) = $year");

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesGlobalQuery->where('idsalesman', $salesId);
            }

            // data for chart
            $arrayLabel = [];
            $arrayData = [];

            $dataSalesGlobal = $dataSalesGlobalQuery
                ->groupByRaw("YEAR(delivery_date), MONTHNAME(delivery_date)")
                ->orderByRaw("MONTH(delivery_date)")
                ->get();

            foreach ($dataSalesGlobal as $key => $value) {
                $label = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel, $label);
                array_push($arrayData, $value->net_sales_total * 1);
            }

            return response()->json([
                'labels' => $arrayLabel,
                'data' => $arrayData
            ]);
        }
        public function getAchiev(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesAchievQuery = DB::table('crm_sales_budget')
                ->selectRaw("
                    YEAR(periode) AS year,
                    MONTHNAME(periode) AS month,
                    MONTH(periode) AS month_number,
                    SUM(b_sales) AS sales_b,
                    SUM(r_sales) AS sales_r
                ")
                ->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = $year");

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesAchievQuery->where('sales_id', $salesId);
            }

            // data for chart
            $arrayLabel1 = [];
            $arrayData1 = [];
            $arrayLabel2 = [];
            $arrayData2 = [];

            $dataSalesAchiev = $dataSalesAchievQuery
                ->groupByRaw("YEAR(periode), MONTHNAME(periode)")
                ->orderByRaw("MONTH(periode)")
                ->get();

            foreach ($dataSalesAchiev as $key => $value) {
                $label1 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel1, $label1);
                array_push($arrayData1, $value->sales_b * 1);
                $label2 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel2, $label2);
                array_push($arrayData2, $value->sales_r * 1);
            }

            return response()->json([
                'labels1' => $arrayLabel1,
                'data1' => $arrayData1,
                'labels2' => $arrayLabel2,
                'data2' => $arrayData2
            ]);
        }

        public function getCust(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesAchievQuery = DB::table('crm_sales_budget')
                ->selectRaw("
                    YEAR(periode) AS year,
                    MONTHNAME(periode) AS month,
                    MONTH(periode) AS month_number,
                    SUM(b_customer) AS customer_b,
                    SUM(r_customer) AS customer_r
                ")
                ->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = $year");

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesAchievQuery->where('sales_id', $salesId);
            }

            // data for chart
            $arrayLabel1 = [];
            $arrayData1 = [];
            $arrayLabel2 = [];
            $arrayData2 = [];

            $dataSalesAchiev = $dataSalesAchievQuery
                ->groupByRaw("YEAR(periode), MONTHNAME(periode)")
                ->orderByRaw("MONTH(periode)")
                ->get();

            foreach ($dataSalesAchiev as $key => $value) {
                $label1 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel1, $label1);
                array_push($arrayData1, $value->customer_b * 1);
                $label2 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel2, $label2);
                array_push($arrayData2, $value->customer_r * 1);
            }

            return response()->json([
                'labels1' => $arrayLabel1,
                'data1' => $arrayData1,
                'labels2' => $arrayLabel2,
                'data2' => $arrayData2
            ]);
        }
        public function getProduct(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesAchievQuery = DB::table('crm_sales_budget')
                ->selectRaw("
                    YEAR(periode) AS year,
                    MONTHNAME(periode) AS month,
                    MONTH(periode) AS month_number,
                    SUM(b_product) AS product_b,
                    SUM(r_product) AS product_r
                ")
                ->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = $year");

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesAchievQuery->where('sales_id', $salesId);
            }

            // data for chart
            $arrayLabel1 = [];
            $arrayData1 = [];
            $arrayLabel2 = [];
            $arrayData2 = [];

            $dataSalesAchiev = $dataSalesAchievQuery
                ->groupByRaw("YEAR(periode), MONTHNAME(periode)")
                ->orderByRaw("MONTH(periode)")
                ->get();

            foreach ($dataSalesAchiev as $key => $value) {
                $label1 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel1, $label1);
                array_push($arrayData1, $value->product_b * 1);
                $label2 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel2, $label2);
                array_push($arrayData2, $value->product_r * 1);
            }

            return response()->json([
                'labels1' => $arrayLabel1,
                'data1' => $arrayData1,
                'labels2' => $arrayLabel2,
                'data2' => $arrayData2
            ]);
        }
        public function getOffer(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesAchievQuery = DB::table('crm_sales_budget')
                ->selectRaw("
                    YEAR(periode) AS year,
                    MONTHNAME(periode) AS month,
                    MONTH(periode) AS month_number,
                    SUM(b_offering) AS offering_b,
                    SUM(r_offering) AS offering_r
                ")
                ->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = $year");

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesAchievQuery->where('sales_id', $salesId);
            }

            // data for chart
            $arrayLabel1 = [];
            $arrayData1 = [];
            $arrayLabel2 = [];
            $arrayData2 = [];

            $dataSalesAchiev = $dataSalesAchievQuery
                ->groupByRaw("YEAR(periode), MONTHNAME(periode)")
                ->orderByRaw("MONTH(periode)")
                ->get();

            foreach ($dataSalesAchiev as $key => $value) {
                $label1 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel1, $label1);
                array_push($arrayData1, $value->offering_b * 1);
                $label2 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel2, $label2);
                array_push($arrayData2, $value->offering_r * 1);
            }

            return response()->json([
                'labels1' => $arrayLabel1,
                'data1' => $arrayData1,
                'labels2' => $arrayLabel2,
                'data2' => $arrayData2
            ]);
        }

        public function getAr(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $filterYear = $request->input('year');
            $yearNow = date('Y');
            $year = $filterYear ?? $yearNow;

            $dataSalesAchievQuery = DB::table('t_ar_days')
                ->selectRaw("
                    YEAR(period) AS year,
                    MONTHNAME(period) AS month,
                    MONTH(period) AS month_number,
                    SUM(unpaidinvt) AS unpaid,
                    SUM(paidinvt) AS paid
                ")
                ->whereRaw("DATE_FORMAT(t_ar_days.period, '%Y') = $year");

            // data for chart
            $arrayLabel1 = [];
            $arrayData1 = [];
            $arrayLabel2 = [];
            $arrayData2 = [];

            $dataSalesAchiev = $dataSalesAchievQuery
                ->groupByRaw("YEAR(period), MONTHNAME(period)")
                ->orderByRaw("MONTH(period)")
                ->get();

            foreach ($dataSalesAchiev as $key => $value) {
                $label1 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel1, $label1);
                array_push($arrayData1, $value->unpaid * 1);
                $label2 = substr($value->month, 0, 3) . ' ' . $value->year;
                array_push($arrayLabel2, $label2);
                array_push($arrayData2, $value->paid * 1);
            }

            return response()->json([
                'labels1' => $arrayLabel1,
                'data1' => $arrayData1,
                'labels2' => $arrayLabel2,
                'data2' => $arrayData2
            ]);
        }

        public function achievPersent(Request $request)
        {
            $year = $request->input('year1');

            $dataSalesAchiev = DB::table('crm_sales_budget')
            ->select('crm_sales_budget.periode', 'crm_sales_budget.b_sales', 'crm_sales_budget.r_sales')
            ->selectRaw("SUM(b_sales) AS sales_b, SUM(r_sales) AS sales_r, YEAR(periode), MONTHNAME(periode),
            (SUM(r_sales) * 100 / SUM(b_sales)) AS percent")
            ->groupByRaw("YEAR(periode), MONTHNAME(periode)")
            ->orderByRaw("MONTH(periode)");

            if ($year != null) {
                $dataSalesAchiev = $dataSalesAchiev->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = '$year'");
            }

            if ($request->ajax()) {
                return DataTables::of($dataSalesAchiev)
                ->editColumn('periode', function ($dataBudget) {
                    return date('Y F', strtotime($dataBudget->periode));
                })
                ->editColumn('sales_b', function ($dataSalesAchiev) {
                    return 'IDR '. number_format($dataSalesAchiev->sales_b, 0, ',', '.')."";
                })
                ->editColumn('sales_r', function ($dataSalesAchiev) {
                    return 'IDR '. number_format($dataSalesAchiev->sales_r, 0, ',', '.')."";
                })
                ->editColumn('percent', function ($dataSalesAchiev) {
                    return number_format($dataSalesAchiev->percent, 2) . '%';
                })
                ->make();
            }
        }

        public function achievPersent1(Request $request)
        {
            $userRole = Auth::user()->role;
            $salesId = Auth::user()->sales_id;
            $year = $request->input('year1');

            $dataSalesAchiev = DB::table('crm_sales_budget')
            ->join('users', 'crm_sales_budget.sales_id', 'users.sales_id')
            ->select('crm_sales_budget.sales_id', 'crm_sales_budget.periode', 'crm_sales_budget.b_sales', 'crm_sales_budget.r_sales', 'users.username')
            ->selectRaw("(r_sales * 100 / b_sales) AS percent");

            if ($year != null) {
                $dataSalesAchiev = $dataSalesAchiev->whereRaw("DATE_FORMAT(crm_sales_budget.periode, '%Y') = '$year'");
            }

            if ($userRole == '200' || $userRole == '201' || $userRole == '202' || $userRole == '203'){
                $dataSalesAchiev->where('crm_sales_budget.sales_id', $salesId);
            }

            if ($request->ajax()) {
                return DataTables::of($dataSalesAchiev)
                ->editColumn('periode', function ($dataBudget) {
                    return date('Y F', strtotime($dataBudget->periode));
                })
                ->editColumn('b_sales', function ($dataSalesAchiev) {
                    return 'IDR '. number_format($dataSalesAchiev->b_sales, 0, ',', '.')."";
                })
                ->editColumn('r_sales', function ($dataSalesAchiev) {
                    return 'IDR '. number_format($dataSalesAchiev->r_sales, 0, ',', '.')."";
                })
                ->editColumn('percent', function ($dataSalesAchiev) {
                    return number_format($dataSalesAchiev->percent, 2) . '%';
                })
                ->make();
            }
        }

        public function achievSales()
        {
            return view('pages.dashboard.achievSales');
        }
        
        public function orderPrincipal(Request $request)
        {
            $year = $request->input('year2');
            $dataInvoice = DB::table('t_purchase_invoice')
            ->join('m_vendors', 't_purchase_invoice.idsupplier', 'm_vendors.idsupplier')
            ->select('t_purchase_invoice.idrec', 'm_vendors.name', 't_purchase_invoice.idsupplier', 't_purchase_invoice.currency', 't_purchase_invoice.invdate'
            , 't_purchase_invoice.idpo', 't_purchase_invoice.total')
            ->selectRaw("COUNT(idrec) AS invoice_count, YEAR(invdate) AS year, SUM(total) AS grand_total")
            ->groupByRaw("YEAR(invdate), idsupplier");

            if ($year != null) {
                $dataInvoice->whereRaw("YEAR(invdate) = $year");
            }

            if ($request->ajax()) {
                return DataTables::of($dataInvoice)
                ->editColumn('invdate', function ($dataInvoice) {
                    return date('Y', strtotime($dataInvoice->invdate));
                })
                ->editColumn('grand_total', function ($dataInvoice) {
                    return number_format($dataInvoice->grand_total, 2, '.', '.') . '';
                })
                    ->addColumn('action', function ($dataInvoice) {
                        return '
                        <div class="flex flex-row">
                            <div x-data="{ modalOpen: false }">
                                <button  class="btn btn-sm btn-principal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                    @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataInvoice->idrec.'"
                                    data-name = "' . $dataInvoice->name . '" data-supplier = "' . $dataInvoice->idsupplier . '" data-currency ="'.$dataInvoice->currency.'" 
                                    data-date = "' . $dataInvoice->invdate . '" data-idpo = "' . $dataInvoice->idpo . '" data-year = "' . $dataInvoice->year . '" 
                                >View Orders</button>
                                
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
                                                <div class="font-semibold text-slate-800">Order By Principal Detail</div>
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
                            </div>
                        </div>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }

        }

        public function orderPrincipalDetail(Request $request, $year,$idsupplier)
        {
            $dataInvoice = DB::table('t_purchase_invoice')
            ->join('m_vendors', 't_purchase_invoice.idsupplier', 'm_vendors.idsupplier')
            ->select('t_purchase_invoice.idrec', 'm_vendors.name', 't_purchase_invoice.idsupplier', 't_purchase_invoice.currency', 't_purchase_invoice.invdate',
            't_purchase_invoice.idpo', 't_purchase_invoice.paystat', 't_purchase_invoice.total', 't_purchase_invoice.sinvoice', 't_purchase_invoice.crate')
            ->whereRaw("DATE_FORMAT(t_purchase_invoice.invdate, '%Y') = '$year' and t_purchase_invoice.idsupplier = '$idsupplier'")->get()->toArray();

            return $dataInvoice;
        }

        public function principalDetail(Request $request, $idpo)
        {
            $dataInvoice = DB::table('t_purchase_invoice')->select('t_purchase_invoice.idpo')->first();
            $dataPrincipalDetail = DB::table('t_purchase_invoice_detail')
            ->leftJoin('t_purchase_invoice', 't_purchase_invoice_detail.idpurch', 't_purchase_invoice.idpo')
            ->select('t_purchase_invoice_detail.idpurch', 't_purchase_invoice_detail.idinventory', 't_purchase_invoice_detail.name as productName', 't_purchase_invoice_detail.qty', 't_purchase_invoice_detail.unit',
            't_purchase_invoice_detail.price', 't_purchase_invoice_detail.total as grandTotal', 't_purchase_invoice.currency')
            ->where('t_purchase_invoice_detail.idpurch', $idpo)->get();

            return view('pages.dashboard.principalOrdersDetail', compact('dataPrincipalDetail', 'dataInvoice'));
        }

    }
