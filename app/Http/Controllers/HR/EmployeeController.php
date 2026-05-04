<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Uid\MaxUlid;

class EmployeeController extends Controller
{
    public function employee()
    {
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.employee', compact('company', 'department'));
    }

    public function employeeOnly()
    {
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.employee-list-only', compact('company', 'department'));
    }

    public function employeeForm(Request $request)
    {
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.form', compact('company', 'department', 'bank'));
    }

    public function employeeEdit()
    {
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.employee-edit', compact('company', 'department', 'bank'));
    }

    public function employeeUpdatePage($employeeId)
    {
        $employee = DB::table('m_employees')->where('idemployee', $employeeId)->first();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.editpage', compact('employee', 'company', 'department', 'bank'));
    }

    public function employeeDeletePage()
    {
        $company = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.hr.employee.employee-delete', compact('company', 'department'));
    }

    public function employeeGetData(Request $request)
    {
        $dataEmployee = DB::table('m_employees')
        ->leftJoin('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->select('m_employees.*', 'm_child_company.name as company', 
        DB::raw("
                case
                    when m_employees.gender = 'M' then 'Male'
                    when m_employees.gender = 'F' then 'Female'
                    else 'unknown gender'
                end as gen
            "))->where('m_employees.status', '=', 'ACTIVE')->orderBy('m_employees.first_name', 'asc');
        
        if ($request->input('company') != null) {
            $dataEmployee->where('m_employees.id_company', $request->company);
        }

        if ($request->ajax()) {
            return DataTables::of($dataEmployee)
            ->editColumn('first_name', function ($dataEmployee) {
                return $dataEmployee->first_name . ' ' . $dataEmployee->last_name;
            })
            ->editColumn('DoB', function ($dataEmployee) {
                return date('Y-m-d', strtotime($dataEmployee->DoB));
            })
            ->editColumn('joined_date', function ($dataEmployee) {
                return date('Y-m-d', strtotime($dataEmployee->joined_date));
            })
            ->addColumn('action', function ($dataEmployee) {
                    return '
                    <div class="flex flex-row">            
                            <a href="/hr/employee/updatepage/'. $dataEmployee->idemployee .'" class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" type="button"
                            >Edit</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataEmployee) {
                return '
                <div class="flex flex-row"> 
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataEmployee->idemployee.'" data-first_name="'.$dataEmployee->first_name.'" data-last_name="'.$dataEmployee->last_name.'"
                        >Delete
                    </button>
                </div>';
            })       
            ->addColumn('action2', function ($dataEmployee) {
                return '
                <div class="flex flex-row"> 
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataEmployee->idemployee.'"
                        >Terminate
                    </button>
                </div>';
            })      
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function employeeCreate(Request $request)
    {
        $maxId = DB::table('m_employees')->max('idemployee');
        if ($request) {
            DB::table('m_employees')->insert([
                'nik' => $request->input('nik'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'DoB' => $request->input('DoB'),
                'place_of_birth' => $request->input('place_of_birth'),
                'marital_status' => $request->input('marital_status'),
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'poh' => $request->input('poh'),
                'id_company' => $request->input('id_company'),
                'employee_type' => $request->input('employee_type'),
                'joined_date' => $request->input('joined_date'),
                'department' => $request->input('department'),
                'title_structural' => $request->input('title_structural'),
                'position' => $request->input('position'),
                'npwp_num' => $request->input('npwp_num'),
                'npwp_name' => $request->input('npwp_name'),
                'bank_name' => $request->input('bank_name'),
                'bank_acc_num' => $request->input('bank_acc_num'),
                'bank_acc_name' => $request->input('bank_acc_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'status' => 'ACTIVE',
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d')
            ]);

            DB::table('h_employee_position')->insert([
                'idemployee' => ++$maxId,
                'sdate' => date('Y-m-d'),
                'id_company' => $request->input('id_company'),
                'employee_type' => $request->input('employee_type'),
                'department' => $request->input('department'),
                'title_structural' => $request->input('title_structural'),
                'position' => $request->input('position'),
                'status' => 'ACTIVE',
                'aktifyn' => 'Y',
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data Employee Has Been Created');
            return to_route('employee.form');
        } else {
            alert()->error('Error', 'Data Employee Already Exist');
            return to_route('employee.form');
        }
    }

    public function employeeUpdate(Request $request, $employeeId)
    {
        $dataEmployee = DB::table('m_employees')->where('idemployee', $employeeId)->first();
        if ($request) {
            DB::table('m_employees')->where('idemployee', $employeeId)->update([
                'nik' => $request->input('nik'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'DoB' => $request->input('DoB'),
                'place_of_birth' => $request->input('place_of_birth'),
                'marital_status' => $request->input('marital_status'),
                'gender' => $request->input('gender'),
                'religion' => $request->input('religion'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'poh' => $request->input('poh'),
                'id_company' => $request->input('id_company'),
                'employee_type' => $request->input('employee_type'),
                'joined_date' => $request->input('joined_date'),
                'department' => $request->input('department'),
                'title_structural' => $request->input('title_structural'),
                'position' => $request->input('position'),
                'npwp_num' => $request->input('npwp_num'),
                'npwp_name' => $request->input('npwp_name'),
                'bank_name' => $request->input('bank_name'),
                'bank_acc_num' => $request->input('bank_acc_num'),
                'bank_acc_name' => $request->input('bank_acc_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);

            if ($dataEmployee->department != $request->input('department') || $dataEmployee->title_structural != $request->input('title_structural') || $dataEmployee->position != $request->input('position')) {
                DB::table('h_employee_position')->where('idemployee', $employeeId)->update([
                    'edate' => date('Y-m-d'),
                    'status' => 'INACTIVE',
                    'aktifyn' => 'N',
                ]);
                DB::table('h_employee_position')->insert([
                    'idemployee' => $employeeId,
                    'id_company' => $request->input('id_company'),
                    'employee_type' => $request->input('employee_type'),
                    'department' => $request->input('department'),
                    'title_structural' => $request->input('title_structural'),
                    'position' => $request->input('position'),
                    'status' => 'ACTIVE',
                    'aktifyn' => 'N',
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            }elseif ($dataEmployee->id_company != $request->input('id_company')) {
                DB::table('h_employee_position')->where('idemployee', $employeeId)->update([
                    'edate' => date('Y-m-d'),
                    'status' => 'INACTIVE',
                    'aktifyn' => 'N',
                ]);
                DB::table('h_employee_position')->insert([
                    'idemployee' => $employeeId,
                    'sdate' => date('Y-m-d'),
                    'id_company' => $request->input('id_company'),
                    'employee_type' => $request->input('employee_type'),
                    'department' => $request->input('department'),
                    'title_structural' => $request->input('title_structural'),
                    'position' => $request->input('position'),
                    'status' => 'ACTIVE',
                    'aktifyn' => 'Y',
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            }elseif ($dataEmployee->id_company != $request->input('id_company') && $dataEmployee->department != $request->input('department') || $dataEmployee->title_structural != $request->input('title_structural') || $dataEmployee->position != $request->input('position')) {
                DB::table('h_employee_position')->where('idemployee', $employeeId)->update([
                    'edate' => date('Y-m-d'),
                    'status' => 'INACTIVE',
                    'aktifyn' => 'N',
                ]);
                DB::table('h_employee_position')->insert([
                    'idemployee' => $employeeId,
                    'sdate' => date('Y-m-d'),
                    'id_company' => $request->input('id_company'),
                    'employee_type' => $request->input('employee_type'),
                    'department' => $request->input('department'),
                    'title_structural' => $request->input('title_structural'),
                    'position' => $request->input('position'),
                    'status' => 'ACTIVE',
                    'aktifyn' => 'Y',
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            }

            alert()->success('Success', 'Data Employee Has Been Updated');
            return to_route('employee.edit');
        } else {
            alert()->error('Error', 'error');
            return to_route('employee.edit');
        }
    }

    public function employeeDelete($employeeId)
    {
        try {
            DB::table('m_employees')->where('idemployee', $employeeId)->update([
                'status' => 'INACTIVE',
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);
            DB::table('h_employee_position')->where('idemployee', $employeeId)->update([
                'edate' => date('Y-m-d'),
                'status' => 'INACTIVE',
                'aktifyn' => 'N',
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data Employee",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
