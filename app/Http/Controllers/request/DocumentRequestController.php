<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use finfo;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
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
        return view('pages.tasks.document-request.index');
    }

    public function form($offeringId, $productId)
    {
        $dataDocument = DB::table('offering_document')->select('offering_document.id_offerings', 'offering_document.product_id',
        DB::raw("ISNULL(offering_document.document_1) as doc1"),
        DB::raw("ISNULL(offering_document.document_2) as doc2"),
        DB::raw("ISNULL(offering_document.imgblob_1) as blob1"),
        DB::raw("ISNULL(offering_document.imgblob_2) as blob2"))
        ->where('offering_document.product_id', $productId)->where('offering_document.id_offerings', $offeringId)->first();
        return view('pages.tasks.document-request.upload', compact('dataDocument'));
    }

    public function getData(Request $request)
    {
        $userId = Auth::user()->id;
        
        $dataDocument = DB::table('offerings')
        ->leftJoin('company_pics', 'offerings.pic', 'company_pics.id')
        ->leftJoin('companies', 'offerings.company_id', 'companies.name')
        ->leftJoin('offering_document', 'offerings.id_offerings', 'offering_document.id_offerings')
        ->join('users as created_by', 'created_by.id', 'offerings.add_by')
        ->join('users as request_to', 'request_to.id', 'offering_document.rnd_user_id')
        ->join('offering_color', 'offering_color.id', 'offerings.id_offering_color')
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
            'company_pics.name',
            'offering_document.rnd_user_id',
            'offering_document.flag_rnd',
            'offering_document.document_date',
            'offering_color.color_tag',
            'created_by.username',
            'request_to.username as request_to',
            'companies.address',
            'companies.id as com_id'
        )->whereRaw("offerings.offerings_flag = 'Y' and offerings.add_by = '$userId' or offering_document.rnd_user_id = '$userId'")
        ->groupBy('offerings.id_offerings');


        if ($request->ajax()) {
            return DataTables::of($dataDocument)
            ->editColumn('document_date', function ($dataDocument) {
                return date('Y-m-d', strtotime($dataDocument->document_date));
           })
                ->addColumn('action', function ($dataDocument) {
                    return '
                    <div class="flex flex-row">

                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDocument->id.'" data-offerings="'.$dataDocument->id_offerings.'" 
                            data-company="'.$dataDocument->company_id.'" data-pic="'.$dataDocument->name.'" data-tag="'.$dataDocument->color_tag.'"
                            data-start="'.$dataDocument->start_time.'" data-end="'.$dataDocument->end_time.'" data-notes="'.$dataDocument->notes.'"
                            data-result="'.$dataDocument->notulens.'" data-by="'.$dataDocument->username.'" data-add_by="'.$dataDocument->add_by.'"
                            data-address="'.$dataDocument->address.'"
                        >Update</button>
                        
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
                                        <div class="font-semibold text-slate-800">Request Document Detail</div>
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
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function getDetail($offeringId)
    {
        $dataDocumentQuery = DB::table('offerings')
        ->leftJoin('offering_products', 'offerings.id', 'offering_products.offering_id')
        ->join('products', 'offering_products.product_id', 'products.id')
        ->select(
        'offerings.id',
        'offerings.id_offerings',
        'offering_products.id as product', 'offering_products.product_id', 'offering_products.qty', 'offering_products.status', 'offering_products.price', 'offering_products.moqty', 'offering_products.notes',
        'offering_products.rnd_user_id', 'offering_products.rnd_flag', 'offering_products.document_date', 'offering_products.document_sent_by', 'offering_products.sample_user_id', 'offering_products.flag_sample', 
        'offering_products.sample_delivery_date','offering_products.sample_delivery_reff', 'offering_products.m_currency', 'offering_products.img_1', 'offering_products.img_2','products.name as product_name',
        'offering_products.show_product', 'offering_products.sample_qty',
        'offering_products.notes_document', 'offering_products.notes_sample',
        DB::raw("ISNULL(offering_products.img_1) as photo1"),
        DB::raw("ISNULL(offering_products.img_2) as photo2"))
        ->whereRaw("offering_products.show_product = 'Y' and offerings.id_offerings = '$offeringId' and offerings.offerings_flag = 'Y'");
            
        $dataDocument = $dataDocumentQuery->get()->toArray();
        return $dataDocument;
    }

    public function upload(Request $request, $offeringId, $productId)
    {
        $offeringId = $request->input('offer');
        $productId = $request->input('product');

         // doc1photo1
         if ($request->hasFile('file1')) {
            $file_doc1 = $request->file('file1');    
            $file1 = $file_doc1->openFile()->fread($file_doc1->getSize());
         } else {
            $file1 = null;
         }

         // doc2
         if ($request->hasFile('file2')) {
            $file_doc2 = $request->file('file2');    
            $file2 = $file_doc2->openFile()->fread($file_doc2->getSize());
         } else {
            $file2 = null;
         }
         // photo1
         if ($request->hasFile('photo1')) {
            $file_photo1 = $request->file('photo1');    
            $photo1 = $file_photo1->openFile()->fread($file_photo1->getSize());
         } else {
            $photo1 = null;
         }
 
         if ($request->hasFile('photo1')) {
             $fileName1 = $request->file('photo1')->storeAs('offeringImg', $offeringId . $productId . '-1.jpg');
             $request->file('photo1')->move($this->saveImageUrl . 'offeringImg/', $fileName1);
         } else {
             $fileName1 = null;
         }
         
         // photo2
         if ($request->hasFile('photo2')) {
            $file_photo2 = $request->file('photo2');    
            $photo2 = $file_photo2->openFile()->fread($file_photo2->getSize());
         } else {
            $photo2 = null;
         }
 
         if ($request->hasFile('photo2')) {
             $fileName2 = $request->file('photo2')->storeAs('offeringImg', $offeringId . $productId . '-2.jpg');
             $request->file('photo2')->move($this->saveImageUrl . 'offeringImg/', $fileName2);
         } else {
             $fileName2 = null;
         }

         if (!empty($file1 && $photo1)){
            $uploadDocument = DB::table('offering_document')
            ->where('offering_document.product_id', $productId)->where('offering_document.id_offerings', $offeringId)
                ->update([
                    'flag_rnd' => 'Yes',
                    'document_date' => $request->input('date'),
                    'imgblob_1' => $photo1,
                    'img_1' => $fileName1,
                    'imgblob_2' => $photo2,
                    'img_2' => $fileName2,
                    'document_1' => $file1,
                    'document_2' => $file2,
                ]);

            $updateOfferings = DB::table('offering_products')
            ->whereRaw("offering_products.show_product = 'Y' and offering_products.id_offerings = '$offeringId' and offering_products.product_id = '$productId'")
                ->update([
                    'rnd_flag' => 'Yes',
                    'document_date' => $request->input('date'),
                    'document_sent_by' => Auth::user()->id,
                    'img_1' => $fileName1,
                    'img_2' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                alert()->success('Success', 'Document Has Been Uploaded');
                return to_route('document.request');
            }else {   
                alert()->error('Error', 'Document or Image one field must fill');
                return to_route('document.request');
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
}
