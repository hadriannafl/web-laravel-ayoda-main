<?php

namespace App\Http\Controllers\finance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use finfo;

class UploadTaxController extends Controller
{
    protected $saveTaxImageUrl;
    protected $baseTaxImageUrl;

    public function __construct()
    {
        $this->saveTaxImageUrl = config('app.save_tax_url_file');
        $this->baseTaxImageUrl = config('app.base_tax_url_file');
    }

    public function index(){
        return view('pages.efaktur.index');
    }

    public function getData(Request $request){
        $dataOrder = DB::table('orders')
        ->leftJoin('companies', 'orders.company_id', 'companies.id')
        ->select(
            'orders.id',
            'orders.code',
            'orders.do_number',
            'orders.inv_number',
            'orders.status',
            'orders.created_at',
            'orders.updated_at',
            'orders.delivery_address',
            'orders.delivery_by',
            'orders.delivery_date',
            'orders.tax',
            'orders.tax_file',
            'companies.name as company'
        );

        if ($request->input('year') != null) {
            $dataOrder = $dataOrder->whereRaw("DATE_FORMAT(orders.delivery_date, '%Y') = '$request->year'");
        }

        if ($request->ajax()) {
            return DataTables::of($dataOrder)
            ->editColumn('delivery_date', function ($dataOrder) {
                return date('Y-m-d', strtotime($dataOrder->delivery_date));
            })
            ->editColumn('updated_at', function ($dataOrder) {
                return date('Y-m-d', strtotime($dataOrder->updated_at));
            })
            ->addColumn('label', function ($dataOrder) {
                $status = ($dataOrder->tax);
                    $color = "color";

                     if (!empty($status)) {
                        $color = "green";
                    } else if (empty($status)) {
                        $color = "grey";
                    }
                    return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataOrder) {
                $role = Auth::user()->role;
                if ($role == '800' || $role == '801' || $role == '802') {
                    if (!empty($dataOrder->tax_file)) {
                        return '
                        <div class="flex flex-row">  
                            <a href="/efaktur/' . $dataOrder->code . '" target="_blank" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white text-sm ml-1">
                                View Invoice
                            </a>
                            
                            <a href="' . $this->baseTaxImageUrl . $dataOrder->file_upload .'" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white text-sm ml-3">
                                View Tax
                            </a>
                        </div>';
                    } else {
                        return '
                        <div class="flex flex-row">  
                            <a href="/efaktur/' . $dataOrder->code . '" target="_blank" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white text-sm ml-1">
                                View Invoice
                            </a>
                        </div>';
                    }
                } else if ($role == '100' || $role == '101' || $role == '102' || $role == '803') {
                    if (!empty($dataOrder->tax_file)) {
                        return '
                        <div class="flex flex-row">  
                            <a href="/efaktur/' . $dataOrder->code . '" target="_blank" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white text-sm ml-1">
                                View Invoice
                            </a>
                            
                            <a href="' . $this->baseTaxImageUrl . $dataOrder->tax_file .'" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white text-sm ml-3">
                                View Tax
                            </a>
    
                            <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-3" 
                                data-code="'.$dataOrder->code.'" data-id="'.$dataOrder->id.'" data-inv_number="'.$dataOrder->inv_number.'"
                                data-delivery_date = "' . $dataOrder->delivery_date . '" data-company = "' . $dataOrder->company . '" data-tax ="'.$dataOrder->tax.'"
                                >Delete Tax
                            </button>
    
                        </div>';
                    } else {
                        return '
                        <div class="flex flex-row">  
                            <a href="/efaktur/' . $dataOrder->code . '" target="_blank" class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white text-sm ml-1">
                                View Invoice
                            </a>

                            <div x-data="{ modalOpen: false }">
                                <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                    @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-code="'.$dataOrder->code.'" data-id="'.$dataOrder->id.'" data-inv_number="'.$dataOrder->inv_number.'"
                                    data-delivery_date = "' . $dataOrder->delivery_date . '" data-company = "' . $dataOrder->company . '" 
                                >Upload Tax</button>
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
                                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                            <!-- Modal header -->
                                            <div class="px-5 py-3 border-b border-slate-200">
                                                <div class="flex justify-between items-center">
                                                    <div class="font-semibold text-slate-800">Upload Tax</div>
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
                            </div>
                        </div>';
                    }
                }
            })
            ->rawColumns(['label', 'action'])
            ->make();
        }
    }

    public function viewInv($code)
    {
        $dataOrder = DB::table('orders')->where('code', $code)->select('invoice', 'code')->first();
        $filename = $dataOrder->code;
        $fileOrder = $dataOrder->invoice;

        return Response::make($fileOrder, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataOrder->invoice),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewTax($code)
    {
        $dataOrder = DB::table('orders')->where('code', $code)->select('tax', 'code')->first();
        $filename = $dataOrder->code;
        $fileOrder = $dataOrder->tax;

        return Response::make($fileOrder, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataOrder->tax),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function taxUpload(Request $request, $code)
    {
        if ($request->hasFile('taxFile')) {
            $fileName = $request->file('taxFile')->storeAs('', $code . '.');
            $request->file('taxFile')->move($this->saveTaxImageUrl , $fileName);
        } else {
            $fileName = null;
        }

        // if ($request->hasFile('taxFile')) {
        //     $filePdf = $request->file('taxFile');    
        //     $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        // } else {
        //        $pdf = null;
        // }

        if (!empty($fileName)) {
            DB::table('orders')->where('orders.code', $code)->update([
                'tax_file' => $fileName
            ]);

            alert()->success('Success', 'Tax Has Beem Uploaded');
            return to_route('upload-tax');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('upload-tax');
        }

    }

    public function taxDelete(Request $request, $code)
    {
        
        $fileDelete = [
            'tax_file' => null
        ];

        try {
            DB::table('orders')->where('code', $code)->update($fileDelete);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the data",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
