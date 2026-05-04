<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use finfo;

class IncidentReportController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }

    public function form()
    {
        return view('pages.incident-report.form');
    }

    public function create(Request $request)
    {
        $yearNow = date('Y');
        $maxId = DB::table('incident_reports')
            ->max('id_report');

        $yearNowSubstring = substr($yearNow, -2);
        $maxIdSubstring = substr($maxId, 0, 2);
        
        if (is_null($maxId)) {
            $IRID = $yearNowSubstring . 'AYD-IR1';
        } else {
            if ($maxIdSubstring == $yearNowSubstring) {
                $runningNumber = substr($maxId, 8);
                $newRunningNumber = $runningNumber + 1;
                $IRID = $yearNowSubstring . 'AYD-IR' . $newRunningNumber;
            } else {
                $IRID = $yearNowSubstring . 'AYD-IR1';
            }
        }

        if ($request->hasFile('file1')) {
            $filePdf = $request->file('file1');    
            $pdf1 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf1 = null;
        }

        if ($request->hasFile('file2')) {
            $filePdf = $request->file('file2');    
            $pdf2 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf2 = null;
        }

        if ($request->hasFile('file3')) {
            $filePdf = $request->file('file3');    
            $pdf3 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf3 = null;
        }

        if ($request->hasFile('img1')) {
            $filePdf = $request->file('img1');    
            $img1 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img1 = null;
        }

        if ($request->hasFile('img2')) {
            $filePdf = $request->file('img2');    
            $img2 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img2 = null;
        }

        if ($request->hasFile('img3')) {
            $filePdf = $request->file('img3');    
            $img3 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img3 = null;
        }

        if ($request->hasFile('img1')) {
            $fileName1 = $request->file('img1')->storeAs('incidentImg', $IRID . '-1.jpg');
            $request->file('img1')->move($this->saveImageUrl . 'incidentImg/', $fileName1);
        } else {
            $fileName1 = null;
        }

        if ($request->hasFile('img2')) {
            $fileName2 = $request->file('img2')->storeAs('incidentImg', $IRID . '-2.jpg');
            $request->file('img2')->move($this->saveImageUrl . 'incidentImg/', $fileName2);
        } else {
            $fileName2 = null;
        }

        if ($request->hasFile('img3')) {
            $fileName3 = $request->file('img3')->storeAs('incidentImg', $IRID . '-3.jpg');
            $request->file('img3')->move($this->saveImageUrl . 'incidentImg/', $fileName3);
        } else {
            $fileName3 = null;
        }

        $incident = DB::table('incident_reports')->insert([
            'id_report' => $IRID,
            'subject' => $request->input('subject'),
            'category' => $request->input('category'),
            'dept' => $request->input('dept'),
            'location' => $request->input('location'),
            'division_involve' => $request->input('division_involve'),
            'person_involve' => $request->input('person_involve'),
            'cronology' => $request->input('cronology'),
            'status' => $request->input('status'),
            'add_by' => Auth::user()->username,
            'date_time' => $request->input('date'),
            'report_flag' => 'Y',
            'file_1' => $pdf1,
            'file_2' => $pdf2,
            'file_3' => $pdf3,
            'img_1' => $fileName1,
            'img_2' => $fileName2,
            'img_3' => $fileName3,
            'imgblob_1' => $img1,
            'imgblob_2' => $img2,
            'imgblob_3' => $img3
        ]);
        if ($request) {
            alert()->success('Success', 'Incident Report Has Been Sent');
            return to_route('incident.report');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('incident.report');
        }
        
    }

    public function index()
    {
        return view('pages.incident-report.list.index');
    }

    public function getData(Request $request)
    {
        $dataReport = DB::table('incident_reports')
        ->leftJoin('incident_report_follow_up', 'incident_reports.id_report', 'incident_report_follow_up.id_report')
        ->select('incident_reports.id', 'incident_reports.id_report', 'incident_reports.category', 'incident_reports.dept', 'incident_reports.location', 'incident_reports.division_involve',
                 'incident_reports.person_involve', 'incident_reports.cronology', 'incident_reports.status', 'incident_reports.add_by', 'incident_reports.date_time', 'incident_reports.img_1',
                 'incident_reports.img_2', 'incident_reports.img_3', 'incident_reports.report_flag', 'incident_reports.subject',
                  DB::raw("ISNULL(incident_reports.file_1) as file1"), DB::raw("ISNULL(incident_reports.file_2) as file2"), DB::raw("ISNULL(incident_reports.file_3) as file3"),
                  DB::raw("ISNULL(incident_reports.imgblob_1) as img1"), DB::raw("ISNULL(incident_reports.imgblob_2) as img2"), DB::raw("ISNULL(incident_reports.imgblob_3) as img3"),
                  DB::raw("ISNULL(incident_report_follow_up.file) as file"), DB::raw("ISNULL(incident_report_follow_up.image) as img"))
        ->orderBy('incident_reports.id_report', 'desc');

        if ($request->input('status') != null){
            $dataReport = $dataReport->where('incident_reports.status', $request->status);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataReport)
            ->editColumn('date_time', function ($dataReport) {
                return date('Y-m-d', strtotime($dataReport->date_time));
            })
            ->addColumn('label', function ($dataReport) {

                $status = ($dataReport->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Open') {
                    $color = "green";
                } else if ($status == 'Close') {
                    $color = "grey";
                }

                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataReport) {
                if ($dataReport->report_flag == 'Y') {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
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

                        <a href = "/incident-report/list/updatepagelist/' . $dataReport->id . '" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white ml-3"
                        >Change Report</a>

                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                            >Follow Up</button>
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
                                                <div class="font-semibold text-slate-800">Follow Up Incident Report</div>
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
                } else if ($dataReport->report_flag == 'N') {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
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

                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
                            >Follow Up</button>
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
                                                <div class="font-semibold text-slate-800">Follow Up Incident Report</div>
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
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function report()
    {
        return view('pages.incident-report.single.report');
    }

    public function getReport(Request $request)
    {
        $user = Auth::user()->username;
        $dataReport = DB::table('incident_reports')
        ->leftJoin('incident_report_follow_up', 'incident_reports.id_report', 'incident_report_follow_up.id_report')
        ->select('incident_reports.id', 'incident_reports.id_report', 'incident_reports.category', 'incident_reports.dept', 'incident_reports.location', 'incident_reports.division_involve',
                 'incident_reports.person_involve', 'incident_reports.cronology', 'incident_reports.status', 'incident_reports.add_by', 'incident_reports.date_time', 'incident_reports.img_1',
                 'incident_reports.img_2', 'incident_reports.img_3', 'incident_reports.report_flag', 'incident_reports.subject',
                  DB::raw("ISNULL(incident_reports.file_1) as file1"), DB::raw("ISNULL(incident_reports.file_2) as file2"), DB::raw("ISNULL(incident_reports.file_3) as file3"),
                  DB::raw("ISNULL(incident_reports.imgblob_1) as img1"), DB::raw("ISNULL(incident_reports.imgblob_2) as img2"), DB::raw("ISNULL(incident_reports.imgblob_3) as img3"),
                  DB::raw("ISNULL(incident_report_follow_up.file) as file"), DB::raw("ISNULL(incident_report_follow_up.image) as img"))
        ->where('incident_reports.add_by', $user)->orderBy('incident_reports.id_report', 'desc');

        if ($request->input('status') != null){
            $dataReport = $dataReport->where('incident_reports.status', $request->status);
        }
        
        if ($request->ajax()) {
            return DataTables::of($dataReport)
            ->editColumn('date_time', function ($dataReport) {
                return date('Y-m-d', strtotime($dataReport->date_time));
            })       
            ->addColumn('label', function ($dataReport) {

                $status = ($dataReport->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Open') {
                    $color = "green";
                } else if ($status == 'Close') {
                    $color = "grey";
                }

                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataReport) {
                if ($dataReport->report_flag == 'Y') {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'" 
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
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

                        <a href = "/incident-report/list/updatepagelist/' . $dataReport->id . '" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white ml-3"
                        >Change Report</a>

                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
                            >Follow Up</button>
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
                                                <div class="font-semibold text-slate-800">Follow Up Incident Report</div>
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
                } else if ($dataReport->report_flag == 'N') {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
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

                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-edit text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_report="'.$dataReport->id_report.'" data-id="'.$dataReport->id.'" data-subject="'.$dataReport->subject.'"
                                data-category = "' . $dataReport->category . '" data-dept = "' . $dataReport->dept . '" data-location ="'.$dataReport->location.'" data-status = "' . $dataReport->status . '"
                                data-division_involve = "' . $dataReport->division_involve . '" data-person_involve = "' . $dataReport->person_involve . '" data-cronology = "' . $dataReport->cronology . '" 
                                data-add_by = "' . $dataReport->add_by . '" data-date_time="'.$dataReport->date_time.'" data-file1="'.$dataReport->file1.'" data-file2="'.$dataReport->file2.'" data-file3="'.$dataReport->file3.'"
                                data-img1="'.$dataReport->img1.'" data-img2="'.$dataReport->img2.'" data-img3="'.$dataReport->img3.'" data-img_1="'.$dataReport->img_1.'" data-img_2="'.$dataReport->img_2.'" data-img_3="'.$dataReport->img_3.'"
                                data-file="'.$dataReport->file.'" data-img="'.$dataReport->img.'"
                            >Follow Up</button>
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
                                                <div class="font-semibold text-slate-800">Follow Up Incident Report</div>
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
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function updatePageList($reportId)
    {
        $dataReport = DB::table('incident_reports')
        ->select('incident_reports.id', 'incident_reports.id_report', 'incident_reports.category', 'incident_reports.dept', 'incident_reports.location', 'incident_reports.division_involve',
                 'incident_reports.person_involve', 'incident_reports.cronology', 'incident_reports.status', 'incident_reports.add_by', 'incident_reports.date_time', 'incident_reports.img_1',
                 'incident_reports.img_2', 'incident_reports.img_3', 'incident_reports.subject',
                  DB::raw("ISNULL(incident_reports.file_1) as file1"), DB::raw("ISNULL(incident_reports.file_2) as file2"), DB::raw("ISNULL(incident_reports.file_3) as file3"),
                  DB::raw("ISNULL(incident_reports.imgblob_1) as img1"), DB::raw("ISNULL(incident_reports.imgblob_2) as img2"), DB::raw("ISNULL(incident_reports.imgblob_3) as img3"))
        ->where('incident_reports.id', $reportId)->first();

        return view('pages.incident-report.list.update', compact('dataReport'));
    }

    public function updatePageSingle($reportId)
    {
        $dataReport = DB::table('incident_reports')
        ->select('incident_reports.id', 'incident_reports.id_report', 'incident_reports.category', 'incident_reports.dept', 'incident_reports.location', 'incident_reports.division_involve',
                 'incident_reports.person_involve', 'incident_reports.cronology', 'incident_reports.status', 'incident_reports.add_by', 'incident_reports.date_time', 'incident_reports.img_1',
                 'incident_reports.img_2', 'incident_reports.img_3', 'incident_reports.subject',
                  DB::raw("ISNULL(incident_reports.file_1) as file1"), DB::raw("ISNULL(incident_reports.file_2) as file2"), DB::raw("ISNULL(incident_reports.file_3) as file3"),
                  DB::raw("ISNULL(incident_reports.imgblob_1) as img1"), DB::raw("ISNULL(incident_reports.imgblob_2) as img2"), DB::raw("ISNULL(incident_reports.imgblob_3) as img3"))
        ->where('incident_reports.id', $reportId)->first();

        return view('pages.incident-report.single.update', compact('dataReport'));
    }

    public function update(Request $request, $reportId)
    {
        $IRID = $request->input('id_report');

        if ($request->hasFile('file1')) {
            $filePdf = $request->file('file1');    
            $pdf1 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf1 = null;
        }

        if ($request->hasFile('file2')) {
            $filePdf = $request->file('file2');    
            $pdf2 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf2 = null;
        }

        if ($request->hasFile('file3')) {
            $filePdf = $request->file('file3');    
            $pdf3 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf3 = null;
        }

        if ($request->hasFile('img1')) {
            $filePdf = $request->file('img1');    
            $img1 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img1 = null;
        }

        if ($request->hasFile('img2')) {
            $filePdf = $request->file('img2');    
            $img2 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img2 = null;
        }

        if ($request->hasFile('img3')) {
            $filePdf = $request->file('img3');    
            $img3 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img3 = null;
        }

        if ($request->hasFile('img1')) {
            $fileName1 = $request->file('img1')->storeAs('incidentImg', $reportId . '-' . $IRID . '-1.jpg');
            $request->file('img1')->move($this->saveImageUrl . 'incidentImg/', $fileName1);
        } else {
            $fileName1 = null;
        }

        if ($request->hasFile('img2')) {
            $fileName2 = $request->file('img2')->storeAs('incidentImg', $reportId . '-' . $IRID . '-2.jpg');
            $request->file('img2')->move($this->saveImageUrl . 'incidentImg/', $fileName2);
        } else {
            $fileName2 = null;
        }

        if ($request->hasFile('img3')) {
            $fileName3 = $request->file('img3')->storeAs('incidentImg', $reportId . '-' . $IRID . '-3.jpg');
            $request->file('img3')->move($this->saveImageUrl . 'incidentImg/', $fileName3);
        } else {
            $fileName3 = null;
        }

        if ($request) {

            $reportFlag = DB::table('incident_reports')->where('incident_reports.id', $reportId)->update([
                'report_flag' => 'N'
            ]);

            $incident = DB::table('incident_reports')->insert([
                'id_report' => $IRID,
                'category' => $request->input('category'),
                'dept' => $request->input('dept'),
                'location' => $request->input('location'),
                'division_involve' => $request->input('division_involve'),
                'person_involve' => $request->input('person_involve'),
                'cronology' => $request->input('cronology'),
                'status' => $request->input('status'),
                'add_by' => Auth::user()->username,
                'date_time' => $request->input('date'),
                'report_flag' => 'Y',
                'file_1' => $pdf1,
                'file_2' => $pdf2,
                'file_3' => $pdf3,
                'img_1' => $fileName1,
                'img_2' => $fileName2,
                'img_3' => $fileName3,
                'imgblob_1' => $img1,
                'imgblob_2' => $img2,
                'imgblob_3' => $img3
            ]);
        
            alert()->success('Success', 'Incident Report Has Been Updated');
            return to_route('incident.report');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('incident.report');
        }
    }

    public function followUp(Request $request)
    {
        $userRole = Auth::user()->role;
        $reportId = $request->input('id_report1');

        if ($request->hasFile('filefollowup')) {
            $filePdf = $request->file('filefollowup');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $pdf = null;
        }

        if ($request->hasFile('imagefollowup')) {
            $filePdf = $request->file('imagefollowup');    
            $img = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $img = null;
        }

        if ($request) {

            DB::table('incident_reports')->where('incident_reports.id', $reportId)->update([
                'status' => $request->input('status')
            ]);

            DB::table('incident_report_follow_up')->insert([
                'id_report' => $reportId,
                'date' => $request->input('date1'),
                'username' => $request->input('username'),
                'follow_up' => $request->input('followup'),
                'file' => $pdf,
                'image' => $img,
            ]);
        
        if ($userRole == '303' || $userRole == '503' || $userRole == '603' || $userRole == '1003'){
            alert()->success('Success', 'Your Follow Up Has Been Sent');
            return to_route('incident.report');
        }
        if ($userRole == '100' || $userRole == '101' || $userRole == '102' || $userRole == '300' || $userRole == '301' || $userRole == '302'
        || $userRole == '500' || $userRole == '501' || $userRole == '502' || $userRole == '600' || $userRole == '601' || $userRole == '602'
        || $userRole == '1000' || $userRole == '1001' || $userRole == '1002'){
            alert()->success('Success', 'Your Follow Up Has Been Sent');
            return to_route('incident.index');
        }
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('incident.report');
        }
    }

    public function getDetail($reportId)
    {
        $dataReportQuery = DB::table('incident_reports')
        ->leftJoin('incident_report_follow_up', 'incident_reports.id', 'incident_report_follow_up.id_report')
        ->select('incident_reports.id', 'incident_reports.id_report', 'incident_report_follow_up.id as follow_upId', 'incident_report_follow_up.id_report as follow_report',
        'incident_report_follow_up.follow_up', 'incident_report_follow_up.date', 'incident_report_follow_up.follow_up', 'incident_report_follow_up.username', DB::raw("ISNULL(incident_report_follow_up.file) as files"), DB::raw("ISNULL(incident_report_follow_up.image) as images"))
        ->where('incident_reports.id', $reportId);
            
        $dataReport = $dataReportQuery->get()->toArray();
        return $dataReport;
    }

    public function file1($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('file_1', 'id_report')->first();
        $filename = $dataReport->id_report . '-1.pdf';
        $fileReport = $dataReport->file_1;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_1),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function file2($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('file_2', 'id_report')->first();
        $filename = $dataReport->id_report . '-2.pdf';
        $fileReport = $dataReport->file_2;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_2),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function file3($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('file_3', 'id_report')->first();
        $filename = $dataReport->id_report . '-3.pdf';
        $fileReport = $dataReport->file_3;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_3),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function fileFollowUp($followId)
    {
        $dataReport = DB::table('incident_report_follow_up')->where('id', $followId)->select('file', 'id')->first();
        $filename = $dataReport->id . '.jpg';
        $fileReport = $dataReport->file;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function img1($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('imgblob_1', 'id_report')->first();
        $filename = $dataReport->id_report . '-1.jpg';
        $fileReport = $dataReport->imgblob_1;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->imgblob_1),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function img2($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('imgblob_2', 'id_report')->first();
        $filename = $dataReport->id_report . '-2.jpg';
        $fileReport = $dataReport->imgblob_2;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->imgblob_2),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function img3($reportId)
    {
        $dataReport = DB::table('incident_reports')->where('id_report', $reportId)->select('imgblob_3', 'id_report')->first();
        $filename = $dataReport->id_report . '-3.jpg';
        $fileReport = $dataReport->imgblob_3;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->imgblob_3),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function imgFollowUp($followId)
    {
        $dataReport = DB::table('incident_report_follow_up')->where('id', $followId)->select('image', 'id')->first();
        $filename = $dataReport->id . '.jpg';
        $fileReport = $dataReport->image;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->image),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
}
