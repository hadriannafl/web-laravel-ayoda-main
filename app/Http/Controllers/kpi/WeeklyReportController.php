<?php

namespace App\Http\Controllers\kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use finfo;
use PhpParser\Builder\FunctionLike;

class WeeklyReportController extends Controller
{
    public function index()
    {
        $salesId = Auth::user()->sales_id;
        $dataUsers = DB::table('users')
        ->select('users.id', 'users.username')
        ->whereRaw("(users.sales_id) != 'null'")
        ->orderBy('users.username', 'asc')
        ->get();
        return view('pages.kpi.weekly-report.index', compact('dataUsers'));
    }

    public function index1()
    {
        $salesId = Auth::user()->sales_id;
        $dataUsers = DB::table('users')
        ->select('users.id', 'users.username')
        ->whereRaw("(users.sales_id) != 'null'")
        ->orderBy('users.username', 'asc')
        ->get();
        return view('pages.kpi.report-list.index', compact('dataUsers'));
    }

    public function getData(Request $request)
    {
        $user = Auth::user()->username;
        $year = $request->input('year');
        $dataReport = DB::table('sales_weekly_report')
        ->select('sales_weekly_report.id', 'sales_weekly_report.id_report', 'sales_weekly_report.date', 'sales_weekly_report.notes', 'sales_weekly_report.add_by', 'sales_weekly_report.file_1', 'sales_weekly_report.file_2', 'sales_weekly_report.file_3',
        'sales_weekly_report.updated_at',
        DB::raw("ISNULL(sales_weekly_report.file_1) as file1"),
        DB::raw("ISNULL(sales_weekly_report.file_2) as file2"),
        DB::raw("ISNULL(sales_weekly_report.file_3) as file3")
        )
        ->where('sales_weekly_report.add_by', $user)->orderBy('date', 'desc');

        if ($year != null) {
            $dataReport = $dataReport->whereRaw("DATE_FORMAT(sales_weekly_report.date, '%Y') = '$year'");
        }

        if ($request->ajax()) {
            $counter = 1;
            return DataTables::of($dataReport)
                ->editColumn('date', function ($dataReport) {
                    return date('Y-m-d', strtotime($dataReport->date));
                })
                ->editColumn('updated_at', function ($dataReport) {
                    return date('Y-m-d', strtotime($dataReport->updated_at));
                })

                ->addColumn('action', function ($dataReport) use (&$counter){                
                    if ($counter <= 3) {
                        $counter++;
                        return '
                        <div class="flex flex-row">
                                <div x-data="{ modalOpen: false }">
                                    <button class="btn btn-edit bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                                        aria-controls="feedback-modal" data-id="' . $dataReport->id . '" data-id_report="' . $dataReport->id_report . '"
                                        data-date="' . $dataReport->date . '" data-notes="' . $dataReport->notes . '" data-add_by="' . $dataReport->add_by . '"
                                        >Update</button>
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
                                                    <div class="font-semibold text-slate-800">Update Weekly Report</div>
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

                            <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-3" 
                                data-id="'.$dataReport->id.'" data-id_report="'.$dataReport->id_report.'"
                                >Delete Report
                            </button>
                    </div>';
                    } else {
                        return '
                        <div class="flex flex-row">
                                <div x-data="{ modalOpen: false }">
                                    <button class="btn btn-edit bg-indigo-500 hover:bg-indigo-600 text-white" @click.prevent="modalOpen = true"
                                        aria-controls="feedback-modal" data-id="' . $dataReport->id . '" data-id_report="' . $dataReport->id_report . '"
                                        data-date="' . $dataReport->date . '" data-notes="' . $dataReport->notes . '" data-add_by="' . $dataReport->add_by . '"
                                        >Update</button>
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
                                                    <div class="font-semibold text-slate-800">Update Weekly Report</div>
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

                ->addColumn('action1', function ($dataReport) {
                    if ($dataReport->file1 != 1) {
                        return '
                        <a href = "' . '/kpi/weekly-report/viewfile1/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Attachment</a>';
                    }else {
                        return '';
                    }
                })

                ->addColumn('action2', function ($dataReport) {
                    if ($dataReport->file2 != 1) {
                            return '<a href = "' . '/kpi/weekly-report/viewfile2/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                            >View Attachment</a>';
                    }else {
                        return '';
                    }
                })

                ->addColumn('action3', function ($dataReport) {
                    if ($dataReport->file3 != 1) {
                        return '<a href = "' . '/kpi/weekly-report/viewfile3/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Attachment</a>';
                    }else {
                        return '';
                    }
                })
                ->rawColumns(['action', 'action1', 'action2', 'action3'])
                ->make();
            }
    }

    public function getData1(Request $request)
    {
        $year = $request->input('year');
        $salesname = $request->input('salesname');
        $dataReport = DB::table('sales_weekly_report')
        ->select('sales_weekly_report.id', 'sales_weekly_report.id_report', 'sales_weekly_report.date', 'sales_weekly_report.notes', 'sales_weekly_report.add_by', 'sales_weekly_report.file_1', 'sales_weekly_report.file_2', 'sales_weekly_report.file_3',
        'sales_weekly_report.updated_at',
        DB::raw("ISNULL(sales_weekly_report.file_1) as file1"),
        DB::raw("ISNULL(sales_weekly_report.file_2) as file2"),
        DB::raw("ISNULL(sales_weekly_report.file_3) as file3")
        )->orderBy('date', 'desc');

        if ($year != null) {
            $dataReport = $dataReport->whereRaw("DATE_FORMAT(sales_weekly_report.date, '%Y') = '$year'");
        }
        if ($salesname != null) {
            $dataReport = $dataReport->where('sales_weekly_report.add_by', $request->salesname);
        }

        if ($request->ajax()) {
            return DataTables::of($dataReport)
                ->editColumn('date', function ($dataReport) {
                    return date('Y-m-d', strtotime($dataReport->date));
                })
                ->editColumn('updated_at', function ($dataReport) {
                    return date('Y-m-d', strtotime($dataReport->updated_at));
                })

                ->addColumn('action1', function ($dataReport) {
                    if ($dataReport->file1 != 1) {
                        return '<a href = "' . '/kpi/weekly-report/viewfile1/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Attachment</a>';
                    }else {
                        return '';
                    }
                })

                ->addColumn('action2', function ($dataReport) {
                    if ($dataReport->file2 != 1) {
                            return '<a href = "' . '/kpi/weekly-report/viewfile2/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                            >View Attachment</a>';
                    }else {
                        return '';
                    }
                })

                ->addColumn('action3', function ($dataReport) {
                    if ($dataReport->file3 != 1) {
                        return '<a href = "' . '/kpi/weekly-report/viewfile3/'. $dataReport->id_report .'/'. $dataReport->notes .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Attachment</a>';
                    }else {
                        return '';
                    }
                })
                ->rawColumns(['action1', 'action2', 'action3'])
                ->make();
            }
    }

    public function create(Request $request)
    {   
        $yearNow = date('Y');
        $monthNow = date('n');
        $username = Auth::user()->username;
        $maxId = DB::table('sales_weekly_report')
            ->max('id_report');

        $yearNowSubstring = substr($yearNow, -2);
        $maxIdSubstring = substr($maxId, 0, 2);
        
        if (is_null($maxId)) {
            $reportId = $yearNowSubstring . 'AYD-WR1';
        } else {
            if ($maxIdSubstring == $yearNowSubstring) {
                $runningNumber = substr($maxId, 8);
                $newRunningNumber = $runningNumber + 1;
                $reportId = $yearNowSubstring . 'AYD-WR' . $newRunningNumber;
            } else {
                $reportId = $yearNowSubstring . 'AYD-WR1';
            }
        }

        if ($request->hasFile('file1')) {
            $file = $request->file('file1');    
            $file1 = $file->openFile()->fread($file->getSize());
        } else {
               $file1 = null;
        }

        if ($request->hasFile('file2')) {
            $file = $request->file('file2');    
            $file2 = $file->openFile()->fread($file->getSize());
        } else {
               $file2 = null;
        }

        if ($request->hasFile('file3')) {
            $file = $request->file('file3');    
            $file3 = $file->openFile()->fread($file->getSize());
        } else {
               $file3 = null;
        }

        if (!empty($file1)) {
            $dataBudget = DB::table('sales_weekly_report')->insert([
                'id_report' => $reportId,
                'date' => $request->input('date'),
                'add_by' => $request->input('username'),
                'notes' => $request->input('notes'),
                'file_1' => $file1,
                'file_2' => $file2,
                'file_3' => $file3,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            alert()->success('Success', 'Weekly Report has been created');
            return to_route('weekly-report');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('weekly-report');
        }
    }

    public function update(Request $request, $reportId)
    {
        if ($request->hasFile('file1_1')) {
            $filePdf = $request->file('file1_1');    
            $file1 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $file1 = null;
        }

        if ($request->hasFile('file2_1')) {
            $filePdf = $request->file('file2_1');    
            $file2 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $file2 = null;
        }

        if ($request->hasFile('file3_1')) {
            $filePdf = $request->file('file3_1');    
            $file3 = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
               $file3 = null;
        }

        $dataBudget = DB::table('sales_weekly_report')->where('sales_weekly_report.id', $reportId)->update([
            'date' => $request->input('date1'),
            'notes' => $request->input('notes1'),
            'file_1' => $file1,
            'file_2' => $file2,
            'file_3' => $file3,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($request) {
            alert()->success('Success', 'Weekly Report has been updated');
            return to_route('weekly-report');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('weekly-report');
        }
    }

    public function viewFile1($reportId, $notes)
    {
        $dataReport = DB::table('sales_weekly_report')->whereRaw("(sales_weekly_report.id_report = '$reportId' and sales_weekly_report.notes = '$notes')")->select('file_1', 'notes')->first();
        $filename = $dataReport->notes . '-1';
        $fileReport = $dataReport->file_1;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_1),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewFile2($reportId, $notes)
    {
        $dataReport = DB::table('sales_weekly_report')->whereRaw("(sales_weekly_report.id_report = '$reportId' and sales_weekly_report.notes = '$notes')")->select('file_2', 'notes')->first();
        $filename = $dataReport->notes . '-2';
        $fileReport = $dataReport->file_2;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_2),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewFile3($reportId, $notes)
    {
        $dataReport = DB::table('sales_weekly_report')->whereRaw("(sales_weekly_report.id_report = '$reportId' and sales_weekly_report.notes = '$notes')")->select('file_3', 'notes')->first();
        $filename = $dataReport->notes . '-3';
        $fileReport = $dataReport->file_3;

        return Response::make($fileReport, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($dataReport->file_3),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function delete ($reportId)
    {
        try {
            DB::table('sales_weekly_report')->where('id', $reportId)->delete();
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted weekly report",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
