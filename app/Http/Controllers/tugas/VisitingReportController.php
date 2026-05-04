<?php

namespace App\Http\Controllers\tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use finfo;

class VisitingReportController extends Controller
{
    public function form()
    {
        return view('pages.tasks.visiting-report.visiting-single.form');
    }

    public function create(Request $request)
    {
        $yearNow = date('Y');
        $maxId = DB::table('visiting_report')
            ->max('id_report');

        $yearNowSubstring = substr($yearNow, -2);
        $maxIdSubstring = substr($maxId, 0, 2);
        
        if (is_null($maxId)) {
            $VRID = $yearNowSubstring . 'AYD-VR1';
        } else {
            if ($maxIdSubstring == $yearNowSubstring) {
                $runningNumber = substr($maxId, 8);
                $newRunningNumber = $runningNumber + 1;
                $VRID = $yearNowSubstring . 'AYD-VR' . $newRunningNumber;
            } else {
                $VRID = $yearNowSubstring . 'AYD-VR1';
            }
        }

        if ($request->hasFile('file')) {
            $filePdf = $request->file('file');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            $fileName = $request->file('file')->getClientOriginalName();
        } else {
               $pdf = null;
        }

        $company = $request->input('idCompany');

        if (!empty($company)) {
            DB::table('visiting_report')->insert([
                'id_report' => $VRID,
                'id_customer' => $request->input('idCompany'),
                'username' => $request->input('name'),
                'date_time' => $request->input('date'),
                'stage' => $request->input('stage'),
                'notulens' => $request->input('notulens'),
                'file' => $pdf,
                'file_name' => $fileName,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('visiting_report_follow_up')->insert([
                'id_report' => $VRID,
                'date_time' => $request->input('date'),
                'stage' => $request->input('stage'),
                'created_at' => date('Y-m-d H:i:s'),
                'notulens' => $request->input('notulens')
            ]);

            alert()->success('Success', 'Visiting Report Has Been Created');
            return to_route('visiting.index');
        } else {
            alert()->error('Error', 'Visiting Customer Not Fill');
            return to_route('visiting.index');
        }
    }

    public function indexAll()
    {
        $dataUsers = DB::table('users')
        ->select('users.id', 'users.username')
        ->whereRaw("(users.sales_id) != 'null'")
        ->orderBy('users.username', 'asc')
        ->get();
        return view('pages.tasks.visiting-report.visiting-all.index',compact('dataUsers'));
    }

    public function getList(Request $request)
    {
        $dataReport = DB::table('visiting_report')
        ->leftJoin('companies', 'visiting_report.id_customer', 'companies.id')
        ->select('visiting_report.id', 'visiting_report.id_report', 'visiting_report.username', 'visiting_report.stage', 'visiting_report.notulens', 'visiting_report.id_customer', 'visiting_report.date_time', 'visiting_report.file_name',  'companies.name', DB::raw("ISNULL(visiting_report.file) as file"))
        ->orderBy('visiting_report.id_report', 'desc');

        if ($request->input('status') != null){
            $dataReport = $dataReport->where('visiting_report.stage', $request->status);
        }
        if ($request->input('salesname') != null){
            $dataReport = $dataReport->where('visiting_report.username', $request->salesname);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataReport)
            ->editColumn('date_time', function ($dataReport) {
                return date('Y-m-d', strtotime($dataReport->date_time));
            })
            ->addColumn('action', function ($dataReport) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-username="'.$dataReport->username.'"
                                data-stage = "' . $dataReport->stage . '" data-notulens = "' . $dataReport->notulens . '" data-name ="'.$dataReport->name.'" data-file_name = "' . $dataReport->file_name . '"
                                data-file = "' . $dataReport->file . '" data-date_time = "' . $dataReport->date_time . '"
                            >View Report</button>
                            
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
                                            <div class="font-semibold text-slate-800">View Incident Report</div>
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

    public function index()
    {
        return view('pages.tasks.visiting-report.visiting-single.index');
    }

    public function getData(Request $request)
    {
        $user = Auth::user()->username;
        $dataReport = DB::table('visiting_report')
        ->leftJoin('companies', 'visiting_report.id_customer', 'companies.id')
        ->select('visiting_report.id', 'visiting_report.id_report', 'visiting_report.username', 'visiting_report.stage', 'visiting_report.notulens', 'visiting_report.id_customer', 'visiting_report.file_name',  'visiting_report.date_time', 'companies.name', DB::raw("ISNULL(visiting_report.file) as file"))
        ->where('visiting_report.username', $user)->orderBy('visiting_report.id_report', 'desc');

        if ($request->input('status') != null){
            $dataReport = $dataReport->where('visiting_report.stage', $request->status);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataReport)
            ->editColumn('date_time', function ($dataReport) {
                return date('Y-m-d', strtotime($dataReport->date_time));
            })    
            ->addColumn('action', function ($dataReport) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-username="'.$dataReport->username.'"
                                data-stage = "' . $dataReport->stage . '" data-notulens = "' . $dataReport->notulens . '" data-name ="'.$dataReport->name.'" data-file_name = "' . $dataReport->file_name . '"
                                data-file = "' . $dataReport->file . '" data-date_time = "' . $dataReport->date_time . '"
                            >View Report</button>
                            
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
                                            <div class="font-semibold text-slate-800">View Visiting Report</div>
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

                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-username="'.$dataReport->username.'"
                                data-stage = "' . $dataReport->stage . '" data-notulens = "' . $dataReport->notulens . '" data-name ="'.$dataReport->name.'" data-file_name = "' . $dataReport->file_name . '"
                                data-file = "' . $dataReport->file . '" data-date_time = "' . $dataReport->date_time . '"
                            >Next Follow Up</button>
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
                                                <div class="font-semibold text-slate-800">Next Follow Up Visiting Report</div>
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
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function followUp(Request $request)
    {
        $reportId = $request->input('id_report');

        if ($request) {

            DB::table('visiting_report')->where('visiting_report.id_report', $reportId)->update([
                'stage' => $request->input('status'),
                'notulens' => $request->input('followup')
            ]);

            DB::table('visiting_report_follow_up')->insert([
                'id_report' => $reportId,
                'date_time' => $request->input('date1'),
                'stage' => $request->input('status'),
                'created_at' => date('Y-m-d H:i:s'),
                'notulens' => $request->input('followup')
            ]);
        
            alert()->success('Success', 'Your Next Follow Up Has Been Sent');
            return to_route('visiting.index');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('visiting.index');
        }
    }

    public function getDetail($reportId)
    {
        $dataReportQuery = DB::table('visiting_report')
        ->leftJoin('visiting_report_follow_up', 'visiting_report.id_report', 'visiting_report_follow_up.id_report')
        ->select('visiting_report.id', 'visiting_report.id_report', 'visiting_report_follow_up.id as follow_upId', 'visiting_report_follow_up.id_report as follow_report',
        'visiting_report_follow_up.notulens', 'visiting_report_follow_up.date_time', 'visiting_report_follow_up.stage', 'visiting_report_follow_up.created_at')
        ->where('visiting_report.id_report', $reportId);
            
        $dataReport = $dataReportQuery->get()->toArray();
        return $dataReport;
    }

    public function viewFIle($reportId)
    {
        $dataReport = DB::table('visiting_report')->where('id_report', $reportId)->select('file', 'id_report')->first();
        $filename = $dataReport->id_report . '.pdf';
        $fileReport = $dataReport->file;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
}
