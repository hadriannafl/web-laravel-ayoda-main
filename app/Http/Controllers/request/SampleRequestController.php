<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use finfo;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class SampleRequestController extends Controller
{
    public function index(Request $request)
    {
        $offeringId = $request->input('offering_id');
        $dataOfferingProducts = DB::table('offering_products')
            ->leftJoin('users', 'offering_products.rnd_user_id', 'users.id')
            ->leftJoin('users as sample', 'offering_products.sample_user_id', 'sample.id')
            ->join('offerings', 'offerings.id', 'offering_products.offering_id')
            ->join('products as ips', 'offering_products.product_id', '=', 'ips.id')
            ->select(
                'offering_products.id',
                'offering_products.offering_id',
                'offering_products.id_offerings',
                'offering_products.product_id',
                'offering_products.price',
                'offering_products.m_currency',
                'offering_products.moqty',
                'offering_products.qty',
                'offering_products.status',
                'offering_products.notes',
                'offering_products.rnd_user_id',
                'offering_products.rnd_flag',
                'offering_products.sample_user_id',
                'offering_products.flag_sample',
                'offering_products.document_sent_by',
                'offering_products.document_date',
                'offering_products.notes_document',
                'offering_products.notes_sample',
                'offering_products.sample_delivery_date',
                'offering_products.sample_delivery_reff',
                'offering_products.img_1',
                'offering_products.img_2',
                'offering_products.show_product',
                'users.username',
                'sample.username as sample',
                'ips.code as product_code',
                'ips.name as product_name'
            )->where('offerings.id', $offeringId)->get();
        return view('pages.tasks.sample-request.index', compact('dataOfferingProducts'));
    }

    public function getData(Request $request)
    {
        $userId = Auth::user()->id; 
        $dataSample = DB::table('offerings')
        ->leftJoin('companies', 'offerings.company_id', 'companies.name')
        ->leftJoin('offering_sample', 'offerings.id_offerings', 'offering_sample.id_offerings')
        ->join('users as created_by', 'created_by.id', 'offerings.add_by')
        ->join('users as request_to', 'request_to.id', 'offering_sample.sample_user_id')
        ->select(
            'offerings.id',
            'offerings.id_offerings',
            'offerings.company_id',
            'offerings.pic',
            'offerings.start_time',
            'offerings.end_time',
            'offerings.id_offering_color',
            'offerings.add_by',
            'offerings.notes',
            'offerings.notulens',
            'offerings.offerings_flag',
            'offerings.sample_flag',
            'offering_sample.offering_id as sample_id',
            'offering_sample.id_offerings as id_sample',
            'offering_sample.id as sample',
            'offering_sample.sample_user_id',
            'offering_sample.flag_sample',
            'offering_sample.sample_delivery_date',
            'offering_sample.sample_delivery_reff',
            'offering_sample.sample_file',
            'created_by.username',
            'request_to.username as request_to',
            'companies.address',
            'companies.id as com_id'
            )
            ->selectRaw("COUNT(DISTINCT offering_sample.product_id) AS item_count")
            ->whereRaw("offerings.offerings_flag = 'Y' and offerings.add_by = '$userId' or offering_sample.sample_user_id = '$userId'")
            ->groupBy('offerings.id_offerings');

        if ($request->ajax()) {
            return DataTables::of($dataSample)
                ->addColumn('action', function ($dataSample) {
                    if ($dataSample->sample_flag != 'Yes') {
                        return '
                        <a href="/tasks/sample-request/getupdate/' . $dataSample->id_offerings . '" class="btn btn-modal text-sm btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" type="button">
                        Update</a>';
                    }
                    if($dataSample->sample_flag == 'Yes'){
                        return '';
                    }
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function getUpdate(Request $request, $offeringId)
    {
        $dataSampleQuery = DB::table('offerings')
        ->leftJoin('offering_products', 'offerings.id', 'offering_products.offering_id')
        ->join('products', 'offering_products.product_id', 'products.id')
        ->select(
        'offerings.id',
        'offerings.id_offerings', 'offerings.offerings_flag',
        'offering_products.id as product', 'offering_products.product_id', 'offering_products.qty', 'offering_products.status', 'offering_products.price', 'offering_products.moqty', 'offering_products.notes',
        'offering_products.rnd_user_id', 'offering_products.rnd_flag', 'offering_products.document_date', 'offering_products.document_sent_by', 'offering_products.sample_user_id', 'offering_products.flag_sample', 
        'offering_products.sample_delivery_date','offering_products.sample_delivery_reff', 'offering_products.m_currency', 'offering_products.img_1', 'offering_products.img_2','products.name as product_name',
        'offering_products.show_product', 'offering_products.sample_qty', 'offering_products.created_at',
        'offering_products.notes_document', 'offering_products.notes_sample',
        DB::raw("ISNULL(offering_products.img_1) as photo1"),
        DB::raw("ISNULL(offering_products.img_2) as photo2"))
        ->whereRaw("offering_products.show_product = 'Y' and offerings.id_offerings = '$offeringId' and offerings.offerings_flag = 'Y'");
            
        $dataSamp = $dataSampleQuery->get();

        $dataSample = DB::table('offerings')
            ->leftJoin('companies', 'offerings.company_id', 'companies.name')
            ->leftJoin('offering_sample', 'offerings.id_offerings', 'offering_sample.id_offerings')
            ->join('users as created_by', 'created_by.id', 'offerings.add_by')
            ->join('users as request_to', 'request_to.id', 'offering_sample.sample_user_id')
            ->select(
                'offerings.id',
                'offerings.id_offerings',
                'offerings.company_id',
                'offerings.pic',
                'offerings.start_time',
                'offerings.end_time',
                'offerings.id_offering_color',
                'offerings.add_by',
                'offerings.notes',
                'offerings.notulens',
                'offerings.sample_flag',
                'offerings.offerings_flag',
                'offering_sample.sample_user_id',
                'offering_sample.flag_sample',
                'offering_sample.sample_delivery_date',
                'offering_sample.sample_delivery_reff',
                'offering_sample.sample_file',
                'created_by.username',
                'request_to.username as request_to',
                'companies.address',
                'companies.id as com_id'
                )->whereRaw("offerings.offerings_flag = 'Y' and offerings.id_offerings = '$offeringId'")->first();

                return view('pages.tasks.sample-request.make', compact('dataSample', 'dataSamp'));
    }

    public function update(Request $request, $offeringId)
    {
        try {
            $maxIdQuery = $request->input('id_offering');
            // Menggunakan DB facade dari Laravel untuk mendapatkan running_number maksimum dari id_offering yang sama
            $maxRunningNumber = DB::table('sample_delivery_reff')
            ->where('id_offering', $maxIdQuery)
            ->max(DB::raw('CAST(SUBSTRING_INDEX(sample_delivery_reff, "/", -1) AS SIGNED)'));

            // Jika tidak ada data sebelumnya dengan id_offering yang sama, atur running_number menjadi 1
            $newRunningNumber = $maxRunningNumber ? $maxRunningNumber + 1 : 1;

            // Membuat reffId baru
            $reffId = $maxIdQuery . '/' . $newRunningNumber;

            $idens = $request->input('idens');
                    
                $item_check = 0;
                foreach ($request->idens as $idens) {
                    $productId = $request->input('ids1_'.$idens);
                    if ($request->input('check_'.$idens) !== null && $request->input('qty1_'.$idens) !== '0') {
                        $item_check++;
                        DB::table('offering_products')->whereRaw("offering_products.show_product = 'Y' and offering_products.id_offerings = '$offeringId' and offering_products.product_id = '$productId'")->update([
                            'sample_user_id' => $request->input('sample_user_'.$idens),
                            'flag_sample' => 'Yes',
                            'sample_delivery_date' => $request->input('date'),
                            'sample_delivery_reff' => $reffId,
                            'notes_sample' => $request->input('notes1_'.$idens),
                            'sample_qty' => $request->input('qty1_'.$idens),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        DB::table('offering_sample')->whereRaw("offering_sample.id_offerings = '$offeringId' and offering_sample.product_id = '$productId'")->update([
                            'sample_delivery_date' => $request->input('date'),
                            'sample_delivery_reff' => $reffId,
                            'flag_sample' => 'Yes'
                        ]);
                    }
                }
                if($item_check > 0){
                    $dataSample = DB::table('offering_sample')
                    ->where('id_offerings', $offeringId)
                    ->count();
                    $dataSampleYesCount = DB::table('offering_sample')
                    ->whereRaw("offering_sample.id_offerings = '$offeringId' and offering_sample.flag_sample = 'Yes'")
                    ->count();
                    if ($dataSampleYesCount == $dataSample) {
                        DB::table('offerings')->whereRaw("offerings.offerings_flag = 'Y' and offerings.id_offerings = '$offeringId'")->update([
                            'sample_flag' => 'Yes'
                        ]);
                    } else {
                        DB::table('offerings')->whereRaw("offerings.offerings_flag = 'Y' and offerings.id_offerings = '$offeringId'")->update([
                            'sample_flag' => 'Partial'
                        ]);
                    }
                    $id = DB::table('sample_delivery_reff')->insertGetId([
                        'id_offering' => $maxIdQuery,
                        'sample_delivery_reff' => $reffId,
                        'company' => $request->input('company'),
                        'address' => $request->input('address'),
                        'sample_delivery_date' => $request->input('date'),
                        'sample_delivery_notes' => $request->input('notes')
                    ]);
                    alert()->success('Success', 'Sample Delivery Reff has been Created');    
                    return response()->json(["st" => '1', "id"=>$id]);
                }else{
                    return response()->json(["st" => '0']);
                }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }

    }
}
