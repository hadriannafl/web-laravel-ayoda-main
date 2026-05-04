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

class GeneralAffairController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }

    public function purchase()
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

        return view('pages.purchasing.purchase-request.form', compact('dataChildCompany', 'dataDivision', 'department', 'subDepartment', 'dataCurrency'));
    }

    public function reimburse(Request $request)
    {
        $dataAsset = DB::table('inventory_assets')
        ->select('inventory_assets.idassets', 'inventory_assets.name', 'inventory_assets.unit', 'inventory_assets.category')->get();

        $dataVendor = DB::table('m_vendors')
        ->select('m_vendors.idsupplier', 'm_vendors.name')->get();

        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $dataType = DB::table('m_reimbursement_type')
        ->select('*')->orderBy('reimburse_type', 'asc')->where('status', '=', 'Active')->get();

        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
            // $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            // ->where('m_child_company.id_company', $user)->first();
        }

        $dataChildCompany2 = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();

        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        $dataVat = DB::table('m_vat')->orderBy('name_vat', 'asc')->get();

        $dataWht = DB::table('m_wht')->orderBy('name_wht', 'asc')->get();

        return view('pages.finance.reimburse-request.form', compact('dataAsset', 'dataVendor', 'dataCurrency', 'dataType', 'dataChildCompany', 'bank' , 'dataVat', 'dataWht', 'dataChildCompany2'));
    }

    public function purchaseList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.list.purchase-request', compact('dataChildCompany', 'department'));
    }

    public function purchaseListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.list.purchase-list-only', compact('dataChildCompany', 'department'));
    }

    public function purchaseUpdatePrice()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.list.update-price', compact('dataChildCompany', 'department'));
    }

    public function purchasePrintSubmit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.list.printedsubmit', compact('dataChildCompany', 'department'));
    }

    public function purchaseQuoSub()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.list.quotation', compact('dataChildCompany', 'department'));
    }

    public function reimburseListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.list.reimburse-list-only', compact('dataChildCompany', 'department'));
    }

    public function reimburseList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.list.reimburse-request', compact('dataChildCompany', 'department'));
    }

    public function printVoucher()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.printvoucher', compact('dataChildCompany', 'department'));
    }

    public function submitPaymentProved()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.uploadvoucher', compact('dataChildCompany', 'department'));
    }

    public function editPaymentProved()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.editvoucher', compact('dataChildCompany', 'department'));
    }

    public function purchaseApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.index', compact('dataChildCompany', 'department'));
    }

    public function purchaseApproval2()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.index2', compact('dataChildCompany', 'department'));
    }

    public function purchaseApproval3()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.purchase-approval.index3', compact('dataChildCompany', 'department'));
    }

    public function reimburseApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.index', compact('dataChildCompany', 'department'));
    }

    public function reimburseApproval2()
    {   
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.reimburse-approval.index2', compact('dataChildCompany', 'department'));
    }

    public function inventoryEdit()
    {        
        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubCategory = DB::table('m_subdepartment')->select('*')->where('status', '=', 'Active')->get();
        return view('pages.ga.office-inventory.asset-edit', compact('dataCategory', 'dataSubCategory'));
    }

    public function inventoryDeletePage()
    {
        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubCategory = DB::table('m_subdepartment')->select('*')->where('status', '=', 'Active')->get();
        return view('pages.ga.office-inventory.asset-delete', compact('dataCategory', 'dataSubCategory'));
    }

    public function inventoryUpdatePage($idAsset)
    {
        $dataInv = DB::table('inventory_assets')->select('*')->where('idassets', $idAsset)->first();

        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $dataRab = DB::table('m_rab_item')->select('m_rab_item.id_rab_item', 'm_rab_item.detail', 'm_rab_item.department', 'm_rab_item.status')
        ->where('m_rab_item.status', '=', 'Active')->get();

        $dataCoa = DB::table('m_coa')->select('*')->get();

        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $dataModel = DB::table('m_brand_model')->select('*')->where('p_id_brand', '=', '0')->where('status', '=', 'Active')->get();
        $idCompany = Auth::user()->company_id;
        $dataVendor = DB::table('inventory_assets_preferred_vendor')->leftJoin('m_vendors', 'inventory_assets_preferred_vendor.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_preferred_vendor.idassets', 'inventory_assets_preferred_vendor.id_company', 'inventory_assets_preferred_vendor.idsupplier', 
        'm_vendors.company_type', 'm_vendors.name')->where('inventory_assets_preferred_vendor.idassets', $idAsset)->where('inventory_assets_preferred_vendor.id_company', $idCompany)->first();

        return view('pages.ga.office-inventory.updatepageinv', compact('dataCurrency', 'dataRab', 'dataCoa', 'dataCategory', 'dataModel', 'dataInv', 'dataVendor'));
    }

    public function inventoryView($idAsset)
    {
        $dataInv = DB::table('inventory_assets')
        ->leftJoin('m_rab_item', 'inventory_assets.id_rab_item', 'm_rab_item.id_rab_item')->select('*')->where('idassets', $idAsset)->first();

        return view('pages.ga.office-inventory.view', compact('dataInv'));
    }

    public function inventory()
    {
        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubCategory = DB::table('m_subdepartment')->select('*')->where('status', '=', 'Active')->get();
        $dataCoa = DB::table('m_coa')->select('*')->get();
        return view('pages.ga.office-inventory.index', compact('dataCoa', 'dataCategory', 'dataSubCategory'));
    }

    public function inventoryOnly()
    {
        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubCategory = DB::table('m_subdepartment')->select('*')->where('status', '=', 'Active')->get();
        $dataCoa = DB::table('m_coa')->select('*')->get();
        return view('pages.ga.office-inventory.asset-list-only', compact('dataCoa', 'dataCategory', 'dataSubCategory'));
    }

    public function asset()
    {
        return view('pages.ga.asset-tracking.index');
    }

    public function anonymous()
    {
        return view('pages.ga.anonymous-report.index');
    }

    public function invAsset(Request $request)
    {
        $dataAssetQuery = DB::table('inventory_assets')
        ->leftJoin('t_rab_detail', 'inventory_assets.id_rab_item', 't_rab_detail.idrec')
        // ->leftJoin('inventory_assets_preferred_vendor', 'inventory_assets.idassets', 'inventory_assets_preferred_vendor.idassets')
        // ->leftJoin('m_vendors', 'inventory_assets_preferred_vendor.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets.idassets', 'inventory_assets.name', 'inventory_assets.unit', 'inventory_assets.category', 'inventory_assets.sub_category' , 'inventory_assets.aktifyn', 'inventory_assets.id_rab_item',
        't_rab_detail.total', 't_rab_detail.id_rab', 't_rab_detail.status', 't_rab_detail.date_rab')
        ->where('inventory_assets.aktifyn', '=', 'Y');

        if ($request->input('department') != null) {
            $dataAssetQuery = $dataAssetQuery->where('inventory_assets.id_dept', $request->department);
        }

        $dataAsset = $dataAssetQuery->orderBy('inventory_assets.idassets', 'asc');
        
        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->editColumn('total',function($dataAsset){
                return '' . number_format($dataAsset->total, 0, ',', '.');
            })
            ->addColumn('action', function ($dataAsset) {
                return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idassets . '"
                    data-nama="' . $dataAsset->name . '" data-budget="' . $dataAsset->total . '" data-unit="' . $dataAsset->unit . '" data-rab="' . $dataAsset->id_rab . '" data-category="' . $dataAsset->category . '" data-sub_category="' . $dataAsset->sub_category . '" id="select"
                >Select</button>';
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function purchaseAsset(Request $request)
    {
        $dataAssetQuery = DB::table('t_rab_detail')
        ->select('*')->where('t_rab_detail.status', '=', 'Active');

        if ($request->input('idRab') != null) {
            $dataAssetQuery = $dataAssetQuery->where('t_rab_detail.id_rab', $request->idRab);
        }

        $dataAsset = $dataAssetQuery->orderBy('t_rab_detail.idrec', 'asc');
        
        if ($request->ajax()) {
            return DataTables::of($dataAsset)
                ->addColumn('action', function ($dataAsset) {

                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idrec . '"
                    data-nama="' . $dataAsset->name_rab_detail . '" data-budget="' . $dataAsset->total . '" data-unit="' . $dataAsset->unit . '" data-rab="' . $dataAsset->id_rab . '" data-category="' . $dataAsset->category . '" data-sub_category="' . $dataAsset->sub_category . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function invBudget(Request $request)
    {
        $dataRab = DB::table('t_rab_detail')
        ->leftJoin('m_rab_item', 't_rab_detail.id_rab_item', 'm_rab_item.id_rab_item')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.created_at', 't_rab_detail.status', 't_rab_detail.total', 'm_rab_item.department', 'm_rab_item.sub_department', 'm_rab_item.detail', 'm_rab_item.coa'
        )->where('t_rab_detail.approvalstat', '=', 'Enforced');

        if ($request->ajax()) {
            return DataTables::of($dataRab)
                ->editColumn('total',function($dataRab){
                    return '' . number_format($dataRab->total, 0, ',', '.');
                })

                ->addColumn('action', function ($dataRab) {
                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataRab->idrec . '"
                    data-nama="' . $dataRab->sub_department . '" data-department="' . $dataRab->department . '" data-coa="' . $dataRab->coa . '"
                    data-detail="' . $dataRab->detail . '" data-id_rab="' . $dataRab->id_rab . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function devAddress(Request $request)
    {
        $dataAddressQuery = DB::table('m_site_warehouse')->leftJoin('m_child_company', 'm_site_warehouse.id_company', 'm_child_company.id_company')
        ->select('m_site_warehouse.id_warehouse', 'm_site_warehouse.w_name', 'm_site_warehouse.w_address', 'm_site_warehouse.w_city', 'm_site_warehouse.w_province',
        'm_site_warehouse.w_country', 'm_site_warehouse.w_zipcode', 'm_site_warehouse.w_pic', 'm_site_warehouse.w_phone', 'm_site_warehouse.status', 'm_child_company.name', 'm_child_company.id_company')->where('m_site_warehouse.status', '=', 'ACTIVE'); 

        if ($request->input('company2') != null){
            $dataAddressQuery = $dataAddressQuery->where('m_site_warehouse.id_company', $request->company2);
        }

        if ($request->input('company') != null){
            $dataAddressQuery = $dataAddressQuery->where('m_site_warehouse.id_company', $request->company);
        }

        $dataAddress = $dataAddressQuery;
        
        if ($request->ajax()) {
            return DataTables::of($dataAddress)
                ->addColumn('action', function ($dataAddress) {

                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAddress->id_warehouse . '"
                    data-address="' . $dataAddress->w_address . '" data-city="' . $dataAddress->w_city . '" data-province="' . $dataAddress->w_province . '" data-country="' . $dataAddress->w_country . '" 
                    data-zip_code="' . $dataAddress->w_zipcode . '" data-pic="' . $dataAddress->w_pic . '" data-phone="' . $dataAddress->w_phone . '" data-wname="' . $dataAddress->w_name . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function reimburseType()
    {
        return view('pages.ga.data-master.m-reimbursetype.m-reimtype');
    }
    public function reimburseTypeList()
    {
        return view('pages.ga.data-master.m-reimbursetype.list');
    }
    public function reimburseTypeForm()
    {
        return view('pages.ga.data-master.m-reimbursetype.m-reimtype-form');
    }
    public function reimburseTypeEdit()
    {
        return view('pages.ga.data-master.m-reimbursetype.m-reimtype-edit');
    }
    public function reimburseTypeDelete()
    {
        return view('pages.ga.data-master.m-reimbursetype.m-reimtype-delete');
    }

    public function typeCreate(Request $request)
    {        
        $reimType = $request->input('type');
        $dataReimType = DB::table('m_reimbursement_type')->where('reimburse_type', $reimType)->pluck('reimburse_type')->first();
        if ($dataReimType == null) {
            DB::table('m_reimbursement_type')->insert([
                'reimburse_type' => $request->input('type'),
                'coa' => $request->input('coa'),
                'add_by' => Auth::user()->username,
                'status' => 'Active',
                'created_at' => date('Y-m-d'),
                'created_by' => Auth::user()->username
            ]);
    
            alert()->success('Success', 'Reimburse Type Has Been Created');
            return to_route('reimburse-type.form');
        } else {
            alert()->error('Error', 'Reimburse Type Already Exist');
            return to_route('reimburse-type.form');
        }
    }

    public function purchaseCreate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('date');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/PR/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('inventory_assets_request')
            ->where('idreqform', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $PRID = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->idreqform;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $PRID = $indicator . $countIndicator;
        }

        $date = $request->input('idRab');

        $date1 = DB::table('t_rab')->where('t_rab.id_rab', $date)->pluck('date_rab')->first();

        $rowsProducts = $request->get('rows');
        $rowsProducts1 = $request->get('rows1');

        try {
            if (!empty($rowsProducts) || !empty($rowsProducts1)) {
                if ($request->input('req') >= $request->input('date')) {
                        DB::transaction(function () use ($rowsProducts, $rowsProducts1, $request, $PRID){
                            DB::table('inventory_assets_request')->insert([
                                'idreqform' => $PRID,
                                'pr_title' => $request->input('pr_title'),
                                'id_rab' => $request->input('idRab'),
                                'pr_date' => date($request->input('date')),
                                'prepared_date' => date($request->input('date')),
                                'rab_date' => date('Y-m-t', strtotime($request->input('period'))),
                                'applicant' => $request->input('name'),
                                'company_id' => $request->input('company'),
                                'currency' => $request->input('currency'),
                                'payment_by' => $request->input('payment_by'),
                                'department' => $request->input('departs'),
                                // 'approved1by' => $approvalTo,
                                'reqlevel' => $request->input('level'),
                                'delivery_date' => date($request->input('req')),
                                'note' => $request->input('notes'),
                                // 'idsupplier' => $request->input('vendor1'),
                                'id_warehouse' => $request->input('id_warehouse'),
                                'pic' => $request->input('pic'),
                                'phone' => $request->input('phone'),
                                'delivery_address' => $request->input('address'),
                                'city' => $request->input('city'),
                                'province' => $request->input('province'),
                                'country' => $request->input('country'),
                                'zip_code' => $request->input('zip_code'),
                                'gtotal' => $request->input('grandtotal1'),
                                'balance' => $request->input('grandtotal1'),
                                'approvalstat' => 'Draft',
                                'price_updated' => 'N',
                                'print_status' => 'N',
                                'created_at' => date('Y-m-d'),
                                'created_by' => Auth::user()->id
                            ]);
                            if (!empty($rowsProducts)) {
                                foreach ($rowsProducts as $key) {
                                    $trabDetailBalance = DB::table('t_rab_detail')
                                    ->where('id_rab', $request->input('idRab'))
                                    ->where('id_rab_item', $key['ids'])
                                    ->pluck('balance')
                                    ->first();
                                    if ($trabDetailBalance <= 0) {
                                        alert()->error('Error', 'One of purchase detail balance not enough');
                                        return to_route('purchase-requestga');
                                    }
                                    $newBalance = $trabDetailBalance - $key['totals'];
                                    DB::table('inventory_assets_request_detail')->insert([
                                        'idreqform' => $PRID,
                                        'id_rab' => $request->input('idRab'),
                                        'idassets' => $key['ids'],
                                        'qty' => $key['qtys'],
                                        'unit' => $key['units'],
                                        'price' => $key['prices'],
                                        'total' => $key['totals'],
                                        'balance' => $key['totals'],
                                        'balance_rab' => $newBalance,
                                        'remarks' => $key['remarkss'],
                                        // 'idsupplier' => $request->input('vendor1'),
                                        'status' => 'Active',
                                        'created_at' => date('Y-m-d')
                                    ]);
                                    DB::table('t_rab_detail')
                                    ->where('id_rab', $request->input('idRab'))
                                    ->where('id_rab_item', $key['ids'])
                                    ->update(['balance' => $newBalance]);
                                }
                            }
                            if (!empty($rowsProducts1)) {
                                foreach ($rowsProducts1 as $key) {
                                    $trabDetailBalance = DB::table('t_rab_detail')
                                    ->where('id_rab', $request->input('idRab'))
                                    ->where('id_rab_item', $key['ids'])
                                    ->pluck('balance')
                                    ->first();
                                    if ($trabDetailBalance <= 0) {
                                        alert()->error('Error', 'One of purchase detail balance not enough');
                                        return to_route('purchase-requestga');
                                    }
                                    $newBalance = $trabDetailBalance - $key['totals'];
                                    DB::table('inventory_assets_request_detail')->insert([
                                        'idreqform' => $PRID,
                                        'id_rab' => $request->input('idRab'),
                                        'idassets' => $key['ids'],
                                        'qty' => $key['qtys'],
                                        'unit' => $key['units'],
                                        'price' => $key['prices'],
                                        'total' => $key['totals'],
                                        'balance' => $key['totals'],
                                        'balance_rab' => $newBalance,
                                        'remarks' => $key['remarkss'],
                                        // 'idsupplier' => $request->input('vendor1'),
                                        'status' => 'Active',
                                        'created_at' => date('Y-m-d')
                                    ]);
                                    DB::table('t_rab_detail')
                                    ->where('id_rab', $request->input('idRab'))
                                    ->where('id_rab_item', $key['ids'])
                                    ->update(['balance' => $newBalance]);
                                }
                            }
                        });
                } else {
                    alert()->error('Error', 'Delivery Date cannot before Form Date');
                    return to_route('purchase-requestga');
                }
                alert()->success('Success', 'PR #' . $PRID . ' Has Been Created');
                return to_route('purchase-list');
            } else {
                alert()->error('Error', 'Asset Inventory Not Fill');
                return to_route('purchase-requestga');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function reimburseCreate(Request $request)
    {
            $company = $request->input('companyId');
            $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
            $initials = $initials ? $initials->initials : null;

            if (!$initials) {
                // Tangani kasus jika $initials tidak ditemukan
            }

            $dateInput = $request->input('date');
            $mm = date('m', strtotime($dateInput));
            $yearNow = date('Y', strtotime($dateInput));
            $yearNowSubstring = substr($yearNow, -2);

            $indicator = $yearNowSubstring . $mm . '/' . $initials . '/RR/';

            // Lakukan kueri untuk mencari nilai maksimal
            $maxIdRecord = DB::table('t_reimburse_request')
                ->where('idreqform', 'like', $indicator . '%')
                ->orderBy('idrec', 'desc')
                ->first();

            if (is_null($maxIdRecord)) {
                $RRID = $indicator . '1';
            } else {
                $maxId = $maxIdRecord->idreqform;
                $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

                // Periksa apakah bulan telah berubah
                if (date('m', strtotime($dateInput)) != $mm) {
                    // Jika bulan berubah, reset nomor berjalan ke 1
                    $countIndicator = 1;
                    $mm = date('m', strtotime($dateInput));
                } else {
                    // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    $countIndicator = $lastRunningNumber + 1;
                }

                $RRID = $indicator . $countIndicator;
            }

            $rowsProducts = $request->get('rows');
            if (isset($rowsProducts[0]['subtotals']) && $rowsProducts[0]['subtotals'] == '0') {
                return response()->json(["st" => '4']);
            }
            if ($request->hasFile('file45')) {
                $filePdf = $request->file('file45');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File to Large, Please compress File');
                    return response()->json(["st" => '2']);
                }
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
               $pdf = null;
            }
            $datereq = date($request->input('date'));
            $monthreq = date('Y-m-d', strtotime($datereq . "+1 month"));

            $crate1 = str_replace('.', '', $request->input('crate'));
            $crate = str_replace(',', '.', $crate1);
            try {
                if ($filePdf === null) {
                    return response()->json(["st" => '2']);
                }
                if (!empty($rowsProducts) && $request->input('grandtotal1') != '0') {
                    DB::transaction(function () use ($rowsProducts, $pdf, $request, $RRID, $company, $datereq, $monthreq, $crate){
                        DB::table('t_reimburse_request')->insert([
                            'idreqform' => $RRID,
                            'datereq' => $datereq,
                            'due_date' => $monthreq,
                            'applicant' => $request->input('employee'),
                            'company_name' => $request->input('company'),
                            'department' => $request->input('department'),
                            'position' => $request->input('division'),
                            'id_company' => $company,
                            'id_company2' => $request->input('companyId'),
                            'currency' => $request->input('currency'),
                            'crate' => $crate,
                            'bank_account' => $request->input('bank'),
                            'number_account' => $request->input('number'),
                            'name_account' => $request->input('account'),
                            'note' => $request->input('notes'),
                            'subtotal' => $request->input('subtotal1'),
                            'total_vat' => $request->input('gtotal_vat'),
                            'total' => $request->input('total1'),
                            'total_wht' => $request->input('gtotal_wht'),
                            'gtotal' => $request->input('grandtotal1'),
                            'reimburse_file' => $pdf,
                            'approvalstat' => 'Draft',
                            'approval1_status' => 'Draft',
                            'approval2_status' => 'Draft',
                            'prepared_by' => Auth::user()->username,
                            'print_status' => 'N',
                            'created_at' => date('Y-m-d'),
                            'created_by' => Auth::user()->id
                        ]);
                        foreach ($rowsProducts as $key) {
                            DB::table('t_reimburse_request_detail')->insert([
                                'idreqform' => $RRID,
                                'date' => $key['dates'],
                                'no_vehicle' => $key['plates'],
                                'reimburse_to' => $key['reimburses'],
                                'type' => $key['types'],
                                'subtotal' => $key['subtotals'],
                                'vat' => $key['vats'],
                                'vat_percent' => $key['vat_percents'],
                                'total_vat' => $key['total_vats'],
                                'total' => $key['totals'],
                                'wht' => $key['whts'],
                                'wht_percent' => $key['wht_percents'],
                                'norma' => $key['normas'],
                                'total_wht' => $key['total_whts'],
                                'paid_total' => $key['gtotals'],
                                'previous_payment' => $key['gtotals'],
                                'remarks' => $key['remarkss'],
                                'status' => 'Active',
                            ]);
                        }
                    });
                    alert()->success('Success', 'Reimburse #' . $RRID . ' Has Been Created');
                    return response()->json(["st" => '1', "id"=>$RRID]);
                } else {
                    alert()->error('Error', 'Reimburse Request Not Sent/Reimburse Detail Must Fill');
                    return response()->json(["st" => '3']);
                }
                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
            }
    }

    public function typeGetData(Request $request)
    {
        $dataType = DB::table('m_reimbursement_type')
        ->select('*')->orderBy('id', 'desc')->where('status', '=', 'Active'); 

        if ($request->ajax()) {
            return DataTables::of($dataType)
            ->addColumn('action', function ($dataType) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataType->id.'"
                                data-type = "' . $dataType->reimburse_type . '" data-coa = "' . $dataType->coa . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Reimbursement Type</div>
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
            ->addColumn('action1', function ($dataType) {
                return '
                <div class="flex flex-row"> 
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataType->id.'" data-type = "' . $dataType->reimburse_type . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function typeUpdate(Request $request, $id)
    {
        $reimType = $request->input('type1');
        $dataReimType = DB::table('m_reimbursement_type')->where('reimburse_type', $reimType)->pluck('reimburse_type')->first();
        if ($dataReimType == null) {
            DB::table('m_reimbursement_type')->where('id', $id)->update([
                'reimburse_type' => $request->input('type1'),
                'coa' => $request->input('coa1'),
                'updated_by' => Auth::user()->username,
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Reimburse Type Has Been Updated');
            return to_route('reimburse-type.edit');
        } else {
            alert()->error('Error', 'Reimburse Type Already Exist');
            return to_route('reimburse-type.edit');
        }
    }

    public function typeDelete($id)
    {
        try {
            DB::table('m_reimbursement_type')->where('id', $id)->update([
                'status' => 'Non Active',
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->username
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Reimbursement Type",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function purchaseApprove1(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataUser = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
            // $dataUser = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'users.company_id', 'users.username')->where('users.company_id', $userByCompany)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.purchasing.purchase-approval.approval1', compact('dataPR', 'PRDetail', 'dataUser'));
    }

    public function purchaseApproved1Page(Request $request, $idPR)
    {
        $token = $request->input('token');

        $checkToken = DB::table('pr_approve1_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        $dataUser = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();

        return view('pr_approval1page', compact('dataPR', 'PRDetail', 'dataUser'));
    }

    public function purchaseApprove2(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataUser = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
            // $dataUser = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'users.company_id', 'users.username')->where('users.company_id', $userByCompany)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.purchasing.purchase-approval.approval2', compact('dataPR', 'PRDetail', 'dataUser'));
    }

    public function purchaseApproved2Page(Request $request, $idPR)
    {
        $token = $request->input('token');

        $checkToken = DB::table('pr_approve2_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        $dataUser = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();

        return view('pr_approval2page', compact('dataPR', 'PRDetail', 'dataUser'));
    }

    public function purchaseApprove3(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        return view('pages.purchasing.purchase-approval.approval3', compact('dataPR', 'PRDetail'));
    }

    public function purchaseApproved3Page(Request $request, $idPR)
    {
        $token = $request->input('token');

        $checkToken = DB::table('pr_approve3_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('inventory_assets', 'inventory_assets_request_detail.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets.name', 'inventory_assets.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)->where('inventory_assets_request_detail.status', '=', 'Active')->orderBy('inventory_assets_request_detail.id', 'asc')->get();

        return view('pr_approval3page', compact('dataPR', 'PRDetail'));
    }

    public function purchaseUpdateStatus (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $approvalTo = $dataPR->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $token = (string)Str::uuid();
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();

        if ($approvalstat == 'Waiting Approval 1' or $approvalstat == 'HQ 1 Approved') {
            if ($status == 'Approved') {
                DB::table('pr_approve2_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('purchase.approve2page', [
                        'idPR' => $idPR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approval2', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - PR Approval 2');
                });
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 1 Approved',
                    'approvaldate' => date('Y-m-d'),
                    'remarks1' => $request->input('remarks1'),
                    'quotation_approval1' => $request->input('quotation_approval1'),
                    'approved1by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase-approvalga');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => Auth::user()->username,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 1 Denied');
                });
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 1 Denied',
                    'approvaldate' => date('Y-m-d'),
                    'remarks1' => $request->input('remarks1'),
                    'approved1by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase-approvalga');
            }
        } else {
            alert()->error('Error', 'Purchase Request status is HQ 2 Approved');
            return to_route('purchase-approvalga');
        }
    }

    public function purchaseApproved1 (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $approvedBy = DB::table('users')->where('id', $dataPR->approval_to)->pluck('username')->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $approvalTo = $dataPR->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $token = (string)Str::uuid();
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token1 = $request->input('token');

        if ($approvalstat == 'Waiting Approval 1' or $approvalstat == 'HQ 1 Approved') {
            if ($status == 'Approved') {
                DB::table('pr_approve2_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('purchase.approve2page', [
                        'idPR' => $idPR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approval2', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - PR Approval 2');
                });
                DB::table('pr_approve1_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 1 Approved',
                    'approvaldate' => date('Y-m-d'),
                    'remarks1' => $request->input('remarks1'),
                    'quotation_approval1' => $request->input('quotation_approval1'),
                    'approved1by' => $approvedBy,
                    'updated_at' => date('Y-m-d')
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase.approve1page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => $approvedBy,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 1 Denied');
                });
                DB::table('pr_approve1_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 1 Denied',
                    'approvaldate' => date('Y-m-d'),
                    'remarks1' => $request->input('remarks1'),
                    'approved1by' => $approvedBy,
                    'updated_at' => date('Y-m-d')
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase.approve1page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
            }
        } else {
            alert()->error('Error', 'Purchase Request status is HQ 2 Approved');
            return to_route('purchase.approve1page', [
                'idPR' => $idPR,
                'token' => $token1
            ]);
        }
    }

    public function purchaseUpdateStatus2 (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $approvalTo = $dataPR->approval3_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $token = (string)Str::uuid();
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();

        if ($approvalstat == 'HQ 1 Approved') {
            if ($status == 'Approved') {
                DB::table('pr_approve3_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('purchase.approve3page', [
                        'idPR' => $idPR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approval3', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - PR Approval 3');
                });
                $updatePO = DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 2 Approved',
                    'reviewed_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'quotation_approval2' => $request->input('quotation_approval2'),
                    'approved2by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase-approvalga2');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => Auth::user()->username,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 2 Denied');
                });
                $updatePO = DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 2 Denied',
                    'reviewed_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'approved2by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase-approvalga2');
            }
        }else {
            alert()->error('Error', 'Purchase Request Already Approved/Denied');
            return to_route('purchase-approvalga2');
        }
    }

    public function purchaseApproved2 (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $approvedBy = DB::table('users')->where('id', $dataPR->approval2_to)->pluck('username')->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $approvalTo = $dataPR->approval3_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $token = (string)Str::uuid();
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token1 = $request->input('token');

        if ($approvalstat == 'HQ 1 Approved') {
            if ($status == 'Approved') {
                DB::table('pr_approve3_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('purchase.approve3page', [
                        'idPR' => $idPR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approval3', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - PR Approval 3');
                });
                DB::table('pr_approve2_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 2 Approved',
                    'reviewed_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'quotation_approval2' => $request->input('quotation_approval2'),
                    'approved2by' => $approvedBy,
                    'updated_at' => date('Y-m-d')
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase.approve2page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => $approvedBy,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 2 Denied');
                });
                DB::table('pr_approve2_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 2 Denied',
                    'reviewed_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'approved2by' => $approvedBy,
                    'updated_at' => date('Y-m-d')
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase.approve2page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
            }
        } else {
            alert()->error('Error', 'Purchase Request Already Approved/Denied');
            return to_route('purchase.approve2page', [
                'idPR' => $idPR,
                'token' => $token1
            ]);
        }
    }
    
    public function purchaseUpdateStatus3 (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();

        if ($approvalstat == 'HQ 2 Approved') {
            if ($status == 'Approved') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => Auth::user()->username,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approved', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approved');
                });
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 3 Approved',
                    'approved_date' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'quotation_approval3' => $request->input('quotation_approval3'),
                    'approved3by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase-approvalga3');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => Auth::user()->username,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 3 Denied');
                });
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'approved_date' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase-approvalga3');
            }
        }else {
            alert()->error('Error', 'Purchase Request Already Approved/Denied');
            return to_route('purchase-approvalga3');
        }
    }

    public function purchaseApproved3 (Request $request, $idPR)
    {
        $status = $request->input('status');
        $dataPR = DB::table('inventory_assets_request')->where('idrec', $idPR)->first();
        $approvedBy = DB::table('users')->where('id', $dataPR->approval3_to)->pluck('username')->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        $email1 = DB::table('users')->where('id', $dataPR->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token1 = $request->input('token');

        if ($approvalstat == 'HQ 2 Approved') {
            if ($status == 'Approved') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => $approvedBy,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approved', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approved');
                });
                DB::table('pr_approve3_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 3 Approved',
                    'approved_date' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'quotation_approval3' => $request->input('quotation_approval3'),
                    'approved3by' => $approvedBy,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Approved');
                return to_route('purchase.approve3page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'approvedby' => $approvedBy,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject('' . $datacomps->name . ' - PR Approval HQ 3 Denied');
                });
                DB::table('pr_approve3_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('inventory_assets_request')
                ->where('idrec', $idPR)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'approved_date' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3by' => $approvedBy,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                alert()->success('Success', 'Purchase Request Has Been Denied');
                return to_route('purchase.approve3page', [
                    'idPR' => $idPR,
                    'token' => $token1
                ]);
            }
        }else {
            alert()->error('Error', 'Purchase Request Already Approved/Denied');
            return to_route('purchase.approve3page', [
                'idPR' => $idPR,
                'token' => $token1
            ]);
        }
    }

    public function purchaseGetApproval(Request $request)
    {
        $user = Auth::user()->id;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel', 'inventory_assets_request.approval_to', 'inventory_assets_request.approval2_to', 'inventory_assets_request.approval3_to',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        );
        if ($request->input('status') != 'No'){
            $dataPurchaseRequestQuery->where(function ($query) use ($user) {
                $query->where('inventory_assets_request.approvalstat', '=', 'Waiting Approval 1')
                    ->orWhere('inventory_assets_request.approvalstat', '=', 'HQ 1 Approved')
                    ->where('inventory_assets_request.approval_to', $user);
            });
        }else if ($request->input('status') != 'Yes'){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
            } else {
                $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', '=', Auth::user()->company_id);
            }
        }
        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) use ($user) {
                if ($dataPurchaseRequest->approvalstat == 'Waiting Approval 1' && $dataPurchaseRequest->approval_to == $user || $dataPurchaseRequest->approvalstat == 'HQ 1 Approved' && $dataPurchaseRequest->approval_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">  
                    <a href = "/purchasing/purchase-approval/approve1/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                    >View</a>
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataPurchaseRequest->idrec.'"
                    >Cancel</button>
                    </div>';
                }else {
                    return '
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    ';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function purchaseGetApproval2(Request $request)
    {
        $user = Auth::user()->id;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel', 'inventory_assets_request.approval_to', 'inventory_assets_request.approval2_to', 'inventory_assets_request.approval3_to',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        );

        if ($request->input('status') != 'No'){
            $dataPurchaseRequestQuery->where(function ($query) use ($user) {
                $query->where('inventory_assets_request.approval2_to', $user)
                ->where('inventory_assets_request.approvalstat', '=', 'HQ 1 Approved');
            });
        }else if ($request->input('status') != 'Yes'){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
            } else {
                $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', '=', Auth::user()->company_id);
            }
        }
        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) use ($user) {
                if ($dataPurchaseRequest->approvalstat == 'HQ 1 Approved' && $dataPurchaseRequest->approval2_to == $user) {
                    return '
                    <a href = "/purchasing/purchase-approval2/approve2/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                    >View</a>';
                }else {
                    return '
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>';
                }
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function purchaseGetApproval3(Request $request)
    {
        $user = Auth::user()->id;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel', 'inventory_assets_request.approval_to', 'inventory_assets_request.approval2_to', 'inventory_assets_request.approval3_to',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        );

        if ($request->input('status') != 'No'){
            $dataPurchaseRequestQuery->where(function ($query) use ($user) {
                $query->where('inventory_assets_request.approval3_to', $user)
                ->where('inventory_assets_request.approvalstat', '=', 'HQ 2 Approved');
            });
        }else if ($request->input('status') != 'Yes'){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
            } else {
                $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', '=', Auth::user()->company_id);
            }
        }
        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }
        // ->whereColumn('inventory_assets_request.quotation_approval1', '=', 'inventory_assets_request.quotation_approval2')
        $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) use ($user) {
                if ($dataPurchaseRequest->approvalstat == 'HQ 2 Approved' && $dataPurchaseRequest->approval3_to == $user) {
                    return '
                    <a href = "/purchasing/purchase-approval3/approve3/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                    >View</a>';
                }else {
                    return '
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>';
                }
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function reimburseGetApproval(Request $request)
    {
        $approvalTo = Auth::user()->id;
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        // ->join('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as companyName'
        );

        if ($request->input('company') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.id_company', $request->company);
        }
        if ($request->input('department') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.approvalstat', $request->department)->where('t_reimburse_request.approval_to', $approvalTo);
        }else if ($request->input('department') == null){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataReimburseRequest = $dataReimburseRequestQuery->orderBy('t_reimburse_request.idreqform', 'desc');
            } else {
                $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.approval_to', $approvalTo);
            }
        }
        $dataReimburseRequest = $dataReimburseRequestQuery->orderBy('t_reimburse_request.idreqform', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->editColumn('employee', function ($dataReimburseRequest) {
                return $dataReimburseRequest->employee . ' ' . $dataReimburseRequest->last_name;
            })
            ->editColumn('gtotal', function ($dataReimburseRequest) {
                return "" . number_format($dataReimburseRequest->gtotal, 0, ',', '.' . " ");
            })
            ->addColumn('label', function ($dataReimburseRequest) {

                $status = ($dataReimburseRequest->approval1_status);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Waiting Approval 1') {
                    $color = "yellow";
                } else if ($status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataReimburseRequest) use ($approvalTo) {
                if ($dataReimburseRequest->approvalstat == 'Waiting Approval 1' && $dataReimburseRequest->approval_to == $approvalTo) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/approve1/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataReimburseRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                } else if($dataReimburseRequest->approvalstat == 'HQ 1 Approved' && $dataReimburseRequest->approval_to == $approvalTo) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataReimburseRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if($dataReimburseRequest->approvalstat == 'Payment Proof' || $dataReimburseRequest->approvalstat == 'Form Printed' || $dataReimburseRequest->approvalstat == 'Draft' || $dataReimburseRequest->approvalstat == 'Waiting Approval 1' || $dataReimburseRequest->approvalstat == 'HQ 1 Approved' || $dataReimburseRequest->approvalstat == 'HQ 1 Denied' || $dataReimburseRequest->approvalstat == 'HQ 2 Denied' || $dataReimburseRequest->approvalstat == 'Canceled' || $dataReimburseRequest->approvalstat == 'Complete') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function reimburseGetApproval2(Request $request)
    {
        $approvalTo = Auth::user()->id;
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as companyName'
        );

        if ($request->input('company') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.id_company', $request->company);
        }
        if ($request->input('department') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.approvalstat', $request->department)->where('t_reimburse_request.approval2_to', $approvalTo);
        }else if ($request->input('department') == null){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataReimburseRequest = $dataReimburseRequestQuery->orderBy('t_reimburse_request.idreqform', 'desc');
            } else {
                $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.approval2_to', $approvalTo);
            }
        }
        $dataReimburseRequest = $dataReimburseRequestQuery->orderBy('t_reimburse_request.idreqform', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->editColumn('employee', function ($dataReimburseRequest) {
                return $dataReimburseRequest->employee . ' ' . $dataReimburseRequest->last_name;
            })
            ->editColumn('gtotal', function ($dataReimburseRequest) {
                return "" . number_format($dataReimburseRequest->gtotal, 0, ',', '.' . " ");
            })
            ->addColumn('label', function ($dataReimburseRequest) {

                $status = ($dataReimburseRequest->approval2_status);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Waiting Approval 1') {
                    $color = "yellow";
                } else if ($status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataReimburseRequest) use ($approvalTo) {
                if ($dataReimburseRequest->approvalstat == 'HQ 1 Approved' && $dataReimburseRequest->approval2_to == $approvalTo) {
                    return '
                    <div class="flex flex-row justify-center">           
                        <a href = "/ga/reimburse-approval2/approve2/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                } else{
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function purchaseListGetData(Request $request)
    {
        $user = Auth::user()->id;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        );

        if ($request->input('status') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataPurchaseRequest = $dataPurchaseRequestQuery;
        } else {
            $dataPurchaseRequest = $dataPurchaseRequestQuery->where('inventory_assets_request.created_by', $user);
        }

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'PR Printed' || $status == 'Price Updated' || $status == 'Waiting Quotation') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Quotation Submitted' || $status == 'HQ 1 Approved' || $status == 'HQ 2 Approved' || $status == 'Waiting Approval 1') {
                    $color = "yellow";
                } else if ($status == 'HQ 3 Approved') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'HQ 3 Denied'|| $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })

            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) {
                if ($dataPurchaseRequest->approvalstat == 'Draft' && $dataPurchaseRequest->print_status == 'N' && $dataPurchaseRequest->price_updated == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <a href = "/purchasing/purchase-approval/list/updatepage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"   
                        >Edit</a>

                        <a href = "/purchasing/purchase-approval/list/clonepage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Clone</a>
                    </div>';
                }elseif ($dataPurchaseRequest->approvalstat == 'PR Printed' && $dataPurchaseRequest->print_status == 'Y' || $dataPurchaseRequest->approvalstat == 'Waiting Approval 1' || $dataPurchaseRequest->approvalstat == 'Quotation Submitted' || $dataPurchaseRequest->approvalstat == 'Canceled' || 
                $dataPurchaseRequest->approvalstat == 'Waiting Quotation' || $dataPurchaseRequest->approvalstat == 'HQ 1 Approved' || $dataPurchaseRequest->approvalstat == 'HQ 1 Denied' || $dataPurchaseRequest->approvalstat == 'HQ 2 Approved' || $dataPurchaseRequest->approvalstat == 'HQ 2 Denied'
                || $dataPurchaseRequest->approvalstat == 'HQ 3 Denied' || $dataPurchaseRequest->approvalstat == 'Price Updated') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>

                    <a href = "/purchasing/purchase-approval/list/clonepage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >Clone</a>
                    </div>';
                }elseif ($dataPurchaseRequest->approvalstat == 'HQ 3 Approved') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataPurchaseRequest) {
                return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    </div>';
            })
            ->rawColumns(['action', 'action1', 'label'])
            ->make();
        }
    }

    public function purchaseListGetPrice(Request $request)
    {
        $applicant = Auth::user()->username;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
            ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
            ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
            ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
            ->select(
                'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
                'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
                'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel',
                'm_child_company.name as companyName',
                'm_department.name as departmentName',
                'm_vendors.name as vendorsName'
            )->where(function ($query) {
                $query->where('inventory_assets_request.approvalstat', '=', 'Draft')
                    ->orWhere('inventory_assets_request.approvalstat', '=', 'Price Updated');
            });

        // if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        //     $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
        // }

        // if (Auth::user()->username == $applicant) {
        //     $dataPurchaseRequestQuery->where('inventory_assets_request.applicant', $applicant);
        // }

        if ($request->input('company') != null) {
            $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }

        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        $result = $dataPurchaseRequestQuery->get();

        $dataPurchaseRequest = $result;

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved' || $status == 'Quotation Submitted' || $status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Waiting for Quotation') {
                    $color = "green";
                } else if ($status == 'Site Denied' || $status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'HQ 3 Denied'|| $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })

            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) {
                return '
                <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>

                    <a href = "/purchasing/purchase-approval/list/priceupdate/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1"    
                    >Update Price</a>
                </div>';
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function purchaseListGetPrintSubmit(Request $request)
    {
        $applicant = Auth::user()->username;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        )->where(function ($query) {
            $query->where('inventory_assets_request.approvalstat', '=', 'Price Updated')->orWhere('inventory_assets_request.approvalstat', '=', 'PR Printed')->orWhere('inventory_assets_request.approvalstat', '=', 'Waiting Quotation')
            ->orWhere('inventory_assets_request.approvalstat', '=', 'Canceled');
        });

        // if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        //     $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
        // }

        // if (Auth::user()->username == $applicant) {
        //     $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.applicant', $applicant);
        // }

        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        $result = $dataPurchaseRequestQuery->get();

        $dataPurchaseRequest = $result;

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved' || $status == 'Quotation Submitted' || $status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Waiting for Quotation') {
                    $color = "green";
                } else if ($status == 'Site Denied' || $status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'HQ 3 Denied'|| $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })

            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) {
                if ($dataPurchaseRequest->approvalstat == 'Price Updated') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <a href = "/purchasing/purchase-approval/list/signature/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print</a>
                    </div>';
                }elseif ($dataPurchaseRequest->approvalstat == 'PR Printed' && $dataPurchaseRequest->print_status == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>

                    <a href = "/purchasing/purchase-approval/list/submitpage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                    >Submit PR</a>
                    
                    <a href = "/purchasing/purchase-approval/list/print/' . $dataPurchaseRequest->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >Print</a>
                    </div>';
                }elseif ($dataPurchaseRequest->approvalstat == 'Waiting Quotation'){
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataPurchaseRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if ($dataPurchaseRequest->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function purchaseListGetQuotation(Request $request)
    {
        $applicant = Auth::user()->username;
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.idrec', 'inventory_assets_request.pr_date', 'inventory_assets_request.delivery_date', 'inventory_assets_request.idreqform', 'inventory_assets_request.pr_title', 'inventory_assets_request.company_id',
            'inventory_assets_request.department', 'inventory_assets_request.applicant', 'inventory_assets_request.approvalstat', 'inventory_assets_request.approvaldate', 'inventory_assets_request.print_status', 'inventory_assets_request.price_updated',
            'inventory_assets_request.gtotal', 'inventory_assets_request.reqlevel',
            'm_child_company.name as companyName',
            'm_department.name as departmentName',
            'm_vendors.name as vendorsName'
        )->where(function ($query) {
            $query->where('inventory_assets_request.approvalstat', '=', 'Waiting Quotation')->orWhere('inventory_assets_request.approvalstat', '=', 'Quotation Submitted')
            ->orWhere('inventory_assets_request.approvalstat', '=', 'Waiting Approval 1')->orWhere('inventory_assets_request.approvalstat', '=', 'Canceled');
        });

        // if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        //     $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idrec', 'desc');
        // }

        // if (Auth::user()->username == $applicant) {
        //     $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.applicant', $applicant);
        // }

        if ($request->input('company') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('inventory_assets_request.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataPurchaseRequestQuery = $dataPurchaseRequestQuery->where('m_department.name', $request->department);
        }

        $result = $dataPurchaseRequestQuery->get();

        $dataPurchaseRequest = $result;

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved' || $status == 'Quotation Submitted' || $status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Waiting for Quotation') {
                    $color = "green";
                } else if ($status == 'Site Denied' || $status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'HQ 3 Denied'|| $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })

            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return "" . "" . number_format($dataPurchaseRequest->gtotal, 0, '.', '.');
            })
            ->editColumn('pr_date', function ($dataPurchaseRequest) {
                return date('Y-m-d', strtotime($dataPurchaseRequest->pr_date));
            })
            ->addColumn('action', function ($dataPurchaseRequest) {
                if ($dataPurchaseRequest->approvalstat == 'Waiting Quotation') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>

                    <a href = "/purchasing/purchase-approval/list/quotationpage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-pink-600 hover:bg-pink-700"    
                    >Upload Quotation</a>
                    </div>';
                } else if ($dataPurchaseRequest->approvalstat == 'Quotation Submitted') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>

                    <a href = "/purchasing/purchase-approval/list/quotationpage/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-pink-600 hover:bg-pink-700"    
                    >Upload Quotation</a>

                    <a href = "/purchasing/purchase-approval/list/submitapproval/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >Submit Approval</a>
                    </div>';
                }else if ($dataPurchaseRequest->approvalstat == 'Waiting Approval 1') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>

                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataPurchaseRequest->idrec.'"
                    >Cancel</button>
                    </div>';
                }else if ($dataPurchaseRequest->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/purchasing/purchase-approval/list/view/' . $dataPurchaseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function ReimburseListGetData(Request $request)
    {
        $user = Auth::user()->id;
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        // ->join('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department',
            'm_child_company.name as companyName'
        );

        
        if ($request->input('status') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.id_company', $request->company);
        }
        if ($request->input('department') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.department', $request->department);
        }

        if(Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888'){
            $dataReimburseRequest = $dataReimburseRequestQuery;
        }else{
            $dataReimburseRequest = $dataReimburseRequestQuery->where('t_reimburse_request.created_by', $user);
        }

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->editColumn('employee', function ($dataReimburseRequest) {
                return $dataReimburseRequest->employee . ' ' . $dataReimburseRequest->last_name;
            })
            ->editColumn('gtotal', function ($dataReimburseRequest) {
                return "" . "" . number_format($dataReimburseRequest->gtotal, 0, ',', '.');
            })
            ->addColumn('label', function ($dataReimburseRequest) {

                $status = ($dataReimburseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Form Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Waiting Approval 1' || $status == 'HQ 1 Approved' || $status == 'Payment Proof') {
                    $color = "yellow";
                } else if ($status == 'Complete') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataReimburseRequest) {
                if ($dataReimburseRequest->approvalstat == 'Draft') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <a href = "/ga/reimburse-approval/list/submitpage/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Submit for Approval</a>

                        <a href = "/ga/reimburse-approval/list/updatepage/' . $dataReimburseRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataReimburseRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                } 
                // else if($dataReimburseRequest->approvalstat == 'Printed') {
                //     return '
                //     <div class="flex flex-row justify-center">   
                //         <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                //         >View</a>

                //         <a href = "/ga/reimburse-approval/list/submitpage/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"    
                //         >Submit to Approval</a>

                //         <a href = "/ga/reimburse-approval/list/print/' . $dataReimburseRequest->idrec . '" target="_blank" class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1"    
                //         >Print</a>

                //         <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                //             data-id="'.$dataReimburseRequest->idrec.'"
                //         >Cancel</button>
                //     </div>';
                // }
                else if($dataReimburseRequest->approvalstat == 'Waiting Approval 1' || $dataReimburseRequest->approvalstat == 'HQ 1 Approved') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataReimburseRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if($dataReimburseRequest->approvalstat == 'Complete' || $dataReimburseRequest->approvalstat == 'Form Printed' ||  $dataReimburseRequest->approvalstat == 'Payment Proof' || $dataReimburseRequest->approvalstat == 'HQ 1 Denied' || $dataReimburseRequest->approvalstat == 'HQ 2 Denied' || $dataReimburseRequest->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataReimburseRequest) {
                return '
                <div class="flex flex-row justify-center">   
                    <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                </div>';
            })
            ->rawColumns(['label','action','action1'])
            ->make();
        }
    }

    public function ReimburseGetPrintVoucher(Request $request)
    {
        $user = Auth::user()->id;
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        // ->join('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department',
            'm_child_company.name as companyName'
        )->where(function ($query){
            $query->where('t_reimburse_request.approvalstat', '=', 'Payment Proof')->orWhere('t_reimburse_request.approvalstat', '=', 'Form Printed');
        });

        if ($request->input('company') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.id_company', $request->company)->orWhere('t_reimburse_request.created_by', $user);
        }
        if ($request->input('department') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.department', $request->department);
        }

        $dataReimburseRequest = $dataReimburseRequestQuery;

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->editColumn('gtotal', function ($dataReimburseRequest) {
                return "" . "" . number_format($dataReimburseRequest->gtotal, 0, ',', '.');
            })
            ->editColumn('employee', function ($dataReimburseRequest) {
                return $dataReimburseRequest->employee . ' ' . $dataReimburseRequest->last_name;
            })
            ->addColumn('action', function ($dataReimburseRequest) {
                if ($dataReimburseRequest->approvalstat == 'Payment Proof') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <button  class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                            data-id="'.$dataReimburseRequest->idrec.'" data-no="'.$dataReimburseRequest->idreqform.'"
                        >Print</button>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href ="/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <a href ="/ga/reimburse-approval/list/print/' . $dataReimburseRequest->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                        >Reprint</a>
                    </div>';
                }
                // elseif ($dataReimburseRequest->approvalstat == 'Form Printed' &&  $dataReimburseRequest->print_status == 'Y') {
                //     return '
                //     <div class="flex flex-row justify-center">   
                //         <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                //         >View</a>
                //     </div>';
                // }
                // else if($dataReimburseRequest->approvalstat == 'Form Printed' && $dataReimburseRequest->print_status == 'N'){
                //     return '
                //     <div class="flex flex-row justify-center">   
                //         <button  class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                //             data-id="'.$dataReimburseRequest->idrec.'" data-no="'.$dataReimburseRequest->idreqform.'"
                //         >Print</button>
                //     </div>';
                // }
                // <a href = "/ga/reimburse-approval/list/signature/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                // >Print</a>
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function ReimburseGetSubmitVoucher(Request $request)
    {
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        // ->join('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department',
            'm_child_company.name as companyName'
        )->where(function ($query){
            $query->where('t_reimburse_request.approvalstat', '=', 'Form Printed')->orWhere('t_reimburse_request.approvalstat', '=', 'Complete');
        });
        if ($request->input('company') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.id_company', $request->company);
        }
        if ($request->input('department') != null){
            $dataReimburseRequestQuery = $dataReimburseRequestQuery->where('t_reimburse_request.department', $request->department);
        }

        $dataReimburseRequest = $dataReimburseRequestQuery;

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->editColumn('employee', function ($dataReimburseRequest) {
                return $dataReimburseRequest->employee . ' ' . $dataReimburseRequest->last_name;
            })
            ->editColumn('gtotal', function ($dataReimburseRequest) {
                return "" . "" . number_format($dataReimburseRequest->gtotal, 0, ',', '.');
            })
            ->addColumn('action', function ($dataReimburseRequest) {
                if ($dataReimburseRequest->approvalstat == 'Payment Proof' || $dataReimburseRequest->approvalstat == 'Form Printed') {
                    return '
                    <div class="flex flex-row justify-center">  
                        <a href = "/ga/reimburse-approval/submitpayment/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"    
                        >Submit Payment</a>
                    </div>';
                }else{
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/ga/reimburse-approval/list/view/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataReimburseRequest) {
                if ($dataReimburseRequest->approvalstat == 'Complete') {
                    return '
                    <div class="flex flex-row justify-center">  
                        <a href = "/ga/reimburse-approval/submitpayment/' . $dataReimburseRequest->idrec . '" class="btn btn-sm text-sm bg-pink-500 hover:bg-pink-600 text-white ml-1"    
                        >Edit Payment</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function reimburseView(Request $request, $idRR)
    {
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        return view('pages.finance.reimburse-approval.list.view', compact('dataRR', 'RRDetail'));
    }

    public function reimburseUpdatePage(Request $request, $idRR)
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        $dataType = DB::table('m_reimbursement_type')
        ->select('*')->get();

        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        $dataVat = DB::table('m_vat')->orderBy('name_vat', 'asc')->get();

        $dataWht = DB::table('m_wht')->orderBy('name_wht', 'asc')->get();

        return view('pages.finance.reimburse-approval.list.updatepage', compact('dataRR', 'RRDetail', 'bank', 'dataType', 'dataCurrency', 'dataVat', 'dataWht'));
    }

    public function reimburseSubmitPage(Request $request, $idRR)
    {
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        $dataUser = DB::table('m_approval_reimburse')->leftJoin('users', 'm_approval_reimburse.id', 'users.id')->select('m_approval_reimburse.id', 'm_approval_reimburse.id_company', 'users.username')->where('m_approval_reimburse.id_company', $dataRR->id_company)->orderBy('users.username', 'asc')->get();
        $dataUser2 = DB::table('m_approval_reimburse2')->leftJoin('users', 'm_approval_reimburse2.id', 'users.id')->select('m_approval_reimburse2.id', 'm_approval_reimburse2.id_company', 'users.username')->where('m_approval_reimburse2.id_company', $dataRR->id_company)->orderBy('users.username', 'asc')->get();

        return view('pages.finance.reimburse-approval.list.reimburse-submit', compact('dataRR', 'RRDetail', 'dataUser', 'dataUser2'));
    }

    public function submitPaymentPage(Request $request, $idRR)
    {
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        return view('pages.finance.reimburse-approval.uploadpage', compact('dataRR', 'RRDetail'));
    }

    public function reimburseSubmit(Request $request, $idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataReimburse->id_company)->first();
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        $approvalTo = $request->input('approval_to');
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $token = (string)Str::uuid();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $employees = DB::table('m_employees')->where('idemployee', $dataReimburse->applicant)->first();

        if ($reimburseStat == 'Draft') {
            DB::table('reimburse_token')->insert([
                'email'=> $email,
                'token'=> $token,
                'is_active' => 1,
                'expired_at' => Carbon::now()->addHour(),
                'created_at' => Carbon::now()
            ]);
            
            $data = [
                'url' => route('reimburse.approvepage', [
                    'idRR' => $idRR,
                    'token' => $token
                ]),
                'logo_filename' => $datacomps->logo_filename,
                'company' => $datacomps->name,
                'address' => $datacomps->address,
                'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                'rrNo' => $dataReimburse->idreqform,
                'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                'applicant' => $employees->first_name . ' ' . $employees->last_name,
                'currency' => $dataReimburse->currency,
                'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.')
            ];
            Mail::send('reimburse_approval', $data, function($message) use($email, $user, $datacomps){
                $message->to($email, $user)->subject(''. $datacomps->name .' - Reimburse Approval');
            });
            DB::table('t_reimburse_request')->where('idrec', $idRR)->update([
                'approvalstat' => 'Waiting Approval 1',
                'approval_to' => $request->input('approval_to'),
                'approval2_to' => $request->input('approval2_to'),
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
    
            alert()->success('Success', 'Reimburse Request Has Been Submited, Waiting Approval');
            return to_route('reimburse-listonly');
        }else {
            alert()->error('Error', 'Reimburse Request Already Submitted to Approval');
            return to_route('reimburse-listonly');
        }
    }

    public function reimburseSubmitPay(Request $request, $idRR)
    {
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        if ($reimburseStat == 'Form Printed' || $reimburseStat == 'Payment Proof') {
            if ($request->hasFile('file45')) {
                $filePdf = $request->file('file45');    
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
               } else {
                   $pdf = null;
               }
            DB::table('t_reimburse_request')->where('idrec', $idRR)->update([
                'approvalstat' => 'Complete',
                'payment_date' => $request->input('payment_date'),
                'payment_proof_by' => $request->input('payment_proof_by'),
                'proof_bank_name' => $request->input('proof_bank_name'),
                'transfer_number' => $request->input('transfer_number'),
                'file_pdf' => $pdf,
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
    
            alert()->success('Success', 'Payment has been Uploaded, Save Complete');
            return to_route('reimburse-list.submitpaymentprove');
        }else {
            alert()->error('Error', 'Reimburse Request Already Complete');
            return to_route('reimburse-list.submitpaymentprove');
        }
    }

    public function reimburseSignature(Request $request, $idRR)
    {   
        $dataRR = DB::table('t_reimburse_request')
        ->select(
            '*'
        )->where('t_reimburse_request.idrec', $idRR)->first();
        return view('pages.finance.reimburse-approval.list.signature', compact('dataRR'));
    }

    public function reimburseSignatureUpdate(Request $request, $idRR)
    {   
        try {
                if($request){
                    $dataReimburse = DB::table('t_reimburse_request')->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')->select('t_reimburse_request.*','m_employees.first_name','m_employees.last_name')->where('t_reimburse_request.idrec', $idRR)->first();
                    $dataBank = DB::table('m_bank')->where('id_bank', $dataReimburse->bank_account)->pluck('name')->first();

                    // $initials = DB::table('m_child_company')->select('initials')->where('id_company', $dataReimburse->id_company)->first();
                    // $initials = $initials ? $initials->initials : null;

                    // if (!$initials) {
                    //     // Tangani kasus jika $initials tidak ditemukan
                    // }

                    // $dateInput = date('Y-m-d');
                    // $mm = date('m', strtotime($dateInput));
                    // $yearNow = date('Y');
                    // $yearNowSubstring = substr($yearNow, -2);

                    // $indicator = $yearNowSubstring . $mm . '/' . $initials . '/CP/';

                    // // Lakukan kueri untuk mencari nilai maksimal
                    // $maxIdRecord = DB::table('t_costpayment')
                    //     ->where('id_costpayment', 'like', $indicator . '%')
                    //     ->orderBy('idrec', 'desc')
                    //     ->first();

                    // if (is_null($maxIdRecord)) {
                    //     $CPID = $indicator . '1';
                    // } else {
                    //     $maxId = $maxIdRecord->id_costpayment;
                    //     $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));
            
                    //      // Periksa apakah bulan telah berubah
                    //     if (date('m', strtotime($dateInput)) != $mm) {
                    //         // Jika bulan berubah, reset nomor berjalan ke 1
                    //         $countIndicator = 1;
                    //         $mm = date('m', strtotime($dateInput));
                    //     } else {
                    //         // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    //         $countIndicator = $lastRunningNumber + 1;
                    //     }
            
                    //     $CPID = $indicator . $countIndicator;
                    // }
                    if ($dataReimburse->approvalstat == 'Payment Proof') {
                        DB::table('t_reimburse_request')->where('t_reimburse_request.idrec', $idRR)->update([
                            'approvalstat' => 'Form Printed',
                            'updated_at' => date('Y-m-d'),
                            'updated_by' => Auth::user()->id
                        ]);

                        DB::table('t_costpayment')->insert([
                            'id_costpayment' => $dataReimburse->idreqform,
                            'id_company' => $dataReimburse->id_company2,
                            // 'company' => $dataReimburse->company_name,
                            'company' => $dataReimburse->first_name . ' ' . $dataReimburse->last_name,
                            'form_type' => 'Reimburse',
                            'date' => $dataReimburse->datereq,
                            'due_date' => $dataReimburse->due_date,
                            'applicant' => $dataReimburse->first_name . ' ' . $dataReimburse->last_name,
                            'currency' => $dataReimburse->currency,
                            'crate' => $dataReimburse->crate,
                            'subtotal' => $dataReimburse->subtotal,
                            'vat' => $dataReimburse->total_vat,
                            'total' => $dataReimburse->total,
                            'wht' => $dataReimburse->total_wht,
                            'total_paid' => $dataReimburse->gtotal,
                            'approved_total' => $dataReimburse->approved_total,
                            'beneficiary_bank' => $dataBank,
                            'beneficiary_name' => $dataReimburse->name_account,
                            'beneficiary_acc' => $dataReimburse->number_account,
                            'balance' => $dataReimburse->approved_total,
                            'balance_wht' => $dataReimburse->total_wht,
                            'status' => 'A/P',
                            'print_status' => 'N',
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => $dataReimburse->created_by,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => $dataReimburse->created_by,
                            'aktifyn' => 'Y'
                        ]);

                        alert()->success('Success', 'Reimburse Form has been Printed');  
                        return response()->json(["st" => '1', "id"=>$dataReimburse->idrec]);
                    }else if($dataReimburse->approvalstat == 'Form Printed' && $dataReimburse->print_status == 'N'){
                        DB::table('t_reimburse_request')->where('t_reimburse_request.idrec', $idRR)->update([
                            'print_status' => 'Y',
                            'updated_at' => date('Y-m-d'),
                            'updated_by' => Auth::user()->id
                        ]);
                        alert()->success('Success', 'Reimburse Form has been Printed');   
                        return response()->json(["st" => '1', "id"=>$dataReimburse->idrec]);
                    }else if($dataReimburse->approvalstat == 'Form Printed' && $dataReimburse->print_status == 'Y'){
                        return response()->json(["st" => '0']);
                    }
                }else{
                    return response()->json(["st" => '0']);
                }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function reimbursePrint(Request $request, $idRR)
    {     
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.datereq', 't_reimburse_request.due_date', 't_reimburse_request.payment_date', 't_reimburse_request.id_company', 't_reimburse_request.id_company2', 't_reimburse_request.user_type', 't_reimburse_request.applicant', 't_reimburse_request.company_name', 't_reimburse_request.department', 't_reimburse_request.position', 't_reimburse_request.currency', 't_reimburse_request.crate',
            't_reimburse_request.bank_account', 't_reimburse_request.number_account', 't_reimburse_request.name_account', 't_reimburse_request.note', 't_reimburse_request.subtotal', 't_reimburse_request.total_vat', 't_reimburse_request.total', 't_reimburse_request.total_wht', 't_reimburse_request.gtotal', 't_reimburse_request.approved_total', 't_reimburse_request.approval_to', 't_reimburse_request.approval2_to', 't_reimburse_request.approval1_date', 't_reimburse_request.approval2_date',
            't_reimburse_request.approvalstat', 't_reimburse_request.approved1by', 't_reimburse_request.approved2by', 't_reimburse_request.approval1_status', 't_reimburse_request.approval2_status', 't_reimburse_request.remarks1', 't_reimburse_request.remarks2', 't_reimburse_request.prepared_by', 't_reimburse_request.reviewed_by', 't_reimburse_request.reviewed2_by', 't_reimburse_request.approved_by', 't_reimburse_request.created_at', 't_reimburse_request.created_by', 't_reimburse_request.updated_at', 
            't_reimburse_request.updated_by', 't_reimburse_request.print_status', 't_reimburse_request.payment_proof_by', 't_reimburse_request.proof_bank_name', 't_reimburse_request.transfer_number',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_child_company.name as companyName',
            'm_child_company.company_type',
            'm_child_company.address',
            'm_child_company.logo_blob',
            'm_child_company.logo_filename',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        return view('pages.finance.reimburse-approval.list.print', compact('dataRR', 'RRDetail'));
    }

    public function reimburseViewFile($idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->select('reimburse_file', 'idreqform')->first();
        $filename = $dataReimburse->idreqform . '.pdf';
        $fileReimburse = $dataReimburse->reimburse_file;

        return Response::make($fileReimburse, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function reimburseViewDocument($idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->select('file_pdf', 'idreqform')->first();
        $filename = $dataReimburse->idreqform . '.pdf';
        $fileReimburse = $dataReimburse->file_pdf;

        return Response::make($fileReimburse, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function getAsset(Request $request)
    {
        $dataAsset= DB::table('inventory_assets')
        ->select(
            'inventory_assets.*',
            DB::raw("
                case
                    when inventory_assets.aktifyn = Y then 'Active'
                    when inventory_assets.aktifyn = N then 'Not Active'
                    else 'unknown status'
                end as status
                ")
        );

        if ($request->input('category') != null) {
            $dataAsset = $dataAsset->where('inventory_assets.category', $request->category);
        }

        if ($request->input('status') != null){
            $dataAsset = $dataAsset->where('inventory_assets.aktifyn', $request->aktifyn);
        }

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataAsset) {

                $status = ($dataAsset->status);
                $color = "color";

                if ($status == 'Active') {
                    $color = "green";
                } else if ($status == 'Not ACtive') {
                    $color = "grey";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->rawColumns(['label'])
            ->make();
        }
    }

    public function getAnon(Request $request)
    {
        $dataAnon = DB::table('purchase_order')
        ->leftJoin('m_vendors', 'purchase_order.idsupplier', 'm_vendors.idsupplier')
        ->select(
            'purchase_order.idpo',
            'purchase_order.datepo',
            'purchase_order.squotation',
            'purchase_order.idsupplier',
            'purchase_order.deliverydate',
            'purchase_order.idwarehouse',
            'purchase_order.category',
            'purchase_order.currency',
            'purchase_order.crossrate',
            'purchase_order.pterm',
            'purchase_order.notes',
            'purchase_order.subtotal',
            'purchase_order.pvat',
            'purchase_order.avat',
            'purchase_order.gtotal',
            'purchase_order.status',
            'purchase_order.addedby',
            'purchase_order.remarks',
            'purchase_order.remarks_by',
            'm_vendors.name'
        )->orderBy('purchase_order.idpo', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataAnon)
            ->editColumn('subtotal', function ($dataAnon) {
                return $dataAnon->currency . " " . number_format($dataAnon->subtotal, 0, ',', '.');
            })
            ->editColumn('gtotal', function ($dataAnon) {
                return $dataAnon->currency . " " . number_format($dataAnon->gtotal, 0, ',', '.');
            })
            ->addColumn('label', function ($dataAnon) {

                $status = ($dataAnon->status);
                $color = "color";

                if ($status == 'Pending') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'COMPLETE') {
                    $color = "grey";
                } else if ($status == 'Denied') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAnon) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpo="'.$dataAnon->idpo.'"
                            data-datepo = "' . $dataAnon->datepo . '" data-squotation = "' . $dataAnon->squotation . '" data-idsupplier ="'.$dataAnon->idsupplier.'" data-status = "' . $dataAnon->status . '"
                            data-deliverydate = "' . $dataAnon->deliverydate . '" data-idwarehouse = "' . $dataAnon->idwarehouse . '" data-category = "' . $dataAnon->category . '" 
                            data-currency = "' . $dataAnon->remarks_by . '" data-crossrate = "' . $dataAnon->crossrate . '" data-pterm="'.$dataAnon->pterm.'"
                            data-notes="'.$dataAnon->notes.'" data-subtotal="'.$dataAnon->subtotal.'" data-pvat="'.$dataAnon->pvat.'" data-avat="'.$dataAnon->avat.'" data-gtotal="'.$dataAnon->gtotal.'"
                            data-addedby="'.$dataAnon->addedby.'" data-remarks="'.$dataAnon->remarks.'" data-name="'.$dataAnon->name.'"
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
                                        <div class="font-semibold text-slate-800">Purchase Order Detail</div>
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
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function getInv1(Request $request)
    {   
        $dataAssetQuery= DB::table('inventory_assets')
        ->select(
            'inventory_assets.*',
            DB::raw("
                case
                    when inventory_assets.aktifyn = 'Y' then 'Active'
                    when inventory_assets.aktifyn = 'N' then 'Not Active'
                    else 'unknown status'
                end as status
                ")
        )->where('inventory_assets.aktifyn', '=', 'Y');

        if ($request->input('category') != null) {
            $dataAssetQuery = $dataAssetQuery->where('inventory_assets.id_dept', $request->category);
        }
        if ($request->input('sub_category') != null) {
            $dataAssetQuery = $dataAssetQuery->where('inventory_assets.id_sub_dept', $request->sub_category);
        }

        $dataAsset = $dataAssetQuery->orderBy('inventory_assets.idassets', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataAsset) {

                $status = ($dataAsset->status);
                $color = "color";

                if ($status == 'Active') {
                    $color = "green";
                } else if ($status == 'Not ACtive') {
                    $color = "grey";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAsset) {
                if (!empty($dataAsset->file && $dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/updatepage/' . $dataAsset->idassets . '" class="btn btn-xs bg-amber-500 hover:bg-amber-600 text-white ml-3">
                        Edit
                        </a>

                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-emerald-500 hover:bg-emerald-600 text-white ml-3">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-sky-500 hover:bg-sky-600 text-white ml-3">
                        View Image
                        </a>
                    </div>';
                } else if (!empty($dataAsset->file)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/updatepage/' . $dataAsset->idassets . '" class="btn btn-xs bg-amber-500 hover:bg-amber-600 text-white ml-3">
                        Edit
                        </a>

                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-emerald-500 hover:bg-emerald-600 text-white ml-3">
                            View File
                        </a>
                    </div>';
                } else if (!empty($dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/updatepage/' . $dataAsset->idassets . '" class="btn btn-xs bg-amber-500 hover:bg-amber-600 text-white ml-3">
                        Edit
                        </a>

                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-sky-500 hover:bg-sky-600 text-white ml-3">
                        View Image
                        </a>
                    </div>';
                } else if (empty($dataAsset->file && $dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/updatepage/' . $dataAsset->idassets . '" class="btn btn-xs bg-amber-500 hover:bg-amber-600 text-white ml-3">
                        Edit
                        </a>
                    </div>';
                }
                
            })
            ->addColumn('label', function ($dataAsset) {

                $status = ($dataAsset->status);
                $color = "color";

                if ($status == 'Active') {
                    $color = "green";
                } else if ($status == 'Not ACtive') {
                    $color = "grey";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action1', function ($dataAsset) {
                if (!empty($dataAsset->file && $dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-xs btn-delete text-xs bg-red-500 hover:bg-red-600 text-white ml-3"
                            data-idassets="'.$dataAsset->idassets.'"
                            >Delete
                        </button>

                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-emerald-500 hover:bg-emerald-600 text-white ml-3">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-sky-500 hover:bg-sky-600 text-white ml-3">
                        View Image
                        </a>
                    </div>';
                } else if (!empty($dataAsset->file)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-xs btn-delete text-xs bg-red-500 hover:bg-red-600 text-white ml-3"
                            data-idassets="'.$dataAsset->idassets.'"
                            >Delete
                        </button>

                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-emerald-500 hover:bg-emerald-600 text-white ml-3">
                            View File
                        </a>
                    </div>';
                } else if (!empty($dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-xs btn-delete text-xs bg-red-500 hover:bg-red-600 text-white ml-3"
                            data-idassets="' .$dataAsset->idassets. '" 
                            >Delete
                        </button>
                        
                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-xs bg-sky-500 hover:bg-sky-600 text-white ml-3">
                        View Image
                        </a>
                    </div>';
                } else if (empty($dataAsset->file && $dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-xs btn-delete text-xs bg-red-500 hover:bg-red-600 text-white ml-3"
                            data-idassets="'.$dataAsset->idassets.'"
                            >Delete
                        </button>
                    </div>';
                }
                
            })
            
            ->rawColumns(['label', 'action', 'action1'])
            ->make();
        }
    }

    public function getInv(Request $request)
    {   
        $dataAssetQuery= DB::table('inventory_assets')
        ->select(
            'inventory_assets.*',
            DB::raw("
                case
                    when inventory_assets.aktifyn = 'Y' then 'Active'
                    when inventory_assets.aktifyn = 'N' then 'Not Active'
                    else 'unknown status'
                end as status
                ")
        )->where('inventory_assets.aktifyn', '=', 'Y');

        if ($request->input('category') != null) {
            $dataAssetQuery = $dataAssetQuery->where('inventory_assets.id_dept', $request->category);
        }
        if ($request->input('sub_category') != null) {
            $dataAssetQuery = $dataAssetQuery->where('inventory_assets.id_sub_dept', $request->sub_category);
        }

        $dataAsset = $dataAssetQuery->orderBy('inventory_assets.idassets', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataAsset) {

                $status = ($dataAsset->status);
                $color = "color";

                if ($status == 'Active') {
                    $color = "green";
                } else if ($status == 'Not ACtive') {
                    $color = "grey";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAsset) {
                if (!empty($dataAsset->file && $dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-3">
                            View File
                        </a>

                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white ml-3">
                        View Image
                        </a>

                    </div>';
                } else if (!empty($dataAsset->file)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/file/' . $dataAsset->idassets . '" target="_blank" class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">
                            View File
                        </a>
                    </div>';
                } else if (!empty($dataAsset->img)) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/ga/office-inventory/photo/' . $dataAsset->idassets . '" target="_blank" class="btn btn-sm bg-sky-500 hover:bg-sky-600 text-white">
                        View Image
                        </a>
                    </div>';
                }
                
            })
            ->rawColumns(['label', 'action'])
            ->make();
        }
    }

    public function inventoryDelete($idAsset)
    {
        try {
            DB::table('inventory_assets')->where('idassets', $idAsset)->update([
                'aktifyn' => 'N'
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Assets",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function reimburseApprove1(Request $request, $idRR)
    {
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*', 'm_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();
        $dataUser = DB::table('m_approval_reimburse')->leftJoin('users', 'm_approval_reimburse.id', 'users.id')->select('m_approval_reimburse.id', 'm_approval_reimburse.id_company', 'users.username')->where('m_approval_reimburse.id_company', $dataRR->id_company)->orderBy('users.username', 'asc')->get();
        return view('pages.finance.reimburse-approval.approval1', compact('dataRR', 'RRDetail', 'dataUser'));
    }

    public function reimburseApprovedPage(Request $request, $idRR)
    {
        $token = $request->input('token');

        $checkToken = DB::table('reimburse_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*', 'm_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        $dataUser = DB::table('m_approval_reimburse')->leftJoin('users', 'm_approval_reimburse.id', 'users.id')->select('m_approval_reimburse.id', 'm_approval_reimburse.id_company', 'users.username')->where('m_approval_reimburse.id_company', $dataRR->id_company)->orderBy('users.username', 'asc')->get();

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        //     return to_route('forgot.password');
        // }

        return view('reimburse_approvalpage', compact('dataRR', 'RRDetail', 'dataUser'));
    }

    public function reimburseApprove2(Request $request, $idRR)
    {
        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*', 'm_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();
        return view('pages.finance.reimburse-approval.approval2', compact('dataRR', 'RRDetail'));
    }

    public function reimburseApproved2Page(Request $request, $idRR)
    {
        $token = $request->input('token');

        $checkToken = DB::table('reimburse_token2')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataRR = DB::table('t_reimburse_request')
        ->leftJoin('m_employees', 't_reimburse_request.applicant', 'm_employees.idemployee')
        ->leftJoin('m_bank', 't_reimburse_request.bank_account', 'm_bank.id_bank')
        ->join('m_child_company', 't_reimburse_request.id_company', 'm_child_company.id_company')
        ->select(
            't_reimburse_request.*',
            'm_employees.first_name as employee',
            'm_employees.last_name',
            'm_employees.department as deptss',
            'm_child_company.name as company',
            'm_bank.name as bank'
        )->where('t_reimburse_request.idrec', $idRR)->first();

        $idreqformRR = $dataRR->idreqform;
            
        $RRDetail = DB::table('t_reimburse_request_detail')
        ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        ->select('t_reimburse_request_detail.*', 'm_reimbursement_type.reimburse_type')
        ->where('t_reimburse_request_detail.idreqform', $idreqformRR)->where('t_reimburse_request_detail.status', '=', 'Active')->get();

        $dataUser = DB::table('m_approval_reimburse2')->leftJoin('users', 'm_approval_reimburse2.id', 'users.id')->select('m_approval_reimburse2.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        //     return to_route('forgot.password');
        // }

        return view('reimburse_approval2page', compact('dataRR', 'RRDetail', 'dataUser'));
    }

    public function reimburseUpdateStatus (Request $request, $idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataReimburse->id_company)->first();
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        $approvalTo = $dataReimburse->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first(); 
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataReimburse->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $employees = DB::table('m_employees')->where('idemployee', $dataReimburse->applicant)->first();
        $status = $request->input('status');
        $token = (string)Str::uuid();
        $approved_total1 = str_replace('.', '', $request->input('approved_total'));
        $approved_total = str_replace(',', '.', $approved_total1) ?: 0; 

        if ($reimburseStat == "Waiting Approval 1") {
            if ($status == 'Approve') {
                DB::table('reimburse_token2')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('reimburse2.approvepage', [
                        'idRR' => $idRR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approval2', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject(''. $datacomps->name .' - Reimburse Approval 2');
                });            
                DB::table('t_reimburse_request')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'HQ 1 Approved',
                        'approval1_status' => 'HQ 1 Approved',
                        'approved_total' => $approved_total,
                        'approval1_date' => date('Y-m-d'),
                        'remarks1' => $request->input('remarks1'),
                        'reviewed_by' => Auth::user()->username,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Reimburse Request Has Been Approved');
                    return to_route('reimburse-approval');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'approvedby' => Auth::user()->username,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse HQ 1 Denied');
                });
                $approved_total1 = str_replace('.', '', $request->input('approved_total'));
                $approved_total = str_replace(',', '.', $approved_total1) ?: 0;
                DB::table('t_reimburse_request')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'HQ 1 Denied',
                    'approval1_status' => 'HQ 1 Denied',
                    'approval1_date' => date('Y-m-d'),
                    'approved_total' => $approved_total,
                    'remarks1' => $request->input('remarks1'),
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id,
                    'approved1by' => Auth::user()->username
                ]);
                alert()->success('Success', 'Reimburse Request Has Been Denied');
                return to_route('reimburse-approval');
            } else if ($status == 'Direct Approval') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approve', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse Approved');
                });
                $approved_total_input = str_replace('.', '', $request->input('approved_total'));
                $approved_total = str_replace(',', '.', $approved_total_input) ?: 0;                
                DB::table('t_reimburse_request')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'Payment Proof',
                        'approval1_status' => 'Payment Proof',
                        'approved_total' => $approved_total,
                        'approval1_date' => date('Y-m-d'),
                        'remarks1' => $request->input('remarks1'),
                        'reviewed_by' => Auth::user()->username,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Reimburse Request Has Been Approved');
                    return to_route('reimburse-approval');
    
            }
        } else {
            alert()->error('Error', 'Request Already Approved/Denied');
            return to_route('reimburse-approval');
        }
    }

    public function reimburseApproved (Request $request, $idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->first();
        $approvedBy = DB::table('users')->where('id', $dataReimburse->approval_to)->pluck('username')->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataReimburse->id_company)->first();
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        $approvalTo = $dataReimburse->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first(); 
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataReimburse->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $employees = DB::table('m_employees')->where('idemployee', $dataReimburse->applicant)->first();
        $status = $request->input('status');
        $token = (string)Str::uuid();
        $token1 = $request->input('token');
        $approved_total_input = str_replace('.', '', $request->input('approved_total')) ?: 0;
        $approved_total = str_replace(',', '.', $approved_total_input) ?: 0;  

        if ($reimburseStat == "Waiting Approval 1") {
            if ($status == 'Approve') {
                DB::table('reimburse_token2')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                $data = [
                    'url' => route('reimburse2.approvepage', [
                        'idRR' => $idRR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => $approvedBy,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approval2', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject(''. $datacomps->name .' - Reimburse Approval 2');
                });
                DB::table('reimburse_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);              
                DB::table('t_reimburse_request')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'HQ 1 Approved',
                        'approval1_status' => 'HQ 1 Approved',
                        'approved_total' => $approved_total,
                        'approval1_date' => date('Y-m-d'),
                        'remarks1' => $request->input('remarks1'),
                        'reviewed_by' => $approvedBy,
                        'updated_at' => date('Y-m-d'),
                        'approved1by' => $approvedBy
                    ]);
                alert()->success('Success', 'Reimburse Request Has Been Approved');
                return to_route('reimburse.approvepage', [
                    'idRR' => $idRR,
                    'token' => $token1
                ]);
            } else if ($status == 'Decline') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'approvedby' => $approvedBy,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse HQ 1 Denied');
                });
                DB::table('reimburse_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                $approved_total1 = str_replace('.', '', $request->input('approved_total'));
                $approved_total = str_replace(',', '.', $approved_total1) ?: 0;
                DB::table('t_reimburse_request')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'HQ 1 Denied',
                    'approval1_status' => 'HQ 1 Denied',
                    'approval1_date' => date('Y-m-d'),
                    'approved_total' => $approved_total,
                    'remarks1' => $request->input('remarks1'),
                    'reviewed_by' => $approvedBy,
                    'updated_at' => date('Y-m-d'),
                    'approved1by' => $approvedBy
                ]);
                alert()->success('Success', 'Reimburse Request Has Been Denied');
                return to_route('reimburse.approvepage', [
                    'idRR' => $idRR,
                    'token' => $token1
                ]);
            } else if ($status == 'Direct Approval') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => $approvedBy,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approve', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse Approved');
                });
                DB::table('reimburse_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                $approved_total_input = str_replace('.', '', $request->input('approved_total'));
                $approved_total = str_replace(',', '.', $approved_total_input) ?: 0;                
                DB::table('t_reimburse_request')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'Payment Proof',
                        'approval1_status' => 'Payment Proof',
                        'approved_total' => $approved_total,
                        'approval1_date' => date('Y-m-d'),
                        'remarks1' => $request->input('remarks1'),
                        'reviewed_by' => $approvedBy,
                        'updated_at' => date('Y-m-d'),
                        'approved1by' => $approvedBy
                    ]);
                alert()->success('Success', 'Reimburse Request Has Been Approved');
                return to_route('reimburse.approvepage', [
                    'idRR' => $idRR,
                    'token' => $token1
                ]);
            }
        } else {
            alert()->error('Error', 'Request Already Approved/Denied');
            return to_route('reimburse.approvepage', [
                'idRR' => $idRR,
                'token' => $token1
            ]);
        }
    }

    public function reimburseUpdateStatus2 (Request $request, $idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataReimburse->id_company)->first();
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        $email1 = DB::table('users')->where('id', $dataReimburse->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $employees = DB::table('m_employees')->where('idemployee', $dataReimburse->applicant)->first();
        $status = $request->input('status');

        if ($reimburseStat == "HQ 1 Approved") {
            if ($status == 'Approved') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($dataReimburse->approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approve', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse Approved');
                });
                DB::table('t_reimburse_request')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'Payment Proof',
                    'approval2_status' => 'Payment Proof',
                    'approval2_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'reviewed2_by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id,
                    'approved2by' => Auth::user()->username
                ]);
                alert()->success('Success', 'Reimburse Request Has Been Approved, Payment Proof');
                return to_route('reimburse-approval2');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'approvedby' => Auth::user()->username,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($dataReimburse->approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse HQ 2 Denied');
                });
                DB::table('t_reimburse_request')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'HQ 2 Denied',
                    'approval2_status' => 'HQ 2 Denied',
                    'approval2_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id,
                    'approved2by' => Auth::user()->username
                ]);
                alert()->success('Success', 'Reimburse Request Has Been Denied');
                return to_route('reimburse-approval2');
            }
        }else{
            alert()->error('Error', 'Request Already Approved/Denied');
            return to_route('reimburse-approval2');
        }
    }

    public function reimburseApproved2 (Request $request, $idRR)
    {
        $dataReimburse = DB::table('t_reimburse_request')->where('idrec', $idRR)->first();
        $approvedBy = DB::table('users')->where('id', $dataReimburse->approval2_to)->pluck('username')->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataReimburse->id_company)->first();
        $reimburseStat = DB::table('t_reimburse_request')->where('idrec', $idRR)->pluck('approvalstat')->first();
        $email1 = DB::table('users')->where('id', $dataReimburse->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $employees = DB::table('m_employees')->where('idemployee', $dataReimburse->applicant)->first();
        $status = $request->input('status');
        $token1 = $request->input('token');

        if ($reimburseStat == "HQ 1 Approved") {
            if ($status == 'Approved') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'approvedby' => $approvedBy,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($dataReimburse->approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_approve', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse Approved');
                });
                DB::table('reimburse_token2')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('t_reimburse_request')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'Payment Proof',
                        'approval2_status' => 'Payment Proof',
                        'approval2_date' => date('Y-m-d'),
                        'remarks2' => $request->input('remarks2'),
                        'reviewed2_by' => $approvedBy,
                        'updated_at' => date('Y-m-d'),
                        'approved2by' => $approvedBy
                    ]);
                    alert()->success('Success', 'Reimburse Request Has Been Approved');
                    return to_route('reimburse2.approvepage', [
                        'idRR' => $idRR,
                        'token' => $token1
                    ]);
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'approvedby' => $approvedBy,
                    'formDate' => date('Y-m-d', strtotime($dataReimburse->datereq)),
                    'rrNo' => $dataReimburse->idreqform,
                    'dueDate' => date('Y-m-d', strtotime($dataReimburse->due_date)),
                    'applicant' => $employees->first_name . ' ' . $employees->last_name,
                    'currency' => $dataReimburse->currency,
                    'gtotal' => number_format($dataReimburse->gtotal, 0, ',', '.'),
                    'approved_total' => number_format($dataReimburse->approved_total, 0, ',', '.')
                ];
                Mail::send('reimburse_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Reimburse HQ 2 Denied');
                });
                DB::table('reimburse_token2')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('t_reimburse_request')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'HQ 2 Denied',
                    'approval2_status' => 'HQ 2 Denied',
                    'approval2_date' => date('Y-m-d'),
                    'remarks2' => $request->input('remarks2'),
                    'reviewed2_by' => $approvedBy,
                    'updated_at' => date('Y-m-d'),
                    'approved2by' => $approvedBy
                ]);
                alert()->success('Success', 'Reimburse Request Has Been Denied');
                return to_route('reimburse2.approvepage', [
                    'idRR' => $idRR,
                    'token' => $token1
                ]);
            }
        } else {
            alert()->error('Error', 'Request Already Approved/Denied');
            return to_route('reimburse2.approvepage', [
                'idRR' => $idRR,
                'token' => $token1
            ]);
        }
    }

    public function purchaseListGetDashboard(Request $request)
    {
        $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
        ->select(
            'inventory_assets_request.idrec',
            'inventory_assets_request.idreqform',
            'inventory_assets_request.datereq',
            'inventory_assets_request.applicant',
            'inventory_assets_request.loc',
            'inventory_assets_request.reqlevel',
            'inventory_assets_request.daterequired',
            'inventory_assets_request.category',
            'inventory_assets_request.currency',
            'inventory_assets_request.note',
            'inventory_assets_request.receivestat',
            'inventory_assets_request.approvaldate',
            'inventory_assets_request.approvalstat',
            'inventory_assets_request.approved1by',
            'inventory_assets_request.approved2by',
            'inventory_assets_request.approval1_status',
            'inventory_assets_request.approval2_status',
            'inventory_assets_request.remarks1',
            'inventory_assets_request.remarks2',
            'inventory_assets_request.gtotal'
        );

        $dataPurchaseRequest = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idreqform', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataPurchaseRequest)
            ->editColumn('gtotal', function ($dataPurchaseRequest) {
                return $dataPurchaseRequest->currency . " " . number_format($dataPurchaseRequest->gtotal, 0, ',', '.');
            })
            ->addColumn('action', function ($dataPurchaseRequest) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpr="'.$dataPurchaseRequest->idreqform.'"
                            data-datepr = "' . $dataPurchaseRequest->datereq . '" data-applicant = "' . $dataPurchaseRequest->applicant . '" data-loc ="'.$dataPurchaseRequest->loc.'" data-reqlevel = "' . $dataPurchaseRequest->reqlevel . '"
                            data-daterequired = "' . $dataPurchaseRequest->daterequired . '" data-note="'.$dataPurchaseRequest->note.'" data-gtotal="'.$dataPurchaseRequest->gtotal.'" data-approvaldate="'.$dataPurchaseRequest->approvaldate.'"
                            data-approvalstat="'.$dataPurchaseRequest->approvalstat.'" data-approved1by="'.$dataPurchaseRequest->approved1by.'" data-approved2by="'.$dataPurchaseRequest->approved2by.'" data-currency="'.$dataPurchaseRequest->currency.'" data-approval1_status="'.$dataPurchaseRequest->approval1_status.'" data-approval2_status="'.$dataPurchaseRequest->approval2_status.'" data-remarks1="'.$dataPurchaseRequest->remarks1.'"
                            data-remarks2="'.$dataPurchaseRequest->remarks2.'"
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
                                        <div class="font-semibold text-slate-800">Inventory Request Detail</div>
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

    public function ReimburseListGetDashboard(Request $request)
    {
        $dataReimburseRequestQuery = DB::table('t_reimburse_request')
        ->select(
            't_reimburse_request.idrec',
            't_reimburse_request.idreqform',
            't_reimburse_request.datereq',
            't_reimburse_request.applicant',
            't_reimburse_request.bank_account',
            't_reimburse_request.number_account',
            't_reimburse_request.name_account',
            't_reimburse_request.note',
            't_reimburse_request.gtotal',
            't_reimburse_request.approvaldate',
            't_reimburse_request.approvalstat',
            't_reimburse_request.approved1by',
            't_reimburse_request.approved2by',
            't_reimburse_request.approval1_status',
            't_reimburse_request.approval2_status',
            't_reimburse_request.remarks1',
            't_reimburse_request.remarks2'
        );

        $dataReimburseRequest = $dataReimburseRequestQuery->orderBy('t_reimburse_request.idreqform', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataReimburseRequest)
            ->addColumn('action', function ($dataReimburseRequest) {
                return '
                <div class="flex flex-row">                
                    <div x-data="{ modalOpen: false }">
                        <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                            @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idreqform="'.$dataReimburseRequest->idreqform.'"
                            data-datereq = "' . $dataReimburseRequest->datereq . '" data-applicant = "' . $dataReimburseRequest->applicant . '" data-note = "' . $dataReimburseRequest->note . '" data-gtotal = "' . $dataReimburseRequest->gtotal . '" data-approvaldate = "' . $dataReimburseRequest->approvaldate . '" 
                            data-approvalstat = "' . $dataReimburseRequest->approvalstat . '" data-approved1by = "' . $dataReimburseRequest->approved1by . '" data-approved2by = "' . $dataReimburseRequest->approved2by . '" data-approval1_status = "' . $dataReimburseRequest->approval1_status . '" data-approval2_status = "' . $dataReimburseRequest->approval2_status . '"
                            data-remarks1 = "' . $dataReimburseRequest->remarks1 . '" data-remarks2 = "' . $dataReimburseRequest->remarks2 . '" data-bank_account = "' . $dataReimburseRequest->bank_account . '" data-number_account = "' . $dataReimburseRequest->number_account . '" data-name_account = "' . $dataReimburseRequest->name_account . '">View</button>
                        
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
                                        <div class="font-semibold text-slate-800">Reimburse Request Detail</div>
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

    public function purchaseView(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        return view('pages.purchasing.purchase-approval.list.view', compact('dataPR', 'PRDetail'));
    }

    public function purchaseSubmitPage(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        $dataUser = DB::table('m_approval_pr')->leftJoin('users', 'm_approval_pr.id', 'users.id')->select('m_approval_pr.id', 'm_approval_pr.id_company', 'users.username')->where('m_approval_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();  
        $dataUser2 = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'm_approval2_pr.id_company', 'users.username')->where('m_approval2_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();  
        $dataUser3 = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'm_approval3_pr.id_company', 'users.username')->where('m_approval3_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();  

        return view('pages.purchasing.purchase-approval.list.purchase-submit', compact('dataPR', 'PRDetail', 'dataUser', 'dataUser2', 'dataUser3'));
    }

    public function purchaseSubmitApprovalPage(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        $dataUser = DB::table('m_approval_pr')->leftJoin('users', 'm_approval_pr.id', 'users.id')->select('m_approval_pr.id', 'm_approval_pr.id_company', 'users.username')->where('m_approval_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();  
        $dataUser2 = DB::table('m_approval2_pr')->leftJoin('users', 'm_approval2_pr.id', 'users.id')->select('m_approval2_pr.id', 'm_approval2_pr.id_company', 'users.username')->where('m_approval2_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();  
        $dataUser3 = DB::table('m_approval3_pr')->leftJoin('users', 'm_approval3_pr.id', 'users.id')->select('m_approval3_pr.id', 'm_approval3_pr.id_company', 'users.username')->where('m_approval3_pr.id_company', $dataPR->company_id)->orderBy('users.username', 'asc')->get();

        return view('pages.purchasing.purchase-approval.list.submit-approval', compact('dataPR', 'PRDetail', 'dataUser'));
    }

    public function purchaseQuotationPage(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        return view('pages.purchasing.purchase-approval.list.quotation-submit', compact('dataPR', 'PRDetail'));
    }

    public function purchaseUpdatePage(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
        $id_rab = $dataPR->id_rab;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 
        'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks', 'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.created_at', 
        'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets_request_detail.id_rab', 'inventory_assets_request_detail.balance_rab', 
        't_rab_detail.name_rab_detail', 't_rab_detail.unit', 't_rab_detail.balance as rabBalance', 'm_vendors.name as vendor', 'm_vendors.phone', 
        DB::raw("inventory_assets_request_detail.balance_rab + inventory_assets_request_detail.balance AS counts"))
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('t_rab_detail.id_rab', $id_rab)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct()
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        $PRDetail1 = DB::table('t_rab_detail')
        ->leftJoin('inventory_assets_request_detail', 't_rab_detail.id_rab_item', 'inventory_assets_request_detail.idassets')
        ->select('t_rab_detail.*', 'inventory_assets_request_detail.total as totalias')
        ->where('t_rab_detail.id_rab', $id_rab)
        ->where('t_rab_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('t_rab_detail.idrec', 'asc')
        ->get();

        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.purchasing.purchase-approval.list.updatepage', compact('dataPR', 'PRDetail', 'PRDetail1', 'dataCurrency'));
    }

    public function purchaseUpdatePage1(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            't_rab.gtotal as rabtotal',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 
        'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks', 'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.created_at', 
        'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets_request_detail.id_rab', 'inventory_assets_request_detail.balance_rab', 
        't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        $PRDetail1 = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 
        'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks', 'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.created_at', 
        'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 'inventory_assets_request_detail.id_rab', 'inventory_assets_request_detail.balance_rab', 
        't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        return view('pages.purchasing.purchase-approval.list.updatepricepage', compact('dataPR', 'PRDetail', 'PRDetail1'));
    }

    public function purchaseClonePage(Request $request, $idPR)
    {   
        $dataPR = DB::table('inventory_assets_request')
        ->select('*')->where('inventory_assets_request.idrec', $idPR)->first();
        return view('pages.purchasing.purchase-approval.list.clone', compact('dataPR'));
    }

    public function purchaseClone(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')
        ->select('*')->where('inventory_assets_request.idrec', $idPR)->first();
        $pr_detail = DB::table('inventory_assets_request_detail')->where('id_rab', $dataPR->id_rab)->get();

        $idPR1 = $dataPR->idreqform;

        $rowsProducts = DB::table('inventory_assets_request_detail')->select('*')->where('idreqform', $idPR1)->where('status', '=', 'Active')->get();

        $company = $dataPR->company_id;

        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('date');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y');
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/PR/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('inventory_assets_request')
            ->where('idreqform', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $PRID = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->idreqform;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $PRID = $indicator . $countIndicator;
        }
        try {
            if ($request->input('req') >= $dateInput) {
                $rabBalances = [];
                
                    // Populate the rabBalances array with balances from the t_rab_detail table
                    foreach ($pr_detail as $detail) {
                        $rabDetails = DB::table('t_rab_detail')
                            ->select('id_rab_item', 'balance')
                            ->where('id_rab', $dataPR->id_rab)
                            ->where('id_rab_item', $detail->idassets)
                            ->get();
    
                        foreach ($rabDetails as $rabDetail) {
                            if (isset($rabBalances[$detail->idassets])) {
                                $rabBalances[$detail->idassets] += $rabDetail->balance;
                            } else {
                                $rabBalances[$detail->idassets] = $rabDetail->balance;
                            }
                        }
                    }
    
                    // Check balance for each product
                    foreach ($rowsProducts as $key => $value) {
                        if (!isset($rabBalances[$value->idassets]) || $rabBalances[$value->idassets] < $value->total) {
                            alert()->error('Error', 'One off rab item balance over budget');
                            return to_route('purchase-list');
                        }
                    }
                DB::transaction(function () use ($rowsProducts, $dataPR, $request, $PRID){
                    // foreach ($rowsProducts as $key => $value) {
                    //     if (!isset($rabBalances[$value->idassets]) || $rabBalances[$rabDetail->balance] < $value->total) {
                    //         alert()->error('Error', 'One off rab item balance over budget');
                    //         return to_route('purchase-list');
                    //     }
                    // }
                    
                    DB::table('inventory_assets_request')->insert([
                        'idreqform' => $PRID,
                        'pr_title' => $request->input('pr_title'),
                        'id_rab' => $dataPR->id_rab,
                        'pr_date' => date($request->input('date')),
                        'rab_date' => $dataPR->rab_date,
                        'applicant' => $dataPR->applicant,
                        'company_id' => $dataPR->company_id,
                        'currency' => $dataPR->currency,
                        'payment_by' => $dataPR->payment_by,
                        'department' => $dataPR->department,
                        'division' => $dataPR->division,
                        'purch_type' => $dataPR->purch_type,
                        // 'approval_to' => $dataPR->approval_to,
                        // 'approved1by' => $dataPR->approved1by,
                        'reqlevel' => $dataPR->reqlevel,
                        'delivery_date' => date($request->input('req')),
                        'note' => $dataPR->note,
                        'idsupplier' => $dataPR->idsupplier,
                        'id_warehouse' => $dataPR->id_warehouse,
                        'pic' => $dataPR->pic,
                        'phone' => $dataPR->phone,
                        'delivery_address' => $dataPR->delivery_address,
                        'city' => $dataPR->city,
                        'province' => $dataPR->province,
                        'country' => $dataPR->country,
                        'zip_code' => $dataPR->zip_code,
                        'subtotal' => $dataPR->subtotal,
                        // 'discount' => $dataPR->discount,
                        // 'total' => $dataPR->total,
                        // 'ppn' => $dataPR->ppn,
                        'gtotal' => $dataPR->gtotal,
                        'balance' => $dataPR->balance,
                        // 'delivery_charge' => $dataPR->delivery_charge,
                        'approvalstat' => 'Draft',
                        'approval1_status' => 'Draft',
                        'price_updated' => 'N',
                        'print_status' => 'N',
                        'created_at' => date('Y-m-d'),
                        'created_by' => Auth::user()->id
                    ]);
                    
                    foreach ($rowsProducts as $key => $value) {
                        DB::table('inventory_assets_request_detail')->insert([
                            'idreqform' => $PRID,
                            'id_rab' => $value->id_rab,
                            'idassets' => $value->idassets,
                            'qty' => $value->qty,
                            'unit' => $value->unit,
                            'price' => $value->price,
                            'total' => $value->total,
                            'balance' => $value->total,
                            'balance_rab' => $value->total,
                            'remarks' => $value->remarks,
                            // 'idsupplier' => $value->idsupplier,
                            'status' => 'Active',
                            'created_at' => date('Y-m-d')
                        ]);
                    }
                });
                alert()->success('Success', 'PR #' . $PRID . ' Has Been Cloned');
                return to_route('purchase-list');
            }else {
                alert()->error('Error', 'Delivery Date cannot before Form Date');
                return to_route('purchase-list');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function purchaseSignature(Request $request, $idPR)
    {   
        $dataPR = DB::table('inventory_assets_request')
        ->select(
            '*'
        )->where('inventory_assets_request.idrec', $idPR)->first();
        return view('pages.purchasing.purchase-approval.list.signature', compact('dataPR'));
    }

    public function purchaseSignatureUpdate(Request $request, $idPR)
    {   
        try {
                if($request){
                    $idrec=DB::table('inventory_assets_request')->select('inventory_assets_request.idrec')->where('inventory_assets_request.idrec', $idPR)->first();
                    $id=$idrec->idrec;
                    $approvalstat = DB::table('inventory_assets_request')->where('inventory_assets_request.idrec', $idPR)->pluck('approvalstat')->first();
                    if ($approvalstat == 'Price Updated') {
                        DB::table('inventory_assets_request')->where('inventory_assets_request.idrec', $idPR)->update([
                            'prepared_by' => $request->input('prepared'),
                            'reviewed_by' => $request->input('view'),
                            'reviewed2_by' => $request->input('view2'),
                            'approved_by' => $request->input('approved'),
                            'print_status' => 'Y',
                            'approvalstat' => 'PR Printed',
                            'approval1_status' => 'Printed'
                        ]);
                        alert()->success('Success', 'Purchase Request has been Printed');    
                        return response()->json(["st" => '1', "id"=>$id]);
                    } else {
                        return response()->json(["st" => '0']);
                    }
                }else{
                    return response()->json(["st" => '0']);
                }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function purchasePrint(Request $request, $idPR)
    {     
        $dataPR = DB::table('inventory_assets_request')
        ->leftJoin('m_child_company', 'inventory_assets_request.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 'inventory_assets_request.idsupplier', 'm_vendors.idsupplier')
        ->leftJoin('t_rab', 'inventory_assets_request.id_rab', 't_rab.id_rab')
        ->leftJoin('m_department', 'inventory_assets_request.department', 'm_department.id')
        ->select(
            'inventory_assets_request.*',
            't_rab.name_rab',
            'm_department.name as departmentName',
            'm_child_company.name as companyName',
            'm_child_company.company_type',
            'm_child_company.address',
            'm_child_company.logo_blob',
            'm_child_company.logo_filename',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType'
        )->where('inventory_assets_request.idrec', $idPR)->first();

        $idPR = $dataPR->idreqform;
            
        $PRDetail = DB::table('inventory_assets_request_detail')
        ->leftJoin('t_rab_detail', 'inventory_assets_request_detail.idassets', 't_rab_detail.id_rab_item')
        ->leftJoin('m_vendors', 'inventory_assets_request_detail.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets_request_detail.id', 'inventory_assets_request_detail.idreqform', 'inventory_assets_request_detail.idassets', 'inventory_assets_request_detail.total', 'inventory_assets_request_detail.status', 'inventory_assets_request_detail.remarks',
        'inventory_assets_request_detail.idsupplier', 'inventory_assets_request_detail.qty', 'inventory_assets_request_detail.price', 't_rab_detail.name_rab_detail', 't_rab_detail.unit', 'm_vendors.name as vendor', 'm_vendors.phone')
        ->where('inventory_assets_request_detail.idreqform', $idPR)
        ->where('inventory_assets_request_detail.status', '=', 'Active')
        ->distinct() // Ensure distinct records
        ->orderBy('inventory_assets_request_detail.id', 'asc')
        ->get();

        $PRDetailCount = $PRDetail->count();

        return view('pages.purchasing.purchase-approval.list.print', compact('dataPR', 'PRDetail', 'PRDetailCount'));
    }

    public function purchaseUpdate(Request $request, $idPR)
    {
        try {
            $dataPR = DB::table('inventory_assets_request')->select('*')->where('inventory_assets_request.idrec', $idPR)->first();
            $PRID = $dataPR->idreqform;
            $approvalstat = $dataPR->approvalstat;
            $date = $request->input('periode');
            $date1 = date('Y-m-t',strtotime($date));
            $iden = $request->input('iden');
            $idenas = $request->input('idenas');
            $rowsProducts = $request->get('rows');
            $rowsProducts1 = $request->get('rows1');
            if ($approvalstat == 'Draft') {
                foreach ($request->idenas as $idenas) {
                    $balancess = $request->input('balanciaga123_'.$idenas);
                    $totstal = $request->input('totalia123_'.$idenas);
                    $newssBalances = $balancess + $totstal;
                    DB::table('t_rab_detail')
                    ->where('id_rab', $request->input('idRab'))
                    ->where('id_rab_item', $request->input('ids123_'.$idenas))
                    ->update(['balance' => $newssBalances]);
                }
                if (!empty($iden) || !empty($rowsProducts) || !empty($rowsProducts1)) {
                    DB::transaction(function () use ($iden, $request, $PRID, $idPR, $rowsProducts, $rowsProducts1){
                        DB::table('inventory_assets_request')->where('inventory_assets_request.idrec', $idPR)->update([
                            'pr_title' => $request->input('pr_title'),
                            'reqlevel' => $request->input('level'),
                            'currency' => $request->input('currency'),
                            'note' => $request->input('notes'),
                            'payment_by' => $request->input('payment_by'),
                            'idsupplier' => $request->input('vendor1'),
                            'pic' => $request->input('pic'),
                            'phone' => $request->input('phone'),
                            'subtotal' => $request->input('subtotal1'),
                            'discount' => $request->input('discount'),
                            'total' => $request->input('total1'),
                            'ppn' => $request->input('ppn'),
                            'gtotal' => $request->input('grandtotal1'),
                            'balance' => $request->input('grandtotal1'),
                            'delivery_charge' => $request->input('deliveryCharge')
                        ]);
                        DB::table('inventory_assets_request_detail')->where('idreqform', $PRID)->delete();
                        if (!empty($iden)) {
                            foreach ($request->iden as $iden) {
                                $trabDetailBalance = DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $request->input('ids_'.$iden))
                                ->pluck('balance')
                                ->first();
                                $newssBalances = $trabDetailBalance - $request->input('total_'.$iden);
                                DB::table('inventory_assets_request_detail')->insert([
                                    'idreqform' => $PRID,
                                    'id_rab' => $request->input('id_rab_'.$iden),
                                    'idassets' => $request->input('ids_'.$iden),
                                    'qty' => $request->input('qty_'.$iden),
                                    'unit' => $request->input('unit_'.$iden),
                                    'price' => $request->input('price_'.$iden),
                                    'total' => $request->input('total_'.$iden),
                                    'balance' => $request->input('total_'.$iden),
                                    'balance_rab' => $newssBalances,
                                    'remarks' => $request->input('remarks1_'.$iden),
                                    'status' => $request->input('status_'.$iden),
                                    'created_at' => $request->input('createdat_'.$iden),
                                    'updated_at' => date('Y-m-d')
                                ]);
                                DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $request->input('ids_'.$iden))
                                ->update(['balance' => $newssBalances]);
                            }
                        }
                        if (!empty($rowsProducts)) {
                            foreach ($rowsProducts as $key) {
                                $trabDetailBalance = DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $key['ids2'])
                                ->pluck('total')
                                ->first();
                                $newBalance = $trabDetailBalance - $key['totals'];
                                DB::table('inventory_assets_request_detail')->insert([
                                    'idreqform' => $PRID,
                                    'id_rab' => $request->input('idRab'),
                                    'idassets' => $key['ids2'],
                                    'qty' => $key['qtys'],
                                    'unit' => $key['units'],
                                    'price' => $key['prices'],
                                    'total' => $key['totals'],
                                    'balance' => $key['totals'],
                                    'balance_rab' => $newBalance,
                                    'remarks' => $key['remarkss'],
                                    'status' => 'Active',
                                    'created_at' => date('Y-m-d')
                                ]);
                                DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $key['ids2'])
                                ->update(['balance' => $newBalance]);
                            }
                        }
                        if (!empty($rowsProducts1)) {
                            foreach ($rowsProducts1 as $key) {
                                $trabDetailBalance = DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $key['ids2'])
                                ->pluck('total')
                                ->first();
                                $newBalance = $trabDetailBalance - $key['totals'];
                                DB::table('inventory_assets_request_detail')->insert([
                                    'idreqform' => $PRID,
                                    'id_rab' => $request->input('idRab'),
                                    'idassets' => $key['ids2'],
                                    'qty' => $key['qtys'],
                                    'unit' => $key['units'],
                                    'price' => $key['prices'],
                                    'total' => $key['totals'],
                                    'balance' => $key['totals'],
                                    'balance_rab' => $newBalance,
                                    'remarks' => $key['remarkss'],
                                    'status' => 'Active',
                                    'created_at' => date('Y-m-d')
                                ]);
                                DB::table('t_rab_detail')
                                ->where('id_rab', $request->input('idRab'))
                                ->where('id_rab_item', $key['ids2'])
                                ->update(['balance' => $newBalance]);
                            }
                        }
                    });
                    alert()->success('Success', 'Purchase Request Has Been Edited');
                    return to_route('purchase-list-only');
                } else {
                    alert()->error('Error', 'Purchase Detail is Empty');
                    return to_route('purchase-list-only');
                }
            } else {
                alert()->error('Success', 'Purchase Request Already Updated');
                return to_route('purchase-list-only');
            }
            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            alert()->error('Error', 'Error Occurred');
            return to_route('purchase-list-only');
        }
    }

    public function purchaseUpdate1(Request $request, $idPR)
    {
        try {
            $dataPR = DB::table('inventory_assets_request')->select('*')->where('inventory_assets_request.idrec', $idPR)->first();
            $PRID = $dataPR->idreqform;
            $approvalstat = $dataPR->approvalstat;
            $date = $request->input('periode');
            $date1 = date('Y-m-t',strtotime($date));
            $iden = $request->input('iden');
            if ($approvalstat == 'Draft' || $approvalstat == 'Price Updated') {
                DB::transaction(function () use ($iden, $request, $PRID, $idPR, $date1){
                    DB::table('inventory_assets_request')->where('inventory_assets_request.idrec', $idPR)->update([
                        'subtotal' => $request->input('subtotal1'),
                        'discount' => $request->input('discount'),
                        'total' => $request->input('total1'),
                        'ppn' => $request->input('ppn'),
                        'gtotal' => $request->input('grandtotal1'),
                        'delivery_charge' => $request->input('deliveryCharge'),
                        'approvalstat' => 'Price Updated',
                        'price_updated' => 'Y'
                    ]);
                    DB::table('inventory_assets_request_detail')->where('idreqform', $PRID)->delete();
                    foreach ($request->iden as $iden) {
                        DB::table('inventory_assets_request_detail')->insert([
                            'idreqform' => $request->input('idPR_'.$iden),
                            'id_rab' => $request->input('id_rab_'.$iden),
                            'idassets' => $request->input('ids_'.$iden),
                            'qty' => $request->input('qty_'.$iden),
                            'unit' => $request->input('unit_'.$iden),
                            'price' => $request->input('price_'.$iden),
                            'total' => $request->input('total_'.$iden),
                            'remarks' => $request->input('remarks1_'.$iden),
                            'status' => $request->input('status_'.$iden),
                            'created_at' => $request->input('createdat_'.$iden),
                            'updated_at' => date('Y-m-d')
                        ]);
                    }
                });
                alert()->success('Success', 'Price Has Been Updated');
                return to_route('purchase-updateprice');
            } else {
                alert()->error('Error', 'Price Already Updated');
                return to_route('purchase-updateprice');
            }
            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            alert()->error('Error', 'Error Occurred');
            return to_route('purchase-updateprice');
        }
    }

    public function purchaseViewFile($idPR)
    {
        $dataPurchase = DB::table('inventory_assets_request')->where('idrec', $idPR)->select('pr_file', 'idreqform')->first();
        $filename = $dataPurchase->idreqform . '.pdf';
        $filePurchase = $dataPurchase->pr_file;

        return Response::make($filePurchase, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function purchaseQuotation1($idPR)
    {
        $dataPurchase = DB::table('inventory_assets_request')->where('idrec', $idPR)->select('quotation1', 'idreqform')->first();
        $filename = $dataPurchase->idreqform . '.pdf';
        $filePurchase = $dataPurchase->quotation1;

        return Response::make($filePurchase, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function purchaseQuotation2($idPR)
    {
        $dataPurchase = DB::table('inventory_assets_request')->where('idrec', $idPR)->select('quotation2', 'idreqform')->first();
        $filename = $dataPurchase->idreqform . '.pdf';
        $filePurchase = $dataPurchase->quotation2;

        return Response::make($filePurchase, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function purchaseQuotation3($idPR)
    {
        $dataPurchase = DB::table('inventory_assets_request')->where('idrec', $idPR)->select('quotation3', 'idreqform')->first();
        $filename = $dataPurchase->idreqform . '.pdf';
        $filePurchase = $dataPurchase->quotation3;

        return Response::make($filePurchase, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function purchaseListUpdate(Request $request, $idPR)
    {
        $status = $request->input('status');

        if ($status == 'Approved') {
            $updatePR = DB::table('inventory_assets_request')
            ->where('idreqform', $idPR)
            ->update([
                'approvalstat' => 'Pending',
                'approvaldate' => date('Y-m-d'),
                'approval1_status' => 'Approved',
                'remarks1' => $request->input('remarks1'),
                'approved1by' => Auth::user()->username
            ]);
            alert()->success('Success', 'Inventory Asset Request Approved');
            return to_route('dashboard');

        } else if ($status == 'Denied') {
            $updatePR = DB::table('inventory_assets_request')
            ->where('idreqform', $idPR)
            ->update([
                'approvalstat' => 'Denied',
                'approvaldate' => date('Y-m-d'),
                'approval1_status' => 'Denied',
                'approval2_status' => 'Denied',
                'remarks1' => $request->input('remarks1'),
                'approved1by' => Auth::user()->username
            ]);
            alert()->success('Success', 'Inventory Asset Request Denied');
            return to_route('dashboard');
        }
    }

    public function purchaseSubmit(Request $request, $idPR)
    {
        $approvalstat = DB::table('inventory_assets_request')->where('idrec', $idPR)->pluck('approvalstat')->first();
        if ($approvalstat == 'PR Printed') {
            if ($request->hasFile('file123')) {
                $filePdf = $request->file('file123');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File too large, please compress file');
                    return to_route('purchase-list.submit', [
                        'idPR' => $idPR,
                    ]);
                }
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
                $pdf = null;
            }
            DB::table('inventory_assets_request')->where('idrec', $idPR)->update([
                'approvalstat' => 'Waiting Quotation',
                'approval1_status' => 'Waiting Quotation',
                'approval_to' => $request->input('approval_to'),
                'approval2_to' => $request->input('approval2_to'),
                'approval3_to' => $request->input('approval3_to'),
                'pr_file' => $pdf
            ]);
    
            alert()->success('Success', 'Purchase Request Has Been Submited, Waiting Quotation');
            return to_route('purchase-printsubmit');
        } else {
            alert()->error('Error', 'Purchase Request Already Submitted');
            return to_route('purchase-printsubmit');
        }
    }

    public function purchaseApprovalSubmit(Request $request, $idPR)
    {
        $dataPR = DB::table('inventory_assets_request')->select('inventory_assets_request.idrec', 'inventory_assets_request.idreqform', 'inventory_assets_request.approvalstat', 'inventory_assets_request.company_id', 
        'inventory_assets_request.pr_title', 'inventory_assets_request.pr_date', 'inventory_assets_request.rab_date', 'inventory_assets_request.applicant', 'inventory_assets_request.gtotal', 
        'inventory_assets_request.currency', 'inventory_assets_request.reqlevel', 'inventory_assets_request.payment_by', 'inventory_assets_request.delivery_date', 'inventory_assets_request.approval_to')->where('idrec', $idPR)->first();
        $idreqform = $dataPR->idreqform;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataPR->company_id)->first();
        $approvalstat = $dataPR->approvalstat;
        try {
            $approvalTo = $dataPR->approval_to;

            $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
    
            $token = (string)Str::uuid();
    
            $user = DB::table('users')->where('email', $email)->pluck('username')->first();
            if ($approvalstat == 'Quotation Submitted'){
                DB::table('pr_approve1_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                
                $data = [
                    'url' => route('purchase.approve1page', [
                        'idPR' => $idPR,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataPR->pr_date)),
                    'prNo' => $idreqform,
                    'title' => $dataPR->pr_title,
                    'level' => $dataPR->reqlevel,
                    'deliveryDate' => date('d F Y', strtotime($dataPR->delivery_date)),
                    'source' => $dataPR->payment_by,
                    'applicant' => $dataPR->applicant,
                    'currency' => $dataPR->currency,
                    'gtotal' => number_format($dataPR->gtotal, 0, ',', '.')
                ];
                Mail::send('pr_approval1', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - PR Approval 1');
                });
                DB::table('inventory_assets_request')->where('idrec', $idPR)->update([
                    'approvalstat' => 'Waiting Approval 1',
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
    
                alert()->success('Success', 'Purchase Request Has Been Submited to Approval');
                return to_route('purchase-submitquotation');
            } else {
                alert()->error('Error', 'Purchase Request Already Submited to Approval');
                return to_route('purchase-submitquotation');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function quotationSubmit(Request $request, $idPR)
    {
        $approvalstat = DB::table('inventory_assets_request')->where('idrec', $idPR)->pluck('approvalstat')->first();
        if ($approvalstat == 'Waiting Quotation' || $approvalstat == 'Quotation Submitted') {
            if ($request->hasFile('quotation1')) {
                $filePdf = $request->file('quotation1');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File too large, please compress file');
                    return to_route('purchase-list.quotationpage', [
                        'idPR' => $idPR,
                    ]);
                }
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
                $pdf = null;
            }
            if ($request->hasFile('quotation2')) {
                $filePdf1 = $request->file('quotation2');
                if ($filePdf1->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File too large, please compress file');
                    return to_route('purchase-list.quotationpage', [
                        'idPR' => $idPR,
                    ]);
                }
                $pdf1 = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
                $pdf1 = null;
            }
            if ($request->hasFile('quotation3')) {
                $filePdf2 = $request->file('quotation3');
                if ($filePdf2->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File too large, please compress file');
                    return to_route('purchase-list.quotationpage', [
                        'idPR' => $idPR,
                    ]);
                }
                $pdf2 = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
                $pdf2 = null;
            }
            DB::table('inventory_assets_request')->where('idrec', $idPR)->update([
                'approvalstat' => 'Quotation Submitted',
                'approval1_status' => 'Quotation Submitted',
                'vendor_quo1' => $request->input('vendor_quotation1'),
                'vendor_quo2' => $request->input('vendor_quotation2'),
                'vendor_quo3' => $request->input('vendor_quotation3'),
                'total_quo1' => $request->input('total_quotation1'),
                'total_quo2' => $request->input('total_quotation2'),
                'total_quo3' => $request->input('total_quotation3'),
                'quotation1' => $pdf,
                'quotation2' => $pdf1,
                'quotation3' => $pdf2
            ]);
    
            alert()->success('Success', 'Quotation Has Been Submited');
            return to_route('purchase-submitquotation');
        } else {
            alert()->error('Error', 'Quotation Already Submitted/Submitted to Approval');
            return to_route('purchase-submitquotation');
        }
    }

    public function selectRab(Request $request)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->select('t_rab.idrec', 't_rab.date_rab', 't_rab.rab_type', 't_rab.id_rab', 't_rab.name_rab', 't_rab.division', 't_rab.approvalstat', 't_rab.id_company', 't_rab.gtotal', 'm_child_company.name', 'm_child_company.company_type', 'm_department.name as deptName',)
        ->whereIn('t_rab.approvalstat', ['Enforced', 'HQ 2 Approved']);

        if ($request->input('company') != null) {
            $dataRab = $dataRab->where('t_rab.id_company', $request->company);
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
                        data-title="' . $dataRab->name_rab . '" data-period="' . $dataRab->date_rab . '" data-division="' . $dataRab->division . '" id="select"
                        >Select</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        // <div x-data="{ modalOpen: false }">
        //                     <button  class="btn btn-sm btn-details text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
        //                         @click.prevent="modalOpen = true" aria-controls="feedback-modal" data-id="'.$dataRab->idrec.'"
        //                         data-rab_id = "' . $dataRab->id_rab . '" data-rab_type = "' . $dataRab->rab_type . '" data-rab_title ="'.$dataRab->name_rab.'" data-gtotal = "' . $dataRab->gtotal . '"
        //                         data-date = "' . $dataRab->date_rab . '" data-company = "' . $dataRab->name . '" data-company_type="'.$dataRab->company_type.'"
        //                     >Detail</button>
                            
        //                     <!-- Modal backdrop -->
        //                     <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
        //                         x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
        //                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        //                         x-transition:leave="transition ease-out duration-100"
        //                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        //                         aria-hidden="true" x-cloak></div>
        //                     <!-- Modal dialog -->
        //                     <div id="feedback-modal"
        //                         class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
        //                         role="dialog" aria-modal="true" x-show="modalOpen"
        //                         x-transition:enter="transition ease-in-out duration-200"
        //                         x-transition:enter-start="opacity-0 translate-y-4"
        //                         x-transition:enter-end="opacity-100 translate-y-0"
        //                         x-transition:leave="transition ease-in-out duration-200"
        //                         x-transition:leave-start="opacity-100 translate-y-0"
        //                         x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
        //                         <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
        //                             @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
        //                             <!-- Modal header -->
        //                             <div class="px-5 py-3 border-b border-slate-200">
        //                                 <div class="flex justify-between items-center">
        //                                     <div class="font-semibold text-slate-800">RAB Detail</div>
        //                                     <button class="text-slate-400 hover:text-slate-500"
        //                                         @click="modalOpen = false">
        //                                         <div class="sr-only">Close</div>
        //                                         <svg class="w-4 h-4 fill-current">
        //                                             <path
        //                                                 d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
        //                                         </svg>
        //                                     </button>
        //                                 </div>
        //                             </div>
        //                             <!-- Modal content -->
        //                             <div class="modal-content text-xs">
                                        
        //                             </div>
        //                             <!-- Modal footer -->
        //                             <div class="px-5 py-4 border-t border-slate-200">
        //                                 <div class="flex flex-wrap justify-end space-x-2">
        //                                     <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
        //                                         Close
        //                                     </button>
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        //                 </div>
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

    public function selectRabGetDetail($rabId)
    {
        $dataDetailRab = DB::table('t_rab')
            ->leftJoin('t_rab_detail', 't_rab.id_rab', 't_rab_detail.id_rab')
            ->leftJoin('m_rab_item', 't_rab_detail.id_rab_item', 'm_rab_item.id_rab_item')
            ->select('t_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status',
            't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.created_by', 't_rab_detail.created_at', 'm_rab_item.department', 'm_rab_item.sub_department'
            , 'm_rab_item.detail', 't_rab_detail.remarks')
            ->where('t_rab_detail.id_rab', $rabId)->where('t_rab_detail.status', '=', 'Active')
            ->get()->toArray();

        return $dataDetailRab;
    }

    public function ReimburseListUpdate(Request $request, $idRR)
    {
        $dataRab = DB::table('t_reimburse_request')->select('t_reimburse_request.idrec', 't_reimburse_request.idreqform', 't_reimburse_request.approvalstat')->where('t_reimburse_request.idrec', $idRR)->first();
        $idRab = $dataRab->idreqform;
        $approvalstat = $dataRab->approvalstat;
        $date = $request->input('periode');
        $date1 = date('Y-m-t',strtotime($date));
        $iden = $request->input('iden');
        try {
            if ($request->hasFile('file45')) {
                $filePdf = $request->file('file45');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File to Large, Please compress File');
                    return response()->json(["st" => '2']);
                }
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
               $pdf = null;
            }
            if ($approvalstat == 'Draft') {
                if (!empty($iden)) {
                    DB::transaction(function () use ($iden, $idRab, $request, $idRR, $pdf){
                        if ($pdf != null) {
                            DB::table('t_reimburse_request')->where('t_reimburse_request.idrec', $idRR)->update([
                                'bank_account' => $request->input('bank'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                'reimburse_file' => $pdf,
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
            
                            DB::table('t_reimburse_request_detail')->where('idreqform', $idRab)->delete();
                            foreach ($request->iden as $iden) {
                                DB::table('t_reimburse_request_detail')->insert([
                                    'idreqform' => $idRab,
                                    'date' => $request->input('date_'.$iden),
                                    'no_vehicle' => $request->input('plate_'.$iden),
                                    'reimburse_to' => $request->input('reimburse_'.$iden),
                                    'type' => $request->input('types_'.$iden),
                                    'subtotal' => $request->input('subtotal1_'.$iden),
                                    'vat' => $request->input('vat_type_'.$iden),
                                    'vat_percent' => $request->input('vat_percent1_'.$iden),
                                    'total_vat' => $request->input('total_vat1_'.$iden),
                                    'total' => $request->input('total1_'.$iden),
                                    'wht' => $request->input('wht_type_'.$iden),
                                    'wht_percent' => $request->input('wht_percent1_'.$iden),
                                    'norma' => $request->input('norma1_'.$iden),
                                    'total_wht' => $request->input('total_wht1_'.$iden),
                                    'paid_total' => $request->input('paid_total_'.$iden),
                                    'previous_payment' => $request->input('paid_total_'.$iden),
                                    'remarks' => $request->input('remarks1_'.$iden),
                                    'status' => $request->input('status_'.$iden)
                                ]);
                            }
                        } else {
                            DB::table('t_reimburse_request')->where('t_reimburse_request.idrec', $idRR)->update([
                                'bank_account' => $request->input('bank'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
            
                            DB::table('t_reimburse_request_detail')->where('idreqform', $idRab)->delete();
                            foreach ($request->iden as $iden) {
                                DB::table('t_reimburse_request_detail')->insert([
                                    'idreqform' => $idRab,
                                    'date' => $request->input('date_'.$iden),
                                    'no_vehicle' => $request->input('plate_'.$iden),
                                    'reimburse_to' => $request->input('reimburse_'.$iden),
                                    'type' => $request->input('types_'.$iden),
                                    'subtotal' => $request->input('subtotal1_'.$iden),
                                    'vat' => $request->input('vat_type_'.$iden),
                                    'vat_percent' => $request->input('vat_percent1_'.$iden),
                                    'total_vat' => $request->input('total_vat1_'.$iden),
                                    'total' => $request->input('total1_'.$iden),
                                    'wht' => $request->input('wht_type_'.$iden),
                                    'wht_percent' => $request->input('wht_percent1_'.$iden),
                                    'norma' => $request->input('norma1_'.$iden),
                                    'total_wht' => $request->input('total_wht1_'.$iden),
                                    'paid_total' => $request->input('paid_total_'.$iden),
                                    'previous_payment' => $request->input('paid_total_'.$iden),
                                    'remarks' => $request->input('remarks1_'.$iden),
                                    'status' => $request->input('status_'.$iden)
                                ]);
                            }
                        }
                    });
                    alert()->success('Success', 'Reimburse Request Has Been Edited');
                    return to_route('reimburse-listonly');
                } else {
                    alert()->error('Error', 'Reimburse Detail Empty');
                    return to_route('reimburse-listonly');
                }
            } else {
                alert()->error('Error', 'Reimburse Already Submitted');
                return to_route('reimburse-listonly');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function deleteReimburseDetail($id)
    {
        try {
            DB::table('t_reimburse_request_detail')->where('id', $id)->update([
                'status' => 'Non Active'
            ]);
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

    public function cancelPurchase($idPR)
    {
        try {
            DB::table('inventory_assets_request')->where('idrec', $idPR)->update([
                'approvalstat' => 'Canceled',
                'approval1_status' => 'Canceled'
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted purchase request",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function cancelReimburse($idRR)
    {
        try {
            DB::table('t_reimburse_request')->where('idrec', $idRR)->update([
                'approvalstat' => 'Canceled'
            ]);
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

    public function codeForm()
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $dataRab = DB::table('m_rab_item')->select('m_rab_item.id_rab_item', 'm_rab_item.detail', 'm_rab_item.department', 'm_rab_item.status')
        ->where('m_rab_item.status', '=', 'Active')->get();

        $dataCoa = DB::table('m_coa')->select('*')->get();

        $dataCategory = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $dataModel = DB::table('m_brand_model')->select('*')->where('p_id_brand', '=', '0')->where('status', '=', 'Active')->get();

        return view('pages.ga.inventory-code.form', compact('dataCurrency', 'dataRab', 'dataCoa', 'dataCategory', 'dataModel'));
    }

    public function codeCreate(Request $request)
    {
        try {
                $idAsset = $request->input('inventoryName');
                $dataInv = DB::table('inventory_assets')->select('name', 'aktifyn')->where('name', $idAsset)->where('aktifyn', '=', 'Y')->first();

                $latestId = DB::table('inventory_assets')
                ->select('idassets')
                ->orderBy('idassets', 'desc')
                ->first();

                if ($latestId) {
                    $numericPart = (int) substr($latestId->idassets, -8); // Ambil bagian numerik dari idassets terakhir
                    $newIdNumber = $numericPart + 1;
                    $idassets = str_pad($newIdNumber, 8, '0', STR_PAD_LEFT);
                } else {
                    // Jika tidak ada entri sebelumnya, mulai dengan '00000001'
                    $idassets = '00000001';
                }

                if ($request->hasFile('file')) {
                    $filePdf = $request->file('file');  
                    if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                        return response()->json(["st" => '2', 'error' => 'File size must be less than or equal to 5 MB']);
                    }  
                    $pdf = $filePdf->openFile()->fread($filePdf->getSize());
                } else {
                    $pdf = null;
                }
                
                if ($request->hasFile('photo')) {
                    $filePhoto = $request->file('photo');   
                    if ($filePhoto->getSize() > 15728640) { // 15 MB in bytes
                        return response()->json(["st" => '3', 'error' => 'Image size must be less than or equal to 15 MB']);
                    }   
                    $photo = $filePhoto->openFile()->fread($filePhoto->getSize());
                } else {
                    $photo = null;
                }

                if ($request->hasFile('photo')) {
                    $fileName = $request->file('photo')->storeAs('assetImg', $idAsset . '.jpg');
                    $request->file('photo')->move($this->saveImageUrl . 'assetImg/', $fileName);
                    } else {
                        $fileName = null;
                    }

                if ($dataInv == null) {
                    DB::transaction(function () use ($request, $idassets, $pdf, $photo, $fileName, $dataInv){
                        DB::table('inventory_assets')->insert([
                            'idassets' => $idassets,
                            'id_dept' => $request->input('category1'),
                            'category' => $request->input('category'),
                            'id_sub_dept' => $request->input('subCategory1'),
                            'sub_category' => $request->input('subCategory'),
                            'type' => $request->input('type'),
                            'id_brand' => $request->input('brand1'),
                            'brand' => $request->input('brand'),
                            'sku' => $request->input('sku'),
                            'color' => $request->input('color'),
                            'id_model' => $request->input('model1'),
                            'model_number' => $request->input('model'),
                            'name' => $request->input('inventoryName'),
                            'qty' => '0',
                            'unit' => $request->input('unit'),
                            'description' => $request->input('desc'),
                            'hpp' => '0',
                            'automargin' => '0',
                            'minsales' => '0',
                            'pricelist' => '0',
                            'lastpurch' => '0',
                            'aktifyn' => 'Y',
                            'wsprice' => '0',
                            'category2' => 'AYD',
                            'plu' => '',
                            'wunit' => $request->input('unit'),
                            'net_weight' => '1',
                            'file' => $pdf,
                            'img' => $photo,
                            'img_name' => $fileName
                        ]);
                    });
                    alert()->success('Success', 'New Inventory Asset #'. $idassets .' Has Been Created');
                    return response()->json(["st" => '1', "id"=>$idassets]);
                } else {
                    return response()->json(["st" => '0']);
                }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function viewFileInv($idAsset)
    {
        $data = DB::table('inventory_assets')->where('idassets', $idAsset)->select('file', 'idassets')->first();
        $filename = $data->idassets . '';
        $file = $data->file;

        return Response::make($file, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewImgInv($idAsset)
    {
        $data = DB::table('inventory_assets')->where('idassets', $idAsset)->select('img', 'idassets')->first();
        $filename = $data->idassets . '';
        $img = $data->img;

        return Response::make($img, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->img),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewFileReimburse($id)
    {
        $data = DB::table('t_reimburse_request_detail')->whereRaw("t_reimburse_request_detail.id = '$id'")->select('file', 'idreqform', 'id')->first();
        $filename = $data->idreqform . '/' . $id;
        $file = $data->file;

        return Response::make($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function postFile(Request $request, $idAsset)
    {
        try {
            if ($request->hasFile('file')) {
                $filePdf = $request->file('file');   
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    return response()->json(["st" => '2', 'error' => 'File size must be less than or equal to 5 MB']);
                } 
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
               } else {
                   $pdf = null;
               }
    
               if ($request->hasFile('photo')) {
                $fileImg = $request->file('photo');
                if ($fileImg->getSize() > 15728640) { // 15 MB in bytes
                    return response()->json(["st" => '3', 'error' => 'Image size must be less than or equal to 15 MB']);
                }    
                $img = $fileImg->openFile()->fread($fileImg->getSize());
               } else {
                   $img = null;
               }
    
               if ($request->hasFile('photo')) {
                $fileName = $request->file('photo')->storeAs('assetImg', $idAsset . '.jpg');
                $request->file('photo')->move($this->saveImageUrl . 'assetImg/', $fileName);
                } else {
                    $fileName = null;
                }
                $nameAsset = $request->input('inventoryName');
                $unitAsset = $request->input('unit');
                $catAsset = $request->input('category');
                $subCatAsset = $request->input('subCategory');
                $brandAsset = $request->input('brand');
                $modelAsset = $request->input('model');
                $colorAsset = $request->input('color');
                $skuAsset = $request->input('sku');
                $typeAsset = $request->input('type');
                $descAsset = $request->input('desc');
                
                // Mengambil data aset berdasarkan ID
                $dataCode = DB::table('inventory_assets')->where('idassets', $idAsset)->where('aktifyn', '=', 'Y')->first();
                
                // Memeriksa apakah ada aset lain dengan nama yang sama
                $dataName = DB::table('inventory_assets')->where('name', $nameAsset)->where('aktifyn', '=', 'Y')->first();
                
                // Memeriksa apakah terdapat perubahan pada atribut selain nama aset
                $isDifferent = (
                    $dataCode->unit != $unitAsset ||
                    $dataCode->category != $catAsset ||
                    $dataCode->sub_category != $subCatAsset ||
                    $dataCode->brand != $brandAsset ||
                    $dataCode->model_number != $modelAsset ||
                    $dataCode->color != $colorAsset ||
                    $dataCode->sku != $skuAsset ||
                    $dataCode->type != $typeAsset ||
                    $dataCode->description != $descAsset
                );

            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
                
            if ($dataName == null || ($dataName->idassets == $idAsset && $isDifferent) || !empty($request->file('file')) || !empty($request->file('photo'))) {
                DB::transaction(function () use ($request, $pdf, $img, $fileName, $idAsset){
                    if (!empty($request->file('file') && $request->input('photo'))) {
                        DB::table('inventory_assets')->where('inventory_assets.idassets', $idAsset)->update([
                            'category' => $request->input('category'),
                            'id_dept' => $request->input('category1'),
                            'sub_category' => $request->input('subCategory'),
                            'id_sub_dept' => $request->input('subCategory1'),
                            'type' => $request->input('type'),
                            'brand' => $request->input('brand'),
                            'id_brand' => $request->input('brand1'),
                            'sku' => $request->input('sku'),
                            'color' => $request->input('color'),
                            'model_number' => $request->input('model'),
                            'id_model' => $request->input('model1'),
                            'name' => $request->input('inventoryName'),
                            'unit' => $request->input('unit'),
                            'wunit' => $request->input('unit'),
                            'description' => $request->input('desc'),
                            'file' => $pdf,
                            'img' => $img,
                            'img_name' => $fileName
                        ]);
                    }else if (!empty($request->file('photo'))) {
                        DB::table('inventory_assets')->where('inventory_assets.idassets', $idAsset)->update([
                            // 'idassets' => $request->input('inventoryCode'),
                            // 'id_coa' => $request->input('coa'),
                            // 'id_rab_item' => $request->input('idRab'),
                            'category' => $request->input('category'),
                            'id_dept' => $request->input('category1'),
                            'sub_category' => $request->input('subCategory'),
                            'id_sub_dept' => $request->input('subCategory1'),
                            'type' => $request->input('type'),
                            'brand' => $request->input('brand'),
                            'id_brand' => $request->input('brand1'),
                            'sku' => $request->input('sku'),
                            'color' => $request->input('color'),
                            'model_number' => $request->input('model'),
                            'id_model' => $request->input('model1'),
                            'name' => $request->input('inventoryName'),
                            'unit' => $request->input('unit'),
                            'wunit' => $request->input('unit'),
                            'description' => $request->input('desc'),
                            'img' => $img,
                            'img_name' => $fileName
                        ]);
                    }else if (!empty($request->file('file'))) {
                        DB::table('inventory_assets')->where('inventory_assets.idassets', $idAsset)->update([
                            // 'idassets' => $request->input('inventoryCode'),
                            // 'id_coa' => $request->input('coa'),
                            // 'id_rab_item' => $request->input('idRab'),
                            'category' => $request->input('category'),
                            'id_dept' => $request->input('category1'),
                            'sub_category' => $request->input('subCategory'),
                            'id_sub_dept' => $request->input('subCategory1'),
                            'type' => $request->input('type'),
                            'brand' => $request->input('brand'),
                            'id_brand' => $request->input('brand1'),
                            'sku' => $request->input('sku'),
                            'color' => $request->input('color'),
                            'model_number' => $request->input('model'),
                            'id_model' => $request->input('model1'),
                            'name' => $request->input('inventoryName'),
                            'unit' => $request->input('unit'),
                            'wunit' => $request->input('unit'),
                            'description' => $request->input('desc'),
                            'file' => $pdf
                        ]);
                    }else if (empty($request->file('file') && $request->input('photo'))) {
                        DB::table('inventory_assets')->where('inventory_assets.idassets', $idAsset)->update([
                            // 'idassets' => $request->input('inventoryCode'),
                            // 'id_coa' => $request->input('coa'),
                            // 'id_rab_item' => $request->input('idRab'),
                            'category' => $request->input('category'),
                            'id_dept' => $request->input('category1'),
                            'sub_category' => $request->input('subCategory'),
                            'id_sub_dept' => $request->input('subCategory1'),
                            'type' => $request->input('type'),
                            'brand' => $request->input('brand'),
                            'id_brand' => $request->input('brand1'),
                            'sku' => $request->input('sku'),
                            'color' => $request->input('color'),
                            'model_number' => $request->input('model'),
                            'id_model' => $request->input('model1'),
                            'name' => $request->input('inventoryName'),
                            'unit' => $request->input('unit'),
                            'description' => $request->input('desc'),
                            'wunit' => $request->input('unit')
                        ]);
                    }
                });
                alert()->success('Success', 'Inventory Asset Has Been Updated');
                return response()->json(["st" => '1', "id"=>$idAsset]);
            } else {
                return response()->json(["st" => '0']);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function childCompany()
    {
        return view('pages.ga.data-master.m-child-company.index');
    }
    public function childCompanyList()
    {
        return view('pages.ga.data-master.m-child-company.list');
    }

    public function childCompanyForm()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        return view('pages.ga.data-master.m-child-company.m-childcompany-form', compact('dataCountry'));
    }

    public function childCompanyEdit()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        return view('pages.ga.data-master.m-child-company.m-childcompany-edit', compact('dataCountry'));
    }

    public function childCompanyDeletePage()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        return view('pages.ga.data-master.m-child-company.m-childcompany-delete', compact('dataCountry'));
    }

    public function childCompanyCreate(Request $request)
    {
        $companyName = $request->input('childName');

        if ($request->hasFile('npwp_pdf')) {
            $filePdf = $request->file('npwp_pdf');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
            $pdf = null;
        } 
        
        if ($request->hasFile('img')) {
            $filePhoto = $request->file('img');    
            $image = $filePhoto->openFile()->fread($filePhoto->getSize());
        } else {
            $image = null;
        }  
        
        if ($request->hasFile('img')) {
            $fileName = $request->file('img')->storeAs('companyLogo', $companyName . '.jpg');
            $request->file('img')->move($this->saveImageUrl . 'companyLogo/', $fileName);
            } else {
                $fileName = null;
            }

            $dataChildCompany = DB::table('m_child_company')->select('name')->where('name', $companyName)->first();
            
        if ($dataChildCompany == null) {
                DB::table('m_child_company')->insert([
                    'initials' => $request->input('initials'),
                    'company_type' => $request->input('companyType'),
                    'name' => $request->input('childName'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'country' => $request->input('country'),
                    'zip_code' => $request->input('zipCode'),
                    'npwp_id' => $request->input('npwp_id'),
                    'npwp_address' => $request->input('npwp_address'),
                    'npwp_city' => $request->input('npwp_city'),
                    'npwp_country' => $request->input('npwp_country'),
                    'npwp_zipcode' => $request->input('npwp_zipcode'),
                    'npwp_pdf' => $pdf,
                    'logo_blob' => $image,
                    'logo_filename' => $fileName,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d'),
                    'status' => 'Active'
                ]);
            alert()->success('Success', 'Data Child Company Has Been Created');
            return to_route('child-company.form');
        } else {
            alert()->error('Error', 'Company Already Exist');
            return to_route('child-company.form');
        }
    }

    public function childCompanyGetData(Request $request)
    {
        $dataChildCompany = DB::table('m_child_company')
        ->select('id_company', 'initials', 'company_type', 'name', 'address', 'city', 'country', 'zip_code', 'npwp_id', 'npwp_address', 'npwp_city', 'npwp_country',
        'npwp_zipcode', 'logo_filename', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status')->where('status', '=', 'Active')->orderBy('created_at', 'desc'); 

        if ($request->ajax()) {
            return DataTables::of($dataChildCompany)
            ->editColumn('created_at', function ($dataChildCompany) {
                return date('Y-m-d', strtotime($dataChildCompany->created_at));
            })
            ->addColumn('action', function ($dataChildCompany) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_company="'.$dataChildCompany->id_company.'"
                                data-zip_code = "' . $dataChildCompany->zip_code . '" data-initials = "' . $dataChildCompany->initials . '"
                                data-name = "' . $dataChildCompany->name . '" data-country = "' . $dataChildCompany->country . '"
                                data-city = "' . $dataChildCompany->city . '" data-address = "' . $dataChildCompany->address . '" data-type = "' . $dataChildCompany->company_type . '" 
                                data-npwp_id = "' . $dataChildCompany->npwp_id . '" data-npwp_address = "' . $dataChildCompany->npwp_address . '" data-npwp_city = "' . $dataChildCompany->npwp_city . '" 
                                data-npwp_country = "' . $dataChildCompany->npwp_country . '" data-npwp_zipcode = "' . $dataChildCompany->npwp_zipcode . '"
                                
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Child Company</div>
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
            ->addColumn('logo', function ($dataChildCompany) {
                if ($dataChildCompany->logo_filename == null) {
                    return '
                    <div class="flex flex-row justify-center">

                    </div>';
                } else {                     
                    return '   
                    <div class="flex flex-row justify-center">  
                        <img src="http://ayoda.integrated-os.cloud/' . $dataChildCompany->logo_filename . '" width="100" height="50" alt="companyLogo">
                    </div>';
                }
            })
            // ->addColumn('npwp', function ($dataChildCompany) {
            //     if ($dataChildCompany->npwp_pdf == null) {
            //         return '
            //         <div class="flex flex-row justify-center">
                    
            //         </div>';
            //     } else {                     
            //         return '   
            //         <div class="flex flex-row justify-center">  
            //             <a href = "/data-master/m-child-company/viewNpwp/' . $dataChildCompany->id_company . '" target="_blank" class="btn btn-xs text-xs bg-sky-500 hover:bg-sky-600 text-white ml-1"    
            //             >View NPWP</a>
            //         </div>';
            //     }
            // })
            ->addColumn('action1', function ($dataChildCompany) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id_company="'.$dataChildCompany->id_company.'" data-name = "' . $dataChildCompany->name . '" data-type = "' . $dataChildCompany->company_type . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1', 'logo', 'npwp'])
            ->make();
        }
    }

    public function childCompanyUpdate(Request $request, $id)
    {
        $companyName = $request->input('childName1');

        if ($request->hasFile('npwp_pdf1')) {
            $filePdf = $request->file('npwp_pdf1');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
            $pdf = null;
        } 

        if ($request->hasFile('image1')) {
            $filePhoto = $request->file('image1');    
            $image = $filePhoto->openFile()->fread($filePhoto->getSize());
        } else {
            $image = null;
        }  
        
        if ($request->hasFile('image1')) {
            $fileName = $request->file('image1')->storeAs('companyLogo', $companyName . '.jpg');
            $request->file('image1')->move($this->saveImageUrl . 'companyLogo/', $fileName);
            } else {
                $fileName = null;
            }
        
            // $dataChildCompany = DB::table('m_child_company')->select('name')->where('name', $companyName)->first();
        if ($request) {
            if (!empty($request->file('image1'))) {
                DB::table('m_child_company')->where('id_company', $id)->update([
                    'initials' => $request->input('initials1'),
                    'name' => $request->input('childName1'),
                    'address' => $request->input('address1'),
                    'city' => $request->input('city1'),
                    'country' => $request->input('country1'),
                    'zip_code' => $request->input('zipCode1'),
                    'npwp_id' => $request->input('npwp_id1'),
                    'npwp_address' => $request->input('npwp_address1'),
                    'npwp_city' => $request->input('npwp_city1'),
                    'npwp_country' => $request->input('npwp_country1'),
                    'npwp_zipcode' => $request->input('npwp_zipcode1'),
                    'logo_blob' => $image,
                    'logo_filename' => $fileName,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
    
                alert()->success('Success', 'Data Child Company Has Been Updated');
                return to_route('child-company.edit');
            } elseif (!empty($request->file('npwp_pdf1'))) {
                DB::table('m_child_company')->where('id_company', $id)->update([
                    'initials' => $request->input('initials1'),
                    'name' => $request->input('childName1'),
                    'address' => $request->input('address1'),
                    'city' => $request->input('city1'),
                    'country' => $request->input('country1'),
                    'zip_code' => $request->input('zipCode1'),
                    'npwp_id' => $request->input('npwp_id1'),
                    'npwp_address' => $request->input('npwp_address1'),
                    'npwp_city' => $request->input('npwp_city1'),
                    'npwp_country' => $request->input('npwp_country1'),
                    'npwp_zipcode' => $request->input('npwp_zipcode1'),
                    'npwp_pdf' => $pdf,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
    
                alert()->success('Success', 'Data Child Company Has Been Updated');
                return to_route('child-company.edit');
            }elseif (!empty($request->file('npwp_pdf1') && $request->file('image1'))) {
                DB::table('m_child_company')->where('id_company', $id)->update([
                    'initials' => $request->input('initials1'),
                    'name' => $request->input('childName1'),
                    'address' => $request->input('address1'),
                    'city' => $request->input('city1'),
                    'country' => $request->input('country1'),
                    'zip_code' => $request->input('zipCode1'),
                    'npwp_id' => $request->input('npwp_id1'),
                    'npwp_address' => $request->input('npwp_address1'),
                    'npwp_city' => $request->input('npwp_city1'),
                    'npwp_country' => $request->input('npwp_country1'),
                    'npwp_zipcode' => $request->input('npwp_zipcode1'),
                    'npwp_pdf' => $pdf,
                    'logo_blob' => $image,
                    'logo_filename' => $fileName,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
    
                alert()->success('Success', 'Data Child Company Has Been Updated');
                return to_route('child-company.edit');
            }elseif (empty($request->file('npwp_pdf1') && $request->file('image1'))) {
                DB::table('m_child_company')->where('id_company', $id)->update([
                    'initials' => $request->input('initials1'),
                    'name' => $request->input('childName1'),
                    'address' => $request->input('address1'),
                    'city' => $request->input('city1'),
                    'country' => $request->input('country1'),
                    'zip_code' => $request->input('zipCode1'),
                    'npwp_id' => $request->input('npwp_id1'),
                    'npwp_address' => $request->input('npwp_address1'),
                    'npwp_city' => $request->input('npwp_city1'),
                    'npwp_country' => $request->input('npwp_country1'),
                    'npwp_zipcode' => $request->input('npwp_zipcode1'),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d')
                ]);
    
                alert()->success('Success', 'Data Child Company Has Been Updated');
                return to_route('child-company.edit');
            }
        } else {
            alert()->error('Error', 'Child Company Already Exist');
            return to_route('child-company.edit');
        }
    }

    public function viewLogo($id)
    {
        $data = DB::table('m_child_company')->where('id_company', $id)->select('logo_blob', 'name')->first();
        $filename = $data->name . '';
        $img = $data->logo_blob;

        return Response::make($img, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->logo_blob),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewNpwp($id)
    {
        $data = DB::table('m_child_company')->where('id_company', $id)->select('npwp_pdf', 'name')->first();
        $filename = $data->name . '';
        $img = $data->npwp_pdf;

        return Response::make($img, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->npwp_pdf),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function childCompanyDelete($id)
    {
        try {
            DB::table('m_child_company')->where('id_company', $id)->update([
                'status' => 'Non Active',
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data Child Company",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function bankir()
    {
        return view('pages.ga.data-master.m-bank.index');
    }
    public function bankirList()
    {
        return view('pages.ga.data-master.m-bank.list');
    }

    public function bankForm()
    {
        return view('pages.ga.data-master.m-bank.m-bank-form');
    }

    public function bankEdit()
    {
        return view('pages.ga.data-master.m-bank.m-bank-edit');
    }

    public function bankDeletePage()
    {
        return view('pages.ga.data-master.m-bank.m-bank-delete');
    }

    public function bankCreate(Request $request)
    {
        $bankir = $request->input('bank');

        $bankName = DB::table('m_bank')->select('name')->where('name', $bankir)->first();
            
        if ($bankName == null) {
                DB::table('m_bank')->insert([
                    'name' => $request->input('bank'),
                    'created_by' => Auth::user()->username,
                    'created_at' => date('Y-m-d'),
                    'status' => 'Active'
                ]);
            alert()->success('Success', 'Bank Has Been Created');
            return to_route('bank.form');
        } else {
            alert()->error('Error', 'Bank Already Exist');
            return to_route('bank.form');
        }
    }

    public function bankGetData(Request $request)
    {
        $dataBank = DB::table('m_bank')
        ->select('*')->where('status', '=', 'Active')->orderBy('id_bank', 'asc'); 

        if ($request->ajax()) {
            return DataTables::of($dataBank)
            ->editColumn('created_at', function ($dataBank) {
                return date('Y-m-d', strtotime($dataBank->created_at));
            })
            ->addColumn('action', function ($dataBank) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_bank="'.$dataBank->id_bank.'"
                                data-bank = "' . $dataBank->name . '"
                                
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Bank</div>
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
            ->addColumn('action1', function ($dataBank) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id_bank="'.$dataBank->id_bank.'" data-bank = "' . $dataBank->name . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1', 'logo', 'npwp'])
            ->make();
        }
    }

    public function bankUpdate(Request $request, $idBank)
    {
        $bankir = $request->input('bank1');

        $bankName = DB::table('m_bank')->select('name')->where('name', $bankir)->first();
            
        if ($bankName == null) {
            DB::table('m_bank')->where('id_bank', $idBank)->update([
                'name' => $request->input('bank1'),
                'updated_by' => Auth::user()->username,
                'updated_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Bank Has Been Updated');
            return to_route('bank.edit');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('bank.edit');
        }
    }

    public function bankDelete($idBank)
    {
        try {
            DB::table('m_bank')->where('id_bank', $idBank)->update([
                'status' => 'Non Active',
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Bank",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterRab(Request $request)
    {
        return view('pages.ga.data-master.m-rab-item.index');
    }

    public function masterRabForm(Request $request)
    {
        $dataDepartment = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $dataSubDepartment = DB::table('m_subdepartment')->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.dept_name', 'm_subdepartment.status', 'm_subdepartment.p_id_dept')->where('m_subdepartment.status', '=', 'Active')->orderBy('m_subdepartment.name', 'asc')->get();
        $dataCoa = DB::table('m_coa')->select('*')->get();
        $dataCurrency = DB::table('currency')
        ->select('*')->get();
        return view('pages.ga.data-master.m-rab-item.m-rabitem-form', compact('dataDepartment', 'dataCoa', 'dataSubDepartment', 'dataCurrency'));
    }

    public function masterRabEdit(Request $request)
    {
        $dataDepartment = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubDepartment = DB::table('m_subdepartment')->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.dept_name', 'm_subdepartment.status', 'm_subdepartment.p_id_dept')->where('m_subdepartment.status', '=', 'Active')->get();
        $dataCoa = DB::table('m_coa')->select('*')->get();
        return view('pages.ga.data-master.m-rab-item.m-rabitem-edit', compact('dataDepartment', 'dataCoa', 'dataSubDepartment'));
    }

    public function masterRabDeletePage(Request $request)
    {
        $dataDepartment = DB::table('m_department')->select('*')->where('status', '=', 'Active')->get();
        $dataSubDepartment = DB::table('m_subdepartment')->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.dept_name', 'm_subdepartment.status', 'm_subdepartment.p_id_dept')->where('m_subdepartment.status', '=', 'Active')->get();
        $dataCoa = DB::table('m_coa')->select('*')->get();
        return view('pages.ga.data-master.m-rab-item.m-rabitem-delete', compact('dataDepartment', 'dataCoa', 'dataSubDepartment'));
    }

    public function masterRabCreate(Request $request)
    {
        $deptName = DB::table('m_department')->where('id', $request->input('department'))->pluck('name')->first();
        $subDeptName = DB::table('m_subdepartment')->where('id', $request->input('subDepartment'))->pluck('name')->first();
        if ($request) {
            DB::table('m_rab_item')->insert([
                'p_id_dept' => $request->input('department'),
                'department' => $deptName,
                'p_id_sub_dept' => $request->input('subDepartment'),
                'sub_department' => $subDeptName,
                'detail' => $request->input('detail'),
                'coa' => $request->input('coa'),
                'status' => 'Active',
                'created_by' => Auth::user()->username,
                'created_at' => date('Y-m-d'),
                'last_updated_by' => Auth::user()->username,
                'last_updated_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data RAB Item Has Been Created');
            return to_route('master-rab.form');
        } else {
            alert()->error('Error', 'RAB ID are already exist');
            return to_route('master-rab.form');
        }
    }

    public function masterRabGetData(Request $request)
    {
        $dataRab = DB::table('m_rab_item')
        ->leftJoin('m_department', 'm_rab_item.department', 'm_department.name')
        ->leftJoin('m_coa', 'm_rab_item.coa', 'm_coa.acc_code')
        ->select('m_rab_item.id_rab_item', 'm_rab_item.department', 'm_rab_item.sub_department', 'm_rab_item.detail', 'm_rab_item.coa', 'm_rab_item.status', 'm_coa.acc_name',
        'm_rab_item.created_at', 'm_department.name as departmentName')->where('m_rab_item.status', '=', 'Active')->orderBy('m_rab_item.created_at', 'desc');
        if ($request->ajax()) {
            return DataTables::of($dataRab)
            ->editColumn('created_at', function ($dataRab) {
                return date('Y-m-d', strtotime($dataRab->created_at));
            })
            ->addColumn('action', function ($dataRab) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataRab->id_rab_item.'"
                                data-department = "' . $dataRab->department . '" data-coa = "' . $dataRab->coa . '" data-detail = "' . $dataRab->detail . '" 
                                data-sub_department = "' . $dataRab->sub_department . '" 
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
                                            <div class="font-semibold text-slate-800">Edit RAB Item</div>
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
            ->addColumn('action1', function ($dataRab) {
                return '
                <div class="flex flex-row">            
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->id_rab_item.'"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function masterRabUpdate(Request $request, $id)
    {
        if ($request) {
            DB::table('m_rab_item')->where('id_rab_item', $id)->update([
                'detail' => $request->input('detail1'),
                'coa' => $request->input('coa1'),
                'last_updated_by' => Auth::user()->username,
                'last_updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'RAB Item Has Been Updated');
            return to_route('master-rab.edit');
        } else {
            alert()->error('Error', 'error');
            return to_route('master-rab.edit');
        }
    }

    public function masterRabDelete($id)
    {
        try {
            DB::table('m_rab_item')->where('id_rab_item', $id)->update([
                'status'=>'Non Active',
                'last_updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted RAB Item",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function rabForm()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
        ->where('m_child_company.id_company', $user)->first();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $cidBank = DB::table('m_benef_bank')->leftJoin('m_bank', 'm_benef_bank.id_bank', 'm_bank.id_bank')->select('m_benef_bank.*', 'm_bank.name as bankName')->where('m_benef_bank.aktifyn', '=', 'Y')->get();
        return view('pages.ga.rab.form', compact('dataChildCompany','fixCompany', 'department', 'bank', 'cidBank'));
    }

    public function rabItem(Request $request)
    {
        $dataRab = DB::table('m_rab_item')
        ->leftJoin('m_department', 'm_rab_item.department', 'm_department.name')
        ->select('m_rab_item.id_rab_item', 'm_rab_item.department', 'm_rab_item.sub_department', 'm_rab_item.detail', 'm_rab_item.coa',
        'm_rab_item.created_at', 'm_rab_item.status', 'm_department.name as departmentName')->where('m_rab_item.status', '=', 'Active')->orderBy('m_rab_item.created_at', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataRab)
                ->editColumn('created_at', function ($dataRab) {
                    return date('Y-m-d', strtotime($dataRab->created_at));
                })
                ->addColumn('action', function ($dataRab) {

                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataRab->id_rab_item . '"
                    data-nama="' . $dataRab->sub_department . '" data-department="' . $dataRab->department . '" data-coa="' . $dataRab->coa . '"
                    data-detail="' . $dataRab->detail . '" id="select"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function rabCreate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('periode');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/RAB/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_rab')
            ->where('id_rab', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $rabId = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->id_rab;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $rabId = $indicator . $countIndicator;
        }


        $date = $request->input('periode');

        $date1 = date('Y-m-t',strtotime($date));
        $dateFormRAB = date('Y-m-t',strtotime($date)); 

        $rowsProducts = $request->get('rows');
        // dd($rowsProducts);

        $dateNow = date('Y-m-d');
        try {
            if ($dateFormRAB == $dateNow) {
                if (!empty($rowsProducts)) {
                    DB::transaction(function () use ($rowsProducts, $date1, $request, $rabId){
                        DB::table('t_rab')->insert([
                            'date_rab' => $date1,
                            'form_date' => date('Y-m-d',strtotime($request->input('formDate'))),
                            'currency' => 'IDR',
                            'rab_type' => $request->input('rabType'),
                            'id_rab' => $rabId,
                            'name_rab' => $request->input('rabName'),
                            'applicant' => $request->input('name'),
                            'id_company' => $request->input('company'),
                            'division' => $request->input('department'),
                            'gtotal' => $request->input('grandtotal1'),
                            'balance' => $request->input('grandtotal1'),
                            'prepared_date' => $request->input('formDate'),
                            'beneficiary_bank' => $request->input('bank'),
                            'beneficiary_name' => $request->input('account'),
                            'beneficiary_acc' => $request->input('number'),
                            'created_at' => date('Y-m-d'),
                            'created_by' => Auth::user()->id,
                            'print_status' => 'N',
                            'approvalstat' => 'Draft'
                        ]);

                        foreach ($rowsProducts as $key) {
                            DB::table('t_rab_detail')->insert([
                                'date_rab' => $date1,
                                'id_rab' => $rabId,
                                'rab_calc_type' => $key['rabCalcTypes'],
                                'id_rab_item' => $key['ids'],
                                'category' => $key['categorys'],
                                'sub_category' => $key['sub_categorys'],
                                'name_rab_detail' => $key['namesis'],
                                'unit' => $key['units'],
                                'days' => $key['dayss'],
                                'qty' => $key['qtys'],
                                'amount' => $key['prices'],
                                'total' => $key['totals'],
                                'balance' => $key['totals'],
                                'remarks' => $key['remarkss'],
                                'created_by' => Auth::user()->username,
                                'created_at' => date('Y-m-d'),
                                'last_updated_by' => Auth::user()->username,
                                'last_updated_at' => date('Y-m-d'),
                                'status' => 'Active',
                                'approvalstat' => 'Draft'
                            ]);
                        }
                    });
                    alert()->success('Success', 'RAB #' . $rabId . ' Has Been Created');
                    return to_route('rab-listonly');
                } else{
                    alert()->error('Error', 'Products Not Fill');
                    return to_route('rabga');
                }
                
            } else if($dateFormRAB > $dateNow){
                if (!empty($rowsProducts)) {
                    DB::transaction(function () use ($rowsProducts, $date1, $request, $rabId){
                        DB::table('t_rab')->insert([
                            'date_rab' => $date1,
                            'form_date' => $request->input('formDate'),
                            'currency' => 'IDR',
                            'rab_type' => $request->input('rabType'),
                            'id_rab' => $rabId,
                            'name_rab' => $request->input('rabName'),
                            'applicant' => $request->input('name'),
                            'id_company' => $request->input('company'),
                            'division' => $request->input('department'),
                            'gtotal' => $request->input('grandtotal1'),
                            'balance' => $request->input('grandtotal1'),
                            'prepared_date' => $request->input('formDate'),
                            'beneficiary_bank' => $request->input('bank'),
                            'beneficiary_name' => $request->input('account'),
                            'beneficiary_acc' => $request->input('number'),
                            'created_at' => date('Y-m-d'),
                            'created_by' => Auth::user()->id,
                            'print_status' => 'N',
                            'approvalstat' => 'Draft'
                        ]);

                        foreach ($rowsProducts as $key) {
                            DB::table('t_rab_detail')->insert([
                                'date_rab' => $date1,
                                'id_rab' => $rabId,
                                'rab_calc_type' => $key['rabCalcTypes'],
                                'id_rab_item' => $key['ids'],
                                'category' => $key['categorys'],
                                'sub_category' => $key['sub_categorys'],
                                'name_rab_detail' => $key['namesis'],
                                'unit' => $key['units'],
                                'days' => $key['dayss'],
                                'qty' => $key['qtys'],
                                'amount' => $key['prices'],
                                'total' => $key['totals'],
                                'balance' => $key['totals'],
                                'remarks' => $key['remarkss'],
                                'created_by' => Auth::user()->username,
                                'created_at' => date('Y-m-d'),
                                'last_updated_by' => Auth::user()->username,
                                'last_updated_at' => date('Y-m-d'),
                                'status' => 'Active',
                                'approvalstat' => 'Draft'
                            ]);
                        }
                    });
                    alert()->success('Success', 'RAB #' . $rabId . ' Has Been Created');
                    return to_route('rab-listonly');
                } else{
                    alert()->error('Error', 'Products Not Fill');
                    return to_route('rabga');
                }
            } else if($dateFormRAB < $dateNow){
                alert()->error('Error', 'RAB cannot be in the past');
                return to_route('rabga');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function rabList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.list.rab-request', compact('dataChildCompany', 'department'));
    }

    public function rabListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.list.rab-list-only', compact('dataChildCompany', 'department'));
    }

    public function rabListEnforced()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.printform', compact('dataChildCompany', 'department'));
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
        );

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

    public function rabPrintSubmit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.list.printsubmit', compact('dataChildCompany', 'department'));
    }

    public function rabListGetPrintSubmit(Request $request)
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
        )->where(function ($query) {
            $query->where('t_rab.approvalstat', '=', 'Draft')->orWhere('t_rab.approvalstat', '=', 'Printed');
        });

        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
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
                        <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"   
                        >View</a>

                        <a href = "/ga/rab-approval/list/signature/' . $dataRab->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Print</a>
                    </div>';
                }elseif ($dataRab->approvalstat == 'Printed' && $dataRab->print_status == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>

                    <a href = "/ga/rab-approval/list/submitpage/' . $dataRab->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"  
                    >Submit Approval</a>
                    
                    <a href = "/ga/rab-approval/list/signature/' . $dataRab->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                    >Reprint</a>
                    </div>';
                }else if($dataRab->approvalstat == 'Site Approved'){
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                    >Cancel</button>
                    </div>';
                }elseif ($dataRab->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"   
                        >View</a>
                    </div>';
                }elseif ($dataRab->approvalstat == 'HQ 1 Approved' || $dataRab->approvalstat == 'HQ 2 Approved' || $dataRab->approvalstat == 'Enforced' || $dataRab->approvalstat == 'HQ 1 Denied' || $dataRab->approvalstat == 'HQ 2 Denied' || $dataRab->approvalstat == 'HQ 3 Denied') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"    
                    >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function rabListGetPrintEnforced(Request $request)
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
        )->where('t_rab.approvalstat', '=', 'Enforced');

        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
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
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/rab-approval/list/printedenforced/' . $dataRab->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Print</a>
                    </div>';
                
            })
            
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function rabListView(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        return view('pages.ga.rab-approval.list.view', compact('dataRab', 'dataRabItem'));
    }

    public function rabListSubmit(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;

        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        $dataUser = DB::table('m_approval_rab')->leftJoin('users', 'm_approval_rab.id', 'users.id')->select('m_approval_rab.id', 'm_approval_rab.id_company', 'users.username')->where('m_approval_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        $dataUser2 = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'm_approval2_rab.id_company', 'users.username')->where('m_approval2_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        $dataUser3 = DB::table('m_approval3_rab')->leftJoin('users', 'm_approval3_rab.id', 'users.id')->select('m_approval3_rab.id', 'm_approval3_rab.id_company', 'users.username')->where('m_approval3_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();

        return view('pages.ga.rab-approval.list.rab-submit', compact('dataRab', 'dataRabItem', 'dataUser', 'dataUser2', 'dataUser3'));
    }

    public function rabListUpdatePage(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;

        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.date_rab', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks', 't_rab_detail.approvalstat')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        return view('pages.ga.rab-approval.list.updatepage', compact('dataRab', 'dataRabItem', 'bank'));
    }

    public function rabListUpdate(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')->select('t_rab.idrec', 't_rab.id_rab', 't_rab.approvalstat')->where('t_rab.idrec', $rabId)->first();
        $idRab = $dataRab->id_rab;
        $approvalstat = $dataRab->approvalstat;
        $date = $request->input('periode');
        $date1 = date('Y-m-t',strtotime($date));
        try {  
                if ($approvalstat == 'Draft') {
                    $iden = $request->input('iden');
                    $rowsProducts = $request->input('rows');
                    if (!empty($iden) || !empty($rowsProducts)) {
                            DB::transaction(function () use ($idRab, $iden, $rowsProducts, $date1, $request, $rabId){
                                DB::table('t_rab')->where('t_rab.idrec', $rabId)->update([
                                    'name_rab' => $request->input('rabName'),
                                    'rab_type' => $request->input('rabType'),
                                    'beneficiary_bank' => $request->input('bank'),
                                    'beneficiary_name' => $request->input('account'),
                                    'beneficiary_acc' => $request->input('number'),
                                    'gtotal' => $request->input('grandtotal1'),
                                    'updated_at' => date('y-m-d'),
                                    'updated_by' => Auth::user()->id
                                ]);
                                DB::table('t_rab_detail')->where('t_rab_detail.id_rab', $idRab)->delete();
                                if (!empty($iden)) {
                                    foreach ($request->iden as $iden) {
                                        DB::table('t_rab_detail')->insert([
                                            'date_rab' => $date1,
                                            'id_rab' => $request->input('offer_'.$iden),
                                            'rab_calc_type' => $request->input('calcul_'.$iden),
                                            'id_rab_item' => $request->input('ids_'.$iden),
                                            'category' => $request->input('cats_'.$iden),
                                            'sub_category' => $request->input('m-currency_'.$iden),
                                            'name_rab_detail' => $request->input('details_'.$iden),
                                            'unit' => $request->input('units1_'.$iden),
                                            'days' => $request->input('days1_'.$iden),
                                            'qty' => $request->input('qty_'.$iden),
                                            'amount' => $request->input('price_'.$iden),
                                            'total' => $request->input('total_'.$iden),
                                            'balance' => $request->input('total_'.$iden),
                                            'remarks' => $request->input('remarks1_'.$iden),
                                            'status' => $request->input('status_'.$iden),
                                            'approvalstat' => $request->input('status_'.$iden),
                                            'created_at' => date('Y-m-d'),
                                            'created_by' => Auth::user()->username,
                                            'last_updated_at' => date('Y-m-d'),
                                            'last_updated_by' => Auth::user()->username
                                        ]);
                                    }
                                }
                                if (!empty($rowsProducts)) {
                                    foreach ($rowsProducts as $key) {
                                        DB::table('t_rab_detail')->insert([
                                            'date_rab' => $date1,
                                            'id_rab' => $idRab,
                                            'rab_calc_type' => $key['rabCalcTypes'],
                                            'id_rab_item' => $key['ids2'],
                                            'category' => $key['categorys'],
                                            'sub_category' => $key['sub-categorys'],
                                            'name_rab_detail' => $key['namesis'],
                                            'unit' => $key['units'],
                                            'days' => $key['dayss'],
                                            'qty' => $key['qtys'],
                                            'amount' => $key['prices'],
                                            'total' => $key['totals'],
                                            'balance' => $key['totals'],
                                            'remarks' => $key['remarkss'],
                                            'created_by' => Auth::user()->username,
                                            'created_at' => date('Y-m-d'),
                                            'last_updated_by' => Auth::user()->username,
                                            'last_updated_at' => date('Y-m-d'),
                                            'status' => 'Active',
                                            'approvalstat' => 'Draft'
                                        ]);
                                    }
                                }
                            });
                        alert()->success('Success', 'RAB Request Has Been Edited');
                        return to_route('rab-listonly');
                    }else {
                        alert()->error('Error', 'RAB Detail Empty');
                        return to_route('rab-listonly');
                    }
                } else {
                    alert()->error('Error', 'RAB Already Printed');
                    return to_route('rab-listonly');
                }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function deleteItem(Request $request, $rabId)
    {
        try {
            DB::table('t_rab_detail')->where('idrec', $rabId)->update([
                'status' => 'Non Active',
                'last_updated_at' => date('Y-m-d'),
                'last_updated_by' => Auth::user()->username
            ]);
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


// public function rabListGetDashboard(Request $request)
// {
    //     $dataPurchaseRequestQuery = DB::table('inventory_assets_request')
    //     ->select(
    //         'inventory_assets_request.idrec',
    //         'inventory_assets_request.idreqform',
    //         'inventory_assets_request.datereq',
    //         'inventory_assets_request.applicant',
    //         'inventory_assets_request.loc',
    //         'inventory_assets_request.reqlevel',
    //         'inventory_assets_request.daterequired',
    //         'inventory_assets_request.category',
    //         'inventory_assets_request.currency',
    //         'inventory_assets_request.note',
    //         'inventory_assets_request.receivestat',
    //         'inventory_assets_request.approvaldate',
    //         'inventory_assets_request.approvalstat',
    //         'inventory_assets_request.approved1by',
    //         'inventory_assets_request.approved2by',
    //         'inventory_assets_request.approval1_status',
    //         'inventory_assets_request.approval2_status',
    //         'inventory_assets_request.remarks1',
    //         'inventory_assets_request.remarks2',
    //         'inventory_assets_request.gtotal'
    //     );

    //     $dataRab = $dataPurchaseRequestQuery->orderBy('inventory_assets_request.idreqform', 'desc');

    //     if ($request->ajax()) {
    //         return DataTables::of($dataPurchaseRequest)
    //         ->editColumn('gtotal', function ($dataPurchaseRequest) {
    //             return $dataPurchaseRequest->currency . " " . number_format($dataPurchaseRequest->gtotal, 0, ',', '.');
    //         })
    //         ->addColumn('action', function ($dataPurchaseRequest) {
    //             return '
    //             <div class="flex flex-row">                
    //                 <div x-data="{ modalOpen: false }">
    //                     <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
    //                         @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-idpr="'.$dataPurchaseRequest->idreqform.'"
    //                         data-datepr = "' . $dataPurchaseRequest->datereq . '" data-applicant = "' . $dataPurchaseRequest->applicant . '" data-loc ="'.$dataPurchaseRequest->loc.'" data-reqlevel = "' . $dataPurchaseRequest->reqlevel . '"
    //                         data-daterequired = "' . $dataPurchaseRequest->daterequired . '" data-note="'.$dataPurchaseRequest->note.'" data-gtotal="'.$dataPurchaseRequest->gtotal.'" data-approvaldate="'.$dataPurchaseRequest->approvaldate.'"
    //                         data-approvalstat="'.$dataPurchaseRequest->approvalstat.'" data-approved1by="'.$dataPurchaseRequest->approved1by.'" data-approved2by="'.$dataPurchaseRequest->approved2by.'" data-currency="'.$dataPurchaseRequest->currency.'" data-approval1_status="'.$dataPurchaseRequest->approval1_status.'" data-approval2_status="'.$dataPurchaseRequest->approval2_status.'" data-remarks1="'.$dataPurchaseRequest->remarks1.'"
    //                         data-remarks2="'.$dataPurchaseRequest->remarks2.'"
    //                     >View</button>
                        
    //                     <!-- Modal backdrop -->
    //                     <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
    //                         x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
    //                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    //                         x-transition:leave="transition ease-out duration-100"
    //                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    //                         aria-hidden="true" x-cloak></div>
    //                     <!-- Modal dialog -->
    //                     <div id="feedback-modal"
    //                         class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
    //                         role="dialog" aria-modal="true" x-show="modalOpen"
    //                         x-transition:enter="transition ease-in-out duration-200"
    //                         x-transition:enter-start="opacity-0 translate-y-4"
    //                         x-transition:enter-end="opacity-100 translate-y-0"
    //                         x-transition:leave="transition ease-in-out duration-200"
    //                         x-transition:leave-start="opacity-100 translate-y-0"
    //                         x-transition:leave-end="opacity-0 translate-y-4" x-cloak>
    //                         <div class="bg-white rounded shadow-lg overflow-auto w-full max-h-full"
    //                             @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
    //                             <!-- Modal header -->
    //                             <div class="px-5 py-3 border-b border-slate-200">
    //                                 <div class="flex justify-between items-center">
    //                                     <div class="font-semibold text-slate-800">Inventory Request Detail</div>
    //                                     <button class="text-slate-400 hover:text-slate-500"
    //                                         @click="modalOpen = false">
    //                                         <div class="sr-only">Close</div>
    //                                         <svg class="w-4 h-4 fill-current">
    //                                             <path
    //                                                 d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
    //                                         </svg>
    //                                     </button>
    //                                 </div>
    //                             </div>
    //                             <!-- Modal content -->
    //                             <div class="modal-content text-xs">
                                    
    //                             </div>
    //                             <!-- Modal footer -->
    //                             <div class="px-5 py-4 border-t border-slate-200">
    //                                 <div class="flex flex-wrap justify-end space-x-2">
    //                                     <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">
    //                                         Close
    //                                     </button>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';
    //         })
    //         ->rawColumns(['action'])
    //         ->make();
    //     }
// }

// public function rabListUpdate(Request $request, $idPR)
    // {
    //     $status = $request->input('status');

    //     if ($status == 'Approved') {
    //         $updatePR = DB::table('inventory_assets_request')
    //         ->where('idreqform', $idPR)
    //         ->update([
    //             'approvalstat' => 'Pending',
    //             'approvaldate' => date('Y-m-d'),
    //             'approval1_status' => 'Approved',
    //             'remarks1' => $request->input('remarks1'),
    //             'approved1by' => Auth::user()->username
    //         ]);
    //         alert()->success('Success', 'Inventory Asset Request Approved');
    //         return to_route('dashboard');

    //     } else if ($status == 'Denied') {
    //         $updatePR = DB::table('inventory_assets_request')
    //         ->where('idreqform', $idPR)
    //         ->update([
    //             'approvalstat' => 'Denied',
    //             'approvaldate' => date('Y-m-d'),
    //             'approval1_status' => 'Denied',
    //             'approval2_status' => 'Denied',
    //             'remarks1' => $request->input('remarks1'),
    //             'approved1by' => Auth::user()->username
    //         ]);
    //         alert()->success('Success', 'Inventory Asset Request Denied');
    //         return to_route('dashboard');
    //     }
// }

    public function rabApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.index', compact('dataChildCompany', 'department'));
    }

    public function rabApprove1(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'm_approval2_rab.id_company', 'users.username')->where('m_approval2_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'm_approval2_rab.id_company', 'users.username')->where('m_approval2_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.ga.rab-approval.approval1', compact('dataRab', 'dataRabItem', 'dataUser'));
    }

    public function rabApproved1Page(Request $request, $rabId)
    {   
        $token = $request->input('token');

        $checkToken = DB::table('rab_approve1_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'm_approval2_rab.id_company', 'users.username')->where('m_approval2_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        // if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        // } else {
        //     $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        //     // $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'users.company_id', 'users.username')->where('users.company_id', $userByCompany)->orderBy('users.username', 'asc')->get();
        // }

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        //     return to_route('forgot.password');
        // }

        // if ($expired_at->lt(Carbon::now()) ) {
        //     alert()->error('Error', 'Link was Expired');
        //     return view('/');
        // }
        return view('rab_approval1page', compact('dataRab', 'dataRabItem', 'dataUser'));
    }

    public function rabUpdateStatus (Request $request, $rabId)
    {
        $status = $request->input('status');
        $approvalstat = DB::table('t_rab')->where('idrec', $rabId)->pluck('approvalstat')->first();
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataRab->id_company)->first();
        $iden = $request->input('iden');
        $approvalTo = $dataRab->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();  
        $token = (string)Str::uuid();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        try {
            if ($approvalstat == 'Site Approved') {
                if ($status == 'Approve') {
                    DB::table('rab_approve2_token')->insert([
                        'email'=> $email,
                        'token'=> $token,
                        'is_active' => 1,
                        'expired_at' => Carbon::now()->addHour(),
                        'created_at' => Carbon::now()
                    ]);
                    
                    $data = [
                        'url' => route('rab.approve2page', [
                            'rabId' => $rabId,
                            'token' => $token
                        ]),
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_approval2', $data, function($message) use($email, $user, $datacomps){
                        $message->to($email, $user)->subject(''. $datacomps->name .' - RAB Approval 2');
                    });
                    DB::transaction(function () use ($request, $rabId, $iden){
                        DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'HQ 1 Approved',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'prepared_date' => date('Y-m-d'),
                            'approved1by' => Auth::user()->username
                        ]);
        
                        // foreach ($request->iden as $iden) {
                        //     $idrecss = $request->input('idrecss_'.$iden);
                        //     DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                        //         'days' => $request->input('days1_'.$iden),
                        //         'qty' => $request->input('qty_'.$iden),
                        //         'amount' => $request->input('price_'.$iden),
                        //         'total' => $request->input('total_'.$iden),
                        //         'approvalstat' => 'HQ 1 Approved',
                        //         'last_updated_at' => date('Y-m-d'),
                        //            'last_updated_by' => Auth::user()->username
                        //     ]);
                        // } 
                    });
                    alert()->success('Success', 'RAB Request Has Been Approved');
                    return to_route('rab-approvalga');
        
                } else if ($status == 'Denied') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'currency' => $dataRab->currency,
                        'approvedby' => Auth::user()->username,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 1 Denied');
                    });
                    DB::transaction(function () use ($request, $rabId, $iden){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'HQ 1 Denied',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'approved1by' => Auth::user()->username
                        ]);
    
                        // foreach ($request->iden as $iden) {
                        //     $idrecss = $request->input('idrecss_'.$iden);
                        //     DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                        //         'days' => $request->input('days1_'.$iden),
                        //         'qty' => $request->input('qty_'.$iden),
                        //         'amount' => $request->input('price_'.$iden),
                        //         'total' => $request->input('total_'.$iden),
                        //         'approvalstat' => 'HQ 1 Denied',
                        //         'last_updated_at' => date('Y-m-d'),
                        //         'last_updated_by' => Auth::user()->username
                        //     ]);
                        // }
                    });
                    alert()->success('Success', 'RAB Request Has Been Denied');
                    return to_route('rab-approvalga');
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'currency' => $dataRab->currency,
                        'approvedby' => Auth::user()->username,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 1 Return to Draft');
                    });
                    DB::transaction(function () use ($request, $rabId, $iden){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'print_status' => 'N',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'approved1by' => Auth::user()->username
                        ]);
                    });
                    alert()->success('Success', 'RAB Request Return to Draft');
                    return to_route('rab-approvalga');
                }
            } else {
                alert()->error('Error', 'RAB Request Already Approved/Denied');
                return to_route('rab-approvalga');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }
    public function rabApproved1 (Request $request, $rabId)
    {
        $status = $request->input('status');
        $approvalstat = DB::table('t_rab')->where('idrec', $rabId)->pluck('approvalstat')->first();
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->first();
        $approvedBy = DB::table('users')->where('id', $dataRab->approval_to)->pluck('username')->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataRab->id_company)->first();
        $iden = $request->input('iden');
        $approvalTo = $dataRab->approval2_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token = (string)Str::uuid();
        $token1 = $request->input('token');

        try {
            if ($approvalstat == 'Site Approved') {
                if ($status == 'Approve') {
                    DB::table('rab_approve2_token')->insert([
                        'email'=> $email,
                        'token'=> $token,
                        'is_active' => 1,
                        'expired_at' => Carbon::now()->addHour(),
                        'created_at' => Carbon::now()
                    ]);
                    
                    $data = [
                        'url' => route('rab.approve2page', [
                            'rabId' => $rabId,
                            'token' => $token
                        ]),
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_approval2', $data, function($message) use($email, $user, $datacomps){
                        $message->to($email, $user)->subject(''. $datacomps->name .' - RAB Approval 2');
                    });
                    DB::table('rab_approve1_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::transaction(function () use ($request, $rabId, $approvedBy){
                        DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'HQ 1 Approved',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'prepared_date' => date('Y-m-d'),
                            'approved1by' => $approvedBy
                        ]);
        
                        // foreach ($request->input('iden') as $iden) {
                        //     $idrecss = $request->input('idrecss_'.$iden);
                        //     DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                        //         'days' => $request->input('days1_'.$iden),
                        //         'qty' => $request->input('qty_'.$iden),
                        //         'amount' => $request->input('price_'.$iden),
                        //         'total' => $request->input('total_'.$iden),
                        //         'approvalstat' => 'HQ 1 Approved',
                        //         'last_updated_at' => date('Y-m-d'),
                        //         'last_updated_by' => $approvedBy
                        //     ]);
                        // } 
                    });
                    alert()->success('Success', 'RAB Request Has Been Approved');
                    return to_route('rab.approve1page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
        
                } else if ($status == 'Decline') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => $approvedBy,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 1 Denied');
                    });
                    DB::table('rab_approve1_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::transaction(function () use ($request, $rabId, $iden, $approvedBy){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'HQ 1 Denied',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'approved1by' => $approvedBy
                        ]);
    
                        // foreach ($request->iden as $iden) {
                        //     $idrecss = $request->input('idrecss_'.$iden);
                        //     DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                        //         'days' => $request->input('days1_'.$iden),
                        //         'qty' => $request->input('qty_'.$iden),
                        //         'amount' => $request->input('price_'.$iden),
                        //         'total' => $request->input('total_'.$iden),
                        //         'approvalstat' => 'HQ 1 Denied',
                        //         'last_updated_at' => date('Y-m-d'),
                        //         'last_updated_by' => $approvedBy
                        //     ]);
                        // }
                    });
                    alert()->success('Success', 'RAB Request Has Been Denied');
                    return to_route('rab.approve1page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => $approvedBy,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 1 Return to Draft');
                    });
                    DB::table('rab_approve1_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::transaction(function () use ($request, $rabId, $approvedBy){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'print_status' => 'N',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks1' => $request->input('remarks1'),
                            'approved1by' => $approvedBy
                        ]);
                    });
                    alert()->success('Success', 'RAB Request Return to Draft');
                    return to_route('rab.approve1page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
                }
            } else {
                alert()->error('Error', 'RAB Request Already Approved/Denied');
                return to_route('rab.approve1page', [
                    'rabId' => $rabId,
                    'token' => $token1
                ]);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function rabApproval2()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.index2', compact('dataChildCompany', 'department'));
    }

    public function rabApprove2(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataUser = DB::table('m_approval3_rab')->leftJoin('users', 'm_approval3_rab.id', 'users.id')->select('m_approval3_rab.id', 'm_approval3_rab.id_company', 'users.username')->where('m_approval3_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval3_rab')->leftJoin('users', 'm_approval3_rab.id', 'users.id')->select('m_approval3_rab.id', 'm_approval3_rab.id_company', 'users.username')->where('m_approval3_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.ga.rab-approval.approval2', compact('dataRab', 'dataRabItem', 'dataUser'));
    }

    public function rabApproved2Page(Request $request, $rabId)
    {
        $token = $request->input('token');

        $checkToken = DB::table('rab_approve2_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        $dataUser = DB::table('m_approval3_rab')->leftJoin('users', 'm_approval3_rab.id', 'users.id')->select('m_approval3_rab.id', 'm_approval3_rab.id_company', 'users.username')->where('m_approval3_rab.id_company', $dataRab->id_company)->orderBy('users.username', 'asc')->get();

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        //     return to_route('forgot.password');
        // }

        // if ($expired_at->lt(Carbon::now()) ) {
        //     alert()->error('Error', 'Link was Expired');
        //     return view('/');
        // }
        return view('rab_approval2page', compact('dataRab', 'dataRabItem', 'dataUser'));
    }

    public function rabUpdateStatus2 (Request $request, $rabId)
    {
        $status = $request->input('status');
        $approvalstat = DB::table('t_rab')->where('idrec', $rabId)->pluck('approvalstat')->first();
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->first();
        $datacomps = DB::table('m_child_company')->select('company_type', 'name', 'address', 'logo_filename', 'npwp_id', 'npwp_address')->where('id_company', $dataRab->id_company)->first();
        $approvalTo = $dataRab->approval3_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token = (string)Str::uuid();

        if ($approvalstat == 'HQ 1 Approved') {
            // if ($dataRab->id_company == '12') {
                // if ($status == 'Approve') {
                //     $data = [
                //         'url' => route('rab.approve3page', [
                //             'rabId' => $rabId,
                //             'token' => $token
                //         ]),
                //         'logo_filename' => $datacomps->logo_filename,
                //         'company' => $datacomps->name,
                //         'address' => $datacomps->address,
                //         'formDate' => date('Y F', strtotime($dataRab->form_date)),
                //         'rabNo' => $dataRab->id_rab,
                //         'title' => $dataRab->name_rab,
                //         'approvedby' => Auth::user()->username,
                //         'period' => date('Y F', strtotime($dataRab->date_rab)),
                //         'applicant' => $dataRab->applicant,
                //         'currency' => $dataRab->currency,
                //         'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                //     ];
                //     Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
                //         $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
                //     });
                //     DB::table('t_rab')
                //     ->where('idrec', $rabId)
                //     ->update([
                //         'approvalstat' => 'Enforced',
                //         'approvaldate' => date('Y-m-d'),
                //         'updated_at' => date('Y-m-d'),
                //         'gtotal' => $request->input('grandtotal1'),
                //         'remarks2' => $request->input('remarks2'),
                //         'approved2_date' => date('Y-m-d'),
                //         'approved2by' => Auth::user()->username
                //     ]);
                //     // $iden = $request->input('iden');
                //     //     foreach ($request->iden as $iden) {
                //     //         $idrecss = $request->input('idrecss_'.$iden);
                //     //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                //     //             'days' => $request->input('days1_'.$iden),
                //     //             'qty' => $request->input('qty_'.$iden),
                //     //             'amount' => $request->input('price_'.$iden),
                //     //             'total' => $request->input('total_'.$iden),
                //     //             'approvalstat' => 'HQ 2 Approved',
                //     //             'last_updated_at' => date('Y-m-d'),
                //     //             'last_updated_by' => Auth::user()->username
                //     //         ]);
                //     //     }

                //     if ($dataRab->rab_type = 'Advance Payment To Site') {
                //         DB::table('t_costpayment')->insert([
                //             'id_costpayment' => $dataRab->id_rab,
                //             'id_company' => $dataRab->id_company,
                //             'company' => $datacomps->company_type.' '.$datacomps->name,
                //             'form_type' => 'RAB',
                //             'date' => $dataRab->form_date,
                //             'applicant' => $applicant,
                //             'currency' => 'IDR',
                //             'crate' => '1',
                //             'subtotal' => '0',
                //             'vat' => '0',
                //             'total' => '0',
                //             'wht' => '0',
                //             'subtotal' => $dataRab->gtotal,
                //             'total_paid' => $dataRab->gtotal,
                //             'approved_total' => $dataRab->gtotal,
                //             'beneficiary_bank' => $dataRab->beneficiary_bank,
                //             'beneficiary_name' => $dataRab->beneficiary_name,
                //             'beneficiary_acc' => $dataRab->beneficiary_acc,
                //             'balance' => $dataRab->gtotal,
                //             'balance_wht' => '0',
                //             'status' => 'A/P',
                //             'print_status' => 'N',
                //             'npwp_id' => $datacomps->npwp_id,
                //             'npwp_name' => $datacomps->company_type.' '.$datacomps->name,
                //             'npwp_address' => $datacomps->npwp_address,
                //             'due_date' => $dataRab->form_date,
                //             'created_at' => date('Y-m-d H:i:s'),
                //             'created_by' => $dataRab->created_by,
                //             'updated_at' => date('Y-m-d H:i:s'),
                //             'updated_by' => $dataRab->created_by,
                //             'aktifyn' => 'Y',
                //         ]);
                //     }
                //     alert()->success('Success', 'RAB Request Has Been Approved');
                //     return to_route('rab-approvalga2');
        
                // } else if ($status == 'Denied') {
                //     $data = [
                //         'logo_filename' => $datacomps->logo_filename,
                //         'company' => $datacomps->name,
                //         'address' => $datacomps->address,
                //         'formDate' => date('Y F', strtotime($dataRab->form_date)),
                //         'rabNo' => $dataRab->id_rab,
                //         'title' => $dataRab->name_rab,
                //         'period' => date('Y F', strtotime($dataRab->date_rab)),
                //         'applicant' => $dataRab->applicant,
                //         'approvedby' => Auth::user()->username,
                //         'currency' => $dataRab->currency,
                //         'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                //     ];
                //     Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                //         $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Denied');
                //     });
                //     DB::table('t_rab')
                //     ->where('idrec', $rabId)
                //     ->update([
                //         'approvalstat' => 'HQ 2 Denied',
                //         'approvaldate' => date('Y-m-d'),
                //         'updated_at' => date('Y-m-d'),
                //         'gtotal' => $request->input('grandtotal1'),
                //         'remarks2' => $request->input('remarks2'),
                //         'approved2by' => Auth::user()->username
                //     ]);
                //     // $iden = $request->input('iden');
                //     //     foreach ($request->iden as $iden) {
                //     //         $idrecss = $request->input('idrecss_'.$iden);
                //     //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                //     //             'days' => $request->input('days1_'.$iden),
                //     //             'qty' => $request->input('qty_'.$iden),
                //     //             'amount' => $request->input('price_'.$iden),
                //     //             'total' => $request->input('total_'.$iden),
                //     //             'approvalstat' => 'HQ 2 Denied',
                //     //             'last_updated_at' => date('Y-m-d'),
                //     //             'last_updated_by' => Auth::user()->username
                //     //         ]);
                //     //     }
                //     alert()->success('Success', 'RAB Request Has Been Denied');
                //     return to_route('rab-approvalga2');
                // }else if ($status == 'Return to Draft') {
                //     $data = [
                //         'logo_filename' => $datacomps->logo_filename,
                //         'company' => $datacomps->name,
                //         'address' => $datacomps->address,
                //         'formDate' => date('Y F', strtotime($dataRab->form_date)),
                //         'rabNo' => $dataRab->id_rab,
                //         'title' => $dataRab->name_rab,
                //         'period' => date('Y F', strtotime($dataRab->date_rab)),
                //         'applicant' => $dataRab->applicant,
                //         'approvedby' => Auth::user()->username,
                //         'currency' => $dataRab->currency,
                //         'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                //     ];
                //     Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                //         $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Return to Draft');
                //     });
                //     DB::transaction(function () use ($request, $rabId){
                //         $updatePO = DB::table('t_rab')
                //         ->where('idrec', $rabId)
                //         ->update([
                //             'approvalstat' => 'Draft',
                //             'print_status' => 'N',
                //             'approvaldate' => date('Y-m-d'),
                //             'updated_at' => date('Y-m-d'),
                //             'gtotal' => $request->input('grandtotal1'),
                //             'remarks2' => $request->input('remarks2'),
                //             'approved2by' => Auth::user()->username
                //         ]);
                //     });
                //     alert()->success('Success', 'RAB Request Return to Draft');
                //     return to_route('rab-approvalga2');
                // }
            // } else {
                if ($status == 'Approve') {
                    // DB::table('rab_approve3_token')->insert([
                    //     'email'=> $email,
                    //     'token'=> $token,
                    //     'is_active' => 1,
                    //     'expired_at' => Carbon::now()->addHour(),
                    //     'created_at' => Carbon::now()
                    // ]);
                    
                    // $data = [
                    //     'url' => route('rab.approve3page', [
                    //         'rabId' => $rabId,
                    //         'token' => $token
                    //     ]),
                    //     'logo_filename' => $datacomps->logo_filename,
                    //     'company' => $datacomps->name,
                    //     'address' => $datacomps->address,
                    //     'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    //     'rabNo' => $dataRab->id_rab,
                    //     'title' => $dataRab->name_rab,
                    //     'period' => date('Y F', strtotime($dataRab->date_rab)),
                    //     'applicant' => $dataRab->applicant,
                    //     'currency' => $dataRab->currency,
                    //     'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    // ];
                    // Mail::send('rab_approval3', $data, function($message) use($email, $user, $datacomps){
                    //     $message->to($email, $user)->subject(''. $datacomps->name .' - RAB Approval 3');
                    // });
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => Auth::user()->username,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
                    });
                    DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'Enforced',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks2' => $request->input('remarks2'),
                        'approved2_date' => date('Y-m-d'),
                        'approved2by' => Auth::user()->username
                    ]);
                    // $iden = $request->input('iden');
                    //     foreach ($request->iden as $iden) {
                    //         $idrecss = $request->input('idrecss_'.$iden);
                    //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                    //             'days' => $request->input('days1_'.$iden),
                    //             'qty' => $request->input('qty_'.$iden),
                    //             'amount' => $request->input('price_'.$iden),
                    //             'total' => $request->input('total_'.$iden),
                    //             'approvalstat' => 'HQ 2 Approved',
                    //             'last_updated_at' => date('Y-m-d'),
                    //             'last_updated_by' => Auth::user()->username
                    //         ]);
                    //     }

                        if ($dataRab->rab_type = 'Advance Payment To Site') {
                            DB::table('t_costpayment')->insert([
                                'id_costpayment' => $dataRab->id_rab,
                                'id_company' => $dataRab->id_company,
                                'company' => $datacomps->company_type.' '.$datacomps->name,
                                'form_type' => 'RAB',
                                'date' => $dataRab->form_date,
                                'applicant' => $applicant,
                                'currency' => 'IDR',
                                'crate' => '1',
                                'subtotal' => '0',
                                'vat' => '0',
                                'total' => '0',
                                'wht' => '0',
                                'subtotal' => $dataRab->gtotal,
                                'total_paid' => $dataRab->gtotal,
                                'approved_total' => $dataRab->gtotal,
                                'beneficiary_bank' => $dataRab->beneficiary_bank,
                                'beneficiary_name' => $dataRab->beneficiary_name,
                                'beneficiary_acc' => $dataRab->beneficiary_acc,
                                'balance' => $dataRab->gtotal,
                                'balance_wht' => '0',
                                'status' => 'A/P',
                                'print_status' => 'N',
                                'npwp_id' => $datacomps->npwp_id,
                                'npwp_name' => $datacomps->company_type.' '.$datacomps->name,
                                'npwp_address' => $datacomps->npwp_address,
                                'due_date' => $dataRab->form_date,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $dataRab->created_by,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $dataRab->created_by,
                                'aktifyn' => 'Y',
                            ]);
                        }
                    alert()->success('Success', 'RAB Request Has Been Approved');
                    return to_route('rab-approvalga2');
        
                } else if ($status == 'Denied') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => Auth::user()->username,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Denied');
                    });
                    DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'HQ 2 Denied',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks2' => $request->input('remarks2'),
                        'approved2by' => Auth::user()->username
                    ]);
                    // $iden = $request->input('iden');
                    //     foreach ($request->iden as $iden) {
                    //         $idrecss = $request->input('idrecss_'.$iden);
                    //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                    //             'days' => $request->input('days1_'.$iden),
                    //             'qty' => $request->input('qty_'.$iden),
                    //             'amount' => $request->input('price_'.$iden),
                    //             'total' => $request->input('total_'.$iden),
                    //             'approvalstat' => 'HQ 2 Denied',
                    //             'last_updated_at' => date('Y-m-d'),
                    //             'last_updated_by' => Auth::user()->username
                    //         ]);
                    //     }
                    alert()->success('Success', 'RAB Request Has Been Denied');
                    return to_route('rab-approvalga2');
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => Auth::user()->username,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Return to Draft');
                    });
                    DB::transaction(function () use ($request, $rabId){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'print_status' => 'N',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks2' => $request->input('remarks2'),
                            'approved2by' => Auth::user()->username
                        ]);
                    });
                    alert()->success('Success', 'RAB Request Return to Draft');
                    return to_route('rab-approvalga2');
                }
            // }
        }else {
            alert()->error('Error', 'RAB Request Already Approved/Denied');
            return to_route('rab-approvalga2');
        }
    }

    public function rabApproved2 (Request $request, $rabId)
    {
        $status = $request->input('status');
        $approvalstat = DB::table('t_rab')->where('idrec', $rabId)->pluck('approvalstat')->first();
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->first();
        $approvedBy = DB::table('users')->where('id', $dataRab->approval2_to)->pluck('username')->first();
        $datacomps = DB::table('m_child_company')->select('company_type', 'name', 'address', 'logo_filename', 'npwp_id', 'npwp_address')->where('id_company', $dataRab->id_company)->first();
        $approvalTo = $dataRab->approval3_to;
        $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
        $user = DB::table('users')->where('real_email', $email)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first(); 
        $token = (string)Str::uuid();
        $token1 = $request->input('token');

        if ($approvalstat == 'HQ 1 Approved') {
            // if ($dataRab->id_company == '12') {
            //     if ($status == 'Approve') {
            //         // $data = [
            //         //     'url' => route('rab.approve3page', [
            //         //         'rabId' => $rabId,
            //         //         'token' => $token
            //         //     ]),
            //         //     'logo_filename' => $datacomps->logo_filename,
            //         //     'company' => $datacomps->name,
            //         //     'address' => $datacomps->address,
            //         //     'formDate' => date('Y F', strtotime($dataRab->form_date)),
            //         //     'rabNo' => $dataRab->id_rab,
            //         //     'title' => $dataRab->name_rab,
            //         //     'period' => date('Y F', strtotime($dataRab->date_rab)),
            //         //     'applicant' => $dataRab->applicant,
            //         //     'approvedby' => $approvedBy,
            //         //     'currency' => $dataRab->currency,
            //         //     'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
            //         // ];
            //         // Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
            //         //     $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
            //         // });
            //         DB::table('rab_approve2_token')->where('token', $token1)->update([
            //             'is_active' => 0
            //         ]);
            //         DB::table('t_rab')
            //         ->where('idrec', $rabId)
            //         ->update([
            //             'approvalstat' => 'Enforced',
            //             'approvaldate' => date('Y-m-d'),
            //             'updated_at' => date('Y-m-d'),
            //             'gtotal' => $request->input('grandtotal1'),
            //             'remarks2' => $request->input('remarks2'),
            //             'approved2_date' => date('Y-m-d'),
            //             'approved2by' => $approvedBy
            //         ]);
            //         // $iden = $request->input('iden');
            //         //     foreach ($request->iden as $iden) {
            //         //         $idrecss = $request->input('idrecss_'.$iden);
            //         //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
            //         //             'days' => $request->input('days1_'.$iden),
            //         //             'qty' => $request->input('qty_'.$iden),
            //         //             'amount' => $request->input('price_'.$iden),
            //         //             'total' => $request->input('total_'.$iden),
            //         //             'approvalstat' => 'HQ 2 Approved',
            //         //             'last_updated_at' => date('Y-m-d'),
            //         //             'last_updated_by' => $approvedBy
            //         //         ]);
            //         //     }

            //             if ($dataRab->rab_type == 'Advance Payment To Site') {
            //                 DB::table('t_costpayment')->insert([
            //                     'id_costpayment' => $dataRab->id_rab,
            //                     'id_company' => $dataRab->id_company,
            //                     'company' => $datacomps->company_type.' '.$datacomps->name,
            //                     'form_type' => 'RAB',
            //                     'date' => $dataRab->form_date,
            //                     'applicant' => $applicant,
            //                     'currency' => 'IDR',
            //                     'crate' => '1',
            //                     'subtotal' => '0',
            //                     'vat' => '0',
            //                     'total' => '0',
            //                     'wht' => '0',
            //                     'subtotal' => $dataRab->gtotal,
            //                     'total_paid' => $dataRab->gtotal,
            //                     'approved_total' => $dataRab->gtotal,
            //                     'beneficiary_bank' => $dataRab->beneficiary_bank,
            //                     'beneficiary_name' => $dataRab->beneficiary_name,
            //                     'beneficiary_acc' => $dataRab->beneficiary_acc,
            //                     'balance' => $dataRab->gtotal,
            //                     'balance_wht' => '0',
            //                     'status' => 'A/P',
            //                     'print_status' => 'N',
            //                     'npwp_id' => $datacomps->npwp_id,
            //                     'npwp_name' => $datacomps->company_type.' '.$datacomps->name,
            //                     'npwp_address' => $datacomps->npwp_address,
            //                     'due_date' => $dataRab->form_date,
            //                     'created_at' => date('Y-m-d H:i:s'),
            //                     'created_by' => $dataRab->created_by,
            //                     'updated_at' => date('Y-m-d H:i:s'),
            //                     'updated_by' => $dataRab->created_by,
            //                     'aktifyn' => 'Y',
            //                 ]);
            //             }
            //         alert()->success('Success', 'RAB Request Has Been Approved');
            //         return to_route('rab.approve2page', [
            //             'rabId' => $rabId,
            //             'token' => $token1
            //         ]);
            //     } else if ($status == 'Decline') {
            //         $data = [
            //             'logo_filename' => $datacomps->logo_filename,
            //             'company' => $datacomps->name,
            //             'address' => $datacomps->address,
            //             'formDate' => date('Y F', strtotime($dataRab->form_date)),
            //             'rabNo' => $dataRab->id_rab,
            //             'title' => $dataRab->name_rab,
            //             'period' => date('Y F', strtotime($dataRab->date_rab)),
            //             'applicant' => $dataRab->applicant,
            //             'approvedby' => $approvedBy,
            //             'currency' => $dataRab->currency,
            //             'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
            //         ];
            //         Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
            //             $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Denied');
            //         });
            //         DB::table('rab_approve2_token')->where('token', $token1)->update([
            //             'is_active' => 0
            //         ]);
            //         DB::table('t_rab')
            //         ->where('idrec', $rabId)
            //         ->update([
            //             'approvalstat' => 'HQ 2 Denied',
            //             'approvaldate' => date('Y-m-d'),
            //             'updated_at' => date('Y-m-d'),
            //             'gtotal' => $request->input('grandtotal1'),
            //             'remarks2' => $request->input('remarks2'),
            //             'approved2by' => $approvedBy
            //         ]);
            //         // $iden = $request->input('iden');
            //         //     foreach ($request->iden as $iden) {
            //         //         $idrecss = $request->input('idrecss_'.$iden);
            //         //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
            //         //             'days' => $request->input('days1_'.$iden),
            //         //             'qty' => $request->input('qty_'.$iden),
            //         //             'amount' => $request->input('price_'.$iden),
            //         //             'total' => $request->input('total_'.$iden),
            //         //             'approvalstat' => 'HQ 2 Denied',
            //         //             'last_updated_at' => date('Y-m-d'),
            //         //             'last_updated_by' => $approvedBy
            //         //         ]);
            //         //     }
            //         alert()->success('Success', 'RAB Request Has Been Denied');
            //         return to_route('rab.approve2page', [
            //             'rabId' => $rabId,
            //             'token' => $token1
            //         ]);
            //     }else if ($status == 'Return to Draft') {
            //         $data = [
            //             'logo_filename' => $datacomps->logo_filename,
            //             'company' => $datacomps->name,
            //             'address' => $datacomps->address,
            //             'formDate' => date('Y F', strtotime($dataRab->form_date)),
            //             'rabNo' => $dataRab->id_rab,
            //             'title' => $dataRab->name_rab,
            //             'period' => date('Y F', strtotime($dataRab->date_rab)),
            //             'applicant' => $dataRab->applicant,
            //             'approvedby' => $approvedBy,
            //             'currency' => $dataRab->currency,
            //             'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
            //         ];
            //         Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
            //             $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Return to Draft');
            //         });
            //         DB::table('rab_approve2_token')->where('token', $token1)->update([
            //             'is_active' => 0
            //         ]);
            //         DB::transaction(function () use ($request, $rabId, $approvedBy){
            //             $updatePO = DB::table('t_rab')
            //             ->where('idrec', $rabId)
            //             ->update([
            //                 'approvalstat' => 'Draft',
            //                 'print_status' => 'N',
            //                 'approvaldate' => date('Y-m-d'),
            //                 'updated_at' => date('Y-m-d'),
            //                 'gtotal' => $request->input('grandtotal1'),
            //                 'remarks2' => $request->input('remarks2'),
            //                 'approved2by' => $approvedBy
            //             ]);
            //         });
            //         alert()->success('Success', 'RAB Request Return to Draft');
            //         return to_route('rab.approve2page', [
            //             'rabId' => $rabId,
            //             'token' => $token1
            //         ]);
            //     }
            // } else {
                if ($status == 'Approve') {
                    // DB::table('rab_approve3_token')->insert([
                    //     'email'=> $email,
                    //     'token'=> $token,
                    //     'is_active' => 1,
                    //     'expired_at' => Carbon::now()->addHour(),
                    //     'created_at' => Carbon::now()
                    // ]);
                    
                    // $data = [
                    //     'url' => route('rab.approve3page', [
                    //         'rabId' => $rabId,
                    //         'token' => $token
                    //     ]),
                    //     'logo_filename' => $datacomps->logo_filename,
                    //     'company' => $datacomps->name,
                    //     'address' => $datacomps->address,
                    //     'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    //     'rabNo' => $dataRab->id_rab,
                    //     'title' => $dataRab->name_rab,
                    //     'period' => date('Y F', strtotime($dataRab->date_rab)),
                    //     'applicant' => $dataRab->applicant,
                    //     'currency' => $dataRab->currency,
                    //     'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    // ];
                    // Mail::send('rab_approval3', $data, function($message) use($email, $user, $datacomps){
                    //     $message->to($email, $user)->subject(''. $datacomps->name .' - RAB Approval 3');
                    // });
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => $approvedBy,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
                    });
                    DB::table('rab_approve2_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'Enforced',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks2' => $request->input('remarks2'),
                        'approved2_date' => date('Y-m-d'),
                        'approved2by' => $approvedBy
                    ]);
                    // $iden = $request->input('iden');
                    //     foreach ($request->iden as $iden) {
                    //         $idrecss = $request->input('idrecss_'.$iden);
                    //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                    //             'days' => $request->input('days1_'.$iden),
                    //             'qty' => $request->input('qty_'.$iden),
                    //             'amount' => $request->input('price_'.$iden),
                    //             'total' => $request->input('total_'.$iden),
                    //             'approvalstat' => 'HQ 2 Approved',
                    //             'last_updated_at' => date('Y-m-d'),
                    //             'last_updated_by' => $approvedBy
                    //         ]);
                    //     }

                        if ($dataRab->rab_type == 'Advance Payment To Site') {
                            DB::table('t_costpayment')->insert([
                                'id_costpayment' => $dataRab->id_rab,
                                'id_company' => $dataRab->id_company,
                                'company' => $datacomps->company_type.' '.$datacomps->name,
                                'form_type' => 'RAB',
                                'date' => $dataRab->form_date,
                                'applicant' => $applicant,
                                'currency' => 'IDR',
                                'crate' => '1',
                                'subtotal' => '0',
                                'vat' => '0',
                                'total' => '0',
                                'wht' => '0',
                                'subtotal' => $dataRab->gtotal,
                                'total_paid' => $dataRab->gtotal,
                                'approved_total' => $dataRab->gtotal,
                                'beneficiary_bank' => $dataRab->beneficiary_bank,
                                'beneficiary_name' => $dataRab->beneficiary_name,
                                'beneficiary_acc' => $dataRab->beneficiary_acc,
                                'balance' => $dataRab->gtotal,
                                'balance_wht' => '0',
                                'status' => 'A/P',
                                'print_status' => 'N',
                                'npwp_id' => $datacomps->npwp_id,
                                'npwp_name' => $datacomps->company_type.' '.$datacomps->name,
                                'npwp_address' => $datacomps->npwp_address,
                                'due_date' => $dataRab->form_date,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $dataRab->created_by,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $dataRab->created_by,
                                'aktifyn' => 'Y',
                            ]);
                        }
                    alert()->success('Success', 'RAB Request Has Been Approved');
                    return to_route('rab.approve2page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
                } else if ($status == 'Decline') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => $approvedBy,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Denied');
                    });
                    DB::table('rab_approve2_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'HQ 2 Denied',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks2' => $request->input('remarks2'),
                        'approved2by' => $approvedBy
                    ]);
                    // $iden = $request->input('iden');
                    //     foreach ($request->iden as $iden) {
                    //         $idrecss = $request->input('idrecss_'.$iden);
                    //         DB::table('t_rab_detail')->where('idrec', $idrecss)->update([
                    //             'days' => $request->input('days1_'.$iden),
                    //             'qty' => $request->input('qty_'.$iden),
                    //             'amount' => $request->input('price_'.$iden),
                    //             'total' => $request->input('total_'.$iden),
                    //             'approvalstat' => 'HQ 2 Denied',
                    //             'last_updated_at' => date('Y-m-d'),
                    //             'last_updated_by' => $approvedBy
                    //         ]);
                    //     }
                    alert()->success('Success', 'RAB Request Has Been Denied');
                    return to_route('rab.approve2page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('Y F', strtotime($dataRab->form_date)),
                        'rabNo' => $dataRab->id_rab,
                        'title' => $dataRab->name_rab,
                        'period' => date('Y F', strtotime($dataRab->date_rab)),
                        'applicant' => $dataRab->applicant,
                        'approvedby' => $approvedBy,
                        'currency' => $dataRab->currency,
                        'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                    ];
                    Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 2 Return to Draft');
                    });
                    DB::table('rab_approve2_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::transaction(function () use ($request, $rabId, $approvedBy){
                        $updatePO = DB::table('t_rab')
                        ->where('idrec', $rabId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'print_status' => 'N',
                            'approvaldate' => date('Y-m-d'),
                            'updated_at' => date('Y-m-d'),
                            'gtotal' => $request->input('grandtotal1'),
                            'remarks2' => $request->input('remarks2'),
                            'approved2by' => $approvedBy
                        ]);
                    });
                    alert()->success('Success', 'RAB Request Return to Draft');
                    return to_route('rab.approve2page', [
                        'rabId' => $rabId,
                        'token' => $token1
                    ]);
                }
            // }
        }else {
            alert()->error('Error', 'RAB Request Already Approved/Denied');
            return to_route('rab.approve2page', [
                'rabId' => $rabId,
                'token' => $token1
            ]);
        }
    }

    public function rabApproval3()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.rab-approval.index3', compact('dataChildCompany', 'department'));
    }

    public function rabApprove3(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        return view('pages.ga.rab-approval.approval3', compact('dataRab', 'dataRabItem'));
    }

    public function rabApproved3Page(Request $request, $rabId)
    {
        $token = $request->input('token');

        $checkToken = DB::table('rab_approve3_token')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->leftJoin('users', 't_rab.created_by', 'users.id')
        ->select(
            't_rab.*',
            'm_child_company.name',
            'm_department.name as dept',
            'users.username',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;
            
        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.days',
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category'
        , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get();

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        //     return to_route('forgot.password');
        // }

        // if ($expired_at->lt(Carbon::now()) ) {
        //     alert()->error('Error', 'Link was Expired');
        //     return view('/');
        // }
        return view('rab_approval3page', compact('dataRab', 'dataRabItem'));
    }

    public function rabUpdateStatus3 (Request $request, $rabId)
    {
        $status = $request->input('status');
        $dataRab = DB::table('t_rab')->select('t_rab.idrec', 't_rab.id_rab', 't_rab.approvalstat', 't_rab.id_company', 't_rab.name_rab', 't_rab.form_date', 
        't_rab.date_rab', 't_rab.applicant', 't_rab.gtotal', 't_rab.currency', 't_rab.created_by', 't_rab.approved2by', 't_rab.id_company', 't_rab.rab_type',
        't_rab.form_date', 't_rab.beneficiary_bank', 't_rab.beneficiary_name', 't_rab.beneficiary_acc')->where('idrec', $rabId)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename', 'npwp_id', 'npwp_address')->where('id_company', $dataRab->id_company)->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $idRab = $dataRab->id_rab;
        $approvalstat = $dataRab->approvalstat;
        $dataPayment = DB::table('t_costpayment')->where('id_costpayment', $dataRab->id_rab)->pluck('id_costpayment')->first();

        if ($approvalstat == 'HQ 2 Approved' || $approvalstat == 'Enforced') {
            if ($status == 'Approve') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
                });
                DB::table('t_rab')
                ->where('idrec', $rabId)
                ->update([
                    'approvalstat' => 'Enforced',
                    'approvaldate' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3_date' => date('Y-m-d'),
                    'approved3by' => Auth::user()->username
                ]);
    
                DB::table('t_rab_detail')
                ->where('id_rab', $idRab)
                ->update([
                    'approvalstat' => 'Enforced',
                    'last_updated_at' => date('Y-m-d'),
                    'last_updated_by' => Auth::user()->username
                ]);
                alert()->success('Success', 'RAB Request Has Been Approved');
                return to_route('rab-approvalga3');
    
            } else if ($status == 'Denied') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 3 Denied');
                });
                DB::table('t_rab')
                ->where('idrec', $rabId)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'approvaldate' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3by' => Auth::user()->username
                ]);
    
                DB::table('t_rab_detail')
                ->where('id_rab', $idRab)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'last_updated_at' => date('Y-m-d'),
                    'last_updated_by' => Auth::user()->username
                ]);
                // if ($dataRab->rab_type == 'Advance Payment To Site' && $dataPayment != null) {
                //     alert()->warning('Warning', 'Payment Voucher of this RAB Request already created!');
                //     return to_route('rab-approvalga3');
                // }else{
                // }
                alert()->success('Success', 'RAB Request Has Been Denied');
                return to_route('rab-approvalga3');
            }else if ($status == 'Return to Draft') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => Auth::user()->username,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 3 Return to Draft');
                });
                DB::transaction(function () use ($request, $rabId){
                    $updatePO = DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'Draft',
                        'print_status' => 'N',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks3' => $request->input('remarks3'),
                        'approved3by' => Auth::user()->username
                    ]);
                });
                alert()->success('Success', 'RAB Request Return to Draft');
                return to_route('rab-approvalga3');
            }
        } else {
            alert()->error('Error', 'RAB Request Already Approved/Denied');
            return to_route('rab-approvalga3');
        }
    }

    public function rabApproved3 (Request $request, $rabId)
    {
        $status = $request->input('status');
        $dataRab = DB::table('t_rab')->select('t_rab.idrec', 't_rab.id_rab', 't_rab.approvalstat', 't_rab.id_company', 't_rab.name_rab', 't_rab.form_date', 
        't_rab.date_rab', 't_rab.applicant', 't_rab.gtotal', 't_rab.currency', 't_rab.created_by', 't_rab.approved2by', 't_rab.id_company', 't_rab.rab_type',
        't_rab.form_date', 't_rab.beneficiary_bank', 't_rab.beneficiary_name', 't_rab.beneficiary_acc', 't_rab.approval3_to')->where('idrec', $rabId)->first();
        $approvedBy = DB::table('users')->where('id', $dataRab->approval3_to)->pluck('username')->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename', 'npwp_id', 'npwp_address')->where('id_company', $dataRab->id_company)->first();
        $email1 = DB::table('users')->where('id', $dataRab->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $idRab = $dataRab->id_rab;
        $approvalstat = $dataRab->approvalstat;
        $token1 = $request->input('token');
        $dataPayment = DB::table('t_costpayment')->where('id_costpayment', $dataRab->id_rab)->pluck('id_costpayment')->first();

        if ($approvalstat == 'HQ 2 Approved' || $approvalstat == 'Enforced') {
            if ($status == 'Approve') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => $approvedBy,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_enforced', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Enforced');
                });
                DB::table('rab_approve3_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('t_rab')
                ->where('idrec', $rabId)
                ->update([
                    'approvalstat' => 'Enforced',
                    'approvaldate' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3_date' => date('Y-m-d'),
                    'approved3by' => $approvedBy
                ]);
    
                DB::table('t_rab_detail')
                ->where('id_rab', $idRab)
                ->update([
                    'approvalstat' => 'Enforced',
                    'last_updated_at' => date('Y-m-d'),
                    'last_updated_by' => $approvedBy
                ]);
                alert()->success('Success', 'RAB Request Has Been Approved');
                return to_route('rab.approve3page', [
                    'rabId' => $rabId,
                    'token' => $token1
                ]);
            } else if ($status == 'Decline') {
                 // if ($dataRab->rab_type == 'Advance Payment To Site' && $dataPayment != null) {
                //     alert()->warning('Warning', 'Payment Voucher of this RAB Request already created!');
                //     return to_route('rab-approvalga3');
                // }else{
                // }
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => $approvedBy,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_denied', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 3 Denied');
                });
                DB::table('rab_approve3_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::table('t_rab')
                ->where('idrec', $rabId)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'approvaldate' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'remarks3' => $request->input('remarks3'),
                    'approved3by' => $approvedBy
                ]);
    
                DB::table('t_rab_detail')
                ->where('id_rab', $idRab)
                ->update([
                    'approvalstat' => 'HQ 3 Denied',
                    'last_updated_at' => date('Y-m-d'),
                    'last_updated_by' => $approvedBy
                ]);
                alert()->success('Success', 'RAB Request Has Been Denied');
                return to_route('rab.approve3page', [
                    'rabId' => $rabId,
                    'token' => $token1
                ]);
            }else if ($status == 'Return to Draft') {
                $data = [
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'approvedby' => $approvedBy,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_draft', $data, function($message) use($email1, $applicant, $datacomps){
                    $message->to($email1, $applicant)->subject(''. $datacomps->name .' - RAB Approval HQ 3 Return to Draft');
                });
                DB::table('rab_approve3_token')->where('token', $token1)->update([
                    'is_active' => 0
                ]);
                DB::transaction(function () use ($request, $rabId, $approvedBy){
                    $updatePO = DB::table('t_rab')
                    ->where('idrec', $rabId)
                    ->update([
                        'approvalstat' => 'Draft',
                        'print_status' => 'N',
                        'approvaldate' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'gtotal' => $request->input('grandtotal1'),
                        'remarks3' => $request->input('remarks3'),
                        'approved3by' => $approvedBy
                    ]);
                });
                alert()->success('Success', 'RAB Request Return to Draft');
                return to_route('rab.approve3page', [
                    'rabId' => $rabId,
                    'token' => $token1
                ]);
            }
        } else {
            alert()->error('Error', 'RAB Request Already Approved/Denied');
            return to_route('rab.approve3page', [
                'rabId' => $rabId,
                'token' => $token1
            ]);
        }
    }

    public function rabGetApproval(Request $request)
    {
        $user = Auth::user()->id;
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
            't_rab.approval_to',
            't_rab.approval2_to',
            't_rab.approval3_to',
            't_rab.print_status',
            't_rab.created_by',
            'm_child_company.name',
            'm_department.name as deptName',
            'users.username'
        );

        if ($searchTriggered) {
            if ($request->input('status') != 'No') {
                $dataRabQuery->where(function($query) use ($user) {
                    $query->where('t_rab.approval_to', $user)
                          ->where(function($query) {
                              $query->where('t_rab.approvalstat', '=', 'Site Approved')
                                    ->orWhere('t_rab.approvalstat', '=', 'HQ 1 Approved');
                          });
                });
            } else if ($request->input('status') != 'Yes') {
                if (in_array(Auth::user()->company_id, ['0', '999', '888'])) {
                    $dataRabQuery->orderBy('t_rab.id_rab', 'desc');
                } else {
                    $dataRabQuery->where('t_rab.id_company', '=', Auth::user()->company_id);
                }
            }
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                             ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
            }
            if ($request->input('company') != null) {
                if (in_array(Auth::user()->company_id, ['0', '999', '888'])) {
                    $dataRabQuery = $dataRabQuery->where('t_rab.id_company', $request->company);
                }else{

                }
            }
            if ($request->input('department') != null) {
                $dataRabQuery = $dataRabQuery->where('t_rab.division', $request->department);
            }
        } else {
            $startOfMonth = date('Y-m-t', strtotime('-3 month'));
            $oneMonthAfter = date('Y-m-t');
            $dataRabQuery->whereBetween('t_rab.date_rab', [$startOfMonth, $oneMonthAfter]);
    
            $dataRabQuery->where(function($query) use ($user) {
                $query->where('t_rab.approval_to', $user)
                      ->where(function($query) {
                          $query->where('t_rab.approvalstat', '=', 'Site Approved')
                                ->orWhere('t_rab.approvalstat', '=', 'HQ 1 Approved');
                      });
            });
        }

        $dataRab = $dataRabQuery->orderBy('t_rab.id_rab', 'desc')->get();

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
            ->addColumn('action', function ($dataRab) use ($user) {
                if ($dataRab->approvalstat == 'Site Approved') {
                    return '
                    <a href = "/ga/rab-approval/approve1/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }else if ($dataRab->approvalstat == 'HQ 1 Approved' && $dataRab->approval_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                    >Cancel</button>
                    </div>';
                }else if ($dataRab->approvalstat == 'HQ 1 Approved' || $dataRab->approvalstat == 'Draft' || $dataRab->approvalstat == 'HQ 2 Approved' || $dataRab->approvalstat == 'Printed' || $dataRab->approvalstat == 'Enforced' || $dataRab->approvalstat == 'HQ 1 Denied' || $dataRab->approvalstat == 'HQ 2 Denied' || $dataRab->approvalstat == 'HQ 3 Denied' || $dataRab->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function rabGetApproval2(Request $request)
    {
        $user = Auth::user()->id;
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
            't_rab.approval_to',
            't_rab.approval2_to',
            't_rab.approval3_to',
            't_rab.print_status',
            't_rab.created_by',
            'm_child_company.name',
            'm_department.name as deptName',
            'users.username'
        );
        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
            }

            if ($request->input('status') != 'No') {
                $dataRabQuery->where(function($query) use ($user) {
                    $query->where('t_rab.approval2_to', $user)
                          ->where(function($query) {
                              $query->where('t_rab.approvalstat', '=', 'HQ 1 Approved')
                                    ->orWhere('t_rab.approvalstat', '=', 'Enforced');
                          });
                });
            } else if ($request->input('status') != 'Yes') {
                if (in_array(Auth::user()->company_id, ['0', '999', '888'])) {
                    $dataRabQuery = $dataRabQuery->orderBy('t_rab.id_rab', 'desc');
                } else {
                    $dataRabQuery = $dataRabQuery->where('t_rab.id_company', '=', Auth::user()->company_id);
                }
            }

            if ($request->input('company') != null){
                if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                    $dataRabQuery = $dataRabQuery->where('t_rab.id_company', $request->company);
                } else {
                    
                }
            }
            if ($request->input('department') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.division', $request->department);
            }
        }else{
            $startOfMonth = date('Y-m-t', strtotime('-3 month'));
            $oneMonthAfter = date('Y-m-t');
            $dataRabQuery->whereBetween('t_rab.date_rab', [$startOfMonth, $oneMonthAfter]);
            $dataRabQuery->where(function($query) use ($user) {
                $query->where('t_rab.approval2_to', $user)
                      ->where(function($query) {
                          $query->where('t_rab.approvalstat', '=', 'HQ 1 Approved')
                                ->orWhere('t_rab.approvalstat', '=', 'Enforced');
                      });
            });
        }

        $dataRab = $dataRabQuery->orderBy('t_rab.id_rab', 'desc');

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
            ->addColumn('action', function ($dataRab) use ($user){
                if ($dataRab->approvalstat == 'HQ 1 Approved' && $dataRab->approval2_to == $user) {
                    return '
                    <a href = "/ga/rab-approval2/approve2/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }else if ($dataRab->approvalstat == 'HQ 2 Approved' && $dataRab->approval2_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                    >Cancel</button>
                    </div>';
                }else if ($dataRab->approvalstat == 'Enforced' && $dataRab->approval2_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                    >Cancel</button>
                    </div>';
                }else{
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }
        })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function rabGetApproval3(Request $request)
    {
        $user = Auth::user()->id;
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
            't_rab.approval_to',
            't_rab.approval2_to',
            't_rab.approval3_to',
            't_rab.print_status',
            't_rab.created_by',
            'm_child_company.name',
            'm_department.name as deptName',
            'users.username'
        );

        if ($searchTriggered) {
            if ($startdate && $enddate) {
                $dataRabQuery->whereDate('t_rab.date_rab', '>=', date('Y-m-t', strtotime($startdate)))
                    ->whereDate('t_rab.date_rab', '<=', date('Y-m-t', strtotime($enddate)));
            }

            if ($request->input('status') != 'No'){
                $dataRabQuery->where(function($query) use ($user) {
                    $query->where('t_rab.approval3_to', $user)
                          ->where(function($query) {
                              $query->where('t_rab.approvalstat', '=', 'HQ 2 Approved')
                                    ->orWhere('t_rab.approvalstat', '=', 'Enforced');
                          });
                });
            }else if ($request->input('status') != 'Yes'){
                if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                    $dataRab = $dataRabQuery->orderBy('t_rab.id_rab', 'desc');
                } else {
                    $dataRabQuery = $dataRabQuery->where('t_rab.id_company', '=', Auth::user()->company_id);
                }
            }
            if ($request->input('company') != null){
                if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                    $dataRabQuery = $dataRabQuery->where('t_rab.id_company', $request->company);
                }else{

                }
            }
            if ($request->input('department') != null){
                $dataRabQuery = $dataRabQuery->where('t_rab.division', $request->department);
            }
        }else{
            $startOfMonth = date('Y-m-t', strtotime('-3 month'));
            $oneMonthAfter = date('Y-m-t');
            $dataRabQuery->whereBetween('t_rab.date_rab', [$startOfMonth, $oneMonthAfter]);
            $dataRabQuery->where(function($query) use ($user) {
                $query->where('t_rab.approval3_to', $user)
                      ->where(function($query) {
                          $query->where('t_rab.approvalstat', '=', 'HQ 2 Approved')
                                ->orWhere('t_rab.approvalstat', '=', 'Enforced');
                      });
            });
        }

        $dataRab = $dataRabQuery->orderBy('t_rab.id_rab', 'desc');

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
            ->addColumn('action', function ($dataRab) use ($user){
                if ($dataRab->approvalstat == 'HQ 2 Approved' && $dataRab->approval3_to == $user) {
                    return '
                    <a href = "/ga/rab-approval3/approve3/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }else if ($dataRab->approvalstat == 'Enforced' && $dataRab->approval3_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataRab->idrec.'"
                        >Cancel</button>
                    </div>';
                }else{
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/rab-approval/list/view/' . $dataRab->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function submitRab(Request $request, $rabId)
    {
        try {
            $dataRab = DB::table('t_rab')->select('t_rab.idrec', 't_rab.id_rab', 't_rab.approvalstat', 't_rab.id_company', 't_rab.name_rab', 't_rab.form_date', 't_rab.date_rab', 't_rab.applicant', 't_rab.gtotal', 't_rab.currency')->where('idrec', $rabId)->first();
            $idRab = $dataRab->id_rab;
            $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataRab->id_company)->first();
            $approvalstat = $dataRab->approvalstat;
            if ($request->hasFile('file')) {
                $filePdf = $request->file('file');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File to Large, Please compress File');
                    return response()->json(["st" => '2']);
                }    
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            } else {
                   $pdf = null;
            }

            $approvalTo = $request->input('approval_to');

            $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
    
            $token = (string)Str::uuid();
    
            $user = DB::table('users')->where('email', $email)->pluck('username')->first();
            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
            if ($approvalstat == 'Printed') {
                DB::table('rab_approve1_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                
                $data = [
                    'url' => route('rab.approve1page', [
                        'rabId' => $rabId,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('Y F', strtotime($dataRab->form_date)),
                    'rabNo' => $dataRab->id_rab,
                    'title' => $dataRab->name_rab,
                    'period' => date('Y F', strtotime($dataRab->date_rab)),
                    'applicant' => $dataRab->applicant,
                    'currency' => $dataRab->currency,
                    'gtotal' => number_format($dataRab->gtotal, 0, ',', '.')
                ];
                Mail::send('rab_approval1', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject('' . $datacomps->name . ' - RAB Approval 1');
                });
                DB::table('t_rab')->where('idrec', $rabId)->update([
                    'approvalstat' => 'Site Approved',
                    'approval_to' => $request->input('approval_to'),
                    'approval2_to' => $request->input('approval2_to'),
                    'approval3_to' => $request->input('approval3_to'),
                    'rab_file' => $pdf,
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
    
                DB::table('t_rab_detail')
                ->where('id_rab', $idRab)
                ->update([
                    'approvalstat' => 'Site Approved',
                    'last_updated_at' => date('Y-m-d'),
                    'last_updated_by' => Auth::user()->username
                ]);
    
                alert()->success('Success', 'RAB Request Has Been Submited, Waiting Approval 1');
                return response()->json(["st" => '1']);
            } else {
                alert()->error('Error', 'RAB Already Submitted');
                return response()->json(["st" => '3']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function cancelRAB($rabId)
    {
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->first();
        $id_rab = $dataRab->id_rab;
        $dataPayment = DB::table('t_costpayment')->where('id_costpayment', $id_rab)->first();
        $dataPR = DB::table('inventory_assets_request')->where('id_rab', $id_rab)->pluck('id_rab')->first();
        $trabDetails = DB::table('t_rab_detail')
        ->where('id_rab', $id_rab)
        ->get(['total', 'balance']);
        try {
            if ($dataRab->rab_type == 'Advance Payment to Site')
            {
                // Kondisi jika $dataPayment null atau $dataPayment->approved_total == $dataPayment->balance
                if (is_null($dataPayment) || $dataPayment->approved_total == $dataPayment->balance) {
                    DB::table('t_rab')->where('idrec', $rabId)->update([
                        'approvalstat' => 'Canceled',
                        'approval1stat' => 'Canceled',
                        'approval2stat' => 'Canceled',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                    DB::table('t_costpayment')->where('id_costpayment', $id_rab)->update([
                        'status' => 'Canceled',
                        'aktifyn' => 'N',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->username
                    ]);
                    return response()->json([
                        'status' => 1,
                        'message' => "Successfully Canceled RAB Request",
                    ]);
                } elseif ($dataPayment != null && $dataPayment->approved_total != $dataPayment->balance) {
                    return response()->json([
                        'status' => 2,
                        'message' => "Cannot cancel RAB, there are Active PV",
                    ]);
                }
            }
            else
            {
                // Kondisi jika $dataPR tidak null
                if ($dataPR != null) {
                    DB::table('t_rab')->where('idrec', $rabId)->update([
                        'approvalstat' => 'Canceled',
                        'approval1stat' => 'Canceled',
                        'approval2stat' => 'Canceled',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                    $status = 'Canceled';

                    foreach ($trabDetails as $detail) {
                        if ($detail->total != $detail->balance) {
                            $status = 'Stop';
                            break; // Stop looping as soon as we find a difference
                        }
                    }

                    DB::table('inventory_assets_request')->where('id_rab', $id_rab)->update([
                        'approvalstat' => $status,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                    DB::table('inventory_assets_request_detail')->where('id_rab', $id_rab)->update([
                        'status' => 'Non Active',
                        'updated_at' => date('Y-m-d'),
                    ]);

                    return response()->json([
                        'status' => 1,
                        'message' => "Successfully Canceled RAB Request",
                    ]);
                }
            }
            // // Kondisi jika $dataPayment atau $dataPR null
            // if (is_null($dataPayment) || is_null($dataPR)) {
            //     DB::table('t_rab')->where('idrec', $rabId)->update([
            //         'approvalstat' => 'Canceled',
            //         'approval1stat' => 'Canceled',
            //         'approval2stat' => 'Canceled',
            //         'updated_at' => date('Y-m-d'),
            //         'updated_by' => Auth::user()->id
            //     ]);
                
            //     return response()->json([
            //         'status' => 1,
            //         'message' => "Successfully Canceled RAB Request",
            //     ]);
            // }

            // // Kondisi jika $dataPR tidak null
            // if ($dataPR != null) {
            //     DB::table('t_rab')->where('idrec', $rabId)->update([
            //         'approvalstat' => 'Canceled',
            //         'approval1stat' => 'Canceled',
            //         'approval2stat' => 'Canceled',
            //         'updated_at' => date('Y-m-d'),
            //         'updated_by' => Auth::user()->id
            //     ]);
            //     $status = 'Canceled';

            //     foreach ($trabDetails as $detail) {
            //         if ($detail->total != $detail->balance) {
            //             $status = 'Stop';
            //             break; // Stop looping as soon as we find a difference
            //         }
            //     }

            //     DB::table('inventory_assets_request')->where('id_rab', $id_rab)->update([
            //         'approvalstat' => $status,
            //         'updated_at' => date('Y-m-d'),
            //         'updated_by' => Auth::user()->id
            //     ]);
            //     DB::table('inventory_assets_request_detail')->where('id_rab', $id_rab)->update([
            //         'status' => 'Non Active',
            //         'updated_at' => date('Y-m-d'),
            //     ]);

            //     return response()->json([
            //         'status' => 1,
            //         'message' => "Successfully Canceled RAB Request",
            //     ]);
            // }

            // // Kondisi jika $dataPayment null atau $dataPayment->approved_total == $dataPayment->balance
            // if (is_null($dataPayment) || $dataPayment->approved_total == $dataPayment->balance) {
            //     DB::table('t_rab')->where('idrec', $rabId)->update([
            //         'approvalstat' => 'Canceled',
            //         'approval1stat' => 'Canceled',
            //         'approval2stat' => 'Canceled',
            //         'updated_at' => date('Y-m-d'),
            //         'updated_by' => Auth::user()->id
            //     ]);
            //     DB::table('t_costpayment')->where('id_costpayment', $id_rab)->update([
            //         'status' => 'Canceled',
            //         'aktifyn' => 'N',
            //         'updated_at' => date('Y-m-d H:i:s'),
            //         'updated_by' => Auth::user()->username
            //     ]);
            //     return response()->json([
            //         'status' => 1,
            //         'message' => "Successfully Canceled RAB Request",
            //     ]);
            // } elseif ($dataPayment != null && $dataPayment->approved_total != $dataPayment->balance) {
            //     return response()->json([
            //         'status' => 2,
            //         'message' => "Cannot cancel RAB there are Active PV",
            //     ]);
            // }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function signature(Request $request, $rabId)
    {   
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->select(
            '*'
        )->where('t_rab.idrec', $rabId)->first();
        return view('pages.ga.rab-approval.list.signature', compact('dataRab'));
    }

    public function signatureupdate(Request $request, $rabId)
    {   
        try {
                if($request){
                    $idrec=DB::table('t_rab')->select('t_rab.idrec', 't_rab.id_rab')->where('t_rab.idrec', $rabId)->first();
                    $id=$idrec->idrec;
                    $idRab=$idrec->id_rab; 
                    $approvalstat = DB::table('t_rab')->where('t_rab.idrec', $rabId)->pluck('approvalstat')->first();
                    if ($approvalstat == 'Draft' || $approvalstat == 'Printed') {
                        DB::table('t_rab')->where('t_rab.idrec', $rabId)->update([
                            'prepared_by' => $request->input('prepared'),
                            'reviewed_by' => $request->input('view'),
                            'reviewed2_by' => $request->input('view2'),
                            'approved_by' => $request->input('approved'),
                            'approved2_date' => $request->input('viewDate'),
                            'approved3_date' => $request->input('approvedDate'),
                            'print_status' => 'Y',
                            'approvalstat' => 'Printed',
                            'updated_at' => date('Y-m-d')
                        ]);
    
                        DB::table('t_rab_detail')
                        ->where('id_rab', $idRab)
                        ->update([
                            'approvalstat' => 'Printed',
                            'last_updated_at' => date('Y-m-d'),
                            'last_updated_by' => Auth::user()->username
                        ]);
                        alert()->success('Success', 'RAB has been Printed');    
                        return response()->json(["st" => '1', "id"=>$id]);
                    }else {
                        return response()->json(["st" => '0']);
                    }
                }else{
                    return response()->json(["st" => '0']);
                }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function print(Request $request, $rabId)
    {     
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('t_rab_detail', 't_rab.id_rab', 't_rab_detail.id_rab')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->select(
            't_rab.*',
            'm_child_company.company_type',
            'm_child_company.name',
            'm_child_company.address',
            'm_child_company.logo_blob',
            'm_child_company.logo_filename',
            'm_department.name as dept',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal"),
        DB::raw("SUM(t_rab_detail.qty) AS qtyTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;

        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.total', 't_rab_detail.unit', 
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.status', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category',
        't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.id_rab_item')->orderBy('t_rab_detail.idrec', 'asc')->get();

        $dataRabItemCount = $dataRabItem->count(); // Menghitung jumlah item

        $dataRabDepartment = DB::table('t_rab_detail')
        ->select('t_rab_detail.id_rab', 't_rab_detail.category', 't_rab_detail.status', 't_rab_detail.sub_category')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.category')->orderBy('t_rab_detail.category', 'asc')->get();

        $dataRabSubDepartment = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.status', 't_rab_detail.id_rab_item', 't_rab_detail.sub_category', 't_rab_detail.category')
        ->selectRaw("SUM(total) AS Totaly")
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.sub_category')->get();

        return view('pages.ga.rab-approval.list.print', compact('dataRab', 'dataRabItem', 'dataRabItemCount', 'dataRabDepartment', 'dataRabSubDepartment'));
    }

    public function printedEnforced(Request $request, $rabId)
    {     
        $dataRab = DB::table('t_rab')
        ->leftJoin('m_child_company', 't_rab.id_company', 'm_child_company.id_company')
        ->leftJoin('t_rab_detail', 't_rab.id_rab', 't_rab_detail.id_rab')
        ->leftJoin('m_department', 't_rab.division', 'm_department.id')
        ->select(
            't_rab.*',
            'm_child_company.company_type',
            'm_child_company.name',
            'm_child_company.address',
            'm_child_company.logo_blob',
            'm_child_company.logo_filename',
            'm_department.name as dept',
        DB::raw("CAST(gtotal AS DECIMAL(18,0)) AS grandTotal"),
        DB::raw("SUM(t_rab_detail.qty) AS qtyTotal")
        )->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;

        $dataRabItem = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.total', 't_rab_detail.unit', 
        't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.status', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category',
        't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.id_rab_item')->orderBy('t_rab_detail.idrec', 'asc')->get();

        $dataRabItemCount = $dataRabItem->count(); // Menghitung jumlah item

        $dataRabDepartment = DB::table('t_rab_detail')
        ->select('t_rab_detail.id_rab', 't_rab_detail.category', 't_rab_detail.status', 't_rab_detail.sub_category')
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.category')->orderBy('t_rab_detail.category', 'asc')->get();

        $dataRabSubDepartment = DB::table('t_rab_detail')
        ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.status', 't_rab_detail.id_rab_item', 't_rab_detail.sub_category', 't_rab_detail.category')
        ->selectRaw("SUM(total) AS Totaly")
        ->where('t_rab_detail.id_rab', $idRab)->where('t_rab_detail.status', '=', 'Active')->groupBy('t_rab_detail.sub_category')->get();

        return view('pages.ga.rab-approval.list.printed-enforced', compact('dataRab', 'dataRabItem', 'dataRabItemCount', 'dataRabDepartment', 'dataRabSubDepartment'));
    }

    public function rabListClonePage(Request $request, $rabId)
    {   
        $dataRab = DB::table('t_rab')->select('t_rab.*')->where('t_rab.idrec', $rabId)->first();
        return view('pages.ga.rab-approval.list.clone', compact('dataRab'));
    }

    public function rabListClone(Request $request, $rabId)
    {
        $dataRab = DB::table('t_rab')->select('t_rab.*')->where('t_rab.idrec', $rabId)->first();

        $idRab = $dataRab->id_rab;

        $rowsProducts = DB::table('t_rab_detail')->select('*')->where('id_rab', $idRab)->where('status', '=', 'Active')->get();

        $company = $dataRab->id_company;

        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('periode');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y');
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/RAB/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_rab')
            ->where('id_rab', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $rabId = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->id_rab;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $rabId = $indicator . $countIndicator;
        }

        $date = $request->input('periode');

        $date1 = date('Y-m-t',strtotime($date));

        $formingdate = $request->input('formDate');

        $formingdate1 = date('Y-m-t',strtotime($formingdate));

        try {
            if ($date == $formingdate) {
                DB::transaction(function () use ($rowsProducts, $dataRab, $request, $rabId, $date1){
                    DB::table('t_rab')->insert([
                        'date_rab' => $date1,
                        'form_date' => $request->input('formDate'),
                        'rab_type' => $dataRab->rab_type,
                        'id_rab' => $rabId,
                        'name_rab' => $request->input('rabName'),
                        'applicant' => $dataRab->applicant,
                        'id_company' => $dataRab->id_company,
                        'division' => $dataRab->division,
                        'gtotal' => $dataRab->gtotal,
                        'currency' => 'IDR',
                        'prepared_date' => $request->input('formDate'),
                        'print_status' => 'N',
                        'approvalstat' => 'Draft',
                        'approval1stat' => 'Draft',
                        'approval2stat' => 'Draft',
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d')
                    ]);
                    
                    foreach ($rowsProducts as $key => $value) {
                        DB::table('t_rab_detail')->insert([
                            'date_rab' => $date1,
                            'id_rab' => $rabId,
                            'rab_calc_type' => $value->rab_calc_type,
                            'id_rab_item' => $value->id_rab_item,
                            'category' => $value->category,
                            'sub_category' => $value->sub_category,
                            'name_rab_detail' => $value->name_rab_detail,
                            'unit' => $value->unit,
                            'days' => $value->days,
                            'qty' => $value->qty,
                            'amount' => $value->amount,
                            'total' => $value->total,
                            'balance' => $value->balance,
                            'remarks' => $value->remarks,
                            'created_by' => Auth::user()->username,
                            'created_at' => date('Y-m-d'),
                            'last_updated_by' => Auth::user()->username,
                            'last_updated_at' => date('Y-m-d'),
                            'status' => 'Active'
                        ]);
                    }
                });
                alert()->success('Success', 'RAB #' . $rabId . ' Has Been Created');
                return to_route('rab-list');
            }else if ($date > $formingdate) {
                DB::transaction(function () use ($rowsProducts, $dataRab, $request, $rabId, $date1){
                    DB::table('t_rab')->insert([
                        'date_rab' => $date1,
                        'form_date' => $request->input('formDate'),
                        'rab_type' => $dataRab->rab_type,
                        'id_rab' => $rabId,
                        'name_rab' => $request->input('rabName'),
                        'applicant' => $dataRab->applicant,
                        'id_company' => $dataRab->id_company,
                        'division' => $dataRab->division,
                        'gtotal' => $dataRab->gtotal,
                        'currency' => 'IDR',
                        'prepared_date' => $request->input('formDate'),
                        'print_status' => 'N',
                        'approvalstat' => 'Draft',
                        'approval1stat' => 'Draft',
                        'approval2stat' => 'Draft',
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d')
                    ]);
                    
                    foreach ($rowsProducts as $key => $value) {
                        DB::table('t_rab_detail')->insert([
                            'date_rab' => $date1,
                            'id_rab' => $rabId,
                            'rab_calc_type' => $value->rab_calc_type,
                            'id_rab_item' => $value->id_rab_item,
                            'category' => $value->category,
                            'sub_category' => $value->sub_category,
                            'name_rab_detail' => $value->name_rab_detail,
                            'unit' => $value->unit,
                            'days' => $value->days,
                            'qty' => $value->qty,
                            'amount' => $value->amount,
                            'total' => $value->total,
                            'balance' => $value->balance,
                            'remarks' => $value->remarks,
                            'created_by' => Auth::user()->username,
                            'created_at' => date('Y-m-d'),
                            'last_updated_by' => Auth::user()->username,
                            'last_updated_at' => date('Y-m-d'),
                            'status' => 'Active'
                        ]);
                    }
                });
                alert()->success('Success', 'RAB #' . $rabId . ' Has Been Created');
                return to_route('rab-listonly');
            }else if ($date < $formingdate){
                alert()->error('Error', 'RAB cannot be in the past');
                return to_route('rab-listonly');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function viewFile($rabId)
    {
        $dataRab = DB::table('t_rab')->where('idrec', $rabId)->select('rab_file', 'date_rab')->first();
        $filename = $dataRab->date_rab . '.pdf';
        $fileRab = $dataRab->rab_file;

        // if (is_null($invoice)) {
        //     alert()->error('Error', 'Invoice Not Found');
        //     return to_route('invoice');
        // }

        return Response::make($fileRab, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function masterVendor()
    {
        return view('pages.ga.data-master.m-vendor.m-vendor');
    }

    public function masterVendorList()
    {
        return view('pages.ga.data-master.m-vendor.m-vendor-list');
    }

    public function masterVendorForm()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-vendor.m-vendor-form', compact('dataCountry', 'bank'));
    }

    public function masterVendorEdit()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-vendor.m-vendor-edit', compact('dataCountry', 'bank'));
    }

    public function masterVendorDeletePage()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        return view('pages.ga.data-master.m-vendor.m-vendor-delete', compact('dataCountry'));
    }

    public function masterVendorGetData(Request $request)
    {
        $dataVendorQuery = DB::table('m_vendors')
        ->select('m_vendors.*', DB::raw("
        case
            when m_vendors.vendor_type = 0 then 'All'
            when m_vendors.vendor_type = 1 then 'Purchasing'
            when m_vendors.vendor_type = 2 then 'Finance'
            else 'unknown type'
        end as types
        "))->where('m_vendors.status', '=', 'ACTIVE');
        
        if ($request->input('dept') == '1') {
            // Munculkan selain vendor_type 2
            $dataVendorQuery->where('m_vendors.vendor_type', '!=', '2');
        } elseif ($request->input('dept') == '2') {
            // Munculkan selain vendor_type 1
            $dataVendorQuery->where('m_vendors.vendor_type', '!=', '1');
        }

        $dataVendor = $dataVendorQuery->orderBy('m_vendors.name', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataVendor)
            // ->editColumn('name', function ($dataVendor) {
            //     return $dataVendor->company_type . " " . $dataVendor->name;
            // })
            ->addColumn('action', function ($dataVendor) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataVendor->idsupplier.'"
                                data-name = "' . $dataVendor->name . '" data-address = "' . $dataVendor->address . '" data-initials = "' . $dataVendor->initials . '"
                                data-city = "' . $dataVendor->city . '" data-country = "' . $dataVendor->country . '" data-type = "' . $dataVendor->company_type . '"
                                data-category = "' . $dataVendor->category . '" data-phone = "' . $dataVendor->phone . '" data-zip_code = "' . $dataVendor->zip_code . '" 
                                data-npwp_id = "' . $dataVendor->npwp_id . '" data-npwp_address = "' . $dataVendor->npwp_address . '" data-npwp_city = "' . $dataVendor->npwp_city . '" 
                                data-npwp_country = "' . $dataVendor->npwp_country . '" data-npwp_zipcode = "' . $dataVendor->npwp_zipcode . '" data-bank_name = "' . $dataVendor->bank_name . '" 
                                data-bank_acc_name = "' . $dataVendor->bank_acc_name . '" data-bank_acc_num = "' . $dataVendor->bank_acc_num . '" data-vendor_type = "' . $dataVendor->vendor_type . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Data Vendor</div>
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
            ->addColumn('action1', function ($dataVendor) {
                return '
                <div class="flex flex-row"> 
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataVendor->idsupplier.'" data-name = "' . $dataVendor->name . '" data-type = "' . $dataVendor->company_type . '"
                        >Delete
                    </button>
                </div>';
            })
            ->addColumn('action2', function ($dataVendor) {
                return '<button
                type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataVendor->idsupplier . '"
                data-company_type="' . $dataVendor->company_type . '" data-name="' . $dataVendor->name . '" data-bank_name="' . $dataVendor->bank_name . '" data-bank_acc_num="' . $dataVendor->bank_acc_num . '" data-bank_acc_name="' . $dataVendor->bank_acc_name . '" id="select"
            >Select</button>';
            })       
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function masterVendorCreate(Request $request)
    {
        $dataVendor = DB::table('m_vendors')->select('name')->where('name', $request->input('vendor'))->first();
        if ($request->hasFile('npwp_pdf1')) {
            $filePdf = $request->file('npwp_pdf1');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
            $pdf = null;
        } 
        if ($dataVendor == null) {
            DB::table('m_vendors')->insert([
                'category' => $request->input('category'),
                'initials' => $request->input('initials'),
                'company_type' => $request->input('companyType'),
                'vendor_type' => $request->input('vendor_type'),
                'name' => $request->input('vendor'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
                'country' => $request->input('country'),
                'zip_code' => $request->input('zipCode'),
                'bank_acc_num' => $request->input('number'),
                'bank_name' => $request->input('bank'),
                'bank_acc_name' => $request->input('account'),
                'npwp_id' => $request->input('npwp_id'),
                'npwp_address' => $request->input('npwp_address'),
                'npwp_city' => $request->input('npwp_city'),
                'npwp_country' => $request->input('npwp_country'),
                'npwp_zipcode' => $request->input('npwp_zipcode'),
                'npwp_pdf' => $pdf,
                'status' => 'ACTIVE',
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data Vendor Has Been Created');
            return to_route('m-vendor.form');
        } else {
            alert()->error('Error', 'Data Vendor Already Exist');
            return to_route('m-vendor.form');
        }
    }

    public function masterVendorUpdate(Request $request, $vendorId)
    {
        if ($request->hasFile('npwp_pdf1')) {
            $filePdf = $request->file('npwp_pdf1');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
            $pdf = null;
        } 
        if ($request) {
            DB::table('m_vendors')->where('idsupplier', $vendorId)->update([
                'company_type' => $request->input('companyType1'),
                'vendor_type' => $request->input('vendor_type'),
                'name' => $request->input('childName1'),
                'initials' => $request->input('initials1'),
                'category' => $request->input('category1'),
                'address' => $request->input('address1'),
                'city' => $request->input('city1'),
                'phone' => $request->input('phone1'),
                'country' => $request->input('country1'),
                'zip_code' => $request->input('zipCode1'),
                'bank_acc_num' => $request->input('number1'),
                'bank_name' => $request->input('bank1'),
                'bank_acc_name' => $request->input('account1'),
                'npwp_id' => $request->input('npwp_id1'),
                'npwp_address' => $request->input('npwp_address1'),
                'npwp_city' => $request->input('npwp_city1'),
                'npwp_country' => $request->input('npwp_country1'),
                'npwp_zipcode' => $request->input('npwp_zipcode1'),
                'npwp_pdf' => $pdf,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Data Vendor Has Been Updated');
            return to_route('m-vendor.edit');
        } else {
            alert()->error('Error', 'error');
            return to_route('m-vendor.edit');
        }
    }

    public function masterVendorDelete($vendorId)
    {
        try {
            DB::table('m_vendors')->where('idsupplier', $vendorId)->update([
                'status' => 'NON ACTIVE',
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data Vendor",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function vendorSelect(Request $request)
    {
        $dataVendor = DB::table('m_vendors')
        ->select('*')->where('status', '=', 'Active')->orderBy('m_vendors.name', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataVendor)
                ->addColumn('action', function ($dataVendor) {
                    return '
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_vendor="' . $dataVendor->idsupplier . '"
                        data-name_vendor="' . $dataVendor->name . '" data-type="' . $dataVendor->company_type . '" data-phone="' . $dataVendor->phone . '"
                        >Select</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function masterModel($brandId)
    {
        $dataBrand = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->get();
        $dataBrand1 = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->first();
        return view('pages.ga.data-master.m-model.m-model', compact('dataBrand', 'dataBrand1'));
    }

    public function masterModelCreate(Request $request)
    {
        $brandName = $request->input('brand1');
        $model = $request->input('model');
        $dataModel = DB::table('m_brand_model')->select('name', 'p_id_brand')->where('name', $model)->where('p_id_brand', $brandName)->first();
        if ($dataModel == null) {
            DB::table('m_brand_model')->insert([
                'name' => $request->input('model'),
                'p_id_brand' => $request->input('brand1'),
                'status'=> 'Active',
                'created_at'=> date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Model Has Been Created');
            return to_route('m-brand.form');
        } else {
            alert()->error('Error', 'Model Already Exist');
            return to_route('m-brand.form');
        }
    }

    public function masterModelUpdate(Request $request, $modelId)
    {
        $modelName = $request->input('model1');
        $brand = $request->input('brand1');
        $dataModel = DB::table('m_brand_model')->select('name', 'p_id_brand')->where('name', $modelName)->where('p_id_brand', $brand)->first();
        if ($dataModel == null) {
            DB::table('m_brand_model')->where('id_brand', $modelId)->update([
                'name' => $request->input('model1'),
                'p_id_brand' => $request->input('brand1'),
                'updated_at'=> date('Y-m-d')
            ]);

            alert()->success('Success', 'Model Has Been Updated');
            return to_route('m-model.edit', $brand);
        } else {
            alert()->error('Error', 'Model Already Exist');
            return to_route('m-model.edit', $brand);
        }
    }
    
    public function masterModelDelete($modelId)
    {
        try {
            DB::table('m_brand_model')->where('id_brand', $modelId)->update([
                'status'=> 'Non Active',
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Sub Model",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterModelEdit($brandId)
    {
        $dataBrand = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->get();
        $dataBrand1 = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->first();
        return view('pages.ga.data-master.m-model.m-model-edit', compact('dataBrand', 'dataBrand1'));
    }

    public function masterModelDeletePage($brandId)
    {
        $dataBrand = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->get();
        $dataBrand1 = DB::table('m_brand_model')->select('*')->where('id_brand', $brandId)->first();
        return view('pages.ga.data-master.m-model.m-model-delete', compact('dataBrand', 'dataBrand1'));
    }

    public function masterModelGetData(Request $request, $brandId)
    {
        $dataModel = DB::table('m_brand_model as mc1')
        ->leftJoin('m_brand_model as mc2', 'mc1.p_id_brand', '=', 'mc2.id_brand')
        ->select('mc1.id_brand', 'mc1.name', 'mc1.p_id_brand', 'mc2.name as name_brand', 'mc1.p_id_brand as brand_id', 'mc1.status')
        ->where('mc1.p_id_brand', $brandId)->where('mc1.status', '=', 'Active')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($dataModel)
            ->addColumn('action', function ($dataModel) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataModel->id_brand.'"
                                data-name = "' . $dataModel->name . '" data-id_brand = "' . $dataModel->p_id_brand . '" 
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Model</div>
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
            ->addColumn('action1', function ($dataModel) {
                    return '
                    <div class="flex flex-row justify-center"> 
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataModel->id_brand.'" data-name = "' . $dataModel->name . '"
                            >Delete
                        </button>
                    </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }
    
    public function masterBrand()
    {
        return view('pages.ga.data-master.m-brand.m-brand');
    }

    public function masterBrandList()
    {
        return view('pages.ga.data-master.m-brand.m-brand-list');
    }

    public function masterBrandForm()
    {
        $dataBrand = DB::table('m_brand_model')->select('*')->where('p_id_brand', '=', '0')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-brand.m-brand-form', compact('dataBrand'));
    }

    public function masterBrandEdit()
    {
        return view('pages.ga.data-master.m-brand.m-brand-edit');
    }
    
    public function masterBrandDeletePage()
    {
        return view('pages.ga.data-master.m-brand.m-brand-delete');
    }

    public function masterBrandGetData(Request $request)
    {
        $dataBrand = DB::table('m_brand_model')
        ->select('*')->where('p_id_brand', '=', '0')->where('status', '=', 'Active')->orderBy('m_brand_model.name', 'desc'); 

        if ($request->ajax()) {
            return DataTables::of($dataBrand)
            ->addColumn('action', function ($dataBrand) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataBrand->id_brand.'"
                                data-name = "' . $dataBrand->name . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Brand</div>
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

                        <a href = "/data-master/m-model/edit/'. $dataBrand->id_brand .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Model Settings</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataBrand) {
                    return '
                    <div class="flex flex-row justify-center">                
                        <a href = "/data-master/m-model/'. $dataBrand->id_brand .'" class="btn btn-sm btn-update text-sm bg-amber-500 hover:bg-amber-600 text-white"
                        >View Model</a>
                    </div>';
            })
            ->addColumn('action2', function ($dataBrand) {
                    return '
                    <div class="flex flex-row justify-center">  
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataBrand->id_brand.'" data-name = "' . $dataBrand->name . '"
                            >Delete
                        </button>

                        <a href = "/data-master/m-model/deletepage/'. $dataBrand->id_brand .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Model Settings</a>
                    </div>';
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function masterBrandGetData1(Request $request)
    {
        $dataBrandQuery = DB::table('m_brand_model as mc1')
        ->leftJoin('m_brand_model as mc2', 'mc1.p_id_brand', '=', 'mc2.id_brand')
        ->select('mc1.id_brand', 'mc1.name', 'mc1.p_id_brand', 'mc2.name as name_brand', 'mc1.p_id_brand as brand_id', 'mc1.status')
        ->where('mc1.p_id_brand', '!=', '0')->where('mc1.status', '=', 'Active');

        if ($request->input('brand1') != null) {
            $dataBrandQuery->where('mc1.p_id_brand', $request->brand1);
        }

        $dataBrand = $dataBrandQuery->get();

        if ($request->ajax()) {
            return DataTables::of($dataBrand)
            ->make();
        }
    }

    public function masterBrandCreate(Request $request)
    {
        $brand = $request->input('brand');
        $dataBrand = DB::table('m_brand_model')->select('m_brand_model.name')->where('m_brand_model.name', $brand)->first();

        if ($dataBrand == null) {
            DB::table('m_brand_model')->insert([
                'name' => $request->input('brand'),
                'p_id_brand' => '0',
                'created_at' => date('Y-m-d'),
                'status' => 'Active'
            ]);

            alert()->success('Success', 'New Brand Has Been Created');
            return to_route('m-brand.form');
        } else {
            alert()->error('Error', 'Brand Already Exist');
            return to_route('m-brand.form');
        }
    }

    public function masterBrandUpdate(Request $request, $brandId)
    {
        $brand = $request->input('brand1');
        $dataBrand = DB::table('m_brand_model')->select('m_brand_model.name')->where('m_brand_model.name', $brand)->first();

        if ($dataBrand == null) {
            DB::table('m_brand_model')->where('id_brand', $brandId)->update([
                'name' => $request->input('brand1'),
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Brand Has Been Updated');
            return to_route('m-brand.edit');
        } else {
            alert()->error('Error', 'Brand Already Exist');
            return to_route('m-brand.edit');
        }
    }
    
    public function masterBrandDelete($brandId)
    {
        try {
            $dataModel = DB::table('m_brand_model')->where('p_id_brand', $brandId)->where('status', '=', 'Active')->count();
            if ($dataModel == '0') {
                DB::table('m_brand_model')->where('id_brand', $brandId)->update([
                    'status' => 'Non Active',
                    'updated_at'=> date('Y-m-d')
                ]);
                
                return response()->json([
                    'status' => 1,
                    'message' => "successfully deleted Brand",
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "there are models still active",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function brandSelect(Request $request)
    {
        
        $dataBrand = DB::table('m_brand_model')
        ->select('*')->where('p_id_brand', '=', '0')->where('status', '=', 'Active')->orderBy('m_brand_model.name', 'asc'); 

        if ($request->ajax()) {
            return DataTables::of($dataBrand)
                ->addColumn('action', function ($dataBrand) {
                    return '
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_brand="' . $dataBrand->id_brand . '"
                    data-name_brand="' . $dataBrand->name . '">Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function modelSelect(Request $request)
    {
        $brandId = $request->input('brandFilter');
        $dataModel = DB::table('m_brand_model as mc1')
        ->leftJoin('m_brand_model as mc2', 'mc1.p_id_brand', '=', 'mc2.id_brand')
        ->select('mc1.id_brand', 'mc1.status', 'mc1.name', 'mc1.p_id_brand', 'mc2.name as name_brand', 'mc1.p_id_brand as brand_id')
        ->where('mc1.p_id_brand', '!=', '0')->where('mc1.status', '=', 'Active');

        if ($brandId != null){
            $dataModel = $dataModel->where('mc1.p_id_brand', $brandId);
        }

        if ($request->ajax()) {
            return DataTables::of($dataModel)
                ->addColumn('action', function ($dataModel) {
                    return '
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_model="' . $dataModel->id_brand . '"
                    data-name_model="' . $dataModel->name . '" data-name_brand="' . $dataModel->name_brand . '" data-id_brand="' . $dataModel->brand_id . '">Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function masterSubCategory($catId)
    {
        $dataCategory = DB::table('m_category')->select('*')->where('id_cat', $catId)->get();
        $dataCategory1 = DB::table('m_category')->select('*')->where('id_cat', $catId)->first();
        return view('pages.ga.data-master.m-subcategory.m-subcategory', compact('dataCategory', 'dataCategory1'));
    }

    public function masterSubCategoryCreate(Request $request)
    {
        $categoryName = $request->input('subcategory');
        $category = $request->input('category1');
        $dataCat = DB::table('m_category')->select('name', 'p_id_cat')->where('name', $categoryName)->where('p_id_cat', $category)->first();
        if ($dataCat == null) {
            DB::table('m_category')->insert([
                'name' => $request->input('subcategory'),
                'p_id_cat' => $request->input('category1'),
                'status' => 'Active',
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Sub Category Has Been Created');
            return to_route('m-category.form');
        } else {
            alert()->error('Error', 'Sub Category Already Exist');
            return to_route('m-category.form');
        }
    }

    public function masterSubCategoryUpdate(Request $request, $catId)
    {
        $categoryName = $request->input('subcategory1');
        $category = $request->input('category1');
        $dataCat = DB::table('m_category')->select('name', 'p_id_cat')->where('name', $categoryName)->where('p_id_cat', $category)->first();
        if ($dataCat == null) {
            DB::table('m_category')->where('id_cat', $catId)->update([
                'name' => $request->input('subcategory1'),
                'p_id_cat' => $request->input('category1'),
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Sub Category Has Been Updated');
            return to_route('m-subcategory.edit', $category);
        } else {
            alert()->error('Error', 'Sub Category Already Exist');
            return to_route('m-subcategory.edit', $category);
        }
    }
    
    public function masterSubCategoryDelete($catId)
    {
        try {
            DB::table('m_category')->where('id_cat', $catId)->update([
                'status' => 'Non Active',
                'updated_at' => date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Sub Category",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterSubCategoryEdit($catId)
    {
        $dataCategory = DB::table('m_category')->select('*')->where('id_cat', $catId)->get();
        $dataCategory1 = DB::table('m_category')->select('*')->where('id_cat', $catId)->first();
        return view('pages.ga.data-master.m-subcategory.m-subcategory-edit', compact('dataCategory', 'dataCategory1'));
    }

    public function masterSubCategoryDeletePage($catId)
    {
        $dataCategory = DB::table('m_category')->select('*')->where('id_cat', $catId)->get();
        $dataCategory1 = DB::table('m_category')->select('*')->where('id_cat', $catId)->first();
        return view('pages.ga.data-master.m-subcategory.m-subcategory-delete', compact('dataCategory', 'dataCategory1'));
    }

    public function masterSubCategoryGetData(Request $request, $catId)
    {
        $dataCategory = DB::table('m_category as mc1')
        ->leftJoin('m_category as mc2', 'mc1.p_id_cat', '=', 'mc2.id_cat')
        ->select('mc1.id_cat', 'mc1.name', 'mc1.p_id_cat', 'mc1.status', 'mc2.name as name_cat')
        ->where('mc1.p_id_cat', $catId)->where('mc1.status', '=', 'Active')
        ->orderBy('mc1.name', 'desc')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($dataCategory)
            ->addColumn('action', function ($dataCategory) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataCategory->id_cat.'"
                                data-name = "' . $dataCategory->name . '" data-id_cat = "' . $dataCategory->p_id_cat . '" 
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
                                            <div class="font-semibold text-slate-800">Edit Sub Category</div>
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
            ->addColumn('action1', function ($dataCategory) {
                return '
                <div class="flex flex-row">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataCategory->id_cat.'"
                        >Delete
                    </button>
                </div>';  
            })  
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }
    
    public function masterCategory()
    {
        return view('pages.ga.data-master.m-category.m-category');
    }

    public function masterCategoryForm()
    {
        $dataCat = DB::table('m_category')->select('*')->where('p_id_cat', '=', '0')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-category.m-category-form', compact('dataCat'));
    }

    public function masterCategoryEdit()
    {
        return view('pages.ga.data-master.m-category.m-category-edit');
    }

    public function masterCategoryDeletePage()
    {
        return view('pages.ga.data-master.m-category.m-category-delete');
    }

    public function masterCategoryGetData(Request $request)
    {
        $dataCategory = DB::table('m_category')
        ->select('*')->where('p_id_cat', '=', '0')->where('status', '=', 'Active')->orderBy('m_category.name', 'desc'); 

        if ($request->ajax()) {
            return DataTables::of($dataCategory)
            ->addColumn('action', function ($dataCategory) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataCategory->id_cat.'"
                                data-name = "' . $dataCategory->name . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Category</div>
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
                                      
                        <a href = "/data-master/m-subcategory/edit/'. $dataCategory->id_cat .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Sub Category Settings</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataCategory) {
                    return '
                    <div class="flex flex-row justify-center">                
                        <a href = "/data-master/m-subcategory/'. $dataCategory->id_cat .'" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Sub Category</a>
                    </div>';
            })
            ->addColumn('action2', function ($dataCategory) {
                    return '
                    <div class="flex flex-row justify-center">  
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataCategory->id_cat.'" data-name = "' . $dataCategory->name . '"
                            >Delete
                        </button>

                        <a href = "/data-master/m-subcategory/deletepage/'. $dataCategory->id_cat .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Sub Category Settings</a>
                    </div>';
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function masterCategoryGetData1(Request $request)
    {
        $dataCategory = DB::table('m_category as mc1')
        ->leftJoin('m_category as mc2', 'mc1.p_id_cat', '=', 'mc2.id_cat')
        ->select('mc1.id_cat', 'mc1.name', 'mc1.p_id_cat', 'mc1.status', 'mc2.name as name_cat')
        ->where('mc1.p_id_cat', '!=', '0')->where('mc1.status', '=', 'Active')
        ->orderBy('mc1.name', 'desc')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($dataCategory)
            ->make();
        }
    }

    public function masterCategoryCreate(Request $request)
    {
        $categoryName = $request->input('category');
        $dataCat = DB::table('m_category')->select('name')->where('name', $categoryName)->first();
        if ($dataCat == null) {
            DB::table('m_category')->insert([
                'name' => $request->input('category'),
                'p_id_cat' => '0',
                'status' => 'Active',
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Category Has Been Created');
            return to_route('m-category.form');
        } else {
            alert()->error('Error', 'Category Already Exist');
            return to_route('m-category.form');
        }
    }

    public function masterCategoryUpdate(Request $request, $catId)
    {
        $categoryName = $request->input('category1');
        $dataCat = DB::table('m_category')->select('name')->where('name', $categoryName)->first();
        if ($dataCat == null) {
            DB::table('m_category')->where('id_cat', $catId)->update([
                'name' => $request->input('category1'),
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Category Has Been Updated');
            return to_route('m-category.edit');
        } else {
            alert()->error('Error', 'Category Already Exist');
            return to_route('m-category.edit');
        }
    }

    public function categorySelect(Request $request)
    {
        $dataCategory = DB::table('m_category')
        ->select('*')->where('p_id_cat', '=', '0')->where('status', '=', 'Active')->orderBy('m_category.name', 'asc'); 

        if ($request->ajax()) {
            return DataTables::of($dataCategory)
                ->addColumn('action', function ($dataCategory) {
                    return '
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_cat="' . $dataCategory->id_cat . '"
                    data-name_cat="' . $dataCategory->name . '">Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function subCategorySelect(Request $request)
    {
        $dataCategoryQuery = DB::table('m_subdepartment')
        ->select('*')->where('status', '=', 'Active');

        if ($request->input('categoryFilter') != null){
            $dataCategoryQuery = $dataCategoryQuery->where('p_id_dept', $request->categoryFilter);
        }

        $dataCategory = $dataCategoryQuery;

        if ($request->ajax()) {
            return DataTables::of($dataCategory)
                ->addColumn('action', function ($dataCategory) {
                    return '
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_sub="' . $dataCategory->id . '"
                    data-sub_name="' . $dataCategory->name . '" data-id_dept="' . $dataCategory->p_id_dept . '" data-dept_name="' . $dataCategory->dept_name . '">Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }
    
    public function masterCategoryDelete($catId)
    {
        try {
            $dataCategory = DB::table('m_category')->where('p_id_cat', $catId)->where('status', '=', 'Active')->count();
            if ($dataCategory == '0') {
                DB::table('m_category')->where('id_cat', $catId)->update([
                    'status' => 'Non Active',
                    'updated_at' => date('Y-m-d')
                ]);
                return response()->json([
                    'status' => 1,
                    'message' => "successfully deleted Category",
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "there are models still active",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterDepartment()
    {
        return view('pages.ga.data-master.m-department.m-department');
    }

    public function masterDepartmentList()
    {
        return view('pages.ga.data-master.m-department.list');
    }

    public function masterDepartmentForm()
    {
        $dataDepartment = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-department.m-department-form', compact('dataDepartment'));
    }

    public function masterDepartmentEdit()
    {
        return view('pages.ga.data-master.m-department.m-department-edit');
    }

    public function masterDepartmentDeletePage()
    {
        return view('pages.ga.data-master.m-department.m-department-delete');
    }

    public function masterDepartmentCreate(Request $request)
    {
        $deptName = $request->input('department');
        $dataDept = DB::table('m_department')->select('name')->where('name', $deptName)->first();
        if ($dataDept == null) {
            DB::table('m_department')->insert([
                'name' => $request->input('department'),
                'status' => 'Active',
                'created_at'=> date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Department Has Been Created');
            return to_route('m-department.form');
        } else {
            alert()->error('Error', 'Department Already Exist');
            return to_route('m-department.form');
        }
    }

    public function masterDepartmentGetData(Request $request)
    {
        $dataDepartment = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataDepartment)
            ->addColumn('action', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDepartment->id.'"
                                data-department = "' . $dataDepartment->name . '" 
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Department</div>
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

                        <a href = "/data-master/m-subdepartment/edit/'. $dataDepartment->id .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Sub Department Settings</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/data-master/m-subdepartment/'. $dataDepartment->id .'" class="btn btn-sm btn-update text-sm bg-sky-500 hover:bg-sky-600 text-white"
                        >View Sub Department</a>
                    </div>';
            })
            ->addColumn('action2', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataDepartment->id.'" data-name = "' . $dataDepartment->name . '"
                            >Delete
                        </button>

                        <a href = "/data-master/m-subdepartment/deletepage/'. $dataDepartment->id .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Sub Department Settings</a>
                    </div>';
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function masterDepartmentGetData1(Request $request)
    {
        $dataDepartment = DB::table('m_subdepartment')
        ->join('m_department', 'm_subdepartment.p_id_dept', 'm_department.id')
        ->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.p_id_dept', 'm_subdepartment.status', 'm_department.name as department')
        ->where('p_id_dept', '!=', '0')->where('m_subdepartment.status', '=', 'Active')
        ->orderBy('name', 'asc');

        if ($request->input('department1') != null) {
            $dataDepartment->where('m_subdepartment.p_id_dept', $request->department1);
        }

        if ($request->ajax()) {
            return DataTables::of($dataDepartment)
            ->make();
        }
    }

    public function masterDepartmentUpdate(Request $request, $deptId)
    {
        $deptName = $request->input('department1');
        $dataDept = DB::table('m_department')->select('name')->where('name', $deptName)->first();
        if ($dataDept == null) {
            DB::table('m_department')->where('id', $deptId)->update([
                'name' => $request->input('department1'),
                'updated_at'=> date('Y-m-d')
            ]);
            DB::table('m_subdepartment')->where('p_id_dept', $deptId)->update([
                'dept_name' => $request->input('department1'),
                'updated_at'=> date('Y-m-d')
            ]);
            DB::table('m_rab_item')->where('p_id_dept', $deptId)->update([
                'department' => $request->input('department1'),
                'last_updated_by' => Auth::user()->username,
                'last_updated_at'=> date('Y-m-d')
            ]);
            DB::table('inventory_assets')->where('id_dept', $deptId)->update([
                'category' => $request->input('department1')
            ]);
            DB::table('users')->where('department', $deptId)->update([
                'role_name' => $request->input('department1')
            ]);
    
            alert()->success('Success', 'Department Has Been Updated');
            return to_route('m-department.edit');
        } else {
            alert()->error('Error', 'Department Already Exist');
            return to_route('m-department.edit');
        }
    }

    public function masterDepartmentDelete($deptId)
    {
        try {
            $dataSubDepartment = DB::table('m_department')->leftJoin('m_subdepartment', 'm_department.id', 'm_subdepartment.p_id_dept')
            ->select('m_department.id', 'm_subdepartment.p_id_dept', 'm_subdepartment.status')
            ->where('m_subdepartment.p_id_dept', $deptId)->where('m_subdepartment.status', '=', 'Active')->count();
            if ($dataSubDepartment == '0') {
                DB::table('m_department')->where('id', $deptId)->update([
                    'status' => 'Non Active',
                    'updated_at' => date('Y-m-d')
                ]);
                return response()->json([
                    'status' => 1,
                    'message' => "successfully deleted Department",
                ]);
            }else {
                return response()->json([
                    'status' => 0,
                    'message' => "there are sub department still active",
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterSubDepartment($deptId)
    {
        $dataDepartment = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->get();
        $dataDepartment1 = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->first();
        return view('pages.ga.data-master.m-subdepartment.m-subdepartment', compact('dataDepartment', 'dataDepartment1'));
    }

    public function masterSubDepartmentEdit($deptId)
    {
        $dataDepartment = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->get();
        $dataDepartment1 = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->first();
        return view('pages.ga.data-master.m-subdepartment.m-subdepartment-edit', compact('dataDepartment', 'dataDepartment1'));
    }

    public function masterSubDepartmentDeletePage($deptId)
    {
        $dataDepartment = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->get();
        $dataDepartment1 = DB::table('m_department')->select('id', 'name')->where('id', $deptId)->first();
        return view('pages.ga.data-master.m-subdepartment.m-subdepartment-delete', compact('dataDepartment', 'dataDepartment1'));
    }

    public function masterSubDepartmentCreate(Request $request)
    {
        $deptName = $request->input('department1');
        $deptName1 = DB::table('m_department')->where('id', $deptName)->pluck('name')->first();
        $subDeptName = $request->input('subdepartment');
        $dataSubDept = DB::table('m_subdepartment')->select('name')->where('name', $subDeptName)->where('p_id_dept', $deptName)->first();
        if ($dataSubDept == null) {
            DB::table('m_subdepartment')->insert([
                'p_id_dept' => $request->input('department1'),
                'name' => $request->input('subdepartment'),
                'dept_name' => $deptName1,
                'status' => 'Active',
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Sub Department Has Been Created');
            return to_route('m-department.form');
        } else {
            alert()->error('Error', 'Sub Department Already Exist');
            return to_route('m-department.form');
        }
    }

    public function masterSubDepartmentGetData(Request $request, $deptId)
    {
        $dataSubDepartment = DB::table('m_subdepartment')
        ->join('m_department', 'm_subdepartment.p_id_dept', 'm_department.id')
        ->select('m_subdepartment.id', 'm_subdepartment.name', 'm_subdepartment.p_id_dept', 'm_subdepartment.status', 'm_department.name as department')
        ->where('p_id_dept', $deptId)->where('m_subdepartment.status', '=', 'Active')
        ->orderBy('name', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataSubDepartment)
            ->addColumn('action', function ($dataSubDepartment) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataSubDepartment->id.'"
                                data-subdepartment = "' . $dataSubDepartment->name . '" data-department = "' . $dataSubDepartment->department . '"
                                data-id_dept = "' . $dataSubDepartment->p_id_dept . '" 
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Sub Department</div>
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
            ->addColumn('action1', function ($dataSubDepartment) {
                return '
                <div class="flex flex-row">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataSubDepartment->id.'" data-name = "' . $dataSubDepartment->name . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function masterSubDepartmentUpdate(Request $request, $subId)
    {
        $deptName = $request->input('department1');
        $subDeptName = $request->input('subdepartment1');
        $dataSubDept = DB::table('m_subdepartment')->select('name')->where('name', $subDeptName)->where('p_id_dept', $deptName)->first();
        if ($dataSubDept == null) {
            DB::table('m_subdepartment')->where('id', $subId)->update([
                'p_id_dept' => $request->input('department1'),
                'name' => $request->input('subdepartment1'),
                'updated_at' => date('Y-m-d')
            ]);
            DB::table('m_rab_item')->where('p_id_sub_dept', $subId)->update([
                'sub_department' => $request->input('subdepartment1'),
                'last_updated_by' => Auth::user()->username,
                'last_updated_at' => date('Y-m-d')
            ]);
            DB::table('inventory_assets')->where('id_sub_dept', $subId)->update([
                'sub_category' => $request->input('subdepartment1')
            ]);
            alert()->success('Success', 'Sub Department Has Been Updated');
            return to_route('m-subdepartment.edit', $deptName);
        } else {
            alert()->error('Error', 'Department Already Exist');
            return to_route('m-subdepartment.edit', $deptName);
        }
    }

    public function masterSubDepartmentDelete($subId)
    {
        try {
            DB::table('m_subdepartment')->where('id', $subId)->update([
                'status' => 'Non Active',
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Sub Department",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function masterSite()
    {
        return view('pages.ga.data-master.m-site-warehouse.m-site');
    }

    public function masterSiteList()
    {
        return view('pages.ga.data-master.m-site-warehouse.list');
    }

    public function masterSiteForm()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-site-warehouse.m-site-form', compact('dataCountry', 'dataChildCompany'));
    }

    public function masterSiteEdit()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name')->get();
        return view('pages.ga.data-master.m-site-warehouse.m-site-edit', compact('dataCountry', 'dataChildCompany'));
    }

    public function masterSiteDeletePage()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name')->get();
        return view('pages.ga.data-master.m-site-warehouse.m-site-delete', compact('dataCountry', 'dataChildCompany'));
    }

    public function masterSiteGetData(Request $request)
    {
        $dataSite = DB::table('m_site_warehouse')->leftJoin('m_child_company', 'm_site_warehouse.id_company', 'm_child_company.id_company')
        ->select('m_site_warehouse.id_warehouse', 'm_site_warehouse.w_name', 'm_site_warehouse.w_address', 'm_site_warehouse.w_city', 'm_site_warehouse.w_province', 'm_site_warehouse.w_zipcode', 'm_site_warehouse.w_pic',
        'm_site_warehouse.w_country', 'm_site_warehouse.w_phone', 'm_site_warehouse.status', 'm_child_company.name', 'm_child_company.id_company')->where('m_site_warehouse.status', '=', 'ACTIVE')
        ->orderBy('m_site_warehouse.w_name', 'desc'); 

        if ($request->ajax()) {
            return DataTables::of($dataSite)
            ->addColumn('action', function ($dataSite) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataSite->id_warehouse.'"
                                data-name = "' . $dataSite->w_name . '" data-address = "' . $dataSite->w_address . '" data-city = "' . $dataSite->w_city . '" 
                                data-country = "' . $dataSite->w_country . '" data-phone = "' . $dataSite->w_phone . '" data-company = "' . $dataSite->id_company . '"
                                data-province = "' . $dataSite->w_province . '" data-zip_code = "' . $dataSite->w_zipcode . '" data-pic = "' . $dataSite->w_pic . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Data Site Warehouse</div>
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

            ->addColumn('action1', function ($dataSite) {
                return '
                <div class="flex flex-row">
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataSite->id_warehouse.'" data-name = "' . $dataSite->w_name . '"
                        >Delete
                    </button>
                </div>';
            })    
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function masterSiteCreate(Request $request)
    {
            DB::table('m_site_warehouse')->insert([
                'id_company' => $request->input('company'),
                'w_name' => $request->input('w_name'),
                'w_address' => $request->input('w_address'),
                'w_city' => $request->input('w_city'),
                'w_province' => $request->input('w_province'),
                'w_country' => $request->input('w_country'),
                'w_zipcode' => $request->input('w_zipcode'),
                'w_pic' => $request->input('w_pic'),
                'w_phone' => $request->input('w_phone'),
                'status' => 'ACTIVE',
                'created_by' => Auth::user()->username,
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data Site Warehouse Has Been Created');
            return to_route('m-site-warehouse.form');
    }

    public function masterSiteUpdate(Request $request, $siteId)
    {
        if ($request) {
            DB::table('m_site_warehouse')->where('id_warehouse', $siteId)->update([
                'w_name' => $request->input('w_name1'),
                'w_address' => $request->input('w_address1'),
                'w_address' => $request->input('w_address1'),
                'w_city' => $request->input('w_city1'),
                'w_province' => $request->input('w_province1'),
                'w_country' => $request->input('w_country1'),
                'w_zipcode' => $request->input('w_zipcode1'),
                'w_pic' => $request->input('w_pic1'),
                'w_phone' => $request->input('w_phone1'),
                'updated_by' => Auth::user()->username,
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Data Site Warehouse Has Been Updated');
            return to_route('m-site-warehouse.edit');
        } else {
            alert()->error('Error', 'error');
            return to_route('m-site-warehouse.edit');
        }
    }

    public function masterSiteDelete($siteId)
    {
        try {
            DB::table('m_site_warehouse')->where('id_warehouse', $siteId)->update([
                'status' => 'NON ACTIVE',
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data Site Warehouse",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function deliveryAddress()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name', 'status')->where('status', '=', 'Active')->get();
        return view('pages.ga.data-master.m-delivery-address.m-address', compact('dataCountry', 'dataChildCompany'));
    }

    public function deliveryAddressEdit()
    {
        $dataCountry = DB::table('m_country')->select('*')->get();
        $dataChildCompany = DB::table('m_child_company')->select('id_company', 'name')->get();
        return view('pages.ga.data-master.m-delivery-address.m-address-edit', compact('dataCountry', 'dataChildCompany'));
    }
    public function deliveryAddressGetData(Request $request)
    {
        $dataAddress = DB::table('m_delivery_address')->leftJoin('m_child_company', 'm_delivery_address.id_company', 'm_child_company.id_company')
        ->select('m_delivery_address.idrec', 'm_delivery_address.address', 'm_delivery_address.city', 'm_delivery_address.province',
        'm_delivery_address.country', 'm_delivery_address.zip_code', 'm_delivery_address.status', 'm_child_company.name', 'm_child_company.id_company')->where('m_delivery_address.status', '=', 'ACTIVE'); 

        if ($request->ajax()) {
            return DataTables::of($dataAddress)
            ->addColumn('action', function ($dataAddress) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataAddress->idrec.'"
                                data-name = "' . $dataAddress->name . '" data-address = "' . $dataAddress->address . '" data-city = "' . $dataAddress->city . '" 
                                data-country = "' . $dataAddress->country . '" data-company = "' . $dataAddress->id_company . '" data-province = "' . $dataAddress->province . '" data-zip_code = "' . $dataAddress->zip_code . '"
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
                                            <div class="font-semibold text-slate-800">Edit Data Delivery Address</div>
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
    
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataAddress->idrec.'"
                            >Delete
                        </button>
                    </div>';
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function deliveryAddressCreate1(Request $request)
    {
        if ($request) {
            DB::table('m_delivery_address')->insert([
                'id_company' => $request->input('company'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'country' => $request->input('country'),
                'zip_code' => $request->input('zip_code'),
                'status' => 'ACTIVE',
                'created_by' => Auth::user()->username,
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data Delivery Address Has Been Created');
            return to_route('delivery-address');
        } else {
            alert()->error('Error', 'Data Delivery Address Already Exist');
            return to_route('delivery-address');
        }
    }

    public function deliveryAddressCreate(Request $request)
    {
        if ($request) {
            DB::table('m_delivery_address')->insert([
                'id_company' => $request->input('company'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'country' => $request->input('country'),
                'zip_code' => $request->input('zip_code'),
                'status' => 'ACTIVE',
                'created_by' => Auth::user()->username,
                'created_at' => date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Data Delivery Address Has Been Created');
            return to_route('delivery-address.edit');
        } else {
            alert()->error('Error', 'Data Delivery Address Already Exist');
            return to_route('delivery-address.edit');
        }
    }

    public function deliveryAddressUpdate(Request $request, $idrec)
    {
        if ($request) {
            DB::table('m_delivery_address')->where('idrec', $idrec)->update([
                'id_company' => $request->input('company1'),
                'address' => $request->input('address1'),
                'city' => $request->input('city1'),
                'province' => $request->input('province1'),
                'country' => $request->input('country1'),
                'zip_code' => $request->input('zip_code1'),
                'updated_by' => Auth::user()->username,
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Data Delivery Address Has Been Updated');
            return to_route('delivery-address.edit');
        } else {
            alert()->error('Error', 'error');
            return to_route('delivery-address.edit');
        }
    }

    public function deliveryAddressDelete($idrec)
    {
        try {
            DB::table('m_delivery_address')->where('idrec', $idrec)->update([
                'status' => 'NON ACTIVE',
                'updated_by' => Auth::user()->username,
                'updated_at' => date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted data Site Warehouse",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function department1()
    {
        return view('pages.ga.data-master.m-department1.department1');
    }

    public function department1Form()
    {
        $dataDepartment = DB::table('m_division')->select('*')->where('status', '=', 'ACTIVE')->where('p_id_division', '=', '0')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-department1.department1-form', compact('dataDepartment'));
    }

    public function  department1Edit()
    {
        return view('pages.ga.data-master.m-department1.department1-edit');
    }

    public function  department1DeletePage()
    {
        return view('pages.ga.data-master.m-department1.department1-delete');
    }

    public function  department1Create(Request $request)
    {
        $deptName = $request->input('department');
        $dataDept = DB::table('m_division')->select('name')->where('name', $deptName)->first();
        if ($dataDept == null) {
            DB::table('m_division')->insert([
                'name' => $request->input('department'),
                'p_id_division' => '0',
                'status' => 'ACTIVE',
                'created_by'=> Auth::user()->username,
                'created_at'=> date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Department Has Been Created');
            return to_route('m-department1.form');
        } else {
            alert()->error('Error', 'Department Already Exist');
            return to_route('m-department1.form');
        }
    }

    public function  department1GetData(Request $request){
        $dataDepartment = DB::table('m_division')->select('*')->where('status', '=', 'ACTIVE')->where('p_id_division', '=', '0')->orderBy('name', 'asc');

        if ($request->ajax()) {
            return DataTables::of($dataDepartment)
            ->addColumn('action', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDepartment->idrec.'"
                                data-department = "' . $dataDepartment->name . '" 
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
                                            <div class="font-semibold text-slate-800">Edit Department</div>
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

                        <a href = "/data-master/m-division/edit/'. $dataDepartment->idrec .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Division Settings</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/data-master/m-division/'. $dataDepartment->idrec .'" class="btn btn-sm btn-update text-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                        >View Division</a>
                    </div>';
            })
            ->addColumn('action2', function ($dataDepartment) {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataDepartment->idrec.'"
                            >Delete
                        </button>

                        <a href = "/data-master/m-division/deletepage/'. $dataDepartment->idrec .'" class="btn btn-sm btn-update text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"
                        >Division Settings</a>
                    </div>';
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }
    
    public function  department1GetData1(Request $request)
    {
        $dataDepartment = DB::table('m_division as mc1')
        ->leftJoin('m_division as mc2', 'mc1.p_id_division', '=', 'mc2.idrec')
        ->select('mc1.idrec', 'mc1.name', 'mc1.p_id_division', 'mc2.name as name_brand', 'mc1.p_id_division as brand_id', 'mc1.status')
        ->where('mc1.p_id_division', '!=', '0')->where('mc1.status', '=', 'ACTIVE')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($dataDepartment)
            ->make();
        }
    }

    public function  department1Update(Request $request, $deptId)
    {
        $deptName = $request->input('department1');
        $dataDept = DB::table('m_division')->select('name')->where('name', $deptName)->where('p_id_division', '=', '0')->first();
        if ($dataDept == null) {
            DB::table('m_division')->where('idrec', $deptId)->update([
                'name' => $request->input('department1'),
                'updated_by'=> Auth::user()->username,
                'updated_at'=> date('Y-m-d')
            ]);
            DB::table('m_division')->where('p_id_division', $deptId)->update([
                'dept_name' => $request->input('department1'),
                'updated_by'=> Auth::user()->username,
                'updated_at'=> date('Y-m-d')
            ]);
    
            alert()->success('Success', 'Department Has Been Updated');
            return to_route('m-department1.edit');
        } else {
            alert()->error('Error', 'Department Already Exist');
            return to_route('m-department1.edit');
        }
    }

    public function department1Delete($deptId)
    {
        try {
            $dataDepartment = DB::table('m_division')->where('p_id_division', $deptId)->where('status', '=', 'ACTIVE')->count();
            if ($dataDepartment == '0') {
                DB::table('m_division')->where('idrec', $deptId)->update([
                    'status' => 'NON ACTIVE',
                    'updated_by' => Auth::user()->username,
                    'updated_at'=> date('Y-m-d')
                ]);
                
                return response()->json([
                    'status' => 1,
                    'message' => "successfully deleted Brand",
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "there are division still active",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function division($deptId)
    {
        $dataDepartment = DB::table('m_division')->select('*')->where('idrec', $deptId)->get();
        $dataDepartment1 = DB::table('m_division')->select('*')->where('idrec', $deptId)->first();
        return view('pages.ga.data-master.m-division.division', compact('dataDepartment', 'dataDepartment1'));
    }

    public function divisionEdit($deptId)
    {
        $dataDepartment = DB::table('m_division')->select('*')->where('idrec', $deptId)->get();
        $dataDepartment1 = DB::table('m_division')->select('*')->where('idrec', $deptId)->first();
        return view('pages.ga.data-master.m-division.division-edit', compact('dataDepartment', 'dataDepartment1'));
    }

    public function divisionDeletePage($deptId)
    {
        $dataDepartment = DB::table('m_division')->select('*')->where('idrec', $deptId)->get();
        $dataDepartment1 = DB::table('m_division')->select('*')->where('idrec', $deptId)->first();
        return view('pages.ga.data-master.m-division.division-delete', compact('dataDepartment', 'dataDepartment1'));
    }

    public function divisionCreate(Request $request)
    {
        $deptName = $request->input('department1');
        $deptName1 = DB::table('m_division')->where('idrec', $deptName)->pluck('name')->first();
        $division = $request->input('division');
        $dataDivision = DB::table('m_division')->select('name', 'p_id_division')->where('name', $division)->where('p_id_division', $deptName)->first();
        if ($dataDivision == null) {
            DB::table('m_division')->insert([
                'name' => $request->input('division'),
                'p_id_division' => $request->input('department1'),
                'dept_name' => $deptName1,
                'status'=> 'ACTIVE',
                'created_at'=> date('Y-m-d')
            ]);
    
            alert()->success('Success', 'New Division Has Been Created');
            return to_route('m-department1.form');
        } else {
            alert()->error('Error', 'Division Already Exist');
            return to_route('m-department1.form');
        }
    }

    public function divisionGetData(Request $request, $divId)
    {
        $dataDept = DB::table('m_division as mc1')
        ->leftJoin('m_division as mc2', 'mc1.p_id_division', '=', 'mc2.idrec')
        ->select('mc1.idrec', 'mc1.name', 'mc1.p_id_division', 'mc2.name as name_brand', 'mc1.p_id_division as brand_id', 'mc1.status')
        ->where('mc1.p_id_division', $divId)->where('mc1.status', '=', 'ACTIVE')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($dataDept)
            ->addColumn('action', function ($dataDept) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-indigo-500 hover:bg-indigo-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataDept->idrec.'"
                                data-name = "' . $dataDept->name . '" data-id_brand = "' . $dataDept->p_id_division . '" 
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
                                            <div class="font-semibold text-slate-800">Edit Model</div>
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
            ->addColumn('action1', function ($dataDept) {
                    return '
                    <div class="flex flex-row justify-center"> 
                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataDept->idrec.'"
                            >Delete
                        </button>
                    </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function divisionUpdate(Request $request, $divId)
    {
        $deptName = $request->input('division1');
        $deptId = $request->input('brand1');
        $dataDivision = DB::table('m_division')->select('name', 'p_id_division')->where('name', $deptName)->where('p_id_division', $deptId)->first();
        if ($dataDivision == null) {
            DB::table('m_division')->where('idrec', $divId)->update([
                'name' => $request->input('division1'),
                'p_id_division' => $request->input('brand1'),
                'updated_by' => Auth::user()->username,
                'updated_at'=> date('Y-m-d')
            ]);

            alert()->success('Success', 'Division Has Been Updated');
            return to_route('m-division.edit', $deptId);
        } else {
            alert()->error('Error', 'Division Already Exist');
            return to_route('m-division.edit', $deptId);
        }
    }

    public function divisionDelete($subId)
    {
        try {
            DB::table('m_division')->where('idrec', $subId)->update([
                'status' => 'NON ACTIVE',
                'updated_by' => Auth::user()->username,
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Division",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function fixedAssetForm()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }

        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        return view('pages.ga.fixedasset.form', compact('dataChildCompany', 'dataCurrency'));
    }

    public function fixedAssetList()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.fixedasset.index', compact('dataChildCompany'));
    }

    public function editGenerateFA()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.fixedasset.editgenerate', compact('dataChildCompany'));
    }

    public function editGenerateFA2()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.fixedasset.generate', compact('dataChildCompany'));
    }

    public function invFixAsset(Request $request)
    {
        $dataAssetQuery = DB::table('inventory_assets')
        ->leftJoin('t_rab_detail', 'inventory_assets.id_rab_item', 't_rab_detail.idrec')
        // ->leftJoin('inventory_assets_preferred_vendor', 'inventory_assets.idassets', 'inventory_assets_preferred_vendor.idassets')
        // ->leftJoin('m_vendors', 'inventory_assets_preferred_vendor.idsupplier', 'm_vendors.idsupplier')
        ->select('inventory_assets.idassets', 'inventory_assets.name', 'inventory_assets.type', 'inventory_assets.unit', 'inventory_assets.category' , 'inventory_assets.aktifyn', 'inventory_assets.id_rab_item',
        't_rab_detail.total', 't_rab_detail.id_rab', 't_rab_detail.status', 't_rab_detail.date_rab')
        ->where('inventory_assets.aktifyn', '=', 'Y');

        $dataAsset = $dataAssetQuery->orderBy('inventory_assets.idassets', 'asc');
        // ->where('inventory_assets.type', '=', 'Fixed Asset')
        
        if ($request->ajax()) {
            return DataTables::of($dataAsset)
                ->addColumn('action', function ($dataAsset) {
                    return '<button
                    type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idassets . '"
                    data-nama="' . $dataAsset->name . '" data-budget="' . $dataAsset->total . '" data-unit="' . $dataAsset->unit . '" data-rab="' . $dataAsset->id_rab . '" id="select"  @click="selectAsset(idAsset, nameAsset)"
                >Select</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function fixedAssetCreate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('purchdate');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/N-FA/';
        $indicator1 = $yearNowSubstring . $mm . '/' . $initials . '/SNFA/';
        // $indicator2 = $yearNowSubstring . $mm . '/' . $initials . '/FA/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_new_fixed_asset')
            ->where('no_form', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();
        $maxIdRecord1 = DB::table('t_new_fixed_asset_detail')
            ->where('idnfa', 'like', $indicator1 . '%')
            ->orderBy('idrec', 'desc')
            ->first();
        // $maxIdRecord2 = DB::table('t_fixed_asset')
        //     ->where('idfa', 'like', $indicator2 . '%')
        //     ->orderBy('idrec', 'desc')
        //     ->first();

        if (is_null($maxIdRecord)) {
            $idnfa = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->no_form;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $idnfa = $indicator . $countIndicator;
        }

        $countIndicator1 = 1;
        if (!is_null($maxIdRecord1)) {
            $maxId1 = $maxIdRecord1->idnfa;
            $lastRunningNumber1 = intval(substr($maxId1, strrpos($maxId1, '/') + 1));
        
            // Check if the month has changed
            if (date('m', strtotime($dateInput)) == $mm) {
                // If the month hasn't changed, set the count to the next number after the last running number
                $countIndicator1 = $lastRunningNumber1 + 1;
            }
        }
        // if (is_null($maxIdRecord1)) {
        //     $idnfa1 = $indicator1 . '1';
        //     $countIndicator1 = 1;
        // } else {
        //     $maxId1 = $maxIdRecord1->idnfa;
        //     $lastRunningNumber1 = intval(substr($maxId1, strrpos($maxId1, '/') + 1));
        
        //     // Periksa apakah bulan telah berubah
        //     if (date('m', strtotime($dateInput)) != $mm) {
        //         // Jika bulan berubah, reset nomor berjalan ke 1
        //         $countIndicator1 = 1;
        //         $mm = date('m', strtotime($dateInput));
        //     } else {
        //         // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
        //         $countIndicator1 = $lastRunningNumber1 + 1;
        //     }
        
        //     $idnfa1 = $indicator1 . $countIndicator1;
        // }
        
        // if (is_null($maxIdRecord2) || date('m', strtotime($dateInput)) != $mm) {
        //     // Reset the counter if the month changes
        //     $idnfa2 = $indicator2 . '1';
        //     $countIndicator2 = 1;
        // } else {
        //     $maxId2 = $maxIdRecord2->idfa;
        //     $lastRunningNumber2 = intval(substr($maxId2, strrpos($maxId2, '/') + 1));
        
        //     // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
        //     $countIndicator2 = $lastRunningNumber2 + 1;
        // }

        $purchdate = $request->input('date');
        $rowsProducts = $request->get('rows');
        if ($request->hasFile('invoice_pdf')) {
            $filePdf = $request->file('invoice_pdf');    
            $invoice_pdf = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
           $invoice_pdf = null;
        }
        try {
                if ($dateInput <= $purchdate) {
                    if (!empty($rowsProducts)) {
                           DB::transaction(function () use ($request, $rowsProducts, $invoice_pdf, $idnfa, $indicator1, $countIndicator1){
                                DB::table('t_new_fixed_asset')->insert([
                                    'no_form' => $idnfa,
                                    'generate' => 'N',
                                    'form_date' => $request->input('date'),
                                    'id_company' => $request->input('company'),
                                    'id_warehouse' => $request->input('wid'),
                                    'purchdate' => $request->input('purchdate'),
                                    'currency' => $request->input('currency'),
                                    'qty' => $request->input('qtyTotal'),
                                    'gtotal' => $request->input('grandtotal1'),
                                    'invoice_number' => $request->input('invoice_number'),
                                    'invoice_pdf' => $invoice_pdf,
                                    'created_by' => Auth::user()->username,
                                    'created_at' => date('Y-m-d')
                                ]);
        
                                foreach ($rowsProducts as $key) {
                                    $idnfa1 = $indicator1 . $countIndicator1;
                                    DB::table('t_new_fixed_asset_detail')->insert([
                                        'no_form' => $idnfa,
                                        'idnfa' => $idnfa1,
                                        'idassets' => $key['ids'],
                                        'qty' => $key['oqs'],
                                        'price' => $key['prices'],
                                        'total' => $key['totals'],
                                        'detail' => $key['descs'],
                                        'created_by' => Auth::user()->username,
                                        'created_at' => date('Y-m-d')
                                    ]);
                                    $countIndicator1++;
                            
                                    // $qty = $key['oqs'];
                            
                                    // for ($i = 1; $i <= $qty; $i++) {
                                    //     // Adjust the logic for idfa to ensure continuity
                                    //     $currentFA = $indicator1 . ($countIndicator2 + $i - 1);
                            
                                    //     DB::table('t_fixed_asset')->insert([
                                    //         'idfa' => $currentFA,
                                    //         'no_form' => $idnfa,
                                    //         'idnfa' => $idnfa1,
                                    //         'idassets' => $key['ids'],
                                    //         'qty' => 1,
                                    //         'detail' => $key['descs'],
                                    //         'available' => 'Y',
                                    //         'aktifyn' => 'Y',
                                    //         'print_status' => 'N',
                                    //         'kondisi' => 'Ready',
                                    //         'id_company' => $request->input('company'),
                                    //         'id_warehouse' => $request->input('wid'),
                                    //         'created_at' => date('Y-m-d'),
                                    //         'created_by' => Auth::user()->username
                                    //     ]);
                                    // }
                            
                                    // // Update the countIndicator2 for the next iteration
                                    // $countIndicator2 += $qty;
                                }
                            });
                        alert()->success('Success', 'New List Fixed Asset #'. $idnfa .' Has Been Created');
                        return to_route('fixedasset');
                    } else{
                        alert()->error('Error', 'List Inventory Must fill');
                        return to_route('fixedasset');
                    }
                } else if($dateInput > $purchdate){
                    alert()->error('Error', 'Purchase Date Cannot After Form Date');
                    return to_route('fixedasset');
                }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function getEmployee(Request $request)
    {   
        $dataEmployeeQuery = DB::table('m_employees')
        ->leftJoin('m_child_company', 'm_employees.id_company', 'm_child_company.id_company')
        ->select('m_employees.*','m_child_company.name as company',
            DB::raw("
                case
                    when m_employees.gender = 'M' then 'Male'
                    when m_employees.gender = 'F' then 'Female'
                    else 'unknown gender'
                end as gen
            "))->where('m_employees.status', '=', 'ACTIVE');

        if ($request->input('company12') != null) {
            $dataEmployee = $dataEmployeeQuery->where('m_employees.id_company', $request->company12);
        }
        if ($request->input('company') != null) {
            $dataEmployee = $dataEmployeeQuery->where('m_employees.id_company', $request->company);
        }

        $dataEmployee = $dataEmployeeQuery;

        if ($request->ajax()) {
            return DataTables::of($dataEmployee)
            ->editColumn('first_name', function ($dataEmployee) {
                return $dataEmployee->first_name . ' ' . $dataEmployee->last_name;
            })
            ->editColumn('DoB', function ($dataEmployee) {
                return date('d F Y', strtotime($dataEmployee->DoB));
            })
            ->addColumn('action', function ($dataEmployee) {
                return '<button
                type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataEmployee->idemployee . '"
                data-nama="' . $dataEmployee->first_name . ' ' . $dataEmployee->last_name . '" data-company="' . $dataEmployee->id_company . '" data-company_name="' . $dataEmployee->company . '" 
                data-department="' . $dataEmployee->department . '" data-position="' . $dataEmployee->position . '" data-bank_name="' . $dataEmployee->bank_name . '" data-bank_acc_num="' . $dataEmployee->bank_acc_num . '" 
                data-bank_acc_name="' . $dataEmployee->bank_acc_name . '" id="select"
            >Select</button>';
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function getAssets(Request $request)
    {   
        $dataAssetQuery= DB::table('t_fixed_asset')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->leftJoin('t_new_fixed_asset', 't_fixed_asset.no_form', 't_new_fixed_asset.no_form')
        ->select(
            't_fixed_asset.idrec',
            't_fixed_asset.idfa',
            't_fixed_asset.no_form',
            't_fixed_asset.idnfa',
            't_fixed_asset.idassets',
            't_fixed_asset.available',
            't_fixed_asset.qty',
            't_fixed_asset.detail',
            't_fixed_asset.id_company',
            't_fixed_asset.id_warehouse',
            't_fixed_asset.borrow_by',
            't_fixed_asset.borrow_date',
            't_fixed_asset.remarks',
            't_fixed_asset.return_date',
            't_fixed_asset.aktifyn',
            't_fixed_asset.kondisi',
            't_fixed_asset.print_status',
            't_fixed_asset.purchase_date',
            't_fixed_asset.m_id_code',
            't_new_fixed_asset.purchdate',
            'm_child_company.name as company',
            'm_site_warehouse.w_name as warehouse',
            'inventory_assets.name as assetName',
            'inventory_assets.category',
            'inventory_assets.sub_category',
            DB::raw("
                case
                    when t_fixed_asset.available = 'Y' then 'Ready'
                    when t_fixed_asset.available = 'N' then 'In Use/Assigned'
                    when t_fixed_asset.available = 'G' then 'Good'
                    when t_fixed_asset.available = 'R' then 'Need Reapair'
                    when t_fixed_asset.available = 'B' then 'Broken'
                    when t_fixed_asset.available = 'D' then 'Discard'
                    when t_fixed_asset.available = 'S' then 'Sold'
                    else 'unknown status'
                end as avail
            ")
        )->where('t_fixed_asset.aktifyn', '=', 'Y');

        if ($request->input('status1234') != null) {
            $dataAsset = $dataAssetQuery->where('t_fixed_asset.kondisi', $request->status1234);
        }
        if ($request->input('status123') != null) {
            $dataAsset = $dataAssetQuery->where('t_fixed_asset.available', $request->status123);
        }
        if ($request->input('company123') != null) {
            $dataAsset = $dataAssetQuery->where('t_fixed_asset.id_company', $request->company123);
        }

        $dataAsset = $dataAssetQuery;

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->editColumn('purchdate', function ($dataAsset) {
                return date('Y-m-d', strtotime($dataAsset->purchdate));
            })
            ->addColumn('label', function ($dataAsset) {

                $status = ($dataAsset->kondisi);
                $color = "color";

                if ($status == 'Sold') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'In Use/Assigned') {
                    $color = "green";
                } else if ($status == 'Need Repair') {
                    $color = "yellow";
                } else if ($status == 'Broken') {
                    $color = "red";
                } else if ($status == 'Ready') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Discard') {
                    $color = "black";
                } else if ($status == 'Good') {
                    $color = "rgb(236 72 153);";
                } 
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->editColumn('qty', function ($dataAsset) {
                return "" . "" . number_format($dataAsset->qty, 0, '.', '.');
            })
            ->addColumn('action', function ($dataAsset) use ($request) {
                if ($request->input('status123') == '') {
                    if ($dataAsset->available == 'Y') {
                        return '<button
                            type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idfa . '"
                            data-nama="' . $dataAsset->assetName . '" data-assets="' . $dataAsset->idassets . '" data-company="' . $dataAsset->company . '" data-warehouse="' . $dataAsset->warehouse . '" id="select"
                        >Select</button>';
                    } else {

                    }
                }else if ($request->input('status123') == 'Y'){
                    return '<button
                        type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idfa . '"
                        data-nama="' . $dataAsset->assetName . '" data-assets="' . $dataAsset->idassets . '" data-company="' . $dataAsset->company . '" data-warehouse="' . $dataAsset->warehouse . '" id="select"
                    >Select</button>';
                }else if ($request->input('status123') == 'N'){
                    return '<button
                        type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataAsset->idfa . '"
                        data-nama="' . $dataAsset->assetName . '" data-assets="' . $dataAsset->idassets . '" data-company="' . $dataAsset->company . '" data-warehouse="' . $dataAsset->warehouse . '" id="select"
                    >Select</button>';
                }
            })
            ->addColumn('action1', function ($dataAsset) {
                return '<button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                data-id="'.$dataAsset->idfa.'"
            >Delete</button>';
            })
            ->addColumn('action2', function ($dataAsset) use ($request) {
                if ($dataAsset->print_status == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/qrcode/' . $dataAsset->idrec . '" target="_blank" class="btn btn-xs btn-modal text-xs text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print QR Code</a>
                    </div>';
                } else if ($dataAsset->print_status == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/qrcode/' . $dataAsset->idrec . '" target="_blank" class="btn btn-xs btn-modal text-xs text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print QR Code</a>
                    </div>';               
                }else if (Auth::user()->role == '100' && $dataAsset->print_status == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/qrcode/' . $dataAsset->idrec . '" target="_blank" class="btn btn-xs btn-modal text-xs text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print QR Code</a>
                    </div>';               
                }
            })
            ->rawColumns(['action', 'action1', 'action2', 'label'])
            ->make();
        }
        // <a href = "/ga/fixedasset/barcode/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
        //                 >Print Barcode</a>
    }

    public function assetsUpdatePage (Request $request, $idForm)
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $dataForm = DB::table('t_new_fixed_asset')
        ->leftJoin('m_child_company', 't_new_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_new_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_new_fixed_asset.*',
            'm_child_company.name as company',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_name'
        )->where('t_new_fixed_asset.idrec', $idForm)->first();

        $idFormFA = $dataForm->no_form;

        $dataFormDetail = DB::table('t_new_fixed_asset_detail')
        ->leftJoin('inventory_assets', 't_new_fixed_asset_detail.idassets', 'inventory_assets.idassets')
        ->select('t_new_fixed_asset_detail.idrec', 't_new_fixed_asset_detail.created_at', 't_new_fixed_asset_detail.created_by', 't_new_fixed_asset_detail.no_form', 't_new_fixed_asset_detail.idnfa', 't_new_fixed_asset_detail.idassets', 't_new_fixed_asset_detail.qty', 't_new_fixed_asset_detail.price', 't_new_fixed_asset_detail.total', 't_new_fixed_asset_detail.detail', 'inventory_assets.name as assetName')
        ->where('t_new_fixed_asset_detail.no_form', $idFormFA)->orderBy('t_new_fixed_asset_detail.idrec', 'asc')->get();

        return view('pages.ga.fixedasset.editgeneratepage', compact('dataForm', 'dataFormDetail', 'dataCurrency'));
    }

    public function assetsGeneratePage (Request $request, $idForm)
    {
        $dataForm = DB::table('t_new_fixed_asset')
        ->leftJoin('m_child_company', 't_new_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_new_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_new_fixed_asset.*',
            'm_child_company.name as company',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_name'
        )->where('t_new_fixed_asset.idrec', $idForm)->first();

        $idFormFA = $dataForm->no_form;

        $dataFormDetail = DB::table('t_new_fixed_asset_detail')
        ->leftJoin('inventory_assets', 't_new_fixed_asset_detail.idassets', 'inventory_assets.idassets')
        ->select('t_new_fixed_asset_detail.idrec', 't_new_fixed_asset_detail.no_form', 't_new_fixed_asset_detail.idnfa', 't_new_fixed_asset_detail.idassets', 't_new_fixed_asset_detail.qty', 't_new_fixed_asset_detail.price', 't_new_fixed_asset_detail.total', 't_new_fixed_asset_detail.detail', 'inventory_assets.name as assetName')
        ->where('t_new_fixed_asset_detail.no_form', $idFormFA)->orderBy('t_new_fixed_asset_detail.idrec', 'asc')->get();

        return view('pages.ga.fixedasset.generatepages', compact('dataForm', 'dataFormDetail'));
    }

    public function assetsUpdate (Request $request, $idrec)
    {
        $dataNFA = DB::table('t_new_fixed_asset')->where('idrec', $idrec)->first();
        if ($request->hasFile('invoice_pdf')) {
            $filePdf = $request->file('invoice_pdf');    
            $invoice_pdf = $filePdf->openFile()->fread($filePdf->getSize());
           } else {
               $invoice_pdf = null;
           }
        $iden = $request->input('iden');
        try {
            if ($dataNFA->generate == 'N') {
                DB::transaction(function () use ($request, $idrec, $iden, $invoice_pdf, $dataNFA){
                    DB::table('t_new_fixed_asset')->where('idrec', $idrec)->update([
                        'id_warehouse' => $request->input('wid'),
                        'currency' => $request->input('currency'),
                        'qty' => $request->input('qtyTotal'),
                        'gtotal' => $request->input('grandtotal1'),
                        'invoice_number' => $request->input('invoice_number'),
                        'invoice_pdf' => $invoice_pdf,
                        'updated_at' => date('y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                    DB::table('t_new_fixed_asset_detail')->where('no_form', $dataNFA->no_form)->delete();
                    foreach ($request->iden as $iden) {
                        DB::table('t_new_fixed_asset_detail')->insert([
                            'no_form' => $dataNFA->no_form,
                            'idnfa' => $request->input('idnfa_'.$iden),
                            'idassets' => $request->input('ids_'.$iden),
                            'qty' => $request->input('qty_'.$iden),
                            'price' => $request->input('price_'.$iden),
                            'total' => $request->input('total_'.$iden),
                            'detail' => $request->input('details_'.$iden),
                            'created_at' => $request->input('cretedat_'.$iden),
                            'created_by' => $request->input('createdby_'.$iden),
                            'updated_at' => date('Y-m-d'),
                            'updated_by' => Auth::user()->id
                        ]);
                    }
                });
                alert()->success('Success', 'M. Input Has Been Edited');
                return to_route('fixedasset.editgenerate');
            } else {
                alert()->error('Error', 'M. Input Already Generated');
                return to_route('fixedasset.editgenerate');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function assetsBarcode($idAsset)
    {
        $dataAsset = DB::table('t_fixed_asset')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->leftJoin('t_new_fixed_asset', 't_fixed_asset.no_form', 't_new_fixed_asset.no_form')
        ->select('t_fixed_asset.*', 'm_child_company.name as company', 'm_child_company.company_type', 'inventory_assets.name as assetss', 't_new_fixed_asset.purchdate')->where('t_fixed_asset.idrec', $idAsset)->first();

        return view('pages.ga.fixedasset.print-barcode', compact('dataAsset'));
    }

    public function assetsQrcode($idAsset)
    {
        $dataAsset = DB::table('t_fixed_asset')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->leftJoin('t_new_fixed_asset', 't_fixed_asset.no_form', 't_new_fixed_asset.no_form')
        ->select('t_fixed_asset.*', 'm_child_company.name as company', 'm_child_company.company_type', 'inventory_assets.name as assetss', 't_new_fixed_asset.purchdate')->where('t_fixed_asset.idrec', $idAsset)->first();

        return view('pages.ga.fixedasset.print-qr', compact('dataAsset'));
    }

    public function assetsDelete($idAsset)
    {
        try {
            DB::table('t_fixed_asset')->where('idfa', $idAsset)->update([
                'aktifyn' => 'N',
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->username
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Assets",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function assetsGenerate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dataNFA = DB::table('t_new_fixed_asset')->where('no_form', $request->input('no_form'))->first();
        $generateStatus = $dataNFA->generate;
        $purchase_date = $dataNFA->purchdate;
        $mm = date('m', strtotime($purchase_date));
        $yearNow = date('Y', strtotime($purchase_date));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator2 = $yearNowSubstring . $mm . '/' . $initials . '/FA/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord2 = DB::table('t_fixed_asset')
            ->where('idfa', 'like', $indicator2 . '%')
            ->orderBy('idrec', 'desc')
            ->first();
        
        if (is_null($maxIdRecord2) || date('m', strtotime($purchase_date)) != $mm) {
            // Reset the counter if the month changes
            $idnfa2 = $indicator2 . '1';
            $countIndicator2 = 1;
        } else {
            $maxId2 = $maxIdRecord2->idfa;
            $lastRunningNumber2 = intval(substr($maxId2, strrpos($maxId2, '/') + 1));
        
            // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
            $countIndicator2 = $lastRunningNumber2 + 1;
        }
        $iden = $request->input('iden');
        $no_form = $request->input('no_form');
        try {
            if ($generateStatus == 'N') {
                DB::transaction(function () use ($request, $no_form, $iden, $countIndicator2, $indicator2, $purchase_date){
                    DB::table('t_new_fixed_asset')->where('no_form', $no_form)->update([
                        'generate' => 'Y'
                    ]);
                    foreach ($request->iden as $iden) {
                        $idnfa = $request->input('idnfa_'.$iden);
                        $qty = DB::table('t_new_fixed_asset_detail')->where('idnfa', $idnfa)->pluck('qty')->first();
                
                        for ($i = 1; $i <= $qty; $i++) {
                            // Adjust the logic for idfa to ensure continuity
                            $currentFA = $indicator2 . ($countIndicator2 + $i - 1);
                
                            DB::table('t_fixed_asset')->insert([
                                'idfa' => $currentFA,
                                'no_form' => $request->input('no_form'),
                                'idnfa' => $idnfa,
                                'idassets' => $request->input('ids_'.$iden),
                                'available' => 'Y',
                                'aktifyn' => 'Y',
                                'print_status' => 'N',
                                'qty' => '1',
                                'price' => $request->input('price_'.$iden),
                                'tipe_aktiva' => $request->input('w_name'),
                                'detail' => $request->input('details_'.$iden),
                                'id_company' => $request->input('company'),
                                'id_warehouse' => $request->input('wid'),
                                'purchase_date' => $purchase_date,
                                'kondisi' => 'Good',
                                'created_at' => date('Y-m-d'),
                                'created_by' => Auth::user()->id
                            ]);
                        }
                        // Update the countIndicator2 for the next iteration
                        $countIndicator2 += $qty;
                    }
                });
                alert()->success('Success', 'SNFA Has Been Generated');
                // return to_route('fixedasset.list');
                return response()->json(["st" => '1']);
            } else{
                alert()->error('Error', 'SNFA Already Generated');
                return response()->json(["st" => '0']);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function listFormFa()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.fixedasset.list-form', compact('dataChildCompany'));
    }

    public function listFormFaOnly()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.fixedasset.form-list-only', compact('dataChildCompany'));
    }

    public function getDataForm(Request $request)
    {   
        $dataFormFAQuery= DB::table('t_new_fixed_asset')
        ->leftJoin('m_child_company', 't_new_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_new_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_new_fixed_asset.*',
            'm_child_company.name as company',
            'm_site_warehouse.w_address'
        );

        if ($request->input('company123') != null) {
            $dataFormFA = $dataFormFAQuery->where('t_new_fixed_asset.id_company', $request->company123);
        }

        $dataFormFA = $dataFormFAQuery;

        if ($request->ajax()) {
            return DataTables::of($dataFormFA)
            ->editColumn('gtotal', function ($dataFormFA) {
                return "" . "" . number_format($dataFormFA->gtotal, 0, '.', '.');
            })
            ->editColumn('qty', function ($dataFormFA) {
                return "" . "" . number_format($dataFormFA->qty, 0, '.', '.');
            })
            ->editColumn('form_date', function ($dataFormFA) {
                return date('Y-m-d', strtotime($dataFormFA->form_date));
            })
            ->editColumn('purchdate', function ($dataFormFA) {
                return date('Y-m-d', strtotime($dataFormFA->purchdate));
            })
            ->addColumn('action', function ($dataFormFA) {
                return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/viewpageform/' . $dataFormFA->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    </div>';
            })
            ->addColumn('action1', function ($dataFormFA) {
                if ($dataFormFA->generate == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/updatepage/' . $dataFormFA->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/viewpageform/' . $dataFormFA->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action2', function ($dataFormFA) {
                if ($dataFormFA->generate == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/generatepage/' . $dataFormFA->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/fixedasset/viewpageform/' . $dataFormFA->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'action1', 'action2', 'label'])
            ->make();
        }
    }

    public function viewFileAssets($idForm)
    {
        $data = DB::table('t_new_fixed_asset')->where('idrec', $idForm)->select('invoice_pdf', 'invoice_number')->first();
        $filename = $data->invoice_number . '';
        $file = $data->invoice_pdf;

        return Response::make($file, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->invoice_pdf),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function viewPageForm($idForm)
    {
        $dataForm = DB::table('t_new_fixed_asset')
        ->leftJoin('m_child_company', 't_new_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_new_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_new_fixed_asset.*',
            'm_child_company.name as company',
            'm_site_warehouse.w_address'
        )->where('t_new_fixed_asset.idrec', $idForm)->first();

        $idFormFA = $dataForm->no_form;

        $dataFormDetail = DB::table('t_new_fixed_asset_detail')
        ->leftJoin('inventory_assets', 't_new_fixed_asset_detail.idassets', 'inventory_assets.idassets')
        ->select('t_new_fixed_asset_detail.idrec', 't_new_fixed_asset_detail.no_form', 't_new_fixed_asset_detail.idnfa', 't_new_fixed_asset_detail.idassets', 't_new_fixed_asset_detail.qty', 't_new_fixed_asset_detail.price', 't_new_fixed_asset_detail.total', 't_new_fixed_asset_detail.detail', 'inventory_assets.name as assetName')
        ->where('t_new_fixed_asset_detail.no_form', $idFormFA)->get();

        $listFixedAsset = DB::table('t_fixed_asset')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_fixed_asset.idrec', 't_fixed_asset.idfa', 't_fixed_asset.no_form', 't_fixed_asset.idnfa', 't_fixed_asset.idassets', 't_fixed_asset.detail', 't_fixed_asset.available',
        'inventory_assets.name as assetName1', DB::raw("
            case
                when t_fixed_asset.available = 'Y' then 'Ready'
                when t_fixed_asset.available = 'N' then 'In Use/Assigned'
                when t_fixed_asset.available = 'G' then 'Good'
                when t_fixed_asset.available = 'R' then 'Need Reapair'
                when t_fixed_asset.available = 'B' then 'Broken'
                when t_fixed_asset.available = 'D' then 'Discard'
                when t_fixed_asset.available = 'S' then 'Sold'
                else 'unknown status'
            end as avail_name
        "))->where('t_fixed_asset.no_form', $idFormFA)->where('t_fixed_asset.aktifyn', '=', 'Y')->get();
        $groupedAssets = $listFixedAsset->groupBy('idassets');

        return view('pages.ga.fixedasset.view-form', compact('dataForm', 'dataFormDetail', 'listFixedAsset', 'groupedAssets'));
    }

    public function assignedList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.assigned-asset.list.assignedrequest', compact('dataChildCompany'));
    }

    public function assignedListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.assigned-asset.list.assigned-list-only', compact('dataChildCompany'));
    }

    public function assignedForm()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.assigned-asset.form', compact('dataChildCompany'));
    }

    public function getAssigned(Request $request)
    {   
        $dataAssetQuery= DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.id_company',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            'm_child_company.name as company',
            'm_employees.first_name as name'
        );

        if ($request->input('status123') != null) {
            $dataAsset = $dataAssetQuery->where('t_assigned_fa.approvalstat', $request->status123);
        }
        if ($request->input('typeRequest') != null) {
            $dataAsset = $dataAssetQuery->where('t_assigned_fa.type_assign', $request->typeRequest);
        }
        if ($request->input('company') != null) {
            $dataAsset = $dataAssetQuery->where('t_assigned_fa.id_company', $request->company);
        }

        $dataAsset = $dataAssetQuery;

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Requested') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Received') {
                    $color = "green";
                } else if ($status == 'Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAsset) {
                if ($dataAsset->approvalstat == 'Requested') {
                    return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>
    
                            <a href = "/ga/assigned-asset/list/updatepage/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1"    
                            >Edit</a>
    
                            <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                                data-id="'.$dataAsset->idrec.'"
                            >Cancel</button>
                        </div>';
                }else {
                    return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>
                        </div>';
                    }
                
            })
            ->addColumn('action1', function ($dataAsset) {
                return '
                <div class="flex flex-row justify-center">
                    <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>
                </div>';
            })
            ->rawColumns(['action', 'action1', 'label'])
            ->make();
        }
    }

    public function assignedUpdatePage($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.list.updatepage', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedView($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.file_condition',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.list.view', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedSubmit($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.file_condition',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.list.assigned-submit', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedSignature($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.list.signature', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedPrint($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            't_assigned_fa.prepared_by',
            't_assigned_fa.received_by',
            'm_employees.first_name as name',
            'm_child_company.name as company',
            'm_child_company.company_type',
            'm_child_company.address',
            'm_child_company.logo_blob',
            'm_child_company.logo_filename'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        $dataAssignedDetailCount = $dataAssignedDetail->count();

        return view('pages.ga.assigned-asset.list.print', compact('dataAssigned', 'dataAssignedDetail', 'dataAssignedDetailCount', 'dataChildCompany'));
    }

    public function assignedCreate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('date');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/A-FA/';
        $indicator1 = $yearNowSubstring . $mm . '/' . $initials . '/R-FA/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_assigned_fa')
            ->where('idassign', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();
        $maxIdRecord1 = DB::table('t_assigned_fa')
            ->where('idassign', 'like', $indicator1 . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if ($request->input('type') == 'Assign') {
            if (is_null($maxIdRecord)) {
                $idassign = $indicator . '1';
            } else {
                $maxId = $maxIdRecord->idassign;
                $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));
    
                // Periksa apakah bulan telah berubah
                if (date('m', strtotime($dateInput)) != $mm) {
                    // Jika bulan berubah, reset nomor berjalan ke 1
                    $countIndicator = 1;
                    $mm = date('m', strtotime($dateInput));
                } else {
                    // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    $countIndicator = $lastRunningNumber + 1;
                }
    
                $idassign = $indicator . $countIndicator;
            }
        } else if ($request->input('type') == 'Return'){
            if (is_null($maxIdRecord1)) {
                $idassign = $indicator1 . '1';
            } else {
                $maxId1 = $maxIdRecord1->idassign;
                $lastRunningNumber1 = intval(substr($maxId1, strrpos($maxId1, '/') + 1));
    
                // Periksa apakah bulan telah berubah
                if (date('m', strtotime($dateInput)) != $mm) {
                    // Jika bulan berubah, reset nomor berjalan ke 1
                    $countIndicator1 = 1;
                    $mm = date('m', strtotime($dateInput));
                } else {
                    // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    $countIndicator1 = $lastRunningNumber1 + 1;
                }
    
                $idassign = $indicator1 . $countIndicator1;
            }
        }

        $rowsProducts = $request->get('rows');

        try {
            if (!empty($rowsProducts)) {
                if ($request->input('type') == 'Assign') {
                    foreach ($rowsProducts as $key) {
                        $assetFixed = DB::table('t_fixed_asset')->where('idfa', $key['ids'])->pluck('available')->first();
                        if ($assetFixed != 'Y') {
                            alert()->error('Error', 'Asset with ID ' . $key['ids'] . ' is not available');
                            return redirect()->route('assigned-asset');
                        }
                    }
                }
                DB::transaction(function () use ($request, $rowsProducts, $idassign){
                    DB::table('t_assigned_fa')->insert([
                        'idassign' => $idassign,
                        'id_company' => $request->input('company'),
                        'type_assign' => $request->input('type'),
                        'borrow_date' => $request->input('date'),
                        'request_by' => $request->input('employee'),
                        'approvalstat' => 'Requested',
                        'approval1stat' => 'Requested',
                        'approval2stat' => 'Requested',
                        'created_by' => Auth::user()->username,
                        'created_at' => date('Y-m-d')
                    ]);
    
                    foreach ($rowsProducts as $key) {
                            DB::table('t_assigned_fa_detail')->insert([
                                'idassign' => $idassign,
                                'idfa' => $key['ids'],
                                'remarks' => $key['remarkss'],
                                'status' => 'Active',
                                'created_by' => Auth::user()->username,
                                'created_at' => date('Y-m-d')
                            ]);
                            
                            $idfa = $key['ids'];
                            DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $idfa)->update([
                                'available' => 'N',
                                'kondisi' => 'In Use/Assigned',
                                'remarks' => $key['remarkss'],
                                'borrow_by' => $request->input('employee'),
                                'borrow_date' => $request->input('date'),
                                'updated_by' => Auth::user()->username,
                                'updated_at' => date('Y-m-d')
                            ]);
                    }
                });
                alert()->success('Success', 'Your Assigned Request #'. $idassign .' Has Been Created');
                return to_route('assigned-asset.list');
            } else{
                alert()->error('Error', 'List Assigned Must fill');
                return to_route('assigned-asset.list');
            }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function assignedUpdate(Request $request, $idassign)
    {
        $dataAssigned = DB::table('t_assigned_fa')->select('t_assigned_fa.idrec', 't_assigned_fa.idassign', 't_assigned_fa.approvalstat')->where('t_assigned_fa.idrec', $idassign)->first();
        $assignedId = $dataAssigned->idassign;
        $approvalstat = $dataAssigned->approvalstat;
        $rowsProducts = $request->get('rows');
        $iden = $request->input('iden');
        try {
            if ($approvalstat == 'Requested') {
                if (!empty($iden)) {
                    DB::transaction(function () use ($request, $rowsProducts, $assignedId, $iden){
                        foreach ($request->iden as $iden) {
                            $productId = $request->input('ids_'.$iden);
                            if (!empty($request->input('remarks1_'.$iden))) {
                                DB::table('t_assigned_fa_detail')->where('idassign', $assignedId)->where('idfa', $productId)->update([
                                    'remarks' => $request->input('remarks1_'.$iden),
                                    'updated_by' => Auth::user()->username,
                                    'updated_at' => date('y-m-d')
                                ]);
                            }
                        }
                        if (!empty($rowsProducts)) {
                            if ($request->input('type') == 'Assign') {
                                foreach ($rowsProducts as $key) {
                                    $assetFixed = DB::table('t_fixed_asset')->where('idfa', $key['ids2'])->pluck('available')->first();
                                    if ($assetFixed != 'Y') {
                                        alert()->error('Error', 'Asset with ID ' . $key['ids2'] . ' is not available');
                                        return redirect()->route('assigned-asset');
                                    }
                                }
                            }
                            foreach ($rowsProducts as $key) {
                                DB::table('t_assigned_fa_detail')->insert([
                                    'idassign' => $assignedId,
                                    'idfa' => $key['ids2'],
                                    'remarks' => $key['remarkss'],
                                    'status' => 'Active',
                                    'created_by' => Auth::user()->username,
                                    'created_at' => date('Y-m-d')
                                ]);
                                $idfa = $key['ids2'];
                                DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $idfa)->update([
                                    'available' => 'N',
                                    'kondisi' => 'In Use/Assigned',
                                    'remarks' => $key['remarkss'],
                                    'borrow_by' => $request->input('employee'),
                                    'borrow_date' => date('Y-m-d'),
                                    'updated_by' => Auth::user()->username,
                                    'updated_at' => date('Y-m-d')
                                ]);
                            }
                        }
                    });
                    alert()->success('Success', 'Assigned Request Has Been Edited');
                    return to_route('assigned-asset.listonly');
                } else {
                    alert()->error('Error', 'Assigned List is empty');
                    return to_route('assigned-asset.listonly');
                }
            } else {
                alert()->error('Error', 'Request Already  Approved/Denied');
                return to_route('assigned-asset.listonly');
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            alert()->error('Error', 'Error Occurred');
            return to_route('assigned-asset.updatepage');
        }
    }

    public function deleteAssigned(Request $request, $idassign)
    {
        $idfa = DB::table('t_assigned_fa_detail')->where('idrec', $idassign)->pluck('idfa')->first();
        try {
            DB::table('t_assigned_fa_detail')->where('idrec', $idassign)->update([
                'status' => 'Non Active',
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->username
            ]);
            $idassigned = DB::table('t_assigned_fa_detail')->where('idrec', $idassign)->pluck('idassign')->first();
            $type = DB::table('t_assigned_fa')->where('idassign', $idassigned)->pluck('type_assign')->first();
            if ($type == 'Assign') {
                DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $idfa)->update([
                    'available' => 'Y',
                    'kondisi' => 'Ready',
                    'updated_by' => Auth::user()->username,
                    'updated_at' => date('Y-m-d')
                ]);
            } else {
                 # code...
            }
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

    public function assignedViewFile($idassign)
    {
        $data = DB::table('t_assigned_fa')->where('idrec', $idassign)->select('file', 'idassign')->first();
        $filename = $data->idassign . '';
        $file = $data->file;

        return Response::make($file, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function assignedViewCon($idassign)
    {
        $data = DB::table('t_assigned_fa')->where('idrec', $idassign)->select('file_condition', 'idassign')->first();
        $filename = $data->idassign . '';
        $file = $data->file_condition;

        return Response::make($file, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->file_condition),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }


    public function cancelAssigned($idassign)
    {
        try {
            $assignedType = DB::table('t_assigned_fa')->where('idrec', $idassign)->pluck('type_assign')->first();
            $type = $assignedType;
            $idassigned = DB::table('t_assigned_fa')->where('idrec', $idassign)->pluck('idassign')->first();
            $idassigned1 = DB::table('t_assigned_fa_detail')->select('idfa', 'idassign')->where('idassign', $idassigned)->get();
            $idassigned2 = $idassigned1->pluck('idfa');
            DB::table('t_assigned_fa')->where('idrec', $idassign)->update([
                'approvalstat' => 'Canceled',
                'approval1stat' => 'Canceled',
                'approval2stat' => 'Canceled'
            ]);
            if ($type == 'Assign') {
                foreach ($idassigned2 as $key) {
                    DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $key)->update([
                        'available' => 'Y',
                        'kondisi' => 'Ready',
                        'updated_by' => Auth::user()->username,
                        'updated_at' => date('Y-m-d')
                    ]);
                }
            } else {
                # code...
            }
            return response()->json([
                'status' => 1,
                'message' => "successfully Canceled Assigned Request",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function assignedSignatureupdate(Request $request, $idassign)
    {   
        try {
                if($request){
                    $idrec=DB::table('t_assigned_fa')->select('t_assigned_fa.idrec', 't_assigned_fa.idassign', 't_assigned_fa.approvalstat')->where('t_assigned_fa.idrec', $idassign)->first();
                    $id = $idrec->idrec; 
                    $approvalstat = $idrec->approvalstat; 
                    if ($approvalstat == 'Approved') {
                        DB::table('t_assigned_fa')->where('t_assigned_fa.idrec', $idassign)->update([
                            'prepared_by' => $request->input('prepared'),
                            'received_by' => $request->input('received'),
                            'updated_at' => date('Y-m-d'),
                            'updated_by' => Auth::user()->username,
                            'approvalstat' => 'Printed'
                        ]);
                        alert()->success('Success', 'Received has been Updated');    
                        return response()->json(["st" => '1', "id"=>$id]);
                    }
                }else{
                    return response()->json(["st" => '0']);
                }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function submitAssigned(Request $request, $idassign)
    {
        try {
            $assigned = DB::table('t_assigned_fa')->select('*')->where('idrec', $idassign)->first();
            $typeAssigned = $assigned->type_assign;
            $approvalstat = $assigned->approvalstat;
            if ($request->hasFile('file')) {
                $filePdf = $request->file('file');    
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
               } else {
                   $pdf = null;
               }

            if ($approvalstat == 'Printed') {
                if ($typeAssigned == 'Assign') {
                    DB::table('t_assigned_fa')->where('idrec', $idassign)->update([
                        'approvalstat' => 'Received',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'file' => $pdf
                    ]);
                    alert()->success('Success', 'Fixed Asset Has Been Received');
                    return to_route('assigned-asset.list');
                } else if ($typeAssigned == 'Return'){
                    DB::table('t_assigned_fa')->where('idrec', $idassign)->update([
                        'approvalstat' => 'Received',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'file' => $pdf
                    ]);
                    $iden = $request->input('iden');
                    foreach ($request->iden as $iden) {
                        $productId = $request->input('ids_'.$iden);
                        DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $productId)->update([
                            'available' => 'Y',
                            'kondisi' => 'Ready',
                            'updated_by' => Auth::user()->username,
                            'updated_at' => date('Y-m-d')
                        ]);
                    }
                    alert()->success('Success', 'Fixed Asset Has Been Received');
                    return to_route('assigned-asset.list');
                }
                
            } else {
                alert()->error('Error', 'Fixed Asset Already Received');
                return to_route('assigned-asset.list');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
    
    public function assignedApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.assigned-asset.index', compact('dataChildCompany'));
    }

    public function assignedGetApproval(Request $request)
    {   
        $dataAssetQuery= DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.id_company',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            'm_child_company.name as company',
            'm_employees.first_name as name'
        )->where(function ($query) {
            $query->where('t_assigned_fa.approvalstat', '=', 'Requested')->orwhere('t_assigned_fa.approvalstat', '=', 'Approved')
            ->orwhere('t_assigned_fa.approvalstat', '=', 'Printed')->orwhere('t_assigned_fa.approvalstat', '=', 'Received');
        });

        if ($request->input('status123') != null) {
            $dataAssetQuery = $dataAssetQuery->where('t_assigned_fa.approvalstat', $request->status123);
        }
        if ($request->input('typeRequest') != null) {
            $dataAssetQuery = $dataAssetQuery->where('t_assigned_fa.type_assign', $request->typeRequest);
        }
        if ($request->input('company') != null) {
            $dataAssetQuery = $dataAssetQuery->where('t_assigned_fa.id_company', $request->company);
        }

        $result = $dataAssetQuery->get();

        $dataAsset = $result;

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Requested') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Received') {
                    $color = "green";
                } else if ($status == 'Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAsset) {
                if ($dataAsset->type_assign == 'Assign') {
                    if ($dataAsset->approvalstat == 'Requested') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-approval/approve1/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                            >View Approval</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Approved') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>
    
                            <a href = "/ga/assigned-asset/list/signature/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                            >Print</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Printed') {
                        return '
                        <div class="flex flex-row justify-center">
                        <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
    
                        <a href = "/ga/assigned-asset/list/submitpage/' . $dataAsset->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Submit Received</a>
    
                        <a href = "/ga/assigned-asset/list/print/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Received' || $dataAsset->approvalstat == 'Denied' || $dataAsset->approvalstat == 'Canceled') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>
                        </div>';
                    }
                } else {
                    if ($dataAsset->approvalstat == 'Requested') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-approval/approve1/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                            >View Approval</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Approved') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>

                            <a href = "/ga/assigned-asset/list/signature/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                            >Print</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Received' || $dataAsset->approvalstat == 'Denied' || $dataAsset->approvalstat == 'Canceled') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                            >View</a>
                        </div>';
                    }elseif ($dataAsset->approvalstat == 'Printed') {
                        return '
                        <div class="flex flex-row justify-center">
                        <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
    
                        <a href = "/ga/assigned-asset/list/submitpage/' . $dataAsset->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Submit Return</a>
    
                        <a href = "/ga/assigned-asset/list/print/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >Print</a>
                        </div>';
                    }
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function assignedApprove1($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.approval1', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedUpdateStatus (Request $request, $idassign)
    {
        $status = $request->input('status');
        $assigned = DB::table('t_assigned_fa')->select('*')->where('idrec', $idassign)->first();
        $typeAssigned = $assigned->type_assign;
        $approvalstat = $assigned->approvalstat;
        if ($request->hasFile('file')) {
            $filePdf = $request->file('file');    
            $pdf = $filePdf->openFile()->fread($filePdf->getSize());
           } else {
               $pdf = null;
           }

        if ($approvalstat == 'Requested') {
            if ($typeAssigned == 'Assign') {
                if ($status == 'Approved') {
                    DB::table('t_assigned_fa')
                    ->where('idrec', $idassign)
                    ->update([
                        'approvalstat' => 'Approved',
                        'approval1stat' => 'Approved',
                        'assign_remark' => $request->input('remarks'),
                        'approved1date' => date('Y-m-d'),
                        'file_condition' => $pdf,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Assigned Request Has Been Approved');
                    return to_route('assigned-approvalga');
        
                } else if ($status == 'Denied') {
                    DB::table('t_assigned_fa')
                    ->where('idrec', $idassign)
                    ->update([
                        'approvalstat' => 'Denied',
                        'approval1stat' => 'Denied',
                        'assign_remark' => $request->input('remarks'),
                        'approved1date' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'approved1by' => Auth::user()->username
                    ]);
        
                    $iden = $request->input('iden');
                    foreach ($request->iden as $iden) {
                        $productId = $request->input('ids_'.$iden);
                        DB::table('t_fixed_asset')->where('t_fixed_asset.idfa', $productId)->update([
                            'available' => 'Y',
                            'kondisi' => 'Ready',
                            'updated_by' => Auth::user()->username,
                            'updated_at' => date('Y-m-d')
                        ]);
                    }
                    alert()->success('Success', 'Assigned Request Has Been Denied');
                    return to_route('assigned-approvalga');
                }
            }else if ($typeAssigned == 'Return'){
                if ($status == 'Approved') {
                    DB::table('t_assigned_fa')
                    ->where('idrec', $idassign)
                    ->update([
                        'approvalstat' => 'Approved',
                        'approval1stat' => 'Approved',
                        'assign_remark' => $request->input('assigned_remark'),
                        'return_remark' => $request->input('return_remark'),
                        'approved1date' => date('Y-m-d'),
                        'file_condition' => $pdf,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Return Request Has Been Approved');
                    return to_route('assigned-approvalga');
        
                } else if ($status == 'Denied') {
                    DB::table('t_assigned_fa')
                    ->where('idrec', $idassign)
                    ->update([
                        'approvalstat' => 'Denied',
                        'approval1stat' => 'Denied',
                        'assign_remark' => $request->input('remarks'),
                        'approved1date' => date('Y-m-d'),
                        'file_condition' => $pdf,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->username,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Return Request Has Been Denied');
                    return to_route('assigned-approvalga');
                }
            }
        } else {
            alert()->error('Error', 'Request Already Approved/Denied');
            return to_route('assigned-approvalga');
        }
    }

    public function assignedApproval2()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        return view('pages.ga.assigned-asset.index2', compact('dataChildCompany'));
    }

    public function assignedGetApproval2(Request $request)
    {   
        $dataAssetQuery= DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            'm_employees.first_name as name'
        )->whereRaw("t_assigned_fa.approvalstat = 'HQ 1 Approved' or t_assigned_fa.approvalstat = 'HQ 2 Approved' or t_assigned_fa.approvalstat = 'Printed'");

        if ($request->input('status123') != null) {
            $dataAsset = $dataAssetQuery->where('t_assigned_fa.approvalstat', $request->status123);
        }

        $dataAsset = $dataAssetQuery;

        if ($request->ajax()) {
            return DataTables::of($dataAsset)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Requested') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "yellow";
                } else if ($status == 'Received') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataAsset) {
                if ($dataAsset->approvalstat == 'HQ 1 Approved') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/assigned-approval2/approve2/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >View</a>
                    </div>';
                } else if($dataAsset->approvalstat == 'HQ 2 Approved'){
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >View</a>

                        <a href = "/ga/assigned-asset/list/signature/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1"    
                        >Print</a>
                    </div>';
                }else if($dataAsset->approvalstat == 'HQ 2 Denied'){
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >View</a>
                    </div>';
                }elseif ($dataAsset->approvalstat == 'Printed') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/ga/assigned-asset/list/view/' . $dataAsset->idrec . '" class="btn btn-sm btn-modal text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                    >View</a>

                    <a href = "/ga/assigned-asset/list/submitpage/' . $dataAsset->idrec . '" class="btn btn-sm text-sm bg-emerald-500 hover:bg-emerald-600 text-white ml-1"    
                    >Submit Received</a>

                    <a href = "/ga/assigned-asset/list/print/' . $dataAsset->idrec . '" target="_blank" class="btn btn-sm text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1"    
                    >Print</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function assignedApprove2($idassign)
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $dataAssigned = DB::table('t_assigned_fa')
        ->leftJoin('m_employees', 't_assigned_fa.request_by', 'm_employees.idemployee')
        ->leftJoin('m_child_company', 't_assigned_fa.id_company', 'm_child_company.id_company')
        ->select(
            't_assigned_fa.idrec',
            't_assigned_fa.idassign',
            't_assigned_fa.type_assign',
            't_assigned_fa.borrow_date',
            't_assigned_fa.request_by',
            't_assigned_fa.approvalstat',
            't_assigned_fa.approval1stat',
            't_assigned_fa.approval2stat',
            't_assigned_fa.approved1by',
            't_assigned_fa.approved2by',
            't_assigned_fa.approved1date',
            't_assigned_fa.approved2date',
            't_assigned_fa.assign_remark',
            't_assigned_fa.return_remark',
            't_assigned_fa.id_company',
            't_assigned_fa.file',
            't_assigned_fa.updated_at',
            't_assigned_fa.assign_remark',
            'm_employees.first_name as name',
            'm_child_company.name as company'
        )->where('t_assigned_fa.idrec', $idassign)->first();

        $idassigned = $dataAssigned->idassign;

        $dataAssignedDetail = DB::table('t_assigned_fa_detail')
        ->leftJoin('t_fixed_asset', 't_assigned_fa_detail.idfa', 't_fixed_asset.idfa')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->select('t_assigned_fa_detail.idrec', 't_assigned_fa_detail.idassign', 't_assigned_fa_detail.idfa', 't_assigned_fa_detail.remarks', 't_assigned_fa_detail.status', 't_assigned_fa_detail.created_at', 't_assigned_fa_detail.created_by', 't_assigned_fa_detail.updated_at', 't_assigned_fa_detail.updated_by',
        'm_child_company.name as company', 'm_site_warehouse.w_address', 'inventory_assets.name as assetName')
        ->where('t_assigned_fa_detail.idassign', $idassigned)->where('t_assigned_fa_detail.status', '=', 'Active')->get();

        return view('pages.ga.assigned-asset.approval2', compact('dataAssigned', 'dataAssignedDetail', 'dataChildCompany'));
    }

    public function assignedUpdateStatus2 (Request $request, $idassign)
    {
        $status = $request->input('status');

        $dataAssigned = DB::table('t_assigned_fa')->select('t_assigned_fa.idrec', 't_assigned_fa.idassign')->where('idrec', $idassign)->first();
        $assignedId = $dataAssigned->idassign;
        $dataFA = DB::table('t_assigned_fa_detail')->select('t_assigned_fa_detail.idfa', 't_assigned_fa_detail.idassign')->where('idassign', $assignedId)->first();
        $idfa = $dataFA->idfa;

        if ($status == 'Approved') {
            DB::table('t_assigned_fa')
            ->where('idrec', $idassign)
            ->update([
                'approvalstat' => 'HQ 2 Approved',
                'approval2stat' => 'HQ 2 Approved',
                'assign_remark' => $request->input('remarks'),
                'approved2date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->username,
                'approved2by' => Auth::user()->username
            ]);
                   
            alert()->success('Success', 'Assigned Request Has Been Approved');
            return to_route('assigned-approvalga2');

        } else if ($status == 'Denied') {
            DB::table('t_assigned_fa')
            ->where('idrec', $idassign)
            ->update([
                'approvalstat' => 'HQ 2 Denied',
                'approval2stat' => 'HQ 2 Denied',
                'assign_remark' => $request->input('remarks'),
                'approved2date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->username,
                'approved2by' => Auth::user()->username
            ]);
            alert()->success('Success', 'Assigned Request Has Been Denied');
            return to_route('assigned-approvalga2');
        }
    }

    public function costType()
    {
        return view('pages.ga.data-master.m-costcentertype.m-costtype');
    }
    public function costTypeList()
    {
        return view('pages.ga.data-master.m-costcentertype.list');
    }
    public function costTypeForm()
    {
        return view('pages.ga.data-master.m-costcentertype.m-costtype-form');
    }
    public function costTypeEdit()
    {
        return view('pages.ga.data-master.m-costcentertype.m-costtype-edit');
    }
    public function costTypeDelete()
    {
        return view('pages.ga.data-master.m-costcentertype.m-costtype-delete');
    }

    public function costTypeCreate(Request $request)
    {        
        $costType = $request->input('type');
        $dataCostType = DB::table('m_cost_center_type')->where('cost_type', $costType)->pluck('cost_type')->first();
        if ($dataCostType == null) {
            DB::table('m_cost_center_type')->insert([
                'cost_type' => $request->input('type'),
                'coa' => $request->input('coa'),
                'add_by' => Auth::user()->username,
                'status' => 'Active',
                'created_at' => date('Y-m-d'),
                'created_by' => Auth::user()->id
            ]);
    
            alert()->success('Success', 'Cost Center Type Has Been Created');
            return to_route('costcenter-type.form');
        } else {
            alert()->error('Error', 'Cost Center Type Already Exist');
            return to_route('costcenter-type.form');
        }
    }

    public function costTypeGetData(Request $request)
    {
        $dataType = DB::table('m_cost_center_type')
        ->select('*')->orderBy('id', 'desc')->where('status', '=', 'Active'); 

        if ($request->ajax()) {
            return DataTables::of($dataType)
            ->addColumn('action', function ($dataType) {
                    return '
                    <div class="flex flex-row">                
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataType->id.'"
                                data-type = "' . $dataType->cost_type . '" data-coa = "' . $dataType->coa . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Cost Center Type</div>
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
            ->addColumn('action1', function ($dataType) {
                return '
                <div class="flex flex-row"> 
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataType->id.'" data-type = "' . $dataType->cost_type . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function costTypeUpdate(Request $request, $id)
    {
        $costType = $request->input('type1');
        $dataCostType = DB::table('m_cost_center_type')->where('cost_type', $costType)->pluck('cost_type')->first();
        if ($dataCostType == null) {
            DB::table('m_cost_center_type')->where('id', $id)->update([
                'cost_type' => $request->input('type1'),
                'coa' => $request->input('coa1'),
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ]);

            alert()->success('Success', 'Cost Center Type Has Been Updated');
            return to_route('costcenter-type.edit');
        } else {
            alert()->error('Error', 'Cost Center Type Already Exist');
            return to_route('costcenter-type.edit');
        }
    }

    public function costDelete($id)
    {
        try {
            DB::table('m_cost_center_type')->where('id', $id)->update([
                'status' => 'Non Active',
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Cost Center Type",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function costcenter(Request $request)
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $dataType = DB::table('m_cost_center_type')
        ->select('*')->orderBy('cost_type', 'asc')->where('status', '=', 'Active')->get();

        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        }

        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        $invoiceNumber = DB::table('t_costcenter_detail')->select('invoice_number')->get();

        $dataVat = DB::table('m_vat')->orderBy('name_vat', 'asc')->get();

        $dataWht = DB::table('m_wht')->orderBy('name_wht', 'asc')->get();

        return view('pages.finance.costcenter-approval.list.form', compact('dataCurrency', 'dataType', 'dataChildCompany', 'bank', 'invoiceNumber', 'dataVat', 'dataWht'));
    }

    public function costCreate(Request $request)
    {
            $company = $request->input('company_id');
            $initials = DB::table('m_child_company')->select('initials', 'name')->where('id_company', $company)->first();
            $initials = $initials ? $initials->initials : null;

            if (!$initials) {
                // Tangani kasus jika $initials tidak ditemukan
            }

            $dateInput = $request->input('date');
            $mm = date('m', strtotime($dateInput));
            $yearNow = date('Y', strtotime($dateInput));
            $yearNowSubstring = substr($yearNow, -2);

            $indicator = $yearNowSubstring . $mm . '/' . $initials . '/CC/';

            // Lakukan kueri untuk mencari nilai maksimal
            $maxIdRecord = DB::table('t_costcenter')
                ->where('idreqform', 'like', $indicator . '%')
                ->orderBy('idrec', 'desc')
                ->first();

            if (is_null($maxIdRecord)) {
                $CCID = $indicator . '1';
            } else {
                $maxId = $maxIdRecord->idreqform;
                $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

                // Periksa apakah bulan telah berubah
                if (date('m', strtotime($dateInput)) != $mm) {
                    // Jika bulan berubah, reset nomor berjalan ke 1
                    $countIndicator = 1;
                    $mm = date('m', strtotime($dateInput));
                } else {
                    // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    $countIndicator = $lastRunningNumber + 1;
                }

                $CCID = $indicator . $countIndicator;
            }

            $rowsProducts = $request->get('rows');
            if (isset($rowsProducts[0]['subtotals']) && $rowsProducts[0]['subtotals'] == '0') {
                return response()->json(["st" => '4']);
            }
            if ($request->hasFile('file45')) {
                $filePdf = $request->file('file45');
                if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File Cost Center to Large, Please compress File');
                    return response()->json(["st" => '2']);
                }
                $pdf = base64_encode($filePdf->openFile()->fread($filePdf->getSize()));
            } else {
               $pdf = null;
               return response()->json(["st" => '2']);
            }
            if ($request->hasFile('dp_file')) {
                $filePdf1 = $request->file('dp_file');
                if ($filePdf1->getSize() > 12582912) { // 5 MB in bytes
                    alert()->error('Error', 'File Previous DP to Large, Please compress File');
                    return response()->json(["st" => '2']);
                }
                $pdf1 = base64_encode($filePdf1->openFile()->fread($filePdf1->getSize()));
            } else {
               $pdf1 = null;
            }
            // $crate1 = str_replace('.', '', $request->input('crate'));
            // $crate = str_replace(',', '.', $crate1);
            $dpamount1 = str_replace('.', '', $request->input('dp_amount')) ?: 0;
            $dpamount = str_replace(',', '.', $dpamount1);
            try {
                if (!empty($rowsProducts) && ($request->input('grandtotal1') != '0' && $request->input('grandtotal1') >= '0')) {
                    DB::transaction(function () use ($request, $rowsProducts, $CCID, $pdf, $pdf1, $dpamount){
                        DB::table('t_costcenter')->insert([
                            'idreqform' => $CCID,
                            'datereq' => date($request->input('date')),
                            'due_date' => date($request->input('due_date')),
                            'user_type' => 'External',
                            'applicant' => $request->input('applicant'),
                            'company_id' => $request->input('company_id'),
                            'idsupplier' => $request->input('idsupplier'),
                            'company' => $request->input('compannyName'),
                            'department' => $request->input('departmentName'),
                            // 'currency' => $request->input('currency'),
                            'crate' => '1',
                            'bank_account' => $request->input('bank'),
                            'number_account' => $request->input('number'),
                            'name_account' => $request->input('account'),
                            'note' => $request->input('notes'),
                            'subtotal' => $request->input('subtotal1'),
                            'total_vat' => $request->input('gtotal_vat'),
                            'total' => $request->input('total1'),
                            'total_wht' => $request->input('gtotal_wht'),
                            'gtotal' => $request->input('grandtotal1'),
                            // 'approved_total' => $request->input('grandtotal1'),
                            'cost_file' => $pdf,
                            'dp_file' => $pdf1,
                            'dp_amount' => $dpamount,
                            'dp_reff' => $request->input('dp_reff'),
                            'approvalstat' => 'Draft',
                            'approval1_status' => 'Draft',
                            'prepared_by' => Auth::user()->username,
                            'print_status' => 'N',
                            'created_at' => date('Y-m-d'),
                            'created_by' => Auth::user()->id
                        ]);
                        foreach ($rowsProducts as $key) {
                            DB::table('t_costcenter_detail')->insert([
                                'idreqform' => $CCID,
                                'date' => $key['dates'],
                                'invoice_number' => $key['invoices'],
                                'type' => $key['types'],
                                'desc' => $key['descs'],
                                'unit_price' => $key['units'],
                                'currency' => $key['currencys'],
                                'forex' => $key['forexs'],
                                'qty' => $key['qtys'],
                                'price' => $key['prices'],
                                'subtotal' => $key['subtotals'],
                                'vat' => $key['vats'],
                                'vat_percent' => $key['vat_percents'],
                                'total_vat' => $key['total_vats'],
                                'total' => $key['totals'],
                                'wht' => $key['whts'],
                                'wht_percent' => $key['wht_percents'],
                                'norma' => $key['normas'],
                                'total_wht' => $key['total_whts'],
                                'paid_total' => $key['gtotals'],
                                'previous_payment' => $key['gtotals'],
                                // 'remarks' => $key['remarkss'],
                                'status' => 'Active',
                            ]);
                        }
                    });
                    alert()->success('Success', 'Cost Center #' . $CCID . ' Has Been Created');
                    return response()->json(["st" => '1', "id"=>$CCID]);
                } else {
                    alert()->error('Error', 'Cost Center Not Sent');
                    return response()->json(["st" => '3']);
                }
                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
            }
    }

    public function costListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.list.costcenter-list-only', compact('dataChildCompany', 'department'));
    }

    public function costList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.list.costcenter-request', compact('dataChildCompany', 'department'));
    }

    public function printVoucherCost()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.printvoucher', compact('dataChildCompany', 'department'));
    }

    public function submitPaymentProof()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.uploadvoucher', compact('dataChildCompany', 'department'));
    }

    public function editPaymentProof()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.editvoucher', compact('dataChildCompany', 'department'));
    }

    public function costListGetData(Request $request)
    {
        $user = Auth::user()->id;
        $dataCostQuery = DB::table('t_costcenter')
        ->join('m_child_company', 't_costcenter.company_id', 'm_child_company.id_company')
        ->join('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.idrec', 't_costcenter.idreqform', 't_costcenter.datereq', 't_costcenter.due_date', 't_costcenter.payment_date', 't_costcenter.user_type', 't_costcenter.applicant', 't_costcenter.company_id',
            't_costcenter.idsupplier', 't_costcenter.company', 't_costcenter.department', 't_costcenter.currency', 't_costcenter.crate', 't_costcenter.bank_account', 't_costcenter.number_account', 't_costcenter.name_account',
            't_costcenter.note', 't_costcenter.subtotal', 't_costcenter.total_vat', 't_costcenter.total', 't_costcenter.total_wht', 't_costcenter.gtotal', 't_costcenter.approved_total', 't_costcenter.approval_to', 't_costcenter.approval1_date',
            't_costcenter.approvalstat', 't_costcenter.approved1by', 't_costcenter.approval1_status', 't_costcenter.remarks1', 't_costcenter.prepared_by', 't_costcenter.approved_by', 't_costcenter.received_by', 't_costcenter.payment_proof_by',
            't_costcenter.proof_bank_name', 't_costcenter.transfer_number', 't_costcenter.print_status', 't_costcenter.created_at', 't_costcenter.created_by', 't_costcenter.updated_at', 't_costcenter.updated_by', 't_costcenter.dp_reff',
            'users.username',
            'm_child_company.name as companyName',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        );

        
        if ($request->input('status') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.company_id', $request->company);
        }
        if ($request->input('company_id') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.company_id', $request->company_id);
        }
        if ($request->input('idsupplier') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.idsupplier', $request->idsupplier);
        }
        if ($request->input('department') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.department', $request->department);
        }

        if(Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888'){
            $dataCostRequest = $dataCostQuery;
        }else{
            $dataCostRequest = $dataCostQuery->where('t_costcenter.created_by', $user);
        }

        if ($request->ajax()) {
            return DataTables::of($dataCostRequest)
            ->editColumn('gtotal', function ($dataCostRequest) {
                return "" . "" . number_format($dataCostRequest->grandeTotal, 0, ',', '.');
            })
            ->editColumn('grandeTotal', function ($dataCostRequest) {
            })
            ->addColumn('label', function ($dataCostRequest) {

                $status = ($dataCostRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Form Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Waiting Approval 1' || $status == 'HQ 1 Approved' || $status == 'Payment Proof') {
                    $color = "yellow";
                } else if ($status == 'Complete') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataCostRequest) {
                if ($dataCostRequest->approvalstat == 'Draft') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                        >View</a>

                        <a href = "/finance/costcenter-approval/list/submitpage/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Submit</a>

                        <a href = "/finance/costcenter-approval/list/updatepage/' . $dataCostRequest->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>

                        <a href = "/finance/costcenter-approval/list/clonepage/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >Clone</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataCostRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if($dataCostRequest->approvalstat == 'Waiting Approval 1' || $dataCostRequest->approvalstat == 'HQ 1 Approved') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                        
                        <a href = "/finance/costcenter-approval/list/clonepage/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >Clone</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataCostRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if($dataCostRequest->approvalstat == 'Complete' || $dataCostRequest->approvalstat == 'Form Printed' ||  $dataCostRequest->approvalstat == 'Payment Proof' || $dataCostRequest->approvalstat == 'HQ 1 Denied' || $dataCostRequest->approvalstat == 'HQ 2 Denied' || $dataCostRequest->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>

                        <a href = "/finance/costcenter-approval/list/clonepage/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm bg-blue-500 hover:bg-blue-600 text-white ml-1"    
                        >Clone</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataCostRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataCostRequest) {
                return '
                <div class="flex flex-row justify-center">   
                    <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                </div>';
            })
            ->addColumn('action2', function ($dataCostRequest) {
                return '
                <div class="flex justify-center">
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-reff="' . $dataCostRequest->idreqform . '"
                    data-gtotal="' . $dataCostRequest->gtotal . '"
                    >Select</button>
                </div>';
            })
            ->rawColumns(['label','action','action1', 'action2'])
            ->make();
        }
    }

    public function costGetPrintVoucher(Request $request)
    {
        $dataCostQuery = DB::table('t_costcenter')
        ->join('m_child_company', 't_costcenter.company_id', 'm_child_company.id_company')
        ->join('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.idrec', 't_costcenter.idreqform', 't_costcenter.datereq', 't_costcenter.due_date', 't_costcenter.payment_date', 't_costcenter.user_type', 't_costcenter.applicant', 't_costcenter.company_id',
            't_costcenter.idsupplier', 't_costcenter.company', 't_costcenter.department', 't_costcenter.currency', 't_costcenter.crate', 't_costcenter.bank_account', 't_costcenter.number_account', 't_costcenter.name_account',
            't_costcenter.note', 't_costcenter.subtotal', 't_costcenter.total_vat', 't_costcenter.total', 't_costcenter.total_wht', 't_costcenter.gtotal', 't_costcenter.approved_total', 't_costcenter.approval_to', 't_costcenter.approval1_date',
            't_costcenter.approvalstat', 't_costcenter.approved1by', 't_costcenter.approval1_status', 't_costcenter.remarks1', 't_costcenter.prepared_by', 't_costcenter.approved_by', 't_costcenter.received_by', 't_costcenter.payment_proof_by',
            't_costcenter.proof_bank_name', 't_costcenter.transfer_number', 't_costcenter.print_status', 't_costcenter.created_at', 't_costcenter.created_by', 't_costcenter.updated_at', 't_costcenter.updated_by', 't_costcenter.dp_reff',
            'users.username',
            'm_child_company.name as companyName',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        )->where(function ($query){
            $query->where('t_costcenter.approvalstat', '=', 'Payment Proof')->orWhere('t_costcenter.approvalstat', '=', 'Form Printed');
        });

        if ($request->input('company') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.company_id', $request->company);
        }
        // if ($request->input('department') != null){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.department', $request->department);
        // }

        $dataCostRequest = $dataCostQuery;

        if ($request->ajax()) {
            return DataTables::of($dataCostRequest)
            ->editColumn('gtotal', function ($dataCostRequest) {
                return "" . "" . number_format($dataCostRequest->grandeTotal, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostRequest) {
                if ($dataCostRequest->approvalstat == 'Payment Proof') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <button  class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                            data-id="'.$dataCostRequest->idrec.'" data-no="'.$dataCostRequest->idreqform.'"
                        >Print</button>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                        >View</a>
                        <a href = "/finance/costcenter-approval/list/print/' . $dataCostRequest->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Reprint</a>
                    </div>';
                }
                // else if($dataCostRequest->approvalstat == 'Form Printed' && $dataCostRequest->print_status == 'N'){
                //     return '
                //     <div class="flex flex-row justify-center">   
                //         <button  class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                //             data-id="'.$dataCostRequest->idrec.'" data-no="'.$dataCostRequest->idreqform.'"
                //         >Print</button>
                //     </div>';
                // }elseif ($dataCostRequest->approvalstat == 'Form Printed' &&  $dataCostRequest->print_status == 'Y') {
                //     return '
                //     <div class="flex flex-row justify-center">   
                //         <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"   
                //         >View</a>
                //     </div>';
                // }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function costGetSubmitVoucher(Request $request)
    {
        $dataCostQuery = DB::table('t_costcenter')
        ->join('m_child_company', 't_costcenter.company_id', 'm_child_company.id_company')
        ->join('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.idrec', 't_costcenter.idreqform', 't_costcenter.datereq', 't_costcenter.due_date', 't_costcenter.payment_date', 't_costcenter.user_type', 't_costcenter.applicant', 't_costcenter.company_id',
            't_costcenter.idsupplier', 't_costcenter.company', 't_costcenter.department', 't_costcenter.currency', 't_costcenter.crate', 't_costcenter.bank_account', 't_costcenter.number_account', 't_costcenter.name_account',
            't_costcenter.note', 't_costcenter.subtotal', 't_costcenter.total_vat', 't_costcenter.total', 't_costcenter.total_wht', 't_costcenter.gtotal', 't_costcenter.approved_total', 't_costcenter.approval_to', 't_costcenter.approval1_date',
            't_costcenter.approvalstat', 't_costcenter.approved1by', 't_costcenter.approval1_status', 't_costcenter.remarks1', 't_costcenter.prepared_by', 't_costcenter.approved_by', 't_costcenter.received_by', 't_costcenter.payment_proof_by',
            't_costcenter.proof_bank_name', 't_costcenter.transfer_number', 't_costcenter.print_status', 't_costcenter.created_at', 't_costcenter.created_by', 't_costcenter.updated_at', 't_costcenter.updated_by', 't_costcenter.dp_reff',
            'users.username',
            'm_child_company.name as companyName'
        )->where(function ($query){
            $query->where('t_costcenter.approvalstat', '=', 'Form Printed')->orWhere('t_costcenter.approvalstat', '=', 'Complete');
        });
        // if ($request->input('company') != null){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.company_id', $request->company);
        // }
        // if ($request->input('department') != null){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.department', $request->department);
        // }

        $dataCost = $dataCostQuery;

        if ($request->ajax()) {
            return DataTables::of($dataCost)
            ->editColumn('gtotal', function ($dataCost) {
                return "" . "" . number_format($dataCost->gtotal, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCost) {
                if ($dataCost->approvalstat == 'Payment Proof' || $dataCost->approvalstat == 'Form Printed') {
                    return '
                    <div class="flex flex-row justify-center">  
                        <a href = "/finance/costcenter-approval/submitpayment/' . $dataCost->idrec . '" class="btn btn-xs text-xs bg-emerald-500 hover:bg-emerald-600 text-white ml-1"    
                        >Submit Payment</a>
                    </div>';
                }else{
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCost->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataCost) {
                if ($dataCost->approvalstat == 'Complete') {
                    return '
                    <div class="flex flex-row justify-center">  
                        <a href = "/finance/costcenter-approval/submitpayment/' . $dataCost->idrec . '" class="btn btn-sm text-sm bg-pink-500 hover:bg-pink-600 text-white ml-1"    
                        >Edit Payment</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function costView(Request $request, $idCC)
    {
        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_bank.name as bank',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();

        return view('pages.finance.costcenter-approval.list.view', compact('dataCC', 'CCDetail'));
    }

    public function costUpdatePage(Request $request, $idCC)
    {
        $dataCurrency = DB::table('currency')
        ->select('*')->get();

        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        $dataType = DB::table('m_cost_center_type')
        ->select('*')->where('status', '=', 'Active')->get();

        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_bank.name as bank',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();

        $dataVat = DB::table('m_vat')->orderBy('name_vat', 'asc')->get();

        $dataWht = DB::table('m_wht')->orderBy('name_wht', 'asc')->get();

        return view('pages.finance.costcenter-approval.list.updatepage', compact('dataCC', 'CCDetail', 'bank', 'dataType', 'dataCurrency', 'dataVat', 'dataWht'));
    }

    public function costSubmitPage(Request $request, $idCC)
    {
        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_bank.name as bank',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();

        $userByCompany = Auth::user()->company_id;

        if ($userByCompany == '0') {
            $dataUser = DB::table('m_approval_cc')->leftJoin('users', 'm_approval_cc.id', 'users.id')->select('m_approval_cc.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval_cc')->leftJoin('users', 'm_approval_cc.id', 'users.id')->select('m_approval_cc.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
            // $dataUser = DB::table('m_approval_cc')->leftJoin('users', 'm_approval_cc.id', 'users.id')->select('m_approval_cc.id', 'users.company_id', 'users.username')->where('users.company_id', $userByCompany)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.finance.costcenter-approval.list.costcenter-submit', compact('dataCC', 'CCDetail', 'dataUser'));
    }

    public function costClonePage(Request $request, $idCC)
    {   
        $dataCost = DB::table('t_costcenter')->where('t_costcenter.idrec', $idCC)->first();
        return view('pages.finance.costcenter-approval.list.clone', compact('dataCost'));
    }

    public function costListClone(Request $request, $idCC)
    {
        $dataCost = DB::table('t_costcenter')->where('t_costcenter.idrec', $idCC)->first();

        $idCost = $dataCost->idreqform;

        $rowsProducts = DB::table('t_costcenter_detail')->select('*')->where('idreqform', $idCost)->where('status', '=', 'Active')->get();

        $company = $dataCost->company_id;

        $initials = DB::table('m_child_company')->select('initials', 'name')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('formDate');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/CC/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_costcenter')
            ->where('idreqform', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $CCID = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->idreqform;
            $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));

            // Periksa apakah bulan telah berubah
            if (date('m', strtotime($dateInput)) != $mm) {
                // Jika bulan berubah, reset nomor berjalan ke 1
                $countIndicator = 1;
                $mm = date('m', strtotime($dateInput));
            } else {
                // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                $countIndicator = $lastRunningNumber + 1;
            }

            $CCID = $indicator . $countIndicator;
        }

        $date = $request->input('due_date');

        $date1 = date('Y-m-t',strtotime($date));

        $formingdate = $request->input('formDate');

        try {
            if ($date == $formingdate) {
                DB::transaction(function () use ($rowsProducts, $dataCost, $request, $CCID, $date, $formingdate){
                    DB::table('t_costcenter')->insert([
                        'idreqform' => $CCID,
                        'datereq' => $formingdate,
                        'due_date' => $date,
                        'payment_date' => $dataCost->payment_date,
                        'user_type' => $dataCost->user_type,
                        'applicant' => $dataCost->applicant,
                        'company_id' => $dataCost->company_id,
                        'idsupplier' => $dataCost->idsupplier,
                        'company' => $dataCost->company,
                        'department' => $request->input('departmentName'),
                        'currency' => $dataCost->currency,
                        'crate' => $dataCost->crate,
                        'bank_account' => $dataCost->bank_account,
                        'number_account' => $dataCost->number_account,
                        'name_account' => $dataCost->name_account,
                        'note' => $dataCost->note,
                        'subtotal' => $dataCost->subtotal,
                        'total_vat' => $dataCost->total_vat,
                        'total' => $dataCost->total,
                        'total_wht' => $dataCost->total_wht,
                        'gtotal' => $dataCost->gtotal,
                        'approved_total' => $dataCost->approved_total,
                        'approval_to' => $dataCost->approval_to,
                        'approval1_date' => $dataCost->approval1_date,
                        'approved1by' => $dataCost->approved1by,
                        'approval1_status' => $dataCost->approval1_status,
                        'prepared_by' => Auth::user()->username,
                        'approved_by' => $dataCost->approved_by,
                        'received_by' => $dataCost->received_by,
                        'payment_proof_by' => $dataCost->payment_proof_by,
                        'proof_bank_name' => $dataCost->proof_bank_name,
                        'transfer_number' => $dataCost->transfer_number,
                        'cost_file' => $dataCost->cost_file,
                        'payment_file' => $dataCost->payment_file,
                        'dp_amount' => $dataCost->dp_amount,
                        'dp_reff' => $dataCost->dp_reff,
                        'dp_file' => $dataCost->dp_file,
                        'remarks1' => $dataCost->remarks1,
                        'print_status' => 'N',
                        'approvalstat' => 'Draft',
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d')
                    ]);
                    
                    foreach ($rowsProducts as $key => $value) {
                        DB::table('t_costcenter_detail')->insert([
                            'idreqform' => $CCID,
                            'date' => $formingdate,
                            'invoice_number' => $value->invoice_number,
                            'type' => $value->type,
                            'desc' => $value->desc,
                            'unit' => $value->unit,
                            'unit_price' => $value->unit_price,
                            'currency' => $value->currency,
                            'forex' => $value->forex,
                            'qty' => $value->qty,
                            'price' => $value->price,
                            'subtotal' => $value->subtotal,
                            'vat' => $value->vat,
                            'vat_percent' => $value->vat_percent,
                            'total_vat' => $value->total_vat,
                            'total' => $value->total,
                            'wht' => $value->wht,
                            'wht_percent' => $value->wht_percent,
                            'norma' => $value->norma,
                            'total_wht' => $value->total_wht,
                            'paid_total' => $value->paid_total,
                            'previous_payment' => $value->previous_payment,
                            'remarks' => $value->remarks,
                            'status' => $value->status
                        ]);
                    }
                });
                alert()->success('Success', 'Cost Center #' . $CCID . ' Has Been Created');
                // return to_route('cost-listonly');
                return response()->json(["st" => '1', "id"=>$CCID]);
            }else if ($date > $formingdate) {
                DB::transaction(function () use ($rowsProducts, $dataCost, $request, $CCID, $date, $formingdate){
                    DB::table('t_costcenter')->insert([
                        'idreqform' => $CCID,
                        'datereq' => $formingdate,
                        'due_date' => $date,
                        'payment_date' => $dataCost->payment_date,
                        'user_type' => $dataCost->user_type,
                        'applicant' => $dataCost->applicant,
                        'company_id' => $dataCost->company_id,
                        'idsupplier' => $dataCost->idsupplier,
                        'company' => $dataCost->company,
                        'department' => $request->input('departmentName'),
                        'currency' => $dataCost->currency,
                        'crate' => $dataCost->crate,
                        'bank_account' => $dataCost->bank_account,
                        'number_account' => $dataCost->number_account,
                        'name_account' => $dataCost->name_account,
                        'note' => $dataCost->note,
                        'subtotal' => $dataCost->subtotal,
                        'total_vat' => $dataCost->total_vat,
                        'total' => $dataCost->total,
                        'total_wht' => $dataCost->total_wht,
                        'gtotal' => $dataCost->gtotal,
                        'approved_total' => $dataCost->approved_total,
                        'approval_to' => $dataCost->approval_to,
                        'approval1_date' => $dataCost->approval1_date,
                        'approved1by' => $dataCost->approved1by,
                        'approval1_status' => $dataCost->approval1_status,
                        'prepared_by' => Auth::user()->username,
                        'approved_by' => $dataCost->approved_by,
                        'received_by' => $dataCost->received_by,
                        'payment_proof_by' => $dataCost->payment_proof_by,
                        'proof_bank_name' => $dataCost->proof_bank_name,
                        'transfer_number' => $dataCost->transfer_number,
                        'cost_file' => $dataCost->cost_file,
                        'payment_file' => $dataCost->payment_file,
                        'dp_amount' => $dataCost->dp_amount,
                        'dp_reff' => $dataCost->dp_reff,
                        'dp_file' => $dataCost->dp_file,
                        'remarks1' => $dataCost->remarks1,
                        'print_status' => 'N',
                        'approvalstat' => 'Draft',
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d')
                    ]);
                    
                    foreach ($rowsProducts as $key => $value) {
                        DB::table('t_costcenter_detail')->insert([
                            'idreqform' => $CCID,
                            'date' => $formingdate,
                            'invoice_number' => $value->invoice_number,
                            'type' => $value->type,
                            'desc' => $value->desc,
                            'unit' => $value->unit,
                            'unit_price' => $value->unit_price,
                            'currency' => $value->currency,
                            'forex' => $value->forex,
                            'qty' => $value->qty,
                            'price' => $value->price,
                            'subtotal' => $value->subtotal,
                            'vat' => $value->vat,
                            'vat_percent' => $value->vat_percent,
                            'total_vat' => $value->total_vat,
                            'total' => $value->total,
                            'wht' => $value->wht,
                            'wht_percent' => $value->wht_percent,
                            'norma' => $value->norma,
                            'total_wht' => $value->total_wht,
                            'paid_total' => $value->paid_total,
                            'previous_payment' => $value->previous_payment,
                            'remarks' => $value->remarks,
                            'status' => $value->status
                        ]);
                    }
                });
                alert()->success('Success', 'Cost Center #' . $CCID . ' Has Been Created');
                // return to_route('cost-listonly');
                return response()->json(["st" => '1', "id"=>$CCID]);
            }else if ($date < $formingdate){
                alert()->error('Error', 'Cost Center cannot be in the past');
                // return to_route('cost-listonly');
                return response()->json(["st" => '2', "id"=>$CCID]);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function submitPaymentPageCost(Request $request, $idCC)
    {
        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_bank.name as bank'
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();

        return view('pages.finance.costcenter-approval.uploadpage', compact('dataCC', 'CCDetail'));
    }

    public function costSubmit(Request $request, $idCC)
    {
        $costStat = DB::table('t_costcenter')->where('idrec', $idCC)->pluck('approvalstat')->first();

        if ($costStat == 'Draft') {
            DB::table('t_costcenter')->where('idrec', $idCC)->update([
                // 'approvalstat' => 'Waiting Approval 1',
                'approvalstat' => 'Payment Proof',
                'approval_to' => $request->input('approval_to'),
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
    
            alert()->success('Success', 'Cost Center Has Been Submited, Waiting Approval');
            return to_route('cost-listonly');
        }else {
            alert()->error('Error', 'Cost Center Already Submitted to Approval');
            return to_route('cost-listonly');
        }
    }

    public function costSubmitPay(Request $request, $idCC)
    {
        $costStat = DB::table('t_costcenter')->where('idrec', $idCC)->pluck('approvalstat')->first();
        if ($costStat == 'Form Printed' || $costStat == 'Payment Proof') {
            if ($request->hasFile('file45')) {
                $filePdf = $request->file('file45');    
                $pdf = $filePdf->openFile()->fread($filePdf->getSize());
               } else {
                   $pdf = null;
               }
            DB::table('t_costcenter')->where('idrec', $idCC)->update([
                'approvalstat' => 'Complete',
                'payment_date' => $request->input('payment_date'),
                'payment_proof_by' => $request->input('payment_proof_by'),
                'proof_bank_name' => $request->input('proof_bank_name'),
                'transfer_number' => $request->input('transfer_number'),
                'payment_file' => $pdf,
                'updated_at' => date('Y-m-d'),
                'updated_by' => Auth::user()->id
            ]);
    
            alert()->success('Success', 'Payment has been Uploaded, Save Complete');
            return to_route('cost-list.submitpaymentproof');
        }else {
            alert()->error('Error', 'Cost Center Already Complete');
            return to_route('cost-list.submitpaymentproof');
        }
    }

    public function costSignatureUpdate(Request $request, $idCC)
    {   
        try {
                if($request){
                    $dataCost = DB::table('t_costcenter')->select('*')->where('t_costcenter.idrec', $idCC)->first();
                    $applicants = DB::table('users')->where('id', $dataCost->created_by)->pluck('username')->first();
                    $dataBank = DB::table('m_bank')->where('id_bank', $dataCost->bank_account)->pluck('name')->first();
                    $vendor = DB::table('m_vendors')->where('idsupplier', $dataCost->idsupplier)->first();

                    // $initials = DB::table('m_child_company')->select('initials')->where('id_company', $dataCost->company_id)->first();
                    // $initials = $initials ? $initials->initials : null;

                    // if (!$initials) {
                    //     // Tangani kasus jika $initials tidak ditemukan
                    // }

                    // $dateInput = date('Y-m-d');
                    // $mm = date('m', strtotime($dateInput));
                    // $yearNow = date('Y');
                    // $yearNowSubstring = substr($yearNow, -2);

                    // $indicator = $yearNowSubstring . $mm . '/' . $initials . '/CP/';

                    // // Lakukan kueri untuk mencari nilai maksimal
                    // $maxIdRecord = DB::table('t_costpayment')
                    //     ->where('id_costpayment', 'like', $indicator . '%')
                    //     ->orderBy('idrec', 'desc')
                    //     ->first();

                    // if (is_null($maxIdRecord)) {
                    //     $CPID = $indicator . '1';
                    // } else {
                    //     $maxId = $maxIdRecord->id_costpayment;
                    //     $lastRunningNumber = intval(substr($maxId, strrpos($maxId, '/') + 1));
            
                    //      // Periksa apakah bulan telah berubah
                    //     if (date('m', strtotime($dateInput)) != $mm) {
                    //         // Jika bulan berubah, reset nomor berjalan ke 1
                    //         $countIndicator = 1;
                    //         $mm = date('m', strtotime($dateInput));
                    //     } else {
                    //         // Jika tidak ada perubahan bulan, tambahkan 1 ke nomor berjalan sebelumnya
                    //         $countIndicator = $lastRunningNumber + 1;
                    //     }
            
                    //     $CPID = $indicator . $countIndicator;
                    // }
                    if ($dataCost->approvalstat == 'Payment Proof') {
                        DB::transaction(function () use ($idCC, $dataCost, $dataBank, $applicants, $vendor){
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idCC)->update([
                                'approvalstat' => 'Form Printed',
                                'updated_at' => date('Y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);

                            $totalPaid = $dataCost->gtotal;
                            $approvedTotal = $dataCost->gtotal;
                            $balance = $dataCost->gtotal;

                            if ($dataCost->dp_amount != null) {
                                $totalPaid = $dataCost->gtotal + ($dataCost->dp_amount * -1);
                                $approvedTotal = $dataCost->gtotal + ($dataCost->dp_amount * -1);
                                $balance = $dataCost->gtotal + ($dataCost->dp_amount * -1);
                            }

                            DB::table('t_costpayment')->insert([
                                'id_costpayment' => $dataCost->idreqform,
                                'id_company' => $dataCost->company_id,
                                'company' => $dataCost->company,
                                'form_type' => 'Cost Center',
                                'date' => $dataCost->datereq,
                                'due_date' => $dataCost->due_date,
                                'applicant' => $dataCost->applicant,
                                'currency' => 'IDR',
                                'crate' => $dataCost->crate,
                                'subtotal' => $dataCost->subtotal,
                                'vat' => $dataCost->total_vat,
                                'total' => $dataCost->total,
                                'wht' => $dataCost->total_wht,
                                'total_paid' => $dataCost->gtotal,
                                'approved_total' => $approvedTotal,
                                'dp_amount' => $dataCost->dp_amount,
                                'beneficiary_bank' => $dataBank,
                                'beneficiary_name' => $dataCost->name_account,
                                'beneficiary_acc' => $dataCost->number_account,
                                'balance' => $balance,
                                'balance_wht' => $dataCost->total_wht,
                                'status' => 'A/P',
                                'print_status' => 'N',
                                'npwp_id' => $vendor->npwp_id,
                                'npwp_name' => $vendor->company_type.' '.$vendor->name,
                                'npwp_address' => $vendor->npwp_address,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $dataCost->created_by,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => $dataCost->created_by,
                                'aktifyn' => 'Y'
                            ]);
                        });
                        alert()->success('Success', 'Cost Center has been Printed');  
                        return response()->json(["st" => '1', "id"=>$dataCost->idrec]);
                    }else if($dataCost->approvalstat == 'Form Printed' && $dataCost->print_status == 'N'){
                        DB::transaction(function () use ($idCC){
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idCC)->update([
                                'print_status' => 'Y',
                                'updated_at' => date('Y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
                        });
                        alert()->success('Success', 'Cost Center has been Printed');   
                        return response()->json(["st" => '1', "id"=>$dataCost->idrec]);
                    }else if($dataCost->approvalstat == 'Form Printed' && $dataCost->print_status == 'Y'){
                        return response()->json(["st" => '0']);
                    }
                }else{
                    return response()->json(["st" => '0']);
                }
                DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function costPrint(Request $request, $idCC)
    {     
        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('m_child_company', 't_costcenter.company_id', 'm_child_company.id_company')
        ->leftJoin('m_vendors', 't_costcenter.idsupplier', 'm_vendors.idsupplier')
        ->select(
            't_costcenter.*',
            'm_bank.name as bank',
            'm_child_company.name as companies',
            'm_child_company.logo_filename',
            'm_child_company.address',
            'm_child_company.company_type',
            'm_vendors.name as vendorsName',
            'm_vendors.company_type as vendorsType',
            DB::raw('t_costcenter.gtotal + (t_costcenter.dp_amount * -1) as grandeTotal')
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();

        return view('pages.finance.costcenter-approval.list.print', compact('dataCC', 'CCDetail'));
    }

    public function costViewFile($idRR)
    {
        $dataCost = DB::table('t_costcenter')->where('idrec', $idRR)->select('cost_file', 'idreqform')->first();
        $filename = $dataCost->idreqform . '.pdf';
        $fileCost = base64_decode($dataCost->cost_file);

        return Response::make($fileCost, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
    public function costViewFileDP($idRR)
    {
        $dataDP = DB::table('t_costcenter')->where('idrec', $idRR)->select('dp_file', 'dp_reff')->first();
        $filename = $dataDP->dp_reff . '.pdf';
        $fileDP = base64_decode($dataDP->dp_file);

        return Response::make($fileDP, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function costViewPayment($idRR)
    {
        $dataCost = DB::table('t_costcenter')->where('idrec', $idRR)->select('payment_file', 'idreqform')->first();
        $filename = $dataCost->idreqform . '.pdf';
        $fileCost = $dataCost->payment_file;

        return Response::make($fileCost, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function costListUpdate(Request $request, $idRR)
    {
        $dataCost = DB::table('t_costcenter')->select('t_costcenter.idrec', 't_costcenter.idreqform', 't_costcenter.approvalstat')->where('t_costcenter.idrec', $idRR)->first();
        $approvalstat = $dataCost->approvalstat;
        $idreqform = $dataCost->idreqform;
        if ($request->hasFile('file45')) {
            $filePdf = $request->file('file45');
            if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                alert()->error('Error', 'File Cost Center to Large, Please compress File');
                return response()->json(["st" => '2']);
            }
            $pdf = base64_encode($filePdf->openFile()->fread($filePdf->getSize()));
        } else {
           $pdf = null;
        }
        if ($request->hasFile('dp_file')) {
            $filePdf1 = $request->file('dp_file');
            if ($filePdf1->getSize() > 12582912) { // 5 MB in bytes
                alert()->error('Error', 'File Previous DP to Large, Please compress File');
                return response()->json(["st" => '2']);
            }
            $pdf1 = base64_encode($filePdf1->openFile()->fread($filePdf1->getSize()));
        } else {
           $pdf1 = null;
        }
        try {
            if ($approvalstat == 'Draft') {
                $iden = $request->input('iden');
                $rowsProducts = $request->get('rows');
                if (!empty($iden) && $request->input('grandtotal1') != '0' && $request->input('grandtotal1') >= '0' || !empty($rowsProducts) && $request->input('grandtotal1') != '0' && $request->input('grandtotal1') >= '0') {
                    DB::transaction(function () use ($iden, $idreqform, $request, $idRR, $rowsProducts, $pdf, $pdf1){
                        if ($pdf != null && $pdf1 != null) {
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idRR)->update([
                                'datereq' => date($request->input('date')),
                                'due_date' => date($request->input('due_date')),
                                'department' => $request->input('departmentName'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'applicant' => $request->input('applicant'),
                                'company' => $request->input('compannyName'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                // 'approved_total' => $request->input('grandtotal1'),
                                'dp_amount' => $request->input('dp_amount'),
                                'dp_reff' => $request->input('dp_reff'),
                                'cost_file' => $pdf,
                                'dp_file' => $pdf1,
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
                            DB::table('t_costcenter_detail')->where('idreqform', $idreqform)->delete();
                            
                            if (!empty($iden)) {
                                foreach ($request->iden as $iden) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $request->input('date_'.$iden),
                                        'invoice_number' => $request->input('plate_'.$iden),
                                        'type' => $request->input('types_'.$iden),
                                        'desc' => $request->input('reimburse_'.$iden),
                                        // 'unit' => $request->input('unit_'.$iden),
                                        'unit_price' => $request->input('unit_price_'.$iden),
                                        'currency' => $request->input('currencys_'.$iden),
                                        'forex' => $request->input('forexs_'.$iden),
                                        'qty' => $request->input('qtys_'.$iden),
                                        'price' => $request->input('prices_'.$iden),
                                        'subtotal' => $request->input('subtotal1_'.$iden),
                                        'vat' => $request->input('vat_type_'.$iden),
                                        'vat_percent' => $request->input('vat_percent1_'.$iden),
                                        'total_vat' => $request->input('total_vat1_'.$iden),
                                        'total' => $request->input('total1_'.$iden),
                                        'wht' => $request->input('wht_type_'.$iden),
                                        'wht_percent' => $request->input('wht_percent1_'.$iden),
                                        'norma' => $request->input('norma1_'.$iden),
                                        'total_wht' => $request->input('total_wht1_'.$iden),
                                        'paid_total' => $request->input('paid_total_'.$iden),
                                        'previous_payment' => $request->input('paid_total_'.$iden),
                                        // 'remarks' => $request->input('remarks1_'.$iden),
                                        'status' => $request->input('status_'.$iden)
                                    ]);
                                }
                            }
    
                            if (!empty($rowsProducts)) {
                                foreach ($rowsProducts as $key) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $key['dates'],
                                        'invoice_number' => $key['invoices'],
                                        'type' => $key['types'],
                                        'desc' => $key['descs'],
                                        'unit_price' => $key['units'],
                                        'currency' => $key['currencys'],
                                        'forex' => $key['forexs'],
                                        'qty' => $key['qtys'],
                                        'price' => $key['prices'],
                                        'subtotal' => $key['subtotals'],
                                        'vat' => $key['vats'],
                                        'vat_percent' => $key['vat_percents'],
                                        'total_vat' => $key['total_vats'],
                                        'total' => $key['totals'],
                                        'wht' => $key['whts'],
                                        'wht_percent' => $key['wht_percents'],
                                        'norma' => $key['normas'],
                                        'total_wht' => $key['total_whts'],
                                        'paid_total' => $key['gtotals'],
                                        'previous_payment' => $key['gtotals'],
                                        // 'remarks' => $key['remarkss'],
                                        'status' => 'Active',
                                    ]);
                                }
                            }
                        } elseif ($pdf != null && $pdf1 == null) {
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idRR)->update([
                                'datereq' => date($request->input('date')),
                                'due_date' => date($request->input('due_date')),
                                'department' => $request->input('departmentName'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'applicant' => $request->input('applicant'),
                                'company' => $request->input('compannyName'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                'dp_amount' => $request->input('dp_amount'),
                                'dp_reff' => $request->input('dp_reff'),
                                'cost_file' => $pdf,
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
                            DB::table('t_costcenter_detail')->where('idreqform', $idreqform)->delete();
                            
                            if (!empty($iden)) {
                                foreach ($request->iden as $iden) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $request->input('date_'.$iden),
                                        'invoice_number' => $request->input('plate_'.$iden),
                                        'type' => $request->input('types_'.$iden),
                                        'desc' => $request->input('reimburse_'.$iden),
                                        // 'unit' => $request->input('unit_'.$iden),
                                        'unit_price' => $request->input('unit_price_'.$iden),
                                        'currency' => $request->input('currencys_'.$iden),
                                        'forex' => $request->input('forexs_'.$iden),
                                        'qty' => $request->input('qtys_'.$iden),
                                        'price' => $request->input('prices_'.$iden),
                                        'subtotal' => $request->input('subtotal1_'.$iden),
                                        'vat' => $request->input('vat_type_'.$iden),
                                        'vat_percent' => $request->input('vat_percent1_'.$iden),
                                        'total_vat' => $request->input('total_vat1_'.$iden),
                                        'total' => $request->input('total1_'.$iden),
                                        'wht' => $request->input('wht_type_'.$iden),
                                        'wht_percent' => $request->input('wht_percent1_'.$iden),
                                        'norma' => $request->input('norma1_'.$iden),
                                        'total_wht' => $request->input('total_wht1_'.$iden),
                                        'paid_total' => $request->input('paid_total_'.$iden),
                                        'previous_payment' => $request->input('paid_total_'.$iden),
                                        // 'remarks' => $request->input('remarks1_'.$iden),
                                        'status' => $request->input('status_'.$iden)
                                    ]);
                                }
                            }
    
                            if (!empty($rowsProducts)) {
                                foreach ($rowsProducts as $key) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $key['dates'],
                                        'invoice_number' => $key['invoices'],
                                        'type' => $key['types'],
                                        'desc' => $key['descs'],
                                        'unit_price' => $key['units'],
                                        'currency' => $key['currencys'],
                                        'forex' => $key['forexs'],
                                        'qty' => $key['qtys'],
                                        'price' => $key['prices'],
                                        'subtotal' => $key['subtotals'],
                                        'vat' => $key['vats'],
                                        'vat_percent' => $key['vat_percents'],
                                        'total_vat' => $key['total_vats'],
                                        'total' => $key['totals'],
                                        'wht' => $key['whts'],
                                        'wht_percent' => $key['wht_percents'],
                                        'norma' => $key['normas'],
                                        'total_wht' => $key['total_whts'],
                                        'paid_total' => $key['gtotals'],
                                        'previous_payment' => $key['gtotals'],
                                        // 'remarks' => $key['remarkss'],
                                        'status' => 'Active',
                                    ]);
                                }
                            }
                        } elseif ($pdf == null && $pdf1 != null) {
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idRR)->update([
                                'datereq' => date($request->input('date')),
                                'due_date' => date($request->input('due_date')),
                                'department' => $request->input('departmentName'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'applicant' => $request->input('applicant'),
                                'company' => $request->input('compannyName'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                'dp_amount' => $request->input('dp_amount'),
                                'dp_reff' => $request->input('dp_reff'),
                                'dp_file' => $pdf1,
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
                            DB::table('t_costcenter_detail')->where('idreqform', $idreqform)->delete();
                            
                            if (!empty($iden)) {
                                foreach ($request->iden as $iden) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $request->input('date_'.$iden),
                                        'invoice_number' => $request->input('plate_'.$iden),
                                        'type' => $request->input('types_'.$iden),
                                        'desc' => $request->input('reimburse_'.$iden),
                                        // 'unit' => $request->input('unit_'.$iden),
                                        'unit_price' => $request->input('unit_price_'.$iden),
                                        'currency' => $request->input('currencys_'.$iden),
                                        'forex' => $request->input('forexs_'.$iden),
                                        'qty' => $request->input('qtys_'.$iden),
                                        'price' => $request->input('prices_'.$iden),
                                        'subtotal' => $request->input('subtotal1_'.$iden),
                                        'vat' => $request->input('vat_type_'.$iden),
                                        'vat_percent' => $request->input('vat_percent1_'.$iden),
                                        'total_vat' => $request->input('total_vat1_'.$iden),
                                        'total' => $request->input('total1_'.$iden),
                                        'wht' => $request->input('wht_type_'.$iden),
                                        'wht_percent' => $request->input('wht_percent1_'.$iden),
                                        'norma' => $request->input('norma1_'.$iden),
                                        'total_wht' => $request->input('total_wht1_'.$iden),
                                        'paid_total' => $request->input('paid_total_'.$iden),
                                        'previous_payment' => $request->input('paid_total_'.$iden),
                                        // 'remarks' => $request->input('remarks1_'.$iden),
                                        'status' => $request->input('status_'.$iden)
                                    ]);
                                }
                            }
    
                            if (!empty($rowsProducts)) {
                                foreach ($rowsProducts as $key) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $key['dates'],
                                        'invoice_number' => $key['invoices'],
                                        'type' => $key['types'],
                                        'desc' => $key['descs'],
                                        'unit_price' => $key['units'],
                                        'currency' => $key['currencys'],
                                        'forex' => $key['forexs'],
                                        'qty' => $key['qtys'],
                                        'price' => $key['prices'],
                                        'subtotal' => $key['subtotals'],
                                        'vat' => $key['vats'],
                                        'vat_percent' => $key['vat_percents'],
                                        'total_vat' => $key['total_vats'],
                                        'total' => $key['totals'],
                                        'wht' => $key['whts'],
                                        'wht_percent' => $key['wht_percents'],
                                        'norma' => $key['normas'],
                                        'total_wht' => $key['total_whts'],
                                        'paid_total' => $key['gtotals'],
                                        'previous_payment' => $key['gtotals'],
                                        // 'remarks' => $key['remarkss'],
                                        'status' => 'Active',
                                    ]);
                                }
                            }
                        } elseif ($pdf == null && $pdf1 == null) {
                            DB::table('t_costcenter')->where('t_costcenter.idrec', $idRR)->update([
                                'datereq' => date($request->input('date')),
                                'due_date' => date($request->input('due_date')),
                                'department' => $request->input('departmentName'),
                                'bank_account' => $request->input('bank'),
                                'number_account' => $request->input('number'),
                                'name_account' => $request->input('account'),
                                'note' => $request->input('notes'),
                                'applicant' => $request->input('applicant'),
                                'company' => $request->input('compannyName'),
                                'subtotal' => $request->input('subtotal1'),
                                'total_vat' => $request->input('gtotal_vat'),
                                'total' => $request->input('total1'),
                                'total_wht' => $request->input('gtotal_wht'),
                                'gtotal' => $request->input('grandtotal1'),
                                'dp_amount' => $request->input('dp_amount'),
                                'dp_reff' => $request->input('dp_reff'),
                                'updated_at' => date('y-m-d'),
                                'updated_by' => Auth::user()->id
                            ]);
                            DB::table('t_costcenter_detail')->where('idreqform', $idreqform)->delete();
                            
                            if (!empty($iden)) {
                                foreach ($request->iden as $iden) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $request->input('date_'.$iden),
                                        'invoice_number' => $request->input('plate_'.$iden),
                                        'type' => $request->input('types_'.$iden),
                                        'desc' => $request->input('reimburse_'.$iden),
                                        // 'unit' => $request->input('unit_'.$iden),
                                        'unit_price' => $request->input('unit_price_'.$iden),
                                        'currency' => $request->input('currencys_'.$iden),
                                        'forex' => $request->input('forexs_'.$iden),
                                        'qty' => $request->input('qtys_'.$iden),
                                        'price' => $request->input('prices_'.$iden),
                                        'subtotal' => $request->input('subtotal1_'.$iden),
                                        'vat' => $request->input('vat_type_'.$iden),
                                        'vat_percent' => $request->input('vat_percent1_'.$iden),
                                        'total_vat' => $request->input('total_vat1_'.$iden),
                                        'total' => $request->input('total1_'.$iden),
                                        'wht' => $request->input('wht_type_'.$iden),
                                        'wht_percent' => $request->input('wht_percent1_'.$iden),
                                        'norma' => $request->input('norma1_'.$iden),
                                        'total_wht' => $request->input('total_wht1_'.$iden),
                                        'paid_total' => $request->input('paid_total_'.$iden),
                                        'previous_payment' => $request->input('paid_total_'.$iden),
                                        // 'remarks' => $request->input('remarks1_'.$iden),
                                        'status' => $request->input('status_'.$iden)
                                    ]);
                                }
                            }
    
                            if (!empty($rowsProducts)) {
                                foreach ($rowsProducts as $key) {
                                    DB::table('t_costcenter_detail')->insert([
                                        'idreqform' => $idreqform,
                                        'date' => $key['dates'],
                                        'invoice_number' => $key['invoices'],
                                        'type' => $key['types'],
                                        'desc' => $key['descs'],
                                        'unit_price' => $key['units'],
                                        'currency' => $key['currencys'],
                                        'forex' => $key['forexs'],
                                        'qty' => $key['qtys'],
                                        'price' => $key['prices'],
                                        'subtotal' => $key['subtotals'],
                                        'vat' => $key['vats'],
                                        'vat_percent' => $key['vat_percents'],
                                        'total_vat' => $key['total_vats'],
                                        'total' => $key['totals'],
                                        'wht' => $key['whts'],
                                        'wht_percent' => $key['wht_percents'],
                                        'norma' => $key['normas'],
                                        'total_wht' => $key['total_whts'],
                                        'paid_total' => $key['gtotals'],
                                        'previous_payment' => $key['gtotals'],
                                        // 'remarks' => $key['remarkss'],
                                        'status' => 'Active',
                                    ]);
                                }
                            }
                        }
                    });
                    alert()->success('Success', 'Cost Center Has Been Edited');
                    return to_route('cost-listonly');
                } else {
                    alert()->error('Error', 'Cost Detail Empty');
                    return to_route('cost-listonly');
                }
            } else {
                alert()->error('Error', 'Cost Center Already Submitted');
                return to_route('cost-listonly');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function deleteCostDetail($id)
    {
        try {
            DB::table('t_costcenter_detail')->where('id', $id)->update([
                'status' => 'Non Active'
            ]);
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

    public function costApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.finance.costcenter-approval.index', compact('dataChildCompany', 'department'));
    }

    public function costGetApproval(Request $request)
    {
        $approvalTo = Auth::user()->id;
        $dataCostQuery = DB::table('t_costcenter')
        ->join('m_child_company', 't_costcenter.company_id', 'm_child_company.id_company')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_child_company.name as companyName'
        );

        if ($request->input('company') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.company_id', $request->company);
        }
        if ($request->input('department') != null){
            $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', $request->department)->where('t_costcenter.approval_to', $approvalTo);
        }else if ($request->input('department') == null){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataCostRequest = $dataCostQuery->orderBy('t_costcenter.idreqform', 'desc');
            } else {
                $dataCostQuery = $dataCostQuery->where('t_costcenter.approval_to', $approvalTo);
            }
        }
        // if ($request->input('department') == 'Waiting Approval 1'){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', '=', 'Waiting Approval 1')->where('t_costcenter.approval_to', $approvalTo);
        // }else if ($request->input('department') == 'Waiting Approval 1 all'){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', '=', 'Waiting Approval 1')->where('t_costcenter.id_company', '=', Auth::user()->company_id);
        // }else if ($request->input('department') == 'Payment Proof'){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', '=', 'Payment Proof')->where('t_costcenter.id_company', '=', Auth::user()->company_id);
        // }else if ($request->input('department') == 'HQ 1 Denied'){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', '=', 'HQ 1 Denied')->where('t_costcenter.id_company', '=', Auth::user()->company_id);
        // }else if ($request->input('department') == 'Canceled'){
        //     $dataCostQuery = $dataCostQuery->where('t_costcenter.approvalstat', '=', 'Canceled')->where('t_costcenter.id_company', '=', Auth::user()->company_id);
        // }else if ($request->input('department') == null){
        //     if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        //         $dataCostRequest = $dataCostQuery->orderBy('t_costcenter.idreqform', 'desc');
        //     } else {
        //         $dataCostQuery = $dataCostQuery->where('t_costcenter.id_company', '=', Auth::user()->company_id);
        //     }
        // }
        $dataCostRequest = $dataCostQuery->orderBy('t_costcenter.idreqform', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataCostRequest)
            ->editColumn('gtotal', function ($dataCostRequest) {
                return "" . number_format($dataCostRequest->gtotal, 0, ',', '.' . " ");
            })
            ->addColumn('label', function ($dataCostRequest) {

                $status = ($dataCostRequest->approval1_status);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Waiting Approval 1') {
                    $color = "yellow";
                } else if ($status == 'HQ 1 Approved' || $status == 'HQ 2 Approved') {
                    $color = "green";
                } else if ($status == 'HQ 1 Denied' || $status == 'HQ 2 Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->addColumn('action', function ($dataCostRequest) use ($approvalTo) {
                if ($dataCostRequest->approvalstat == 'Waiting Approval 1' && $dataCostRequest->approval_to == $approvalTo) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/approve1/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataCostRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                } else if($dataCostRequest->approvalstat == 'HQ 1 Approved' && $dataCostRequest->approval_to == $approvalTo) {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>

                        <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataCostRequest->idrec.'"
                        >Cancel</button>
                    </div>';
                }else if($dataCostRequest->approvalstat == 'Payment Proof' || $dataCostRequest->approvalstat == 'Form Printed' || $dataCostRequest->approvalstat == 'Draft' || $dataCostRequest->approvalstat == 'Waiting Approval 1' || $dataCostRequest->approvalstat == 'HQ 1 Approved' || $dataCostRequest->approvalstat == 'HQ 1 Denied' || $dataCostRequest->approvalstat == 'HQ 2 Denied' || $dataCostRequest->approvalstat == 'Canceled' || $dataCostRequest->approvalstat == 'Complete') {
                    return '
                    <div class="flex flex-row justify-center">   
                        <a href = "/finance/costcenter-approval/list/view/' . $dataCostRequest->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['label','action'])
            ->make();
        }
    }

    public function costApprove1(Request $request, $idCC)
    {
        $dataCC = DB::table('t_costcenter')
        ->leftJoin('m_bank', 't_costcenter.bank_account', 'm_bank.id_bank')
        ->leftJoin('users', 't_costcenter.created_by', 'users.id')
        ->select(
            't_costcenter.*',
            'users.username',
            'm_bank.name as bank'
        )->where('t_costcenter.idrec', $idCC)->first();

        $idreqformCC = $dataCC->idreqform;
            
        $CCDetail = DB::table('t_costcenter_detail')
        ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        ->where('t_costcenter_detail.idreqform', $idreqformCC)->where('t_costcenter_detail.status', '=', 'Active')->get();
        return view('pages.finance.costcenter-approval.approval1', compact('dataCC', 'CCDetail'));
    }

    public function costUpdateStatus (Request $request, $idRR)
    {
        $status = $request->input('status');
        $reimburseStat = DB::table('t_costcenter')->where('idrec', $idRR)->pluck('approvalstat')->first();

        if ($reimburseStat == "Waiting Approval 1") {
            if ($status == 'Approved') {
                $approved_total1 = str_replace('.', '', $request->input('approved_total'));
                $approved_total = str_replace(',', '.', $approved_total1) ?: 0;
                DB::table('t_costcenter')
                    ->where('idrec', $idRR)
                    ->update([
                        'approvalstat' => 'Payment Proof',
                        'approval1_status' => 'Payment Proof',
                        'approved_total' => $approved_total,
                        'approval1_date' => date('Y-m-d'),
                        'remarks1' => $request->input('remarks1'),
                        'approved_by' => Auth::user()->username,
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id,
                        'approved1by' => Auth::user()->username
                    ]);
                    alert()->success('Success', 'Cost Center Has Been Approved');
                    return to_route('costcenter-approval');
    
            } else if ($status == 'Denied') {
                DB::table('t_costcenter')
                ->where('idrec', $idRR)
                ->update([
                    'approvalstat' => 'HQ 1 Denied',
                    'approval1_status' => 'HQ 1 Denied',
                    'approval1_date' => date('Y-m-d'),
                    'remarks1' => $request->input('remarks1'),
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id,
                    'approved1by' => Auth::user()->username
                ]);
                alert()->success('Success', 'Cost Center Has Been Denied');
                return to_route('costcenter-approval');
            }
        } else {
            alert()->error('Error', 'Cost Center Already Approved/Denied');
            return to_route('costcenter-approval');
        }
    }

    public function cancelcost($idRR)
    {
        try {
            $idreqform = DB::table('t_costcenter')->where('idrec', $idRR)->pluck('idreqform')->first();
            $dataPayment = DB::table('t_costpayment')->where('id_costpayment', $idreqform)->first();
            $dataPaymentDetail = DB::table('t_costpayment_detail')->where('id_costpayment', $idreqform)->pluck('id_costpayment')->first();
            if(is_null($dataPayment) || $dataPayment->approved_total == $dataPayment->balance){
                DB::table('t_costcenter')->where('idrec', $idRR)->update([
                    'approvalstat' => 'Canceled',
                    'updated_at' => date('Y-m-d'),
                    'updated_by' => Auth::user()->id
                ]);
                DB::table('t_costpayment')->where('id_costpayment', $idreqform)->update([
                    'status' => 'Canceled',
                    'aktifyn' => 'N',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->username
                ]);
                return response()->json([
                    'status' => 1,
                    'message' => "successfully deleted weekly report",
                ]);
            }elseif ($dataPayment != null && $dataPayment->approved_total != $dataPayment->balance) {
                return response()->json([
                    'status' => 2,
                    'message' => "Cannot cancel cost center there are Active PV",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function vat()
    {
        return view('pages.ga.data-master.m-tax.vat');
    }

    public function vatForm()
    {
        return view('pages.ga.data-master.m-tax.vat-form');
    }

    public function vatGetData(Request $request)
    {
        $dataVat = DB::table('m_vat')
        ->join('users', 'm_vat.created_by', 'users.id')
        ->select(
            'm_vat.*',
            'users.username'
        );

        if ($request->ajax()) {
            return DataTables::of($dataVat)
            ->editColumn('created_at', function ($dataVat) {
                return date('Y-m-d', strtotime($dataVat->created_at));
            })
            ->editColumn('rate', function ($dataVat) {
                return $dataVat->rate . ' ' . "";
            })
            ->make();
        }
    }

    public function vatCreate(Request $request)
    {
        // $type = $request->input('name_vat');

        // $typeName = DB::table('m_vat')->select('name_vat')->where('name_vat', $type)->first();
            
        if ($request) {
                DB::table('m_vat')->insert([
                    'name_vat' => $request->input('name_vat'),
                    'rate' => $request->input('rate'),
                    'created_at' => date('Y-m-d'),
                    'created_by' => Auth::user()->id
                ]);
            alert()->success('Success', 'VAT Type Has Been Created');
            return to_route('vat');
        } else {
            alert()->error('Error', 'VAT Type Already Exist');
            return to_route('vat.form');
        }
    }

    public function wht()
    {
        return view('pages.ga.data-master.m-tax.wht');
    }

    public function whtForm()
    {
        return view('pages.ga.data-master.m-tax.wht-form');
    }

    public function whtGetData(Request $request)
    {
        $dataPph = DB::table('m_wht')
        ->join('users', 'm_wht.created_by', 'users.id')
        ->select(
            'm_wht.*',
            'users.username'
        );

        if ($request->ajax()) {
            return DataTables::of($dataPph)
            ->editColumn('created_at', function ($dataPph) {
                return date('Y-m-d', strtotime($dataPph->created_at));
            })
            ->editColumn('rate', function ($dataPph) {
                return $dataPph->rate . ' ' . "";
            })
            ->make();
        }
    }

    public function whtCreate(Request $request)
    {
        // $type = $request->input('name_wht');

        // $typeName = DB::table('m_wht')->select('name_wht')->where('name_wht', $type)->first();
            
        if ($request) {
                DB::table('m_wht')->insert([
                    'name_wht' => $request->input('name_wht'),
                    'rate' => $request->input('rate'),
                    'norma' => $request->input('norma'),
                    'created_at' => date('Y-m-d'),
                    'created_by' => Auth::user()->id
                ]);
            alert()->success('Success', 'WHT Type Has Been Created');
            return to_route('wht');
        } else {
            alert()->error('Error', 'WHT Type Already Exist');
            return to_route('wht.form');
        }
    }

    public function ppn()
    {
        return view('pages.ga.data-master.m-tax.ppn');
    }

    public function ppnForm()
    {
        return view('pages.ga.data-master.m-tax.ppn-form');
    }

    public function ppnGetData(Request $request)
    {
        $dataPpn = DB::table('m_ppn')
        ->join('users', 'm_ppn.created_by', 'users.id')
        ->select(
            'm_ppn.*',
            'users.username'
        );

        if ($request->ajax()) {
            return DataTables::of($dataPpn)
            ->editColumn('created_at', function ($dataPpn) {
                return date('Y-m-d', strtotime($dataPpn->created_at));
            })
            ->editColumn('rate', function ($dataPpn) {
                return $dataPpn->rate . ' ' . "";
            })
            ->make();
        }
    }

    public function ppnCreate(Request $request)
    {
        $type = $request->input('name_ppn');

        $typeName = DB::table('m_ppn')->select('name_ppn')->where('name_ppn', $type)->first();
            
        if ($typeName == null) {
                DB::table('m_ppn')->insert([
                    'name_ppn' => $request->input('name_ppn'),
                    'rate' => $request->input('rate'),
                    'created_at' => date('Y-m-d'),
                    'created_by' => Auth::user()->id
                ]);
            alert()->success('Success', 'PPN Type Has Been Created');
            return to_route('ppn');
        } else {
            alert()->error('Error', 'PPN Type Already Exist');
            return to_route('ppn.form');
        }
    }
}
