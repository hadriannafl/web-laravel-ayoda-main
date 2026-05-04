<?php

namespace App\Http\Controllers\purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;

class PurchasingController extends Controller
{
    public function form()
    {
        $dataProduct = DB::table('products')
        ->select('products.code', 'products.name', 'products.unit')->get();

        $dataVendor = DB::table('m_vendors')
        ->select('m_vendors.idsupplier', 'm_vendors.name')->get();
        
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.purchasing.purchase-request.form', compact('dataProduct', 'dataVendor', 'dataCurrency'));
    }

    public function approval()
    {
        return view('pages.purchasing.purchase-approval.index');
    }

    public function order()
    {
        return view('pages.purchasing.purchase-order.index');
    }

    public function kpi()
    {
        return view('pages.purchasing.purchase-kpi.index');
    }

    public function create(Request $request)
    {
        $yearNow = date('Y');
        $maxId = DB::table('purchase_order')
            ->max('idpo');

        $yearNowSubstring = substr($yearNow, -2);
        $maxIdSubstring = substr($maxId, 0, 2);
        
        if (is_null($maxId)) {
            $POID = $yearNowSubstring . 'AYD-PO1';
        } else {
            if ($maxIdSubstring == $yearNowSubstring) {
                $runningNumber = substr($maxId, 8);
                $newRunningNumber = $runningNumber + 1;
                $POID = $yearNowSubstring . 'AYD-PO' . $newRunningNumber;
            } else {
                $POID = $yearNowSubstring . 'AYD-PO1';
            }
        }

        $rowsProducts = $request->get('rows');

        if (!empty($rowsProducts)) {
            $dataPurcahseOrder = DB::table('purchase_order')->insertGetId([
                'idpo' => $POID,
                'datepo' => $request->input('date'),
                'deliverydate' => $request->input('date'),
                'idsupplier' => $request->input('supplier'),
                'idwarehouse' => '1',
                'category' => 'AYD',
                'crossrate' => $request->input('crossrate'),
                'pterm' => $request->input('pterm'),
                'pvat' => $request->input('pvat'),
                'avat' => $request->input('pvatidr1'),
                'currency' => $request->input('currency'),
                'notes' => $request->input('notes'),
                'subtotal' => $request->input('subtotal1'),
                'gtotal' => $request->input('grandtotal1'),
                'status' => 'Pending',
                'addedby' => Auth::user()->username
            ]);
            $dataPO = $dataPurcahseOrder;
    
            foreach ($rowsProducts as $key) {
                DB::table('purchase_order_detail')->insert([
                    'idpo' => $POID,
                    'no' => $key['no'],
                    'code' => $key['ids'],
                    'name' => $key['name'],
                    'quantity' => $key['oqs'],
                    'unit' => $key['unit'],
                    'price' => $key['prices'],
                    'total' => $key['totals'],
                    'balance' => '0'
                ]);
            }
            alert()->success('Success', 'Purchase Request Has Been Sent');
            return to_route('purchase-order');
        } else {
            alert()->error('Error', 'Products Not Fill');
            return to_route('purchase-order');
        }
    }

    public function getProduct($idPO)
    {
        $dataDetailPurchaseOrderQuery = DB::table('purchase_order_detail')
        ->select('*')
        ->where('purchase_order_detail.idpo', $idPO);
            
        $dataDetailPurchaseOrder = $dataDetailPurchaseOrderQuery->get()->toArray();
        return $dataDetailPurchaseOrder;
    }

