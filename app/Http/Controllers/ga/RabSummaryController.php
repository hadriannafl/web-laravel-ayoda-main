<?php

namespace App\Http\Controllers\ga;

use App\Http\Controllers\Controller;
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
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class RabSummaryController extends Controller
{
    public function rabSummary()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
        ->where('m_child_company.id_company', $user)->first();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab.summary', compact('dataChildCompany','fixCompany', 'department', 'bank'));
    }
    
    public function rabSummaryGetData(Request $request)
    {
        $startdate = date('Y-m-t', strtotime($request->input('from')));
        $enddate = date('Y-m-t', strtotime($request->input('to')));
        $searchTriggered = $request->input('search');

        $dataRabQuery = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as deptName',
            'users.username'
        )->whereNotIn('t_rab.approvalstat', ['Draft', 'Canceled']);

        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
            }
    
            if ($request->input('status') != null) {
                $dataRabQuery->where('t_rab.approvalstat', $request->status);
            }
            if ($request->input('company') != null) {
                $dataRabQuery->where('t_rab.id_company', $request->company);
            }
            if ($request->input('department') != null) {
                $dataRabQuery->where('t_rab.division', $request->department);
            }
        } else {
            $dataRabQuery->whereRaw('1 = 0');
        }
    
        $dataRab = $dataRabQuery;

        if ($request->ajax()) {
            return DataTables::of($dataRab)
            ->addColumn('label', function ($dataRab) {

                $status = ($dataRab->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved' || $status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Enforced') {
                    $color = "green";
                } else if ($status == 'Site Denied' || $status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'HQ 3 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->editColumn('gtotal', function ($dataRab) {
                return "" . "" . number_format($dataRab->gtotal, 0, ',', '.');
            })
            ->editColumn('date_rab', function ($dataRab) {
                return date('Y F', strtotime($dataRab->date_rab));
            })
            ->editColumn('form_date', function ($dataRab) {
                return date('Y-m-d', strtotime($dataRab->form_date));
            })
            ->addColumn('action', function ($dataRab) {
                if ($dataRab->approvalstat == 'Draft' && $dataRab->print_status == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>

                        <a href = "/ga/rab-approval/list/updatepage/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>

                        <a href = "/ga/rab-approval/list/clonepage/' . $dataRab->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >Clone</a>
                    </div>';
                }elseif ($dataRab->approvalstat == 'Printed' && $dataRab->print_status == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>

                    <a href = "/ga/rab-approval/list/clonepage/' . $dataRab->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                    >Clone</a>
                    </div>';
                }else if($dataRab->approvalstat == 'Site Approved'){
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                    >Cancel</button>
                    
                    <a href = "/ga/rab-approval/list/clonepage/' . $dataRab->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                    >Clone</a>
                    </div>';
                }elseif ($dataRab->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
                    
                    <a href = "/ga/rab-approval/list/clonepage/' . $dataRab->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                    >Clone</a>
                    </div>';
                }elseif ($dataRab->approvalstat == 'HQ 1 Approved' || $dataRab->approvalstat == 'HQ 2 Approved' || $dataRab->approvalstat == 'Enforced' || $dataRab->approvalstat == 'HQ 1 Denied' || $dataRab->approvalstat == 'HQ 2 Denied' || $dataRab->approvalstat == 'HQ 3 Denied') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"    
                    >View</a>
                    
                    <a href = "/ga/rab-approval/list/clonepage/' . $dataRab->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                    >Clone</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataRab) {
                return '
                <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                    >View</a>
                </div>';
            })
            
            ->rawColumns(['action', 'action1', 'label'])
            ->make();
        }
    }

    public function rabSummaryPost(Request $request)
    {   
        try {
            if($request){
                $from = date('Y-m-t', strtotime($request->input('from')));;
                $to = date('Y-m-t', strtotime($request->input('to')));;
                $idCompany = $request->input('company');
                $dept = $request->input('department');

                $idQuery = DB::table('t_rab')
                ->select(
                    't_rab.idrec',
                )
                ->whereNotIn('t_rab.approvalstat', ['Draft', 'Canceled'])
                ->whereDate('t_rab.date_rab', '>=', $from)
                ->whereDate('t_rab.date_rab', '<=', $to)
                ->where('t_rab.id_company', $idCompany);

                if ($dept != null) {
                    $idQuery->where('t_rab.division', $dept);
                }

                $id = $idQuery->get();

                return response()->json([
                    "st" => '1',
                    "from" => $from,
                    "to" => $to,
                    "company" => $idCompany,
                    "department" => $dept,
                    "idrec" => $id
                ]);
            }else{
                return response()->json(["st" => '0']);
            }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function rabSummaryPrint(Request $request, $from, $to, $company, $department = null)
    {  
        $dataComps = DB::table('m_child_company')
            ->select(
                'm_child_company.company_type',
                'm_child_company.name',
                'm_child_company.address',
                'm_child_company.logo_filename'
            )->where('m_child_company.id_company', $company)->first();

        // Mengambil data untuk dataRabitem
        $dataRabItemQuery = DB::table('t_rab')
            ->leftJoin('m_department', 't_rab.division', 'm_department.id')
            ->select(
                't_rab.idrec',
                't_rab.date_rab',
                't_rab.id_rab',
                't_rab.rab_type',
                't_rab.name_rab',
                't_rab.gtotal',
                't_rab.approvalstat',
                'm_department.name as dept',
                DB::raw("SUM(t_rab.gtotal) AS totals")
            )
            ->whereNotIn('t_rab.approvalstat', ['Draft', 'Canceled'])
            ->whereDate('t_rab.date_rab', '>=', $from)
            ->whereDate('t_rab.date_rab', '<=', $to)
            ->where('t_rab.id_company', $company);

        if ($department != null) {
            $dataRabItemQuery->where('t_rab.division', $department);
        }

        $dataRabItem = $dataRabItemQuery->groupBy(
            't_rab.idrec',
            't_rab.date_rab',
            't_rab.id_rab',
            't_rab.rab_type',
            't_rab.name_rab',
            't_rab.gtotal',
            't_rab.approvalstat',
            'm_department.name'
        )->get();

        $dataRabItemCount = $dataRabItem->count();

        $totalsQuery = DB::table('t_rab')
        ->select(
            DB::raw("SUM(t_rab.gtotal) AS totals")
        )
        ->whereNotIn('t_rab.approvalstat', ['Draft', 'Canceled'])
        ->whereDate('t_rab.date_rab', '>=', $from)
        ->whereDate('t_rab.date_rab', '<=', $to)
        ->where('t_rab.id_company', $company);

        if ($department != null) {
            $totalsQuery->where('t_rab.division', $department);
        }

        $totals = $totalsQuery->first();

        return view('pages.ga.rab.summary-print', compact('dataComps', 'dataRabItem', 'dataRabItemCount', 'totals'));
    }
}
