<?php

namespace App\Http\Controllers\tugas;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;

class ProyekController extends Controller
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
        $dataUsers = DB::table('users')
        ->select('users.id', 'users.username')
        ->whereRaw("(users.sales_id) != 'null'")
        ->orderBy('users.username', 'asc')
        ->get();

        return view('pages.tasks.proyek.proyek-all.index', compact('dataUsers'));
    }

    public function form()
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.tasks.proyek.proyek-all.create-task', compact('dataCurrency'));
    }

    public function pic()
    {
        return view('pages.tasks.proyek.proyek-all.new-pic');
    }


    public function getData(Request $request)
    {
        $dataProjects = DB::table('projects')
            ->leftJoin('companies', 'projects.company_id', 'companies.id')
            ->leftJoin('company_pics', 'projects.company_pic_id', 'company_pics.id')
            ->leftJoin('users', 'projects.user_id', 'users.id')
            ->leftJoin('tasks', 'projects.id', 'tasks.project_id')
            ->leftJoin('task_details', 'tasks.id', 'task_details.task_id')
            ->select(
                'projects.id',
                'projects.company_id',
                'projects.created_at',
                'companies.name as companyname',
                'company_pics.name as pic',
                'projects.company_pic_id',
                'projects.user_id',
                'projects.description',
                'users.username as salesname',
                'projects.name',
                'projects.status',
                'projects.file_upload',
                'task_details.task_action_id as stage',
                'task_details.task_time as date',
                'task_details.notes',
                DB::raw("
                case
                    when projects.status = 0 then 'Pending'
                    when projects.status = 1 then 'Open'
                    when projects.status = 2 then 'Lost'
                    when projects.status = 3 then 'Won'
                    else 'unknown status'
                end as status_name
                "),
                DB::raw("
                case
                    when task_details.task_action_id = 0 then ''
                    when task_details.task_action_id = 1 then 'DOCUMENTATION / SAMPLING & QUOTATION'
                    when task_details.task_action_id = 2 then 'FORMULATION IN PROGRESS'
                    when task_details.task_action_id = 3 then 'STABLE FORMULA & PENDING APPROVAL'
                    when task_details.task_action_id = 4 then 'PILOT'
                    when task_details.task_action_id = 5 then 'MARKETING APPROVED'
                    when task_details.task_action_id = 6 then 'INDUSTRIAL BATCHES'
                    when task_details.task_action_id = 7 then 'LAUNCHING'
                    else ' '
                end as stage_name
                ")
            )->orderBy('projects.created_at', 'desc');

        if ($request->input('status') != null) {
                $dataProjects = $dataProjects->where('projects.status', $request->status);
            }
        if ($request->input('salesname') != null) {
                $dataProjects = $dataProjects->where('projects.user_id', $request->salesname);
            }

        if ($request->ajax()) {
            return DataTables::of($dataProjects)
                ->editColumn('created_at', function ($dataProjects) {
                    return date('Y-m-d', strtotime($dataProjects->created_at));
                })
                ->addColumn('label', function ($dataProjects) {

                    $status = ($dataProjects->status);
                    $color = "color";

                    if ($status == '0') {
                        $color = "yellow";
                    } else if ($status == '1') {
                        $color = "blue";
                    } else if ($status == '2') {
                        $color = "red";
                    } else if ($status == '3') {
                        $color = "green";
                    }
                    return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
                })
                ->addColumn('action', function ($dataProjects) {
                    return '    <a
                                href = "/tasks/proyek/proyek-all/updatepage/' . $dataProjects->id . '" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                data-company-id="' . $dataProjects->company_id . '"
                                data-company="' . $dataProjects->companyname . '" data-company-pic-id="' . $dataProjects->company_pic_id . '"
                                data-sales="' . $dataProjects->user_id . '" data-project="' . $dataProjects->name . '" data-description="' . $dataProjects->description . '"
                                data-status="' . $dataProjects->status . '" data-file="' . $dataProjects->file_upload . '" data-stage="' . $dataProjects->stage_name . '"
                                data-notes="' . $dataProjects->notes . '" data-date="' . $dataProjects->date . '"
                            >Update</a>
                            
                            <a href = "' . $this->baseImageUrl . 'proposal/'. $dataProjects->file_upload .'" target="_blank" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                            >View Attachment</a>';
                })
                ->rawColumns(['label', 'action'])
                ->make();
        }
    }

    // public function getUpdate($companyId)
    // {
    //     $dataCompanyPic = DB::table('company_pics')
    //         ->where('company_id', $companyId)
    //         ->select('id', 'name', 'phone_number_1', 'phone_number_2')
    //         ->get()->toArray();
    //     $dataSales = DB::table('users')->select('id', 'username')->get()->toArray();

    //     return response()->json([
    //         'companyPicList' => $dataCompanyPic,
    //         'salesList' => $dataSales,
    //     ]);
    // }

    // public function update(Request $request, $projectId)
    // {
    //     $data = $request->all();
    //     $dataUpdated = [
    //         'company_pic_id' => $data['pic'],
    //         'user_id' => $data['sales'],
    //         'name' => $data['project_name'],
    //         'description' => $data['desc'],
    //         'status' => $data['status'],
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ];

    //     if ($request->hasFile('file')) {
    //         $fileName = Str::of($data['project_name'])->slug();
    //         $dataUpdated['file_upload'] = $fileName . '.' . $request->file('file')->extension();
    //     }

    //     $update = DB::table('projects')->where('id', $projectId)->update($dataUpdated);

    //     if ($update) {
    //         alert()->success('Success', 'Proposal Has Been Updated');
    //         return to_route('proyek-all');
    //     } else {
    //         alert()->error('Error', 'Error Occurred');
    //         return to_route('proyek-all');
    //     }
    // }

    public function getCompany(Request $request)
    {
        $dataCompany = DB::table('companies')
            ->select(
                'companies.id as company_id',
                'companies.name as company',
                'companies.status',
                DB::raw("
                case
                    when companies.status = 1 then 'Active'
                    else 'unknown status'
                end as status_name
            ")
            );
        if ($request->ajax()) {
            return DataTables::of($dataCompany)
                ->addColumn('action', function ($dataCompany) {
                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataCompany->company_id . '"
                    data-nama="' . $dataCompany->company . '" data-status="' . $dataCompany->status_name . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function selectCompany($idCompany)
    {
        $companyDataPic = DB::table('company_pics')
            ->where('company_id', $idCompany)
            ->select('id', 'name', 'phone_number_1', 'phone_number_2', 'email')
            ->get()->toArray();
        $salesData = DB::table('users')->select('id', 'username', 'sales_id')->get()->toArray();

        return response()->json([
            'listCompanyPic' => $companyDataPic,
            'salesList' => $salesData,
        ]);
    }

    public function getProduct(Request $request)
    {
        $dataProduct = DB::table('products')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                'products.unit'
            );
        if ($request->ajax()) {
            return DataTables::of($dataProduct)
                ->addColumn('action', function ($dataProduct) {

                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_product="' . $dataProduct->id . '"
                    data-nama_product="' . $dataProduct->name . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }
     public function create(Request $request)
    {
        //return $request->all();
        $rowsProducts = $request->get('rows');
        
        if ($request->hasFile('file')) {
           $fileName = $request->file('file')->getClientOriginalName();
           $request->file('file')->move($this->saveImageUrl . 'proposal/', $fileName);
       } else {
           $fileName = null;
       }

       if ($rowsProducts != null) {

        $id = DB::table('projects')->insertGetId([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'company_id' => $request->input('idCompany'),
            'company_pic_id' => $request->input('pic'),
            'user_id' => Auth::user()->id,
            'status' => $request->input('status'),
            'date' => $request->input('date'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'file_upload' => $request->input('file')
        ]);
        $projectId = $id;

        DB::table('projects')
            ->where('id', $projectId)
            ->update([
                'file_upload' => $fileName
            ]);

        $task = DB::table('tasks')->insertGetId([
            'project_id' => $projectId,
            'product_id' => $request->input('productId'),
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'last_updated_by' => Auth::user()->id,
        ]);
        $taskId = $task;

        DB::table('task_details')->insert([
            'task_id' => $taskId,
            'task_action_id' => $request->input('actions'),
            'task_time' => $request->input('date'),
            'notes' => $request->input('notes'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $request->input('status'),
        ]);

        DB::table('task_history')->insert([
            'project_id' => $projectId,
            'project_status_id' => $request->input('status'),
            'stage_id' => $request->input('actions'),
            'notes' => $request->input('notes'),
            'success_rate' => '0',
            'date' => $request->input('date')
        ]);
        
            foreach ($rowsProducts as $key) {
                DB::table('task_products')->insert([
                    'task_id' => $taskId,
                    'product_id' => $key['ids'],
                    'price' => $key['prices'],
                    'm_currency' => $key['currencys'],
                    'minimum_order_qty' => $key['moqs'],
                    'order_qty' => $key['oqs'],
                    'status' => $key['status'],
                    'notes' => $key['notes'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        
        
            alert()->success('Success', 'Project Proposal Has Been Created');
            return to_route('proyek-all');
        } else if ($rowsProducts == null) {
            alert()->error('Error', 'Error Product not Fill');
            return to_route('proyek-all');
        }
    }

    public function updatePage(Request $request, $projectId)
    {
        $dataProduct = DB::table('products')
            ->leftJoin('task_products', 'products.id', 'task_products.product_id')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                'products.unit',
                'task_products.id as task_id',
                'task_products.task_id as task',
                'task_products.price',
                'task_products.m_currency',
                'task_products.minimum_order_qty',
                'task_products.order_qty'
            );
        $dataProjects = DB::table('projects')
            ->leftJoin('companies', 'projects.company_id', 'companies.id')
            ->leftJoin('company_pics', 'projects.company_pic_id', 'company_pics.id')
            ->leftJoin('users', 'projects.user_id', 'users.id')
            ->select(
                'projects.id',
                'projects.company_id',
                'projects.created_at',
                'companies.name as companyname',
                'company_pics.name as pic',
                'projects.company_pic_id',
                'projects.user_id',
                'users.username as salesname',
                'projects.name',
                'projects.description',
                'projects.status',
                'projects.file_upload'
            );
        $dataTasks = DB::table('tasks')
            ->select(
                'tasks.id',
                'tasks.project_id',
                'tasks.product_id',
                'tasks.success_rate'
            );
        $dataTasksDetail = DB::table('tasks_details')
            ->select(
                'task_details.id',
                'task_details.task_id',
                'task_details.task_action_id',
                'task_details.task_time',
                'task_details.notes'
            );

        $dataTasksProducts = DB::table('task_products')
            ->join('tasks as it', 'task_products.task_id', '=', 'it.id')
            ->join('projects as ip', 'it.project_id', '=', 'ip.id')
            ->join('products as ips', 'task_products.product_id', '=', 'ips.id')
            ->select(
                'task_products.id',
                'task_products.task_id',
                'task_products.product_id',
                'task_products.price',
                'task_products.m_currency',
                'task_products.minimum_order_qty as moq',
                'task_products.order_qty as oq',
                'task_products.status',
                'task_products.notes',
                'ips.name as product_name'
            )->where('ip.id', $projectId)->get();

        $dataTasksHistory = DB::table('task_history')
            ->select(
                'task_history.idrec',
                'task_history.project_id',
                'task_history.project_status_id',
                'task_history.stage_id',
                'task_history.notes',
                'task_history.success_rate'
            );

        $viewUpdate = DB::table('projects')
            ->leftJoin('companies', 'projects.company_id', 'companies.id')
            ->leftJoin('company_pics', 'projects.company_pic_id', 'company_pics.id')
            ->leftJoin('users', 'projects.user_id', 'users.id')
            ->leftJoin('tasks', 'projects.id', 'tasks.project_id')
            ->leftJoin('task_details', 'tasks.id', 'task_details.task_id')
            ->select(
                'projects.id as projectId',
                'projects.company_id',
                'projects.created_at',
                'companies.name as companyname',
                'company_pics.name as pic',
                'projects.company_pic_id',
                'projects.user_id',
                'users.username as salesname',
                'projects.name',
                'projects.description',
                'projects.status',
                'projects.file_upload',
                'tasks.id as tasksId',
                'tasks.success_rate as success',
                'task_details.task_action_id as stage',
                'task_details.notes',
                'task_details.task_time',
                'projects.date'
            )->where('projects.id', $projectId)->first();

        $histories = DB::table('task_history')
            ->join('task_actions', 'task_actions.id', 'task_history.stage_id')
            ->select(
                'task_history.*',
                'task_actions.name',
                DB::raw("
                case
                    when task_history.project_status_id = 0 then 'Pending'
                    when task_history.project_status_id = 1 then 'Open'
                    when task_history.project_status_id = 2 then 'Lost'
                    when task_history.project_status_id = 3 then 'Won'
                    else 'unknown status'
                end as status_name
                ")
            )
            ->where('project_id', $projectId)
            ->orderBy('date', 'desc')->get();

            $dataCurrency = DB::table('currency')
            ->select('*')->get();

        return view('pages.tasks.proyek.proyek-all.updatepage', compact('viewUpdate', 'dataTasksProducts', 'histories', 'dataCurrency'));
    }

    public function updateProduct(Request $request)
    {
        $productData = DB::table('products')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                'products.unit'
            );
        if ($request->ajax()) {
            return DataTables::of($productData)
                ->addColumn('action', function ($productData) {

                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_product="' . $productData->id . '"
                    data-nama_product="' . $productData->name . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function deleteProduct($taskproductId)
    {
        try {
            DB::table('task_products')->where('id', $taskproductId)->delete();
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted the data",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => $e,
            ]);
        }
    }
    
    public function proposalUpdate(Request $request, $projectId)
    {
        // return $request->all();
        $data = $request->all();

        if ($request->hasFile('file')) {
           $fileName = $request->file('file')->getClientOriginalName();
           $request->file('file')->move($this->saveImageUrl . 'proposal/', $fileName);
       } else {
           $fileName = null;
       }

        // data for update table projects
        $dataUpdatedProjects = [
            'name' => $data['project_name'],
            'description' => $data['desc'],
            'status' => $data['status'],
            'date' => $data['date'],
            'status' => $data['status'],
            'file_upload' => $fileName,
            'last_updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];



        // data for update table tasks
        $dataUpdatedTasks = [
            'success_rate' => $data['success'],
            'last_updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // data for update table task details
        $dataUpdatedTaskDetails = [
            'notes' => $data['notes'],
            'task_time' => $data['date'],
            'task_action_id' => $data['stage'],
            'last_updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // data tasks products
        $dataUpdatedTasksProducts = $data['rows'];

        // data for table tasks history
        $dataTasksHistory = [
            'project_id' => $projectId,
            'project_status_id' => $data['status'],
            'stage_id' => $data['stage'],
            'notes' => $data['notes'],
            'success_rate' => $data['success'],
            'date' => $data['date']
        ];

        // get task id by project id
        $taskId = DB::table('tasks')->where('project_id', $projectId)->pluck('id')->first();

        try {
            DB::transaction(function () use ($projectId, $taskId, $dataUpdatedProjects, $dataUpdatedTasks, $dataUpdatedTaskDetails, $dataUpdatedTasksProducts, $dataTasksHistory) {
                DB::table('projects')->where('id', $projectId)->update($dataUpdatedProjects);
                DB::table('tasks')->where('project_id', $projectId)->update($dataUpdatedTasks);
                DB::table('task_details')->where('task_id', $taskId)->update($dataUpdatedTaskDetails);

                DB::table('task_products')->where('task_id', $taskId)->delete();
                foreach ($dataUpdatedTasksProducts as $key => $value) {
                    DB::table('task_products')->insert([
                        'task_id' => $taskId,
                        'product_id' => $value['product_id'],
                        'price' => $value['price'],
                        'm_currency' => $value['m_currency'],
                        'minimum_order_qty' => $value['minimum_order_qty'],
                        'order_qty' => $value['order_qty'],
                        'status' => $value['status'],
                        'notes' => $value['notes'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }

                DB::table('task_history')->insert($dataTasksHistory);
            });

            alert()->success('Success', 'Proposal Has Been Updated');
            return to_route('proyek-all');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error('Error', 'Error Occurred');
            return to_route('proyek-all');
        }
    }

    public function createPic(Request $request){
        $pic = DB::table('company_pics')->insertGetId([
            'company_id' => $request->input('idCompany'),
            'name' => $request->input('name_pic'),
            'phone_number_1' => $request->input('phone_number_1'),
            'phone_number_2' => $request->input('phone_number_2'),
            'email' => $request->input('email'),
            'status' => '1',
            'last_updated_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($request) {
            alert()->success('Success', 'New PIC Has Been Added');
            return to_route('proyek.form');
        } else {
            alert()->error('Error', 'Error Occurred');
            return to_route('proyek.form');
        }
    }
    
}