    public function getApproval(Request $request)
    {
        $dataPurchaseOrder = DB::table('purchase_order')
        ->leftJoin('m_vendors', 'purchase_order.idsupplier', 'm_vendors.idsupplier')
        ->select(
            'purchase_order.idpo',
            'purchase_order.datepo',
            'purchase_order.squotation',
            'purchase_order.idsupplier',
            'purchase_order.deliverydate',
            'purchase_order.idwarehouse',
            'purchase_order.category',
            'purchase_order.currency',
            'purchase_order.crossrate',
            'purchase_order.pterm',
            'purchase_order.notes',
            'purchase_order.subtotal',
            'purchase_order.pvat',
            'purchase_order.avat',
            'purchase_order.gtotal',
            'purchase_order.status',
            'purchase_order.addedby',
            'purchase_order.remarks',
            'purchase_order.remarks_by',
            'm_vendors.name'
        )->whereRaw("(purchase_order.status != 'VOID' and purchase_order.status != 'CANCEL')")->orderBy('purchase_order.idpo', 'desc');

        if ($request->input('status') != null){
            $dataPurchaseOrder = $dataPurchaseOrder->where('purchase_order.status', $request->status);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataPurchaseOrder)
            ->editColumn('subtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->subtotal, 0, ',', '.');
            })
            ->editColumn('gtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->gtotal, 0, ',', '.');
            })
            ->addColumn('label', function ($dataPurchaseOrder) {

                $status = ($dataPurchaseOrder->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'COMPLETE') {
                    $color = "grey";
                } else if ($status == 'Denied') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataPurchaseOrder) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataPurchaseOrder->idpo.'"
                            data-datepo = "' . $dataPurchaseOrder->datepo . '" data-squotation = "' . $dataPurchaseOrder->squotation . '" data-idsupplier ="'.$dataPurchaseOrder->idsupplier.'" data-status = "' . $dataPurchaseOrder->status . '"
                            data-deliverydate = "' . $dataPurchaseOrder->deliverydate . '" data-idwarehouse = "' . $dataPurchaseOrder->idwarehouse . '" data-category = "' . $dataPurchaseOrder->category . '" 
                            data-currency = "' . $dataPurchaseOrder->remarks_by . '" data-crossrate = "' . $dataPurchaseOrder->crossrate . '" data-pterm="'.$dataPurchaseOrder->pterm.'"
                            data-notes="'.$dataPurchaseOrder->notes.'" data-subtotal="'.$dataPurchaseOrder->subtotal.'" data-pvat="'.$dataPurchaseOrder->pvat.'" data-avat="'.$dataPurchaseOrder->avat.'" data-gtotal="'.$dataPurchaseOrder->gtotal.'"
                            data-addedby="'.$dataPurchaseOrder->addedby.'" data-remarks="'.$dataPurchaseOrder->remarks.'" data-name="'.$dataPurchaseOrder->name.'" data-matauang="'.$dataPurchaseOrder->currency.'"
                        >View</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase Order Detail</div>
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

                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-approve text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataPurchaseOrder->idpo.'"
                            data-datepo = "' . $dataPurchaseOrder->datepo . '" data-squotation = "' . $dataPurchaseOrder->squotation . '" data-idsupplier ="'.$dataPurchaseOrder->idsupplier.'" data-status = "' . $dataPurchaseOrder->status . '"
                            data-deliverydate = "' . $dataPurchaseOrder->deliverydate . '" data-idwarehouse = "' . $dataPurchaseOrder->idwarehouse . '" data-category = "' . $dataPurchaseOrder->category . '" 
                            data-currency = "' . $dataPurchaseOrder->remarks_by . '" data-crossrate = "' . $dataPurchaseOrder->crossrate . '" data-pterm="'.$dataPurchaseOrder->pterm.'"
                            data-notes="'.$dataPurchaseOrder->notes.'" data-subtotal="'.$dataPurchaseOrder->subtotal.'" data-pvat="'.$dataPurchaseOrder->pvat.'" data-avat="'.$dataPurchaseOrder->avat.'" data-gtotal="'.$dataPurchaseOrder->gtotal.'"
                            data-addedby="'.$dataPurchaseOrder->addedby.'" data-remarks="'.$dataPurchaseOrder->remarks.'" data-name="'.$dataPurchaseOrder->name.'" data-matauang="'.$dataPurchaseOrder->currency.'"
                        >Approve</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase Order Approve</div>
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

                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-denied text-sm bg-rose-500 hover:bg-rose-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataPurchaseOrder->idpo.'"
                            data-datepo = "' . $dataPurchaseOrder->datepo . '" data-squotation = "' . $dataPurchaseOrder->squotation . '" data-idsupplier ="'.$dataPurchaseOrder->idsupplier.'" data-status = "' . $dataPurchaseOrder->status . '"
                            data-deliverydate = "' . $dataPurchaseOrder->deliverydate . '" data-idwarehouse = "' . $dataPurchaseOrder->idwarehouse . '" data-category = "' . $dataPurchaseOrder->category . '" 
                            data-currency = "' . $dataPurchaseOrder->remarks_by . '" data-crossrate = "' . $dataPurchaseOrder->crossrate . '" data-pterm="'.$dataPurchaseOrder->pterm.'"
                            data-notes="'.$dataPurchaseOrder->notes.'" data-subtotal="'.$dataPurchaseOrder->subtotal.'" data-pvat="'.$dataPurchaseOrder->pvat.'" data-avat="'.$dataPurchaseOrder->avat.'" data-gtotal="'.$dataPurchaseOrder->gtotal.'"
                            data-addedby="'.$dataPurchaseOrder->addedby.'" data-remarks="'.$dataPurchaseOrder->remarks.'" data-name="'.$dataPurchaseOrder->name.'" data-matauang="'.$dataPurchaseOrder->currency.'"
                        >Denied</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase Order Denied</div>
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
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function getOrder(Request $request)
    {
        $dataPurchaseOrder = DB::table('purchase_order')
        ->leftJoin('m_vendors', 'purchase_order.idsupplier', 'm_vendors.idsupplier')
        ->select(
            'purchase_order.idpo',
            'purchase_order.datepo',
            'purchase_order.squotation',
            'purchase_order.idsupplier',
            'purchase_order.deliverydate',
            'purchase_order.idwarehouse',
            'purchase_order.category',
            'purchase_order.currency',
            'purchase_order.crossrate',
            'purchase_order.pterm',
            'purchase_order.notes',
            'purchase_order.subtotal',
            'purchase_order.pvat',
            'purchase_order.avat',
            'purchase_order.gtotal',
            'purchase_order.status',
            'purchase_order.addedby',
            'purchase_order.remarks',
            'purchase_order.remarks_by',
            'm_vendors.name'
        )->whereRaw("(purchase_order.status != 'VOID' and purchase_order.status != 'CANCEL')")->orderBy('purchase_order.idpo', 'desc');

        if ($request->input('status') != null){
            $dataPurchaseOrder = $dataPurchaseOrder->where('purchase_order.status', $request->status);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataPurchaseOrder)
            ->editColumn('subtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->subtotal, 0, ',', '.');
            })
            ->editColumn('gtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->gtotal, 0, ',', '.');
            })
            ->addColumn('label', function ($dataPurchaseOrder) {

                $status = ($dataPurchaseOrder->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'COMPLETE') {
                    $color = "grey";
                } else if ($status == 'Denied') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataPurchaseOrder) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataPurchaseOrder->idpo.'"
                            data-datepo = "' . $dataPurchaseOrder->datepo . '" data-squotation = "' . $dataPurchaseOrder->squotation . '" data-idsupplier ="'.$dataPurchaseOrder->idsupplier.'" data-status = "' . $dataPurchaseOrder->status . '"
                            data-deliverydate = "' . $dataPurchaseOrder->deliverydate . '" data-idwarehouse = "' . $dataPurchaseOrder->idwarehouse . '" data-category = "' . $dataPurchaseOrder->category . '" 
                            data-currency = "' . $dataPurchaseOrder->remarks_by . '" data-crossrate = "' . $dataPurchaseOrder->crossrate . '" data-pterm="'.$dataPurchaseOrder->pterm.'"
                            data-notes="'.$dataPurchaseOrder->notes.'" data-subtotal="'.$dataPurchaseOrder->subtotal.'" data-pvat="'.$dataPurchaseOrder->pvat.'" data-avat="'.$dataPurchaseOrder->avat.'" data-gtotal="'.$dataPurchaseOrder->gtotal.'"
                            data-addedby="'.$dataPurchaseOrder->addedby.'" data-remarks="'.$dataPurchaseOrder->remarks.'" data-name="'.$dataPurchaseOrder->name.'" data-matauang="'.$dataPurchaseOrder->currency.'"
                        >View</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase Order Detail</div>
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
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function getKpi(Request $request)
    {   
        $filterYear = $request->input('year');
        $yearNow = date('Y');

        $year = $filterYear ?? $yearNow;

        $dataPurchaseKpi = DB::table('purchase_kpi')
        ->leftJoin('m_vendors', 'purchase_kpi.idsupplier', 'm_vendors.idsupplier')
        ->select(
            'purchase_kpi.id_kpi',
            'purchase_kpi.periode',
            'purchase_kpi.idsupplier',
            'purchase_kpi.name',
            'purchase_kpi.currency',
            'purchase_kpi.purchase_total',
            'purchase_kpi.product_total',
            'purchase_kpi.product_qty_total',
            'm_vendors.name as supplier_name'
        )->whereRaw("YEAR(periode) = $year")->orderBy('purchase_kpi.id_kpi', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseKpi)
            ->editColumn('periode', function ($dataPurchaseKpi) {
                return date('Y', strtotime($dataPurchaseKpi->periode));
            })
            ->editColumn('purchase_total', function ($dataPurchaseKpi) {
                return "$dataPurchaseKpi->currency" . " " . number_format($dataPurchaseKpi->purchase_total, 0, ',', '.');
            })
            ->editColumn('product_total', function ($dataPurchaseKpi) {
                return "" . number_format($dataPurchaseKpi->product_total, 0, ',', '.' . "");
            })
            ->editColumn('product_qty_total', function ($dataPurchaseKpi) {
                return "" . number_format($dataPurchaseKpi->product_qty_total, 0, ',', '.' . "");
            })
            ->addColumn('action', function ($dataPurchaseKpi) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idkpi="'.$dataPurchaseKpi->id_kpi.'" data-periode = "' . $dataPurchaseKpi->periode . '" 
                            data-idsupplier ="'.$dataPurchaseKpi->idsupplier.'" data-name = "' . $dataPurchaseKpi->name . '" data-currency = "' . $dataPurchaseKpi->currency . '" 
                            data-supplier ="'.$dataPurchaseKpi->supplier_name.'" data-purchase = "' . $dataPurchaseKpi->purchase_total . '" data-product = "' . $dataPurchaseKpi->product_total . '"
                            data-qty = "' . $dataPurchaseKpi->product_qty_total . '"
                        >View</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase KPI Detail</div>
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

    public function getDetail($idKpi)
    {
        $dataDetailPurchaseKpiQuery = DB::table('purchase_kpi_detail')
        ->select('*')
        ->where('purchase_kpi_detail.id_kpi', $idKpi)->orderBy('purchase_kpi_detail.name', 'asc');
            
        $dataDetailPurchaseKpi = $dataDetailPurchaseKpiQuery->get()->toArray();
        return $dataDetailPurchaseKpi;
    }

    public function updateApprove(Request $request, $idPO)
    {
        $updatePO = DB::table('purchase_order')
            ->where('idpo', $idPO)
            ->update([
                'status' => 'Approved',
                'remarks' => $request->input('approve_remarks'),
                'remarks_by' => Auth::user()->username
            ]);

        if ($updatePO) {
            alert()->success('Success', 'Purchase Request Has Been Approved');
            return to_route('purchase-approval');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('purchase-approval');
        }   
    }

    public function updateDenied(Request $request, $idPO)
    {   
        $updatePO = DB::table('purchase_order')
            ->where('idpo', $idPO)
            ->update([
                'status' => 'Denied',
                'remarks' => $request->input('denied_remarks'),
                'remarks_by' => Auth::user()->username
            ]);

        if ($updatePO) {
            alert()->success('Success', 'Purchase Request Has Been Denied');
            return to_route('purchase-approval');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('purchase-approval');
        }  
    }

    public function purchaseDashboard(Request $request)
    {
        $dataPurchaseOrder = DB::table('purchase_order')
        ->leftJoin('m_vendors', 'purchase_order.idsupplier', 'm_vendors.idsupplier')
        ->select(
            'purchase_order.idpo',
            'purchase_order.datepo',
            'purchase_order.squotation',
            'purchase_order.idsupplier',
            'purchase_order.deliverydate',
            'purchase_order.idwarehouse',
            'purchase_order.category',
            'purchase_order.currency',
            'purchase_order.crossrate',
            'purchase_order.pterm',
            'purchase_order.notes',
            'purchase_order.subtotal',
            'purchase_order.pvat',
            'purchase_order.avat',
            'purchase_order.gtotal',
            'purchase_order.status',
            'purchase_order.addedby',
            'purchase_order.remarks',
            'purchase_order.remarks_by',
            'm_vendors.name'
        )->whereRaw("(purchase_order.status = 'Approved')")->orderBy('purchase_order.idpo', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseOrder)
            ->editColumn('subtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->subtotal, 0, ',', '.');
            })
            ->editColumn('gtotal', function ($dataPurchaseOrder) {
                return $dataPurchaseOrder->currency . " " . number_format($dataPurchaseOrder->gtotal, 0, ',', '.');
            })
            ->addColumn('label', function ($dataPurchaseOrder) {

                $status = ($dataPurchaseOrder->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'COMPLETE') {
                    $color = "grey";
                } else if ($status == 'Denied') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataPurchaseOrder) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataPurchaseOrder->idpo.'"
                            data-datepo = "' . $dataPurchaseOrder->datepo . '" data-squotation = "' . $dataPurchaseOrder->squotation . '" data-idsupplier ="'.$dataPurchaseOrder->idsupplier.'" data-status = "' . $dataPurchaseOrder->status . '"
                            data-deliverydate = "' . $dataPurchaseOrder->deliverydate . '" data-idwarehouse = "' . $dataPurchaseOrder->idwarehouse . '" data-category = "' . $dataPurchaseOrder->category . '" 
                            data-currency = "' . $dataPurchaseOrder->remarks_by . '" data-crossrate = "' . $dataPurchaseOrder->crossrate . '" data-pterm="'.$dataPurchaseOrder->pterm.'"
                            data-notes="'.$dataPurchaseOrder->notes.'" data-subtotal="'.$dataPurchaseOrder->subtotal.'" data-pvat="'.$dataPurchaseOrder->pvat.'" data-avat="'.$dataPurchaseOrder->avat.'" data-gtotal="'.$dataPurchaseOrder->gtotal.'"
                            data-addedby="'.$dataPurchaseOrder->addedby.'" data-remarks="'.$dataPurchaseOrder->remarks.'" data-name="'.$dataPurchaseOrder->name.'" data-matauang="'.$dataPurchaseOrder->currency.'"
                        >View</button>
                        
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
                                        <div class="font-semibold text-slate-800">Purchase Order Detail</div>
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
            ->rawColumns(['label','action'])
            ->make();
        }
    }

}
