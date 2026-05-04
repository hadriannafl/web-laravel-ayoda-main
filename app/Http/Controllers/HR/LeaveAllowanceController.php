<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use finfo;
use Illuminate\Support\Facades\Response;

class LeaveAllowanceController extends Controller
{
    public function index()
    {
        return view('pages.hr.leaveallow.index');
    }

    public function getData(Request $request)
    {
        $employeeId = Auth::user()->employee_id;
        $dataLeave = DB::table('employee_leaves')
        ->leftJoin('m_employees', 'employee_leaves.employee_id', 'm_employees.idemployee')
        ->select(
            'employee_leaves.id',
            'employee_leaves.created_at',
            'employee_leaves.employee_id',
            'employee_leaves.category',
            'employee_leaves.periode_from',
            'employee_leaves.periode_to',
            'employee_leaves.description',
            'employee_leaves.status',
            'employee_leaves.leave_days',
            'employee_leaves.approval1_name',
            'employee_leaves.approval1_status',
            'employee_leaves.approval2_name',
            'employee_leaves.approval2_status',
            'employee_leaves.approval1_notes',
            'employee_leaves.approval2_notes',
            'm_employees.first_name as employee',
            DB::raw("ISNULL(employee_leaves.image) as image")
        )->where('employee_leaves.employee_id', $employeeId)
        ->orderBy('employee_leaves.id', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataLeave)
            ->editColumn('created_at', function ($dataLeave) {
                return date('Y-m-d', strtotime($dataLeave->created_at));
            })
            ->addColumn('action', function ($dataLeave) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataLeave->id.'"
                            data-date = "' . $dataLeave->created_at . '" data-from = "' . $dataLeave->periode_from . '" data-to ="'.$dataLeave->periode_to.'" data-stat = "' . $dataLeave->status . '"
                            data-desc = "' . $dataLeave->description . '" data-approve1_stat = "' . $dataLeave->approval1_status . '" data-approve1_name = "' . $dataLeave->approval1_name . '" 
                            data-approve2_stat = "' . $dataLeave->approval2_status . '" data-approve2_name = "' . $dataLeave->approval2_name . '" data-image="'.$dataLeave->image.'" data-employee="'.$dataLeave->employee.'"
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
            ->rawColumns(['action'])
            ->make();
        }
    }
    
    public function getDetail($leaveId)
    {
        $dataDetailLeave = DB::table('employee_leaves')
        ->leftJoin('m_employees', 'employee_leaves.employee_id', 'm_employees.idemployee')
        ->select(
            'employee_leaves.id',
            'employee_leaves.created_at',
            'employee_leaves.employee_id',
            'employee_leaves.category',
            'employee_leaves.periode_from',
            'employee_leaves.periode_to',
            'employee_leaves.description',
            'employee_leaves.status',
            'employee_leaves.leave_days',
            'employee_leaves.approval1_name',
            'employee_leaves.approval1_status',
            'employee_leaves.approval2_name',
            'employee_leaves.approval2_status',
            'employee_leaves.approval1_notes',
            'employee_leaves.approval2_notes',
            'm_employees.first_name as employee',
            DB::raw("ISNULL(employee_leaves.image) as image")
            )->where('employee_leaves.id', $leaveId)
            ->get()->toArray();

        return $dataDetailLeave;
    }

    public function viewDocument($leaveId)
    {
        $data = DB::table('employee_leaves')->where('id', $leaveId)->select('image', 'id')->first();

        return Response::make($data->image, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->image)
        ]);
    }
}
