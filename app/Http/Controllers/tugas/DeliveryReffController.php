<?php

namespace App\Http\Controllers\tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DeliveryReffController extends Controller
{
    public function index()
    {
        return view('pages.tasks.delivery-reff.index');
    }

    public function getData (Request $request)
    {
        $dataReff = DB::table('sample_delivery_reff')
        ->select('sample_delivery_reff.id', 'sample_delivery_reff.sample_delivery_reff', 'sample_delivery_reff.company', 'sample_delivery_reff.address',
        'sample_delivery_reff.sample_delivery_date', 'sample_delivery_reff.sample_delivery_notes');

        if ($request->ajax()) {
            return DataTables::of($dataReff)
                ->addColumn('action', function ($dataReff) {
                    return '
                    <a href="/tasks/sample-request/delivery-reff/' . $dataReff->id . '" target="_blank" type="button" class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">Print Sample Receipt</a>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function view(Request $request, $deliveryReff)
    {     
        $dataSamp = DB::table('offering_products')
        ->join('products', 'offering_products.product_id', 'products.id')
        ->leftJoin('sample_delivery_reff', 'offering_products.sample_delivery_reff', 'sample_delivery_reff.sample_delivery_reff')
        ->select(
        'sample_delivery_reff.id',
        'offering_products.id_offerings',
        'offering_products.id as product', 'offering_products.product_id', 'offering_products.qty', 'offering_products.status', 'offering_products.price', 'offering_products.moqty', 'offering_products.notes',
        'offering_products.rnd_user_id', 'offering_products.rnd_flag', 'offering_products.document_date', 'offering_products.document_sent_by', 'offering_products.sample_user_id', 'offering_products.flag_sample', 
        'offering_products.sample_delivery_date','offering_products.sample_delivery_reff', 'offering_products.m_currency', 'offering_products.img_1', 'offering_products.img_2','products.name as product_name',
        'offering_products.show_product', 'offering_products.sample_qty', 'offering_products.created_at',
        'offering_products.notes_document', 'offering_products.notes_sample',
        DB::raw("ISNULL(offering_products.img_1) as photo1"),
        DB::raw("ISNULL(offering_products.img_2) as photo2"))
        ->where('sample_delivery_reff.id', $deliveryReff)->get()->toArray();

        $dataReff = DB::table('sample_delivery_reff')
        ->leftJoin('companies', 'sample_delivery_reff.company', 'companies.name')
        // ->leftJoin('offerings', 'sample_delivery_reff.id_offering', 'offerings.id_offerings')
        // ->join('users', 'offerings.add_by', 'users.id')
        ->join('company_pics', 'companies.id', 'company_pics.company_id')
        ->join('salesmen', 'companies.sales_id', 'salesmen.idsales')
        ->select('salesmen.name as sales', 'sample_delivery_reff.id', 'sample_delivery_reff.sample_delivery_reff', 'sample_delivery_reff.company', 'sample_delivery_reff.address',
        'sample_delivery_reff.sample_delivery_date', 'sample_delivery_reff.sample_delivery_notes', 'company_pics.name', 'company_pics.phone_number_1', 'company_pics.phone_number_2')->where('sample_delivery_reff.id', $deliveryReff)
        ->first();

        return view('pages.tasks.sample-request.delivery-reff', compact('dataReff', 'dataSamp'));
    }
}
