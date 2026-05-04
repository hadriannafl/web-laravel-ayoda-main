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

class ProductOfferingAllController extends Controller
{
    public function index(Request $request)
    {
        $colors = DB::table('colors')->get();

        $calendarTags = DB::table('offering_color')
            ->join('colors', 'colors.id', 'offering_color.id_color')
            ->select('offering_color.id', 'colors.value_color', 'offering_color.color_tag', 'colors.name_color', 'colors.id as color')
            ->get();

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->whereRaw("(users.sales_id) != 'null'")
            ->orderBy('users.username', 'asc')
            ->get();

        $filterUserId = $request->input('users_schedule');
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;

        $dataCalendarsQuery = DB::table('offerings')
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
            'company_pics.name'
            )
            ->groupBy('offerings.id');

            if ($filterUserId) {
                $dataCalendarsQuery->whereRaw("offerings.add_by = $filterUserId");
            } else {
                $dataCalendarsQuery->whereRaw("offerings.add_by = $userId");
            }

        $dataCalendars = $dataCalendarsQuery->get()->toArray();

        return view('pages.tasks.offering.productoffered-all.index', compact('calendarTags', 'colors', 'dataUsers', 'dataCalendars'));
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
            alert()->success('Success', 'Offering Tag Has Been Added');
            return to_route('productoffered-all');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('productoffered-all');
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
            ->where('offerings.id', $offeringId)
            ->first();

        return response()->json([
            'dataOfferings' => $offeringsData
        ]);
    }

    public function getDetail($offeringId)
    {
        $dataDetailOfferings = DB::table('offerings')
            ->leftJoin('offering_products', 'offerings.id', 'offering_products.offering_id')
            ->join('products', 'offering_products.product_id', 'products.id')
            ->select(
            'offerings.id',
            'offerings.id_offerings',
            'offering_products.product_id', 'offering_products.qty', 'offering_products.status', 'offering_products.price', 'offering_products.moqty', 'offering_products.notes',
            'offering_products.m_currency', 'products.name as product_name')
            ->where('offerings.id', $offeringId)
            ->get()->toArray();

        return $dataDetailOfferings;
    }

    public function getTag($tagId)
    {
        $calendarsTag = DB::table('offering_color')
            ->join('colors', 'colors.id', 'offering_color.id_color')
            ->select(
                'offering_color.id',
                'offering_color.id_color',
                'offering_color.color_tag',
                'offering_color.add_by',
                'colors.name_color'
            )
            ->where('offering_color.id', $tagId)
            ->first();

        return response()->json([
            'dataTag' => $calendarsTag
        ]);
    }

    public function deleteTag($tagId)
    {
        try {
            DB::table('offering_color')->where('offering_color.id', $tagId)->delete();
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted offering tag",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function detail(Request $request)
    {
        $filterUserId = $request->input('users_schedule');
        $startTime = $request->input('start_time');
        $userId = Auth::user()->id;

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

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
            'offering_color.color_tag',
            'created_by.username',
            'company_pics.name'
        )->whereDate('offerings.start_time', $startTime);

        if ($filterUserId) {
            $dataOfferingQuery->whereRaw("offerings.add_by = $filterUserId");
        } else {
            $dataOfferingQuery->whereRaw("offerings.add_by = $userId");
        }

        $dataOffering = $dataOfferingQuery->first();
    
        return view('pages.tasks.offering.productoffering.offeringdetail', compact('dataOffering', 'dataUsers'));
    }

    public function getData(Request $request)
    {
        $filterUserId = $request->input('users_schedule');
        $startTime = $request->input('start_time');
        $userId = Auth::user()->id;

        $dataUsers = DB::table('users')
            ->select('users.id', 'users.username')
            ->where('status', 1)
            ->orderBy('users.username', 'asc')
            ->get();

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
                'offering_color.color_tag',
                'company_pics.name',
                'created_by.username',
            );

            if ($filterUserId) {
                $dataOfferingQuery->whereRaw("offerings.add_by = $filterUserId");
            } else {
                $dataOfferingQuery->whereRaw("offerings.add_by = $userId");
            }

        $dataOffering = $dataOfferingQuery;

        if ($startTime != null) {
            $dataOffering->whereDate('offerings.start_time', $request->start_time);
        }

        if ($request->ajax()) {
            return DataTables::of($dataOffering)
            ->editColumn('start_time', function ($dataOffering) {
                return date('Y-m-d', strtotime($dataOffering->start_time));
            })
            ->editColumn('end_time', function ($dataOffering) {
                return date('Y-m-d', strtotime($dataOffering->end_time));
            })
                ->addColumn('action', function ($dataOffering) {
                    return '
                    <div class="flex flex-row">
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataOffering->id.'" 
                                data-company="'.$dataOffering->company_id.'" data-pic="'.$dataOffering->name.'" data-tag="'.$dataOffering->color_tag.'"
                                data-start="'.$dataOffering->start_time.'" data-end="'.$dataOffering->end_time.'" data-notes="'.$dataOffering->notes.'"
                                data-result="'.$dataOffering->notulens.'" data-by="'.$dataOffering->username.'"
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
                                            <div class="font-semibold text-slate-800">Offering Product Detail</div>
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

                        <a href = "/tasks/offering/productoffering/offeringupdatepage/' . $dataOffering->id . '" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white ml-3"
                        >Update Offering Product</a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }
}
