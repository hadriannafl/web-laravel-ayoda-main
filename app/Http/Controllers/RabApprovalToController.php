<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\Return_;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RabApprovalToController extends Controller
{
    public function rabapproval1to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval1to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval1toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval1to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval1toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval1to.m-approval1to-delete', compact('dataChildCompany'));
    }

    public function rabapproval1toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval1to.edit', compact('dataChildCompany'));
    }

    public function rabapproval1toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval_rab')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'RAB Approval 1 To Has Been Created');
            return to_route('rabapproval1to');
        } else {
            alert()->error('Error', 'RAB Approval 1 To Already Exist');
            return to_route('rabapproval1to');
        }
    }

    public function rabapproval1toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval_rab')->where('m_approval_rab.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'RAB Approval 1 To Has Been Updated');
            return to_route('rabapproval1to.editpage');
        } else {
            alert()->error('Error', 'RAB Approval 1 To Already Exist');
            return to_route('rabapproval1to.editpage');
        }
    }

    public function rabapproval1toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval_rab')
        ->leftJoin('users', 'm_approval_rab.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval_rab.id_company', 'm_child_company.id_company')
        ->select('m_approval_rab.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');
        // DB::raw('CASE WHEN users.company_id = 0 THEN (SELECT name FROM m_child_company WHERE id_company = 1) ELSE m_child_company.name END as companyName')

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit RAB Approval 1 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function rabapproval1toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval_rab')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function rabapproval2to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval2to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval2toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval2to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval2toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval2to.m-approval2to-delete', compact('dataChildCompany'));
    }

    public function rabapproval2toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval2to.edit', compact('dataChildCompany'));
    }

    public function rabapproval2toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval2_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval2_rab')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'RAB Approval 2 To Has Been Created');
            return to_route('rabapproval2to');
        } else {
            alert()->error('Error', 'RAB Approval 2 To Already Exist');
            return to_route('rabapproval2to');
        }
    }

    public function rabapproval2toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval2_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval2_rab')->where('m_approval2_rab.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'RAB Approval 2 To Has Been Updated');
            return to_route('rabapproval2to.editpage');
        } else {
            alert()->error('Error', 'RAB Approval 2 To Already Exist');
            return to_route('rabapproval2to.editpage');
        }
    }

    public function rabapproval2toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval2_rab')
        ->leftJoin('users', 'm_approval2_rab.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval2_rab.id_company', 'm_child_company.id_company')
        ->select('m_approval2_rab.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit RAB Approval 2 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function rabapproval2toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval2_rab')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function rabapproval3to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval3to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval3toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-rabapproval3to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function rabapproval3toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval3to.m-approval3to-delete', compact('dataChildCompany'));
    }

    public function rabapproval3toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-rabapproval3to.edit', compact('dataChildCompany'));
    }

    public function rabapproval3toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval3_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval3_rab')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'RAB Approval 3 To Has Been Created');
            return to_route('rabapproval3to');
        } else {
            alert()->error('Error', 'RAB Approval 3 To Already Exist');
            return to_route('rabapproval3to');
        }
    }

    public function rabapproval3toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval3_rab')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval3_rab')->where('m_approval3_rab.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'RAB Approval 3 To Has Been Updated');
            return to_route('rabapproval3to.editpage');
        } else {
            alert()->error('Error', 'RAB Approval 3 To Already Exist');
            return to_route('rabapproval3to.editpage');
        }
    }

    public function rabapproval3toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval3_rab')
        ->leftJoin('users', 'm_approval3_rab.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval3_rab.id_company', 'm_child_company.id_company')
        ->select('m_approval3_rab.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit RAB Approval 3 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function rabapproval3toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval3_rab')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function prapproval1to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval1to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval1toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval1to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval1toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval1to.m-approval1to-delete', compact('dataChildCompany'));
    }

    public function prapproval1toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval1to.edit', compact('dataChildCompany'));
    }

    public function prapproval1toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval_pr')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'PR Approval 1 To Has Been Created');
            return to_route('prapproval1to');
        } else {
            alert()->error('Error', 'PR Approval 1 To Already Exist');
            return to_route('prapproval1to');
        }
    }

    public function prapproval1toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval_pr')->where('m_approval_pr.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'PR Approval 1 To Has Been Updated');
            return to_route('prapproval1to.editpage');
        } else {
            alert()->error('Error', 'PR Approval 1 To Already Exist');
            return to_route('prapproval1to.editpage');
        }
    }

    public function prapproval1toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval_pr')
        ->leftJoin('users', 'm_approval_pr.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval_pr.id_company', 'm_child_company.id_company')
        ->select('m_approval_pr.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');
        // DB::raw('CASE WHEN users.company_id = 0 THEN (SELECT name FROM m_child_company WHERE id_company = 1) ELSE m_child_company.name END as companyName')

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit PR Approval 1 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function prapproval1toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval_pr')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function prapproval2to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval2to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval2toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval2to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval2toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval2to.m-approval2to-delete', compact('dataChildCompany'));
    }

    public function prapproval2toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval2to.edit', compact('dataChildCompany'));
    }

    public function prapproval2toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval2_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval2_pr')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'PR Approval 2 To Has Been Created');
            return to_route('prapproval2to');
        } else {
            alert()->error('Error', 'PR Approval 2 To Already Exist');
            return to_route('prapproval2to');
        }
    }

    public function prapproval2toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval2_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval2_pr')->where('m_approval2_pr.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'PR Approval 2 To Has Been Updated');
            return to_route('prapproval2to.editpage');
        } else {
            alert()->error('Error', 'PR Approval 2 To Already Exist');
            return to_route('prapproval2to.editpage');
        }
    }

    public function prapproval2toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval2_pr')
        ->leftJoin('users', 'm_approval2_pr.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval2_pr.id_company', 'm_child_company.id_company')
        ->select('m_approval2_pr.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit PR Approval 2 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function prapproval2toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval2_pr')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function prapproval3to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval3to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval3toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-prapproval3to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function prapproval3toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval3to.m-approval3to-delete', compact('dataChildCompany'));
    }

    public function prapproval3toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-prapproval3to.edit', compact('dataChildCompany'));
    }

    public function prapproval3toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval3_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval3_pr')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'PR Approval 3 To Has Been Created');
            return to_route('prapproval3to');
        } else {
            alert()->error('Error', 'PR Approval 3 To Already Exist');
            return to_route('prapproval3to');
        }
    }

    public function prapproval3toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval3_pr')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval3_pr')->where('m_approval3_pr.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'PR Approval 3 To Has Been Updated');
            return to_route('prapproval3to.editpage');
        } else {
            alert()->error('Error', 'PR Approval 3 To Already Exist');
            return to_route('prapproval3to.editpage');
        }
    }

    public function prapproval3toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval3_pr')
        ->leftJoin('users', 'm_approval3_pr.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval3_pr.id_company', 'm_child_company.id_company')
        ->select('m_approval3_pr.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit PR Approval 3 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function prapproval3toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval3_pr')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function reimburseapprovalto()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-reimburseapprovalto.index', compact('dataChildCompany', 'dataUser'));
    }

    public function reimburseapprovaltoonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-reimburseapprovalto.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function reimburseapprovaltoDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-reimburseapprovalto.m-reimburse-delete', compact('dataChildCompany'));
    }

    public function reimburseapprovaltoEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-reimburseapprovalto.edit', compact('dataChildCompany'));
    }

    public function reimburseapprovaltoCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_reimburse')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval_reimburse')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'Reimburse Approval To Has Been Created');
            return to_route('reimburseapprovalto');
        } else {
            alert()->error('Error', 'Reimburse Approval To Already Exist');
            return to_route('reimburseapprovalto');
        }
    }

    public function reimburseapprovaltoUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_reimburse')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval_reimburse')->where('m_approval_reimburse.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'Reimburse Approval To Has Been Updated');
            return to_route('reimburseapprovalto.editpage');
        } else {
            alert()->error('Error', 'Reimburse Approval To Already Exist');
            return to_route('reimburseapprovalto.editpage');
        }
    }

    public function reimburseapprovaltoGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval_reimburse')
        ->leftJoin('users', 'm_approval_reimburse.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval_reimburse.id_company', 'm_child_company.id_company')
        ->select('m_approval_reimburse.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit Reimburse Approval 1 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function reimburseapprovaltoDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval_reimburse')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function reimburseapproval2to()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-reimburseapproval2to.index', compact('dataChildCompany', 'dataUser'));
    }

    public function reimburseapproval2toonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-reimburseapproval2to.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function reimburseapproval2toDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-reimburseapproval2to.m-reimburse-delete', compact('dataChildCompany'));
    }

    public function reimburseapproval2toEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-reimburseapproval2to.edit', compact('dataChildCompany'));
    }

    public function reimburseapproval2toCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_reimburse2')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval_reimburse2')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'Reimburse Approval 2 To Has Been Created');
            return to_route('reimburseapproval2to');
        } else {
            alert()->error('Error', 'Reimburse Approval 2 To Already Exist');
            return to_route('reimburseapproval2to');
        }
    }

    public function reimburseapproval2toUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_reimburse2')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval_reimburse2')->where('m_approval_reimburse2.idrec', $id)->update([
                    'id_company' => $request->input('company'),
                ]);
            });
            alert()->success('Success', 'Reimburse Approval 2 To Has Been Updated');
            return to_route('reimburseapproval2to.editpage');
        } else {
            alert()->error('Error', 'Reimburse Approval 2 To Already Exist');
            return to_route('reimburseapproval2to.editpage');
        }
    }

    public function reimburseapproval2toGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval_reimburse2')
        ->leftJoin('users', 'm_approval_reimburse2.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval_reimburse2.id_company', 'm_child_company.id_company')
        ->select('m_approval_reimburse2.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('users.company_id', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company="'.$dataApprovalTo->id_company.'"
                                
                            >Edit</button>
    
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
                                    @keydown.escape.window="modalOpen = false">
                                    <!-- Modal header -->
                                    <div class="px-5 py-3 border-b border-slate-200">
                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-slate-800 text-sm">Edit Reimburse Approval 2 To</div>
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
            })
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function reimburseapproval2toDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval_reimburse2')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval 2 to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
