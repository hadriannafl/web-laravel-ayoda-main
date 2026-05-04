<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        return view('pages.sales.sales-invoice.index');
    }

    public function getData(Request $request)
    {
        $dataInv = DB::table('orders')
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
            'companies.name as company',
            DB::raw("
                case
                    when orders.status = 1 then 'Shipping in Progress'
                    when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                    when orders.status = 301 then 'Delivery Confirmed - Waiting Payment'
                    when orders.status = 302 then 'Partially Delivered - Please Follow Up'
                    when orders.status = 303 then 'Lost in Delivery - Please Follow Up'
                    when orders.status = 4 then 'Payment Information Received'
                    when orders.status = 5 then 'Finished Payment Verified'
                    else 'unknown status'
                end as status_name
                "),
        )->orderBy('orders.created_at', 'desc');

        if ($request->input('status') != null) {
            $dataInv = $dataInv->where('orders.status', $request->status);
        }

        if ($request->ajax()) {
            return DataTables::of($dataInv)
            ->editColumn('created_at', function ($dataInv) {
                return date('Y-m-d', strtotime($dataInv->created_at));
            })
            ->editColumn('updated_at', function ($dataInv) {
                return date('Y-m-d', strtotime($dataInv->created_at));
            })
            ->addColumn('label', function ($dataInv) {

                $status = ($dataInv->status);
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
                ->addColumn('action', function ($dataInv) {
                    return '
                    <a href="/sales/sales-invoice/file/' . $dataInv->id . '" target="_blank" class="btn btn-xs bg-indigo-500 hover:bg-indigo-600 text-white">
                        View
                    </a>';
                })
                ->rawColumns(['label', 'action'])
                ->make();
        }
    }

    public function viewFile($ordersId)
    {
        $order = DB::table('orders')->where('id', $ordersId)->select('invoice', 'inv_number')->first();
        $filename = $order->inv_number . '.pdf';
        $invoice = $order->invoice;

        // if (is_null($invoice)) {
        //     alert()->error('Error', 'Invoice Not Found');
        //     return to_route('invoice');
        // }

        return Response::make($invoice, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
}
