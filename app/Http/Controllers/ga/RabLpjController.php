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

class RabLpjController extends Controller
{

    public function rabLpjList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.lpj.rab-lpj-list', compact('dataChildCompany', 'department'));
    }

    public function rabLpjCreate()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.lpj.rab-lpj-list-create', compact('dataChildCompany', 'department'));
    }

    public function rabLpjFormCreate()
    {
        $user = Auth::user()->company_id;
        $dataDivision = DB::table('m_division')->select('*')->where('p_id_division', '=', '0')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $subDepartment = DB::table('m_subdepartment')->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.dept_name', 'm_subdepartment.status', 'm_subdepartment.p_id_dept')->where('m_subdepartment.status', '=', 'Active')->orderBy('m_subdepartment.name', 'asc')->get();
        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.ga.lpj.rab-lpj-form-create', compact('dataChildCompany', 'dataDivision', 'department', 'subDepartment', 'dataCurrency'));
    }

    public function rabListGetData(Request $request)
    {
        $startdate = $request->input('from');
        $enddate = $request->input('to');
        $searchTriggered = $request->input('search');
        $dataRabQuery = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.idrec',
            't_rab.date_rab',
            't_rab.form_date',
            't_rab.id_rab',
            't_rab.rab_type',
            't_rab.name_rab',
            't_rab.applicant',
            't_rab.id_company',
            't_rab.division',
            't_rab.gtotal',
            't_rab.approvalstat',
            't_rab.approval1stat',
            't_rab.approval2stat',
            't_rab.approvaldate',
            't_rab.approved1by',
            't_rab.approved2by',
            't_rab.approved3by',
            't_rab.remarks1',
            't_rab.remarks2',
            't_rab.remarks3',
            't_rab.print_status',
            't_rab.created_by',
            'm_child_company.name',
            'm_department.name as deptName',
            'users.username'
        )
        ->where('t_rab.approvalstat', 'Enforced')
        ->where('t_rab.rab_type', 'Advance Payment to Site');

        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
            }
            if ($request->input('status') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.approvalstat', $request->status);
            }
            if ($request->input('company') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.id_company', $request->company);
            }
            if ($request->input('department') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.division', $request->department);
            }
        }else{
            $startOfMonth = date('Y-m-t', strtotime('-3 month'));
            $oneMonthAfter = date('Y-m-t');
            $dataRabQuery->whereBetween('t_rab.date_rab', [$startOfMonth, $oneMonthAfter]);
            if ($request->input('company') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.id_company', $request->company);
            }
        }

        $dataRab = $dataRabQuery;

        if ($request->ajax()) {
            return DataTables::of($dataRab)
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
                return '
                <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                    >View Detail</a>
                </div>';
            })
            
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function selectRab(Request $request)
    {
        $userCompany = Auth::user()->company_id;
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select('t_rab.idrec', 
                 't_rab.date_rab',
                 't_rab.form_date',
                 't_rab.rab_type',
                 't_rab.id_rab',
                 't_rab.name_rab', 
                 't_rab.division', 
                 't_rab.approvalstat', 
                 't_rab.id_company', 
                 't_rab.gtotal', 
                 't_rab.balance', 
                 'm_child_company.name', 
                 'm_child_company.company_type', 
                 'm_department.name as deptName',
                 'users.username')
        ->where('t_rab.approvalstat', ['Enforced'])
        ->where('t_rab.rab_type', '=', 'Advance Payment to Site');

        if ($userCompany != '0' && $userCompany != '999' && $userCompany != '888') {
            $dataRab = $dataRab->where('t_rab.id_company', $userCompany);
        }

        // if ($request->input('pr_type') != null) {
        //     $dataRab = $dataRab->where('t_rab.rab_type', $request->pr_type);
        // }

        if ($request->input('department') != null) {
            $dataRab = $dataRab->where('t_rab.division', $request->department);
        }

        if ($request->ajax()) {
            return DataTables::of($dataRab)
                ->editColumn('name', function ($dataRab) {
                    return $dataRab->company_type . '. ' . $dataRab->name;
                })
                ->editColumn('date_rab', function ($dataRab) {
                    return date('Y F', strtotime($dataRab->date_rab));
                })
                ->editColumn('gtotal',function($dataRab){
                    return '' . number_format($dataRab->gtotal, 0, ',', '.');
                })

                ->addColumn('action', function ($dataRab) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" target="_blank" class="btn btn-sm btn-modal text-sm bg-amber-500 text-white ml-1 hover:bg-amber-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Detail</a>

                        <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-3" @click="modalOpen = false"  data-id="' . $dataRab->id_rab . '"
                        data-form_date="' . $dataRab->form_date . '" data-title="' . $dataRab->name_rab . '" data-period="' . $dataRab->date_rab . '" data-division="' . $dataRab->division . '" data-company="' . $dataRab->name . '" data-username="' . $dataRab->username . '" data-balance="' . $dataRab->balance . '" id="select"
                        >Select</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function selectRabDetail(Request $request)
    {
        $dataDetailRAB = DB::table('t_rab_detail')
        ->select('t_rab_detail.*')->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc');

        if ($request->input('idRab') != null) {
            $dataDetailRAB = $dataDetailRAB->where('t_rab_detail.id_rab', $request->idRab);
        }

        if ($request->ajax()) {
            return DataTables::of($dataDetailRAB)
                ->editColumn('qty',function($dataDetailRAB){
                    return '' . number_format($dataDetailRAB->qty, 0, ',', '.');
                })
                ->editColumn('amount',function($dataDetailRAB){
                    return '' . number_format($dataDetailRAB->amount, 0, ',', '.');
                })
                ->editColumn('total',function($dataDetailRAB){
                    return '' . number_format($dataDetailRAB->total, 0, ',', '.');
                })
                ->editColumn('balance',function($dataDetailRAB){
                    return '' . number_format($dataDetailRAB->balance, 0, ',', '.');
                })

                ->addColumn('action', function ($dataDetailRAB) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-3" @click="modalOpen = false"  data-id="' . $dataDetailRAB->id_rab . '"
                        data-id_item="' . $dataDetailRAB->id_rab_item . '" data-nama="' . $dataDetailRAB->name_rab_detail . '" data-unit="' . $dataDetailRAB->unit . '" data-budget="' . $dataDetailRAB->balance . '" 
                        data-amount="' . $dataDetailRAB->amount . '" data-qty="' . $dataDetailRAB->qty . '" data-total="' . $dataDetailRAB->total . '" id="select"
                        >Select</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

}