<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\File;

class DoUpdateController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }
    
    public function index()
    {
        return view('pages.logistic.doupdate.index');
    }

    public function getData(Request $request)
    {
        $dataDo = DB::table('orders')
        ->leftJoin('companies', 'orders.company_id', 'companies.id')
        ->select(
            'orders.id',
            'orders.code',
            'orders.do_number',
            'orders.status',
            'orders.created_at',
            'orders.updated_at',
            'orders.delivery_address',
            'orders.delivery_by',
            'orders.delivery_date',
            'orders.photo1_name',
            'orders.photo2_name',
            'companies.name as company',
            DB::raw("ISNULL(orders.photo1) as photo1"),
            DB::raw("ISNULL(orders.photo2) as photo2"),
            DB::raw("
                case
                    when orders.status = 1 then 'Shipping in Progress'
                    when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                    when orders.status = 301 then 'All Delivered - CONFIRMED'
                    when orders.status = 302 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when orders.status = 303 then 'All Lost Delivery - DAMAGE/LOST'
                    when orders.status = 4 then 'Payment Information Received'
                    when orders.status = 5 then 'Finished Payment Verified'
                    else 'unknown status'
                end as name_status
                ")
        )->orderBy('orders.created_at', 'desc');

        if ($request->input('status') != null) {
            $dataDo = $dataDo->where('orders.status', $request->status);
        }

        if ($request->ajax()) {
            return DataTables::of($dataDo)
            ->editColumn('created_at', function ($dataDo) {
                return date('Y-m-d', strtotime($dataDo->created_at));
            })
            ->editColumn('updated_at', function ($dataDo) {
                return date('Y-m-d', strtotime($dataDo->updated_at));
            })
            ->addColumn('label', function ($dataDo) {

                $status = ($dataDo->status);
                    $color = "color";

                    if ($status == '1') {
                        $color = "yellow";
                    } else if ($status == '2') {
                        $color = "orange";
                    } else if ($status == '301') {
                        $color = "red";
                    } else if ($status == '302') {
                        $color = "brown";
                    } else if ($status == '303') {
                        $color = "black";
                    } else if ($status == '4') {
                        $color = "blue";
                    } else if ($status == '5') {
                        $color = "green";
                    }
                    return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
                })
                ->addColumn('action', function ($dataDo) {
                    return '
                    <div class="flex flex-row">
                            <a
                                href = "/logistic/doupdate/doupdatepage/' . $dataDo->code . '" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                data-id="'.$dataDo->id.'" data-code = "' . $dataDo->code . '" data-number = "' . $dataDo->do_number . '" data-by ="'.$dataDo->delivery_by.'" data-stat = "' . $dataDo->name_status . '"
                                data-date = "' . $dataDo->delivery_date . '" data-address = "' . $dataDo->delivery_address . '" data-photo1="'.$dataDo->photo1.'" data-photo2="'.$dataDo->photo2.'"
                            >Update</a>

                    
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDo->id.'"
                                data-code = "' . $dataDo->code . '" data-number = "' . $dataDo->do_number . '" data-by ="'.$dataDo->delivery_by.'" data-stat = "' . $dataDo->name_status . '"
                                data-date = "' . $dataDo->delivery_date . '" data-address = "' . $dataDo->delivery_address . '" data-photo1="'.$dataDo->photo1.'" data-photo2="'.$dataDo->photo2.'"
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
                                            <div class="font-semibold text-slate-800">Delivery Orders Detail</div>
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
                ->rawColumns(['label', 'action'])
                ->make();
        }
    }

    public function getDetail($code)
    {
        $dataDetailDo = DB::table('orders')
            ->leftJoin('delivery_orders', 'orders.do_number', 'delivery_orders.do_number')
            ->join('products', 'delivery_orders.product_code', 'products.code')
            ->select(
            'orders.code',
            'orders.do_number',
            'delivery_orders.product_code', 'delivery_orders.qty', 'delivery_orders.status',
            'delivery_orders.batch_no', 'products.name as product_name',
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
                "))
            ->where('orders.code', $code)
            ->get()->toArray();

        return $dataDetailDo;
    }

    public function updateDO(Request $request, $doNumber)
    {  
        $code = $request->input('code');
       // photo1
       $file_photo1 = $request->file('photo1');    
       $photo1 = $file_photo1->openFile()->fread($file_photo1->getSize());

       if ($request->hasFile('photo1')) {
           $fileName1 = $request->file('photo1')->storeAs('doImg', $code . '-1.jpg');
           $request->file('photo1')->move($this->saveImageUrl . 'doImg/', $fileName1);
       } else {
           $fileName1 = null;
       }
       
       // photo2
       $file_photo2 = $request->file('photo2');    
       $photo2 = $file_photo2->openFile()->fread($file_photo2->getSize());

       if ($request->hasFile('photo2')) {
           $fileName2 = $request->file('photo2')->storeAs('doImg', $code . '-2.jpg');
           $request->file('photo2')->move($this->saveImageUrl . 'doImg/', $fileName2);
       } else {
           $fileName2 = null;
       }
        
        // $status = $request->input('status');

        // if ($status == 'All Delivered - CONFIRMED') {
        //     $statusUpdate = "301";
        // } else if ($status == 'Partially Damage/Lost - DAMAGE/LOST') {
        //     $statusUpdate = "302";
        // } else if ($status == 'All Lost Delivery - DAMAGE/LOST') {
        //     $statusUpdate = "303";
        // }

        $status = $request->input('doStatus');

        if ($status == '303') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);

            $updateProduct = DB::table('delivery_orders')->where('do_number', $doNumber)
            ->update([
                'status' => '3',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('do-update');
        }
        
        if ($status == '301') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);
            $updateProduct = DB::table('delivery_orders')->where('do_number', $doNumber)
            ->update([
                'status' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('do-update');
        }

        if ($status == '302') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('do-update');
        }
    }

    public function viewPhoto1($code)
    {
        $data = DB::table('orders')->where('orders.code', $code)->select('photo1')->first();

        return Response::make($data->photo1, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->photo1)
        ]);
    }

    public function viewPhoto2($code)
    {
        $data = DB::table('orders')->where('code', $code)->select('photo2')->first();

        return Response::make($data->photo2, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->photo2)
        ]);
    }

    public function updatePage(Request $request, $code)
    {
        $dataDeliveryOrders = DB::table('delivery_orders')
            ->leftJoin('products', 'delivery_orders.product_code', 'products.code')
            ->leftJoin('orders', 'delivery_orders.do_number', 'orders.do_number')
            ->select(
                'delivery_orders.do_number',
                'delivery_orders.product_code',
                'delivery_orders.batch_no',
                'delivery_orders.qty',
                'delivery_orders.status',
                'orders.id',
                'orders.code',
                'products.name as product_name',
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
            ")
            )->where('orders.code', $code)->get();

        $viewDo = DB::table('orders')
        ->leftJoin('companies', 'orders.company_id', 'companies.id')
        ->select(
            'orders.id',
            'orders.code',
            'orders.do_number',
            'orders.status',
            'orders.created_at',
            'orders.updated_at',
            'orders.delivery_address',
            'orders.delivery_by',
            'orders.delivery_date',
            'orders.photo1_name',
            'orders.photo2_name',
            'companies.name as company',
            DB::raw("ISNULL(orders.photo1) as photo1"),
            DB::raw("ISNULL(orders.photo2) as photo2"),
            DB::raw("
                case
                    when orders.status = 1 then 'Shipping in Progress'
                    when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                    when orders.status = 301 then 'All Delivered - CONFIRMED'
                    when orders.status = 302 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when orders.status = 303 then 'All Lost Delivery - DAMAGE/LOST'
                    when orders.status = 4 then 'Payment Information Received'
                    when orders.status = 5 then 'Finished Payment Verified'
                    else 'unknown status'
                end as name_status
                ")

            )->where('orders.code', $code)->first();

        return view('pages.logistic.doupdate.doupdatepage', compact('viewDo', 'dataDeliveryOrders'));
    }
}
