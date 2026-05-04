<?php

namespace App\Http\Controllers\offering;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Response;

class ProductOfferingController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;
    
    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }

    public function index(Request $request)
    {
        $colors = DB::table('colors')->get();

        $offeringTags = DB::table('offering_color')
            ->join('colors', 'colors.id', 'offering_color.id_color')
            ->select('offering_color.id', 'colors.value_color', 'offering_color.color_tag')
            ->get();

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

        $filterUserId = $request->input('users_schedule');
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

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
                'offerings.offerings_flag',
                'colors.value_color',
                'company_pics.phone_number_1',
                'company_pics.phone_number_2',
                'company_pics.email',
                'company_pics.name'
            )
            ->groupBy('offerings.id');

            $dataOfferingQuery->whereRaw("(offerings.add_by = '$userId' and offerings.offerings_flag = 'Y')");

        $dataOffering = $dataOfferingQuery->get()->toArray();

        $dataProduct = DB::table('products')
        ->select('products.id', 'products.name')->get();

        $dataProducts = DB::table('products')
        ->select('products.id', 'products.name')->get();

        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.tasks.offering.productoffering.index', compact('offeringTags', 'colors', 'dataUsers', 'dataOffering', 'dataProduct', 'dataProducts', 'dataCurrency'));
    }

    public function pic()
    {
        return view('pages.tasks.offering.productoffering.new-pic');
    }

    public function createTag(Request $request)
    {
        $dataOfferingTag = [
            'id_color' => $request->input('color'),
            'color_tag' => $request->input('color_tag'),
            'add_by' => Auth::user()->id
        ];

        $insertOfferingTag = DB::table('offering_color')->insert($dataOfferingTag);

        if ($insertOfferingTag) {
            alert()->success('Success', 'Calendar Tag Has Been Added');
            return to_route('productoffering');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('productoffering');
        }
    }

    public function createOffering(Request $request)
    {   
        //return $request->all();
        $rowsProducts = $request->get('rows');
        $tag = $request->input('offeringTag');
        $pic = $request->input('pic');
        

        $yearNow = date('Y');
        $maxId = DB::table('offerings')
            ->max('id_offerings');

        $yearNowSubstring = substr($yearNow, -2);
        $maxIdSubstring = substr($maxId, 0, 2);
        
        if (is_null($maxId)) {
            $offeringId = $yearNowSubstring . 'AYD-OFP001';
        } else {
            if ($maxIdSubstring == $yearNowSubstring) {
                $runningNumber = substr($maxId, -3);
                $newRunningNumber = $runningNumber + 1;
                $offeringId = $yearNowSubstring . 'AYD-OFP' . str_pad($newRunningNumber, 3, '0', STR_PAD_LEFT);
            } else {
                $offeringId = $yearNowSubstring . 'AYD-OFP001';
            }
        }

        if (!empty($rowsProducts && $tag && $pic)) {
            if ($request->input('name_pic') != null) {    
                if ($request->input('phone_number_2') && $request->input('email') && $request->input('phone_number_1') && $request->input('name_pic')  != null) {
                    $datacreatePic = DB::table('company_pics')->insertGetId([
                        'company_id' => $request->input('idCompany'),
                        'name' => $request->input('name_pic'),
                        'phone_number_1' => $request->input('phone_number_1'),
                        'phone_number_2' => $request->input('phone_number_2'),
                        'email' => $request->input('email'),
                        'status' => '1',
                        'last_updated_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $createPic = $datacreatePic;
                    $dataOfferingProduct = DB::table('offerings')->insertGetId([
                        'id_offerings' => $offeringId,
                        'company_id' => $request->input('company'),
                        'pic' => $createPic,
                        'id_offering_color' => $request->input('offeringTag'),
                        'start_time' => $request->input('start_date'),
                        'end_time' => $request->input('end_date'),
                        'notes' => $request->input('notes'),
                        'offerings_flag' => 'Y',
                        'project_flag' => 'N',
                        'sample_flag' => 'No',
                        'created_at' => date('Y-m-d H:i:s'),
                        'add_by' => Auth::user()->id
                    ]);
                    $idOffering = $dataOfferingProduct;
        
                    foreach ($rowsProducts as $key) {
                        DB::table('offering_products')->insert([
                            'offering_id' => $idOffering,
                            'id_offerings' => $offeringId,
                            'product_id' => $key['ids'],
                            'price' => $key['prices'],
                            'm_currency' => $key['currencys'],
                            'moqty' => $key['moqs'],
                            'qty' => $key['oqs'],
                            'status' => $key['status'],
                            'notes' => $key['notes'],
                            'rnd_user_id' => $key['request'],
                            'rnd_flag' => $key['rnd_flag'],
                            'flag_sample' => $key['sample_flag'],
                            'sample_user_id' => $key['request1'],
                            'show_product' => $key['shows'],
                            'notes_document' => $key['document'],
                            'notes_sample' => $key['sample'],
                            'sample_qty' => '0',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        
                        if ($key['request'] != null) {
                            DB::table('offering_document')->insert([
                                'id_offerings'=> $offeringId,
                                'offering_id'=> $idOffering,
                                'product_id'=> $key['ids'],
                                'rnd_user_id' => $key['request'],
                                'flag_rnd' => $key['rnd_flag']
                            ]);
                        } else {
        
                        }
                        
                        if ($key['request1'] != null) {
                            DB::table('offering_sample')->insert([
                                'id_offerings'=> $offeringId,
                                'offering_id'=> $idOffering,
                                'product_id'=> $key['ids'],
                                'sample_user_id' => $key['request1'],
                                'flag_sample' => $key['sample_flag']
                            ]);
                        } else {
                            
                        }
                    }
                } else {
                    alert()->error('Error', 'Data New PIC Must Fill');
                    return to_route('productoffering');
                }
            } else {
                $dataOfferingProduct = DB::table('offerings')->insertGetId([
                    'id_offerings' => $offeringId,
                    'company_id' => $request->input('company'),
                    'pic' => $request->input('pics'),
                    'id_offering_color' => $request->input('offeringTag'),
                    'start_time' => $request->input('start_date'),
                    'end_time' => $request->input('end_date'),
                    'notes' => $request->input('notes'),
                    'notulens' => $request->input('notulens'),
                    'offerings_flag' => 'Y',
                    'project_flag' => 'N',
                    'sample_flag' => 'No',
                    'created_at' => date('Y-m-d H:i:s'),
                    'add_by' => Auth::user()->id
                ]);
                $idOffering = $dataOfferingProduct;

                foreach ($rowsProducts as $key) {
                    DB::table('offering_products')->insert([
                        'offering_id' => $idOffering,
                        'id_offerings' => $offeringId,
                        'product_id' => $key['ids'],
                        'price' => $key['prices'],
                        'm_currency' => $key['currencys'],
                        'moqty' => $key['moqs'],
                        'qty' => $key['oqs'],
                        'status' => $key['status'],
                        'notes' => $key['notes'],
                        'rnd_user_id' => $key['request'],
                        'rnd_flag' => $key['rnd_flag'],
                        'sample_user_id' => $key['request1'],
                        'flag_sample' => $key['sample_flag'],
                        'show_product' => $key['shows'],
                        'notes_document' => $key['document'],
                        'notes_sample' => $key['sample'],
                        'sample_qty' => '0',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    if ($key['request'] != null) {
                        DB::table('offering_document')->insert([
                            'id_offerings'=> $offeringId,
                            'offering_id'=> $idOffering,
                            'product_id'=> $key['ids'],
                            'rnd_user_id' => $key['request'],
                            'flag_rnd' => $key['rnd_flag']
                        ]);
                    } else {

                    }
                    
                    if ($key['request1'] != null) {
                        DB::table('offering_sample')->insert([
                            'id_offerings'=> $offeringId,
                            'offering_id'=> $idOffering,
                            'product_id'=> $key['ids'],
                            'sample_user_id' => $key['request1'],
                            'flag_sample' => $key['sample_flag']
                        ]);
                    } else {

                    }
                }
            }

            alert()->success('Success', 'Product Offering Has Been Created');
            return to_route('productoffering');
        } else if (empty($rowsProducts && $tag && $pic)){
            alert()->error('Error', 'Products, PIC or Offering Tag Not Fill');
            return to_route('productoffering');
        }
    }

    public function getUpdate($offeringId)
    {
        $offeringsData = DB::table('offerings')
            ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
            ->join('users', 'users.id', 'offerings.add_by')
            ->select(
                'offerings.id',
                'offerings.id_offerings',
                'offerings.company_id',
                'offerings.pic',
                'offerings.id_offering_color',
                'offerings.start_time',
                'offerings.end_time',
                'offerings.notes',
                'offerings.add_by',
                'offerings.notulens',
                'company_pics.name',
                'users.username'
            )
            ->whereRaw("(offerings.id = '$offeringId' and offerings.offerings_flag = 'Y')")
            ->first();

        return response()->json([
            'dataOfferings' => $offeringsData
        ]);
    }

    public function getDetail($offeringId)
    {
        $dataDetailOfferingsQuery = DB::table('offerings')
        ->leftJoin('offering_products', 'offerings.id', 'offering_products.offering_id')
        ->join('products', 'offering_products.product_id', 'products.id')
        ->select(
        'offerings.id',
        'offerings.id_offerings',
        'offering_products.id as product', 'offering_products.product_id', 'offering_products.qty', 'offering_products.status', 'offering_products.price', 'offering_products.moqty', 'offering_products.notes',
        'offering_products.rnd_user_id', 'offering_products.rnd_flag', 'offering_products.document_date', 'offering_products.document_sent_by', 'offering_products.sample_user_id', 'offering_products.flag_sample', 
        'offering_products.sample_delivery_date','offering_products.sample_delivery_reff', 'offering_products.m_currency', 'offering_products.img_1', 'offering_products.img_2','products.name as product_name',
        'offering_products.show_product',
        'offering_products.notes_document',
        'offering_products.notes_sample',
        DB::raw("ISNULL(offering_products.img_1) as photo1"),
        DB::raw("ISNULL(offering_products.img_2) as photo2"))
        ->where('offerings.id', $offeringId);
            
        $dataDetailOfferings = $dataDetailOfferingsQuery->get()->toArray();
        return $dataDetailOfferings;
    } 

    public function update(Request $request, $offeringId)
    {
        $id_offering = $request->input('id_offering');
        $offering_id = $request->input('offering_id');
        $rowsProducts = DB::table('offering_products')
            ->select('offering_id', 'id_offerings', 'product_id', 'm_currency', 'qty', 'price', 'moqty', 'status', 'notes', 'rnd_user_id', 'rnd_flag',
            'document_date', 'document_sent_by', 'sample_user_id', 'flag_sample', 'sample_delivery_date', 'sample_delivery_reff', 'show_product', 'img_1', 'img_2',
            'notes_document', 'notes_sample', 'sample_qty')
            ->where('offering_id', $id_offering)
            ->get();

        $status = $request->input('status');
        if ($status == 'Reschedule') {
            $updatedDate = DB::table('offerings')
            ->where('id', $id_offering)
            ->update([
                'start_time' => $request->input('start_time1'),
                'end_time' => $request->input('end_time1'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Offering Has Been Rescheduled');
            return to_route('productoffering');
        
        }else if ($status == 'update') {
        $updateOffer = DB::table('offerings')->where('id', $offeringId)->update([
            'offerings_flag' => 'N'
        ]);
        
        $idOffering = DB::table('offerings')->insertGetId([
            'id_offerings' => $offering_id,
            'company_id' => $request->input('company1'),
            'pic' => $request->input('picId'),
            'id_offering_color' => $request->input('offeringTag1'),
            'start_time' => $request->input('start_time1'),
            'end_time' => $request->input('end_time1'),
            'notes' => $request->input('notes1'),
            'notulens' => $request->input('notulens'),
            'offerings_flag' => 'Y',
            'project_flag' => 'N',
            'sample_flag' => 'No',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'add_by' => Auth::user()->id
        ]);

        foreach ($rowsProducts as $key => $value) {
            DB::table('offering_products')->insert([
                'offering_id' => $idOffering,
                'id_offerings' => $offering_id,
                'product_id' => $value->product_id,
                'price' => $value->price,
                'm_currency' => $value->m_currency,
                'moqty' => $value->moqty,
                'qty' => $value->qty,
                'status' => $value->status,
                'notes' => $value->notes,
                'rnd_user_id' => $value->rnd_user_id, 
                'rnd_flag' => $value->rnd_flag,
                'sample_user_id' => $value->sample_user_id,
                'flag_sample' => $value->flag_sample, 
                'notes_document' => $value->notes_document,
                'notes_sample' => $value->notes_sample,
                'show_product' => $value->show_product,
                'sample_qty' => $value->sample_qty,
                'img_1' => $value->img_1,
                'img_2' => $value->img_2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
            alert()->success('Success', 'Product Offering Has Been Updated');
            return to_route('productoffering');
        } else {
            alert()->error('Error', 'Products Not Fill');
            return to_route('productoffering');
        }
    }

    public function delete($offeringId)
    {
        try {
            DB::table('offerings')->where('id', $offeringId)->delete();
            DB::table('offering_products')->where('offering_id', $offeringId)->delete();
            DB::table('offering_document')->where('offering_id', $offeringId)->delete();
            DB::table('offering_sample')->where('offering_id', $offeringId)->delete();
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the offerings",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function reschedule(Request $request, $offeringId)
    { 
        $updatedDate = DB::table('offerings')
        ->where('id', $offeringId)
        ->update([
            'start_time' => $request->input('start_time1'),
            'end_time' => $request->input('end_time1'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
            
        if ($updatedDate) {
            alert()->success('Success', 'Offering Has Been Rescheduled');
            return to_route('productoffering');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('productoffering');
        }
    }

    public function detail(Request $request)
    {
        $startTime = $request->input('start_time');
        $userId = Auth::user()->id;

        $dataUsers = DB::table('users')->select('*')->get();
        $dataOfferingQuery = DB::table('offerings')
        ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
        ->join('offering_color', 'offering_color.id', 'offerings.id_offering_color')
        ->join('users as created_by', 'created_by.id', 'offerings.add_by')
        ->select(
            'offerings.id',
            'offerings.id_offerings',
            'offerings.company_id',
            'offerings.pic',
            'offerings.start_time',
            'offerings.end_time',
            'offerings.created_at',
            'offerings.id_offering_color',
            'offerings.add_by',
            'offerings.notes',
            'offerings.notulens',
            'offerings.offerings_flag',
            'offering_color.color_tag',
            'created_by.username',
            'company_pics.name'
        )->whereDate('offerings.start_time', $startTime)
        ->whereRaw("(offerings.add_by = '$userId' and offerings.offerings_flag = 'Y')");

        $dataOffering = $dataOfferingQuery->first();
    
        return view('pages.tasks.offering.productoffering.offeringdetail', compact('dataOffering', 'dataUsers'));
    }

    public function getData(Request $request)
    {
        $startTime = $request->input('start_time');
        $filterUserId = $request->input('users_schedule');
        $userId = Auth::user()->id;

        $dataOfferingQuery = DB::table('offerings')
            ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
            ->join('offering_color', 'offering_color.id', 'offerings.id_offering_color')
            ->join('users as created_by', 'created_by.id', 'offerings.add_by')
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
                'offering_color.color_tag',
                'company_pics.name',
                'created_by.username'
            )->whereRaw("offerings.offerings_flag = 'Y'");

        $dataOffering = $dataOfferingQuery;

        if ($startTime != null) {
            $dataOffering->whereDate('offerings.start_time', '<=', $request->start_time)
            ->whereDate('offerings.end_time', '>=', $request->start_time);
        }
        if ($filterUserId != null) {
            $dataOffering->where('offerings.add_by', $request->users_schedule);
        }

        if ($request->ajax()) {
            return DataTables::of($dataOffering)
            ->editColumn('start_time', function ($dataOffering) {
                return date('Y-m-d H:i', strtotime($dataOffering->start_time));
            })
            ->editColumn('end_time', function ($dataOffering) {
                return date('Y-m-d H:i', strtotime($dataOffering->end_time));
            })
                ->addColumn('action', function ($dataOffering) {
                    if ($dataOffering->offerings_flag  == "Y") {
                        return '
                                <div class="flex flex-row">
                                    <div x-data="{ modalOpen: false }">
                                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white" 
                                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataOffering->id.'" data-offerings="'.$dataOffering->id_offerings.'" 
                                            data-company="'.$dataOffering->company_id.'" data-pic="'.$dataOffering->name.'" data-tag="'.$dataOffering->color_tag.'"
                                            data-start="'.$dataOffering->start_time.'" data-end="'.$dataOffering->end_time.'" data-notes="'.$dataOffering->notes.'"
                                            data-result="'.$dataOffering->notulens.'" data-by="'.$dataOffering->username.'" data-add_by="'.$dataOffering->add_by.'"
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
                                                        <div class="font-semibold text-slate-800">Offering Product Detail Detail</div>
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
                                            </div>
                                        </div>
                                    </div>

                                    <a href = "/tasks/offering/productoffering/offeringupdatepage/' . $dataOffering->id . '/' . $dataOffering->id_offerings . '" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white ml-3"
                                    >Update Offering Product</a>
                                </div>';
                    } else if ($dataOffering->offerings_flag  == "N") {
                        return '
                                <div class="flex flex-row">
                                    <div x-data="{ modalOpen: false }">
                                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white" 
                                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataOffering->id.'" data-offerings="'.$dataOffering->id_offerings.'" 
                                            data-company="'.$dataOffering->company_id.'" data-pic="'.$dataOffering->name.'" data-tag="'.$dataOffering->color_tag.'"
                                            data-start="'.$dataOffering->start_time.'" data-end="'.$dataOffering->end_time.'" data-notes="'.$dataOffering->notes.'"
                                            data-result="'.$dataOffering->notulens.'" data-by="'.$dataOffering->username.'" data-add_by="'.$dataOffering->add_by.'"
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
                                                        <div class="font-semibold text-slate-800">Offering Product Detail Detail</div>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                    
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function updatePage(Request $request, $offeringId, $idOfferings)
    {
        $colors = DB::table('colors')->get();

        $offeringTags = DB::table('offering_color')
            ->join('colors', 'colors.id', 'offering_color.id_color')
            ->select('offering_color.id', 'colors.value_color', 'offering_color.color_tag')
            ->get();

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

        $filterUserId = $request->input('users_schedule');
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

        $dataOfferingQuery = DB::table('offerings')
            ->leftJoin('companies', 'offerings.company_id', 'companies.name')
            ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
            ->join('offering_color', 'offering_color.id', 'offerings.id_offering_color')
            ->join('users as created_by', 'created_by.id', 'offerings.add_by')
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
                'offerings.project_flag',
                'offering_color.color_tag',
                'company_pics.name',
                'created_by.username',
                'companies.id as com_id'
            )
            ->where('offerings.id', $offeringId);

        $dataOffering = $dataOfferingQuery->first();

        $dataProduct = DB::table('products')
        ->select('products.id', 'products.name')->get();

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

        $histories = DB::table('offering_products')
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
                'offering_products.notes_document',
                'offering_products.notes_sample',
                'offering_products.updated_at',
                'users.username',
                'sample.username as sample',
                'ips.code as product_code',
                'ips.name as product_name'
            )->where('offering_products.id_offerings', $idOfferings)->orderBy('offering_products.id', 'desc')->get();

            $dataCurrency = DB::table('currency')
            ->select('*')->get();

        return view('pages.tasks.offering.productoffering.updatepage', compact('offeringTags', 'colors', 'dataUsers', 'dataOffering', 'dataProduct', 'dataOfferingProducts', 'histories', 'dataCurrency'));
    }

    public function deleteProduct($offeringId)
    {
        try {
            DB::table('offering_products')->where('id', $offeringId)->update([
                'status' => 'Deleted',
                'show_product' => 'N',
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the data",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => $e,
            ]);
        }
    }

    public function updateOffering(Request $request, $offeringId)
    {
        // dd($request->all());
        $id_offering = $request->input('id_offering');
        $offering_id = $request->input('offering_id');
        $rows = $request->input('rows');
        $iden = $request->input('iden');
        $rowsProducts = DB::table('offering_products')
            ->select('offering_id', 'id_offerings', 'product_id', 'm_currency', 'qty', 'price', 'moqty', 'status', 'notes', 'rnd_user_id', 'rnd_flag',
            'document_date', 'document_sent_by', 'sample_user_id', 'flag_sample', 'sample_delivery_date', 'sample_delivery_reff', 'img_1', 'img_2', 'show_product',
            'notes_document',
            'notes_sample')
            ->where('offering_id', $id_offering)
            ->get();

        $updateOffer = DB::table('offerings')->where('id', $offeringId)->update([
            'offerings_flag' => 'N'
        ]);
        $updateProd = DB::table('offering_products')->where('offering_id', $offeringId)->update([
            'show_product' => 'N'
        ]);

        $idOffering = DB::table('offerings')->insertGetId([
            'id_offerings' => $offering_id,
            'company_id' => $request->input('company'),
            'pic' => $request->input('pics'),
            'id_offering_color' => $request->input('offeringTag'),
            'start_time' => $request->input('start_date'),
            'end_time' => $request->input('end_date'),
            'notes' => $request->input('notes'),
            'notulens' => $request->input('notulens'),
            'notulens' => $request->input('notulens'),
            'offerings_flag' => 'Y',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'add_by' => Auth::user()->id
        ]);

        if(!empty($request->iden)){
            foreach($request->iden as $iden){
                DB::table('offering_products')->insert([
                    'offering_id' => $idOffering,
                    'id_offerings' => $offering_id,
                    'product_id' => $request->input('ids_'.$iden),
                    'price' => $request->input('price_'.$iden),
                    'm_currency' => $request->input('m_currency_'.$iden),
                    'moqty' => $request->input('moqty_'.$iden),
                    'qty' => $request->input('qty_'.$iden),
                    'status' => $request->input('status_'.$iden),
                    'notes' => $request->input('notes_'.$iden),
                    'rnd_user_id' => $request->input('rnd_user_'.$iden), 
                    'rnd_flag' => $request->input('rnd_flag_'.$iden),
                    'sample_user_id' => $request->input('sample_user_id_'.$iden),
                    'flag_sample' => $request->input('flag_sample_'.$iden), 
                    'img_1' => $request->input('img_1_'.$iden), 
                    'img_2' => $request->input('img_2_'.$iden), 
                    'document_date' => date('Y-m-d H:i:s'), 
                    'document_sent_by' => $request->input('document_sent_by_'.$iden), 
                    'sample_delivery_date' => date('Y-m-d H:i:s'), 
                    'sample_delivery_reff' => $request->input('sample_delivery_reff_'.$iden), 
                    'notes_document' => $request->input('notes2_'.$iden),
                    'notes_sample' => $request->input('notes3_'.$iden),
                    'show_product' => $request->input('show_product_'.$iden),
                    'sample_qty' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // foreach ($rows1 as $key) {
        //     DB::table('offering_products')->insert([
        //         'offering_id' => $idOffering,
        //         'id_offerings' => $offering_id,
        //         'product_id' => $key['ids1'],
        //         'price' => $request->input('product_price2'),
        //         'm_currency' => $request->input('currency2'),
        //         'moqty' => $request->input('minimum_quantity_order2'),
        //         'qty' => $request->input('order_quantity2'),
        //         'status' => $request->input('status_product2'),
        //         'notes' => $request->input('product_note2'),
        //         'rnd_user_id' => $key['rnd_user1'], 
        //         'rnd_flag' => $key['rnd_flag1'],
        //         'sample_user_id' => $key['sample_user_id1'],
        //         'flag_sample' => $key['flag_sample1'], 
        //         'img_1' => $key['img_1'], 
        //         'img_2' => $key['img_2'], 
        //         'document_date' => $key['document_date1'], 
        //         'document_sent_by' => $key['document_sent_by1'], 
        //         'sample_delivery_date' => $key['sample_delivery_date1'], 
        //         'sample_delivery_reff' => $key['sample_delivery_reff1'], 
        //         'notes_document' => $request->input('document_note2'),
        //         'notes_sample' => $request->input('sample_note2'),
        //         'show_product' => $key['show_product'],
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ]);
        // }
        if (!empty($rows)) {
            foreach ($rows as $key) {
                DB::table('offering_products')->insert([
                    'offering_id' => $idOffering,
                    'id_offerings' => $offering_id,
                    'product_id' => $key['ids'],
                    'price' => $key['prices'],
                    'm_currency' => $key['currencys'],
                    'moqty' => $key['moqs'],
                    'qty' => $key['oqs'],
                    'status' => $key['status'],
                    'notes' => $key['notes'],
                    'rnd_user_id' => $key['request'],
                    'rnd_flag' => $key['rnd_flag'],
                    'sample_user_id' => $key['request1'],
                    'flag_sample' => $key['sample_flag'],
                    'show_product' => $key['shows'],
                    'notes_document' => $key['document'],
                    'notes_sample' => $key['sample'],
                    'sample_qty' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                if ($key['request'] != null) {
                    DB::table('offering_document')->insert([
                        'id_offerings'=> $offering_id,
                        'offering_id'=> $idOffering,
                        'product_id'=> $key['ids'],
                        'rnd_user_id' => $key['request'],
                        'flag_rnd' => $key['rnd_flag']
                    ]);
                } else {

                }
                
                if ($key['request1'] != null) {
                    DB::table('offering_sample')->insert([
                        'id_offerings'=> $offering_id,
                        'offering_id'=> $idOffering,
                        'product_id'=> $key['ids'],
                        'sample_user_id' => $key['request1'],
                        'flag_sample' => $key['sample_flag']
                    ]);
                } else {
                    
                }
            }
        }

        if ($request) {
            alert()->success('Success', 'Product Offering Has Been Updated');
            return to_route('productoffering');
        } else {
            alert()->error('Error', 'Products Not Fill');
            return to_route('productoffering');
        }
    }

    public function viewPhoto1($offeringId, $productId)
    {
        $data = DB::table('offering_document')->where('offering_document.product_id', $productId)->where('offering_document.id_offerings', $offeringId)->select('imgblob_1')->first();

        return Response::make($data->imgblob_1, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->imgblob_1)
        ]);
    }

    public function viewPhoto2($offeringId, $productId)
    {
        $data = DB::table('offering_document')->where('offering_document.product_id', $productId)->where('offering_document.id_offerings', $offeringId)->select('imgblob_2')->first();

        return Response::make($data->imgblob_2, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->imgblob_2)
        ]);
    }

    public function viewFile1($offeringId, $productId)
    {
        $dataBs = DB::table('offering_document')->where('id_offerings', $offeringId)->where('product_id', $productId)->select('document_1', 'id_offerings')->first();
        $filename = $dataBs->id_offerings . '.pdf';
        $filebs = $dataBs->document_1;

        return Response::make($filebs, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewFile2($offeringId, $productId)
    {
        $dataBs = DB::table('offering_document')->where('id_offerings', $offeringId)->where('product_id', $productId)->select('document_2', 'id_offerings')->first();
        $filename = $dataBs->id_offerings . '.pdf';
        $filebs = $dataBs->document_2;

        return Response::make($filebs, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function sample($offeringId, $productId)
    {
        $dataBs = DB::table('offering_sample')->where('id_offerings', $offeringId)->where('product_id', $productId)->select('sample_file', 'id_offerings')->first();
        $filename = $dataBs->id_offerings;
        $filebs = $dataBs->sample_file;

        return Response::make($filebs, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataBs->sample_file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function addproject(Request $request)
    {
        //return $request->all();
        $idens = $request->input('idens');
        $offering_id = $request->input('offering_id1');
        
        if ($request->hasFile('file')) {
           $fileName = $request->file('file')->getClientOriginalName();
           $request->file('file')->move($this->saveImageUrl . 'proposal/', $fileName);
       } else {
           $fileName = null;
       }

       if ($request) {

        $updateOffer = DB::table('offerings')->where('id_offerings', $offering_id)->update([
            'project_flag' => 'Y'
        ]);

        $id = DB::table('projects')->insertGetId([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'company_id' => $request->input('companyId'),
            'company_pic_id' => $request->input('pics1'),
            'user_id' => Auth::user()->id,
            'status' => $request->input('status'),
            'date' => $request->input('date'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'file_upload' => $request->input('file')
        ]);
        $projectId = $id;

        DB::table('projects')
            ->where('id', $projectId)
            ->update([
                'file_upload' => $fileName
            ]);

        $task = DB::table('tasks')->insertGetId([
            'project_id' => $projectId,
            'product_id' => $request->input('ids2'),
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'last_updated_by' => Auth::user()->id,
        ]);
        $taskId = $task;

        DB::table('task_details')->insert([
            'task_id' => $taskId,
            'task_action_id' => $request->input('actions'),
            'task_time' => $request->input('date'),
            'notes' => $request->input('notes1'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $request->input('status'),
        ]);

        DB::table('task_history')->insert([
            'project_id' => $projectId,
            'project_status_id' => $request->input('status'),
            'stage_id' => $request->input('actions'),
            'notes' => $request->input('notes1'),
            'success_rate' => '0',
            'date' => $request->input('date')
        ]);
        
        foreach ($request->idens as $idens) {
            if($request->input('check_'.$idens) !== null){
                DB::table('task_products')->insert([
                    'task_id' => $taskId,
                    'product_id' => $request->input('ids1_'.$idens),
                    'price' => $request->input('price1_'.$idens),
                    'm_currency' => $request->input('m_currency1_'.$idens),
                    'minimum_order_qty' => $request->input('moqty1_'.$idens),
                    'order_qty' => $request->input('qty1_'.$idens),
                    'status' => $request->input('status1_'.$idens),
                    'notes' => $request->input('notes1_'.$idens),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        
            alert()->success('Success', 'Add To Project Proposal Succeed');
            return to_route('proyek-single');
        } else{
            alert()->error('Error', 'Error Product not Fill');
            return to_route('proyek-single');
        }
    }
}
