<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UserManagerController extends Controller
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
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $department = DB::table('m_department')->select('id', 'name', 'status')->where('status', '=', 'Active')->get();
        return view('pages.user-manager.index', compact('dataChildCompany', 'department'));
    }

    public function changePassword(Request $request, $userId)
    {   
        $dataUser = DB::table('users')
        ->select(
            '*'
        )->where('id', $userId)->first();
        return view('pages.user-manager.changepassword', compact('dataUser'));
    }

    public function getData(Request $request)
    {
        $dataUser = DB::table('users')->leftJoin('m_child_company', 'users.company_id', 'm_child_company.id_company')->leftJoin('m_department', 'users.role_name', 'm_department.id')
        ->select('users.id', 'users.username', 'users.email', 'users.real_email', 'users.role', 'users.department', 'users.role_name', 'users.status', 'users.company_id', 'users.employee_id', 
        'users.created_at', 'users.updated_at', 'm_child_company.company_type', 'm_child_company.name', 'm_department.name as deptName',
        DB::raw("
        case
            when users.status = 1 then 'Active'
            else 'unknown status'
        end as status_name
        "))->where('users.status', '=', '1'); 

        if ($request->ajax()) {
            return DataTables::of($dataUser)
            ->editColumn('created_at', function ($dataUser) {
                return date('Y-m-d', strtotime($dataUser->created_at));
            })
            ->editColumn('updated_at', function ($dataUser) {
                return date('Y-m-d', strtotime($dataUser->updated_at));
            })
            ->editColumn('name', function ($dataUser) {
                return $dataUser->company_type. '. ' . $dataUser->name;
            })
            ->addColumn('action', function ($dataUser) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataUser->id.'"
                                data-username = "' . $dataUser->username . '" data-email = "' . $dataUser->email . '" data-real_email = "' . $dataUser->real_email . '" data-role = "' . $dataUser->department . '" 
                                data-role_name = "' . $dataUser->role_name . '" data-employee = "' . $dataUser->employee_id . '"
                                data-company = "' . $dataUser->company_id . '"
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
                                            <div class="font-semibold text-slate-800">Edit Data User</div>
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

                        <a href = "/user-manager/changepassword/' . $dataUser->id . '" class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1"    
                        >Change Password</a>
    
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataUser->id.'"
                            >Delete
                        </button>
                    </div>';
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function create(Request $request)
    {
        $role_name = $request->input('role_name');
        $email = $request->input('email');
        $companyId = $request->input('company_id');
        
        $dataUser = DB::table('users')->select('email')->where('email', $email)->first();
        $role = DB::table('m_department')->where('id', $role_name)->pluck('name')->first();
        if (is_null($dataUser)) {
            $hashPassword = Hash::make($request->input('pass'));
            DB::table('users')->insert([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'real_email' => $request->input('real_email'),
                'password' => $hashPassword,
                'role' => '0',
                'department' => $request->input('role_name'),
                'role_name' => $role,
                'employee_id' => $request->input('employee_id'),
                'status' => '1',
                'image' => 'No Image',
                'company_id' => $companyId,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
                'kanban' => '1',
                'hr' => '1',
                'hr_1' => '1',
                'hr_2' => '1',
                'hr_3' => '1',
                'hr_4' => '1',
                'hr_5' => '1',
                'hr_6' => '1',
                'hr_7' => '1',
                'hr_8' => '1',
                'hr_9' => '1',
                'hr_10' => '1',
                'hr_11' => '1',
                'ga' => '1',
                'ga_1' => '1',
                'ga_2' => '1',
                'ga_3' => '1',
                'ga_4' => '1',
                'ga_5' => '1',
                'ga_6' => '1',
                'ga_7' => '1',
                'ga_8' => '1',
                'ga_9' => '1',
                'ga_10' => '1',
                'ga_11' => '1',
                'ga_12' => '1',
                'ga_13' => '1',
                'ga_14' => '1',
                'ga_15' => '1',
                'ga_16' => '1',
                'ga_17' => '1',
                'ga_18' => '1',
                'ga_19' => '1',
                'ga_20' => '1',
                'ga_21' => '1',
                'ga_22' => '1',
                'ga_23' => '1',
                'ga_24' => '1',
                'ga_25' => '1',
                'ga_26' => '1',
                'ga_27' => '1',
                'master_data' => '1',
                'md_1' => '1',
                'md_2' => '1',
                'md_3' => '1',
                'md_4' => '1',
                'md_5' => '1',
                'md_6' => '1',
                'md_7' => '1',
                'md_8' => '1',
                'md_9' => '1',
                'md_10' => '1',
                'md_11' => '1',
                'md_12' => '1',
                'md_13' => '1',
                'md_14' => '1',
                'md_15' => '1',
                'md_16' => '1',
                'md_17' => '1',
                'md_18' => '1',
                'md_19' => '1',
                'md_20' => '1',
                'md_21' => '1',
                'md_22' => '1',
                'md_23' => '1',
                'md_24' => '1',
                'md_25' => '1',
                'calendar' => '1',
                'google' => '1',
                'google_calendar' => '1'
            ]);

            alert()->success('Success', 'Data User Has Been Created');
            return redirect()->route('user-manager'); // Menggunakan 'redirect()->route()'
        } else {
            alert()->error('Error', 'Data User Not Valid or Data Are Already Exist');
            return redirect()->route('user-manager'); // Menggunakan 'redirect()->route()'
        }
    }


    public function update(Request $request, $userId)
    {
        if ($request) {
            $role_name1 = $request->input('role_name1');
            $role1 = DB::table('m_department')->where('id', $role_name1)->pluck('name')->first();  
            $dataUser = DB::table('users')->where('id', $userId)->pluck('company_id')->first();
            if ($dataUser == '0') {
                DB::table('users')->where('id', $userId)->update([
                    'username' => $request->input('username1'),
                    'email' => $request->input('email1'),
                    'real_email' => $request->input('real_email1'),
                    'department' => $request->input('role_name1'),
                    'role_name' => $role1,
                    'employee_id' => $request->input('employee_id1'),
                    'updated_at' => now(),
                    'updated_by' => Auth::user()->id
                ]);
            } else {
                DB::table('users')->where('id', $userId)->update([
                    'username' => $request->input('username1'),
                    'email' => $request->input('email1'),
                    'real_email' => $request->input('real_email1'),
                    'department' => $request->input('role_name1'),
                    'role_name' => $role1,
                    'employee_id' => $request->input('employee_id1'),
                    'company_id' => $request->input('company_id1'),
                    'updated_at' => now(),
                    'updated_by' => Auth::user()->id
                ]);
            }

            alert()->success('Success', 'Data User Has Been Updated');
            return redirect()->route('user-manager');
        }
        
    }

    public function update1(Request $request, $userId)
    {
         // Ambil data user berdasarkan ID
        $userData = DB::table('users')->where('id', $userId)->first();

        // Ambil input password lama dari request
        $oldPassword = $request->input('pass1');

        if ($oldPassword != null && Hash::check($oldPassword, $userData->password)) {
            $newPassword = $request->input('pass2');

            // Jika password baru diisi, hash password baru
            if ($newPassword != null) {
                $hashPassword = Hash::make($newPassword);
            } else {
                $hashPassword = $userData->password; // Gunakan password lama jika password baru kosong
            }

            // Update data user
            DB::table('users')->where('id', $userId)->update([
                'password' => $hashPassword,
                'updated_at' => now()
            ]);

            alert()->success('Success', 'Password Has Been Changed');
            return redirect()->route('user-manager');
        }else{
            alert()->error('Error', 'Old Password not Match');
            return to_route('user-manager');
        }
        
    }

    public function delete($userId)
    {
        try {
            DB::table('users')->where('id', $userId)->update([
                'status' => '0',
                'updated_at' => now()
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data User",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
