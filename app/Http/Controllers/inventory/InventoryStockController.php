<?php

namespace App\Http\Controllers\inventory;

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

class InventoryStockController extends Controller
{
    public function stockListOnly()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        
        return view('pages.inventory.inventory-stock.list.stocklist-only', compact('dataChildCompany', 'department'));
    }
    public function stockList()
    {
        $user = Auth::user()->company_id;

        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
            ->where('m_child_company.id_company', $user)->first();
        }
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        
        return view('pages.inventory.inventory-stock.list.stocklist', compact('dataChildCompany', 'department'));
    }

    public function inboundPrintConfirm()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.inventory-stock.list.printconfirm', compact('dataChildCompany'));
    }

    public function stockForm()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        return view('pages.inventory.inventory-stock.form', compact('dataChildCompany', 'department', 'fixCompany'));
    }

    public function stockCreate(Request $request)
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

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/II/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_inbound_inv')
            ->where('id_inbound', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $iiId = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->id_inbound;
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

            $iiId = $indicator . $countIndicator;
        }
        $rowsProducts = $request->get('rows');
        
        try {
            if (!empty($rowsProducts)) {
                DB::transaction(function () use ($rowsProducts, $dateInput, $request, $iiId){
                    DB::table('t_inbound_inv')->insert([
                        'date' => $dateInput,
                        'id_inbound' => $iiId,
                        'id_company' => $request->input('company'),
                        'id_warehouse' => $request->input('wid'),
                        'reff' => $request->input('reff'),
                        'courier_name' => $request->input('courier_name'),
                        'vehicle' => $request->input('vehicle'),
                        'notes' => $request->input('notes'),
                        'total_qty' => $request->input('grandtotal1'),
                        'status' => 'Scheduled',
                        'total_qty' => $request->input('grandtotal1'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id
                    ]);

                    foreach ($rowsProducts as $key) {
                        DB::table('t_inbound_inv_detail')->insert([
                            'id_inbound' => $iiId,
                            'idassets' => $key['ids'],
                            'qty' => $key['qtys'],
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 'Scheduled'
                        ]);

                        DB::table('t_inventory_assets')->insert([
                            'reff' => $iiId,
                            'reff_name' => 'Inventory Inbound',
                            'batch' => '-',
                            'idassets' => $key['ids'],
                            'cqty' => $key['qtys'],
                            'cbalance' => '0',
                            'sbalance' => '0',
                            'wbalance' => '0',
                            'id_company' => $request->input('company'),
                            'id_warehouse' => $request->input('wid'),
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 'Scheduled'
                        ]);
                    }
                });
                alert()->success('Success', 'Form #' . $iiId . ' Has Been Created');
                return to_route('inbound-inventory.listonly');
            } else{
                alert()->error('Error', 'Inventory Not Fill');
                return to_route('inbound-inventory.form');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function inboundListEdit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.inventory-stock.list.editinbound-list', compact('dataChildCompany'));
    }

    public function inboundListDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.inventory-stock.list.deleteinbound-list', compact('dataChildCompany'));
    }

    public function stockGetData(Request $request)
    {
        $dataInboundQuery = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
        )->where('t_inbound_inv.status', '!=', 'Deleted');

        if ($request->input('company') != null){
            $dataInboundQuery = $dataInboundQuery->where('t_inbound_inv.id_company', $request->company);
        }

        $dataInbound = $dataInboundQuery;

        if ($request->ajax()) {
            return DataTables::of($dataInbound)
            ->editColumn('total_qty', function ($dataInbound) {
                return "" . "" . number_format($dataInbound->total_qty, 0, ',', '.');
            })
            ->editColumn('date', function ($dataInbound) {
                return date('Y-m-d', strtotime($dataInbound->date));
            })
            ->addColumn('action', function ($dataInbound) {
                if ($dataInbound->status == 'Scheduled') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>
                    </div>';
                }elseif ($dataInbound->status == 'Printed' || $dataInbound->status == 'Received') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataInbound) {
                if ($dataInbound->status == 'Scheduled') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
    
                        <a href = "/inventory/inbound-inventory/list/updatepage/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>
                    </div>';
                } else {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action2', function ($dataInbound) {
                if ($dataInbound->status == 'Scheduled') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>

                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataInbound->idrec.'"
                        >Delete</button>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action3', function ($dataInbound) {
                if ($dataInbound->status == 'Scheduled') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>

                        <a href = "/inventory/inbound-inventory/list/signature/' . $dataInbound->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Print</a>
                    </div>';
                }elseif ($dataInbound->status == 'Printed') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>

                        <a href = "/inventory/inbound-inventory/list/confirmpage/' . $dataInbound->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"  
                        >Confirm Inbound</a>

                        <a href = "/inventory/inbound-inventory/list/signature/' . $dataInbound->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Reprint</a>
                    </div>';
                }elseif ($dataInbound->status == 'Received') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/inbound-inventory/list/view/' . $dataInbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                        >View</a>
                    </div>';
                }
            })
            
            ->rawColumns(['action', 'action1', 'action2', 'action3'])
            ->make();
        }
    }

    public function inboundListView(Request $request, $inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_inbound_inv.idrec', $inboundId)->first();

        $idInbound = $dataInbound->id_inbound;

        $dataInboundItem = DB::table('t_inbound_inv_detail')
        ->leftJoin('inventory_assets', 't_inbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_inbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_inbound_inv_detail.id_inbound', $idInbound)->orderBy('t_inbound_inv_detail.idrec', 'asc')->get();

        return view('pages.inventory.inventory-stock.list.view', compact('dataInbound', 'dataInboundItem'));
    }

    public function inboundViewFile($inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')->where('idrec', $inboundId)->select('file', 'id_inbound')->first();
        $filename = $dataInbound->id_inbound . '.pdf';
        $fileInbound = $dataInbound->file;

        return Response::make($fileInbound, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function inboundListUpdatePage(Request $request, $inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_inbound_inv.idrec', $inboundId)->first();

        $idInbound = $dataInbound->id_inbound;

        $dataInboundItem = DB::table('t_inbound_inv_detail')
        ->leftJoin('inventory_assets', 't_inbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_inbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_inbound_inv_detail.id_inbound', $idInbound)->orderBy('t_inbound_inv_detail.idrec', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        return view('pages.inventory.inventory-stock.list.updatepage', compact('dataInbound', 'dataInboundItem', 'department'));
    }

    public function inboundListUpdate(Request $request, $inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')->select('*')->where('t_inbound_inv.idrec', $inboundId)->first();
        $idInbound = $dataInbound->id_inbound;
        $status = $dataInbound->status;
        $id_company = $dataInbound->id_company;
        $id_warehouse = $dataInbound->id_warehouse;
        try {  
                if ($status == 'Scheduled') {
                    $iden = $request->input('iden');
                    $rowsProducts = $request->input('rows');
                    if (!empty($iden)) {
                            DB::transaction(function () use ($idInbound, $iden, $rowsProducts, $request, $id_company, $id_warehouse){
                                DB::table('t_inbound_inv')->where('t_inbound_inv.id_inbound', $idInbound)->update(['total_qty' => $request->input('grandtotal1')]);
                                DB::table('t_inbound_inv_detail')->where('t_inbound_inv_detail.id_inbound', $idInbound)->delete();
                                DB::table('t_inventory_assets')->where('t_inventory_assets.inout_id', $idInbound)->where('t_inventory_assets.id_company', $id_company)->where('t_inventory_assets.id_warehouse', $id_warehouse)->delete();
                                foreach ($request->iden as $iden) {
                                    DB::table('t_inbound_inv_detail')->insert([
                                        'id_inbound' => $idInbound,
                                        'idassets' => $request->input('ids_'.$iden),
                                        'qty' => $request->input('qty_'.$iden),
                                        'status' => 'Scheduled',
                                        'created_at' => $request->input('created_at_'.$iden),
                                        'created_by' => $request->input('created_by_'.$iden),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'updated_by' => Auth::user()->id
                                    ]);
                                    DB::table('t_inventory_assets')->insert([
                                        'inout_id' => $idInbound,
                                        'idassets' => $request->input('ids_'.$iden),
                                        'cqty' => $request->input('qty_'.$iden),
                                        'cbalance' => '0',
                                        'sbalance' => '0',
                                        'wbalance' => '0',
                                        'id_company' => $id_company,
                                        'id_warehouse' => $id_warehouse,
                                        'created_at' => $request->input('created_at_'.$iden),
                                        'created_by' => $request->input('created_by_'.$iden),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'updated_by' => Auth::user()->id,
                                        'status' => 'Scheduled'
                                    ]);
                                }
                                if (!empty($rowsProducts)) {
                                    foreach ($rowsProducts as $key) {
                                        DB::table('t_inbound_inv_detail')->insert([
                                            'id_inbound' => $idInbound,
                                            'idassets' => $key['ids'],
                                            'qty' => $key['qtys'],
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'created_by' => Auth::user()->id,
                                            'status' => 'Scheduled'
                                        ]);
                                        DB::table('t_inventory_assets')->insert([
                                            'inout_id' => $idInbound,
                                            'idassets' => $key['ids'],
                                            'cqty' => $key['qtys'],
                                            'cbalance' => '0',
                                            'sbalance' => '0',
                                            'wbalance' => '0',
                                            'id_company' => $id_company,
                                            'id_warehouse' => $id_warehouse,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'created_by' => Auth::user()->id,
                                            'status' => 'Scheduled'
                                        ]);
                                    }
                                }
                            });
                        alert()->success('Success', 'Inbound Inventory Has Been Edited');
                        return to_route('inbound-inventory');
                    }else {
                        alert()->error('Error', 'List Inbound Inventory Empty');
                        return to_route('inbound-inventory');
                    }
                } else {
                    alert()->error('Error', 'Inbound Inventory Already Printed');
                    return to_route('inbound-inventory');
                }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function deleteInbound($inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')->where('idrec', $inboundId)->first();
        try {
            DB::table('t_inbound_inv')->where('idrec', $inboundId)->update([
                'status' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            DB::table('t_inbound_inv_detail')->where('id_inbound', $dataInbound->id_inbound)->update([
                'status' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            DB::table('t_inventory_assets')->where('inout_id', $dataInbound->id_inbound)->where('id_company', $dataInbound->id_company)->where('id_warehouse', $dataInbound->id_warehouse)->update([
                'status' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully Canceled Inbound Inventory",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function inboundPrint($inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_child_company.address',
            'm_child_company.company_type',
            'm_child_company.logo_filename',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_inbound_inv.idrec', $inboundId)->first();

        $idInbound = $dataInbound->id_inbound;

        $dataInboundItem = DB::table('t_inbound_inv_detail')
        ->leftJoin('inventory_assets', 't_inbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_inbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_inbound_inv_detail.id_inbound', $idInbound)->orderBy('t_inbound_inv_detail.idrec', 'asc')->get();
        $dataInboundItemCount = $dataInboundItem->count();

        return view('pages.inventory.inventory-stock.list.print', compact('dataInbound', 'dataInboundItem', 'dataInboundItemCount'));
    }

    public function inboundSignature(Request $request, $inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_child_company.address',
            'm_child_company.company_type',
            'm_child_company.logo_filename',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_inbound_inv.idrec', $inboundId)->first();

        return view('pages.inventory.inventory-stock.list.signature', compact('dataInbound'));
    }

    public function inboundSignatureupdate(Request $request, $inboundId)
    {   
        try {
            if($request){
                $dataInbound=DB::table('t_inbound_inv')->where('t_inbound_inv.idrec', $inboundId)->first();
                $id=$dataInbound->idrec;
                $status = $dataInbound->status;
                if ($status == 'Scheduled') {
                    DB::table('t_inbound_inv')->where('t_inbound_inv.idrec', $inboundId)->update([
                        // 'released_by' => $request->input('released_by'),
                        // 'received_by' => $request->input('received_by'),
                        'status' => 'Printed',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
                    alert()->success('Success', 'Inbound has been Printed');    
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

    public function inboundListConfirm(Request $request, $inboundId)
    {
        $dataInbound = DB::table('t_inbound_inv')
        ->leftJoin('m_child_company', 't_inbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_inbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select(
            't_inbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_inbound_inv.idrec', $inboundId)->first();

        $idInbound = $dataInbound->id_inbound;

        $dataInboundItem = DB::table('t_inbound_inv_detail')
        ->leftJoin('inventory_assets', 't_inbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_inbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_inbound_inv_detail.id_inbound', $idInbound)->orderBy('t_inbound_inv_detail.idrec', 'asc')->get();

        return view('pages.inventory.inventory-stock.list.confirmpage', compact('dataInbound', 'dataInboundItem'));
    }

    public function confirmInbound(Request $request, $inboundId)
    {
        $dataInbound=DB::table('t_inbound_inv')->where('t_inbound_inv.idrec', $inboundId)->first();
        $status = $dataInbound->status;
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
        try {
            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
            if ($status == 'Scheduled' || $status == 'Printed') {
                if ($request->input('date') >= date('Y-m-d')) {
                    DB::table('t_inbound_inv')->where('idrec', $inboundId)->update([
                        'status' => 'Received',
                        'file' => $pdf,
                        'received_date' => $request->input('date'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
                    DB::table('t_inbound_inv_detail')->where('id_inbound', $dataInbound->id_inbound)->update([
                        'status' => 'Received',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
                    DB::table('t_inventory_assets')->where('inout_id', $dataInbound->id_inbound)->where('id_company', $dataInbound->id_company)->where('id_warehouse', $dataInbound->id_warehouse)->update([
                        'status' => 'Received',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
        
                    alert()->success('Success', 'Inbound Inventory Has Been Confirmed');
                    return response()->json(["st" => '1']);
                } else {
                    return response()->json(["st" => '4']);
                }
            } else {
                alert()->error('Error', 'Inbound Inventory Already Confirmed');
                return response()->json(["st" => '3']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function outboundForm()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.inventory.outbound-order.form', compact('dataChildCompany','fixCompany', 'department'));
    }

    public function outboundCreate(Request $request)
    {
        $company = $request->input('company');
        $initials = DB::table('m_child_company')->select('initials')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('formDate');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/OI/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_outbound_inv')
            ->where('id_outbound', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $oiId = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->id_outbound;
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

            $oiId = $indicator . $countIndicator;
        }
        $rowsProducts = $request->get('rows');

        try {
            if (!empty($rowsProducts)) {
                DB::transaction(function () use ($rowsProducts, $dateInput, $request, $oiId){
                    DB::table('t_outbound_inv')->insert([
                        'date' => $dateInput,
                        'id_outbound' => $oiId,
                        'id_company' => $request->input('company'),
                        'id_warehouse' => $request->input('wid'),
                        'idemployee' => $request->input('employee'),
                        'reff' => $request->input('reff'),
                        'courier_name' => $request->input('courier_name'),
                        'vehicle' => $request->input('vehicle'),
                        'notes' => $request->input('notes'),
                        'total_qty' => $request->input('grandtotal1'),
                        'approvalstat' => 'Draft',
                        'total_qty' => $request->input('grandtotal1'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);

                    foreach ($rowsProducts as $key) {
                        DB::table('t_outbound_inv_detail')->insert([
                            'id_outbound' => $oiId,
                            'idassets' => $key['ids'],
                            'qty' => $key['qtys'],
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 'Active'
                        ]);

                        DB::table('t_inventory_assets')->insert([
                            'reff' => $oiId,
                            'reff_name' => 'Inventory Outbound',
                            'batch' => '-',
                            'idassets' => $key['ids'],
                            'cqty' => $key['qtys'],
                            'cbalance' => '0',
                            'sbalance' => '0',
                            'wbalance' => '0',
                            'id_company' => $request->input('company'),
                            'id_warehouse' => $request->input('wid'),
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 'Active'
                        ]);
                    }
                });
                alert()->success('Success', 'Form #' . $oiId . ' Has Been Created');
                return to_route('outbound-inventory');
            } else{
                alert()->error('Error', 'Inventory Not Fill');
                return to_route('outbound');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function outboundList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.outboundorder-request', compact('dataChildCompany'));
    }

    public function outboundListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.outboundorder-only', compact('dataChildCompany'));
    }

    public function outboundListEdit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.editoutbound-list', compact('dataChildCompany'));
    }

    public function outboundListDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.deleteoutbound-list', compact('dataChildCompany'));
    }

    public function outboundListGetData(Request $request)
    {
        $dataOutboundQuery = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_employees.first_name',
            'm_employees.last_name'
        )->where('t_outbound_inv.approvalstat', '!=', 'Deleted');

        if ($request->input('status') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.id_company', $request->company);
        }

        $dataOutbound = $dataOutboundQuery;

        if ($request->ajax()) {
            return DataTables::of($dataOutbound)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->editColumn('total_qty', function ($dataOutbound) {
                return "" . "" . number_format($dataOutbound->total_qty, 0, ',', '.');
            })
            ->editColumn('first_name', function ($dataOutbound) {
                return $dataOutbound->first_name . " " . $dataOutbound->last_name;
            })
            ->editColumn('date', function ($dataOutbound) {
                return date('Y-m-d', strtotime($dataOutbound->date));
            })
            ->addColumn('action', function ($dataOutbound) {
                if ($dataOutbound->approvalstat == 'Draft') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>

                        <a href = "/inventory/outbound-inventory/list/updatepage/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                        >Edit</a>
                    </div>';
                }elseif ($dataOutbound->approvalstat == 'Printed') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    </div>';
                }else if($dataOutbound->approvalstat == 'Site Approved'){
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataOutbound->idrec.'"
                    >Cancel</button>
                    </div>';
                }elseif ($dataOutbound->approvalstat == 'Canceled' || $dataOutbound->approvalstat == 'Approved' || $dataOutbound->approvalstat == 'Denied') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
                    </div>';
                }
            })
            ->addColumn('action1', function ($dataOutbound) {
                return '
                <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                    >View</a>
                </div>';
            })
            ->addColumn('action2', function ($dataOutbound) {
                if ($dataOutbound->approvalstat == 'Draft') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>

                        <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                            data-id="'.$dataOutbound->idrec.'"
                        >Delete</button>
                    </div>';
                }else {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;""    
                        >View</a>
                    </div>';
                }
            })
            
            ->rawColumns(['action', 'action1', 'action2', 'label'])
            ->make();
        }
    }

    public function outboundPrintSubmit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.printsubmit', compact('dataChildCompany'));
    }

    public function outboundPrintList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.inventory.outbound-order.list.print-list', compact('dataChildCompany'));
    }

    public function outboundListGetPrintSubmit(Request $request)
    {
        $dataOutboundQuery = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_employees.first_name',
            'm_employees.last_name'
        )->where(function ($query) {
            $query->where('t_outbound_inv.approvalstat', '=', 'Draft');
        });
        
        if ($request->input('status') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.id_company', $request->company);
        }
        
        $dataOutbound = $dataOutboundQuery;

        if ($request->ajax()) {
            return DataTables::of($dataOutbound)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->editColumn('total_qty', function ($dataOutbound) {
                return "" . "" . number_format($dataOutbound->total_qty, 0, ',', '.');
            })
            ->editColumn('first_name', function ($dataOutbound) {
                return $dataOutbound->first_name . " " . $dataOutbound->last_name;
            })
            ->editColumn('date', function ($dataOutbound) {
                return date('Y-m-d', strtotime($dataOutbound->date));
            })
            ->addColumn('action', function ($dataOutbound) {
                if ($dataOutbound->approvalstat == 'Draft') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"   
                        >View</a>

                        <a href = "/inventory/outbound-inventory/list/submitpage/' . $dataOutbound->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(132 204 22); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"  
                        >Submit Approval</a>
                    </div>';
                }else if($dataOutbound->approvalstat == 'Site Approved'){
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataOutbound->idrec.'"
                    >Cancel</button>
                    </div>';
                }elseif ($dataOutbound->approvalstat == 'Canceled' || $dataOutbound->approvalstat == 'Approved' || $dataOutbound->approvalstat == 'Denied') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"   
                        >View</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function outboundListGetDataPrint(Request $request)
    {
        $dataOutboundQuery = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_employees.first_name',
            'm_employees.last_name'
        )->where(function ($query) {
            $query->where('t_outbound_inv.approvalstat', '=', 'Approved')->orwhere('t_outbound_inv.approvalstat', '=', 'Printed');
        });
        
        if ($request->input('status') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.approvalstat', $request->status);
        }
        if ($request->input('company') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.id_company', $request->company);
        }
        
        $dataOutbound = $dataOutboundQuery;

        if ($request->ajax()) {
            return DataTables::of($dataOutbound)
            ->addColumn('label', function ($dataPurchaseRequest) {

                $status = ($dataPurchaseRequest->approvalstat);
                $color = "color";

                if ($status == 'Draft') {
                    $color = "rgb(156 163 175)";
                } else if ($status == 'Printed') {
                    $color = "rgb(14 165 233)";
                } else if ($status == 'Site Approved') {
                    $color = "yellow";
                } else if ($status == 'Approved') {
                    $color = "green";
                } else if ($status == 'Denied' || $status == 'Canceled') {
                    $color = "red";
                }
                return '<div class="h-4 w-4 rounded-full" style="background-color: ' . $color . '"></div>';
            })
            ->editColumn('total_qty', function ($dataOutbound) {
                return "" . "" . number_format($dataOutbound->total_qty, 0, ',', '.');
            })
            ->editColumn('first_name', function ($dataOutbound) {
                return $dataOutbound->first_name . " " . $dataOutbound->last_name;
            })
            ->editColumn('date', function ($dataOutbound) {
                return date('Y-m-d', strtotime($dataOutbound->date));
            })
            ->addColumn('action', function ($dataOutbound) {
                if ($dataOutbound->approvalstat == 'Approved') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600"   
                        >View</a>

                        <a href = "/inventory/outbound-inventory/list/signature/' . $dataOutbound->idrec . '" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >Print</a>
                    </div>';
                }elseif ($dataOutbound->approvalstat == 'Printed') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                                
                    <a href = "/inventory/outbound-inventory/list/print/' . $dataOutbound->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                    >Print</a>
                    </div>';
                }
            })
            ->rawColumns(['action', 'label'])
            ->make();
        }
    }

    public function outboundListView(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();

        return view('pages.inventory.outbound-order.list.view', compact('dataOutbound', 'dataOutboundItem'));
    }

    public function signature(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();

        return view('pages.inventory.outbound-order.list.signature', compact('dataOutbound', 'dataOutboundItem'));
    }

    public function signatureupdate(Request $request, $outboundId)
    {   
        try {
            if($request){
                $dataOutbound=DB::table('t_outbound_inv')->where('t_outbound_inv.idrec', $outboundId)->first();
                $id=$dataOutbound->idrec;
                $approvalstat = $dataOutbound->approvalstat;
                if ($approvalstat == 'Approved') {
                    DB::table('t_outbound_inv')->where('t_outbound_inv.idrec', $outboundId)->update([
                        'released_by' => $request->input('released_by'),
                        'received_by' => $request->input('received_by'),
                        'approvalstat' => 'Printed',
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id
                    ]);
                    alert()->success('Success', 'Outbound has been Printed');    
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

    public function print($outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_child_company.address',
            'm_child_company.company_type',
            'm_child_company.logo_filename',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();
        $dataOutboundItemCount = $dataOutboundItem->count();

        return view('pages.inventory.outbound-order.list.print', compact('dataOutbound', 'dataOutboundItem', 'dataOutboundItemCount'));
    }

    public function outboundListSubmit(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();


        if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
            $dataUser = DB::table('m_approval_outbound')->leftJoin('users', 'm_approval_outbound.id', 'users.id')->select('m_approval_outbound.id', 'm_approval_outbound.id_company', 'users.username')->where('m_approval_outbound.id_company', $dataOutbound->id_company)->orderBy('users.username', 'asc')->get();
        } else {
            $dataUser = DB::table('m_approval_outbound')->leftJoin('users', 'm_approval_outbound.id', 'users.id')->select('m_approval_outbound.id', 'm_approval_outbound.id_company', 'users.username')->where('m_approval_outbound.id_company', $dataOutbound->id_company)->orderBy('users.username', 'asc')->get();
        }

        return view('pages.inventory.outbound-order.list.outboundorder-submit', compact('dataOutbound', 'dataOutboundItem', 'dataUser'));
    }

    public function outboundListUpdatePage(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();

        return view('pages.inventory.outbound-order.list.updatepage', compact('dataOutbound', 'dataOutboundItem', 'department'));
    }

    public function outboundListUpdate(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')->select('*')->where('t_outbound_inv.idrec', $outboundId)->first();
        $idOutbound = $dataOutbound->id_outbound;
        $approvalstat = $dataOutbound->approvalstat;
        $id_company = $dataOutbound->id_company;
        $id_warehouse = $dataOutbound->id_warehouse;
        try {  
                if ($approvalstat == 'Draft') {
                    $iden = $request->input('iden');
                    $rowsProducts = $request->input('rows');
                    if (!empty($iden)) {
                            DB::transaction(function () use ($idOutbound, $iden, $rowsProducts, $request, $id_company, $id_warehouse){
                                DB::table('t_outbound_inv')->where('t_outbound_inv.id_outbound', $idOutbound)->update(['total_qty' => $request->input('grandtotal1')]);
                                DB::table('t_outbound_inv_detail')->where('t_outbound_inv_detail.id_outbound', $idOutbound)->delete();
                                DB::table('t_inventory_assets')->where('t_inventory_assets.inout_id', $idOutbound)->where('t_inventory_assets.id_company', $id_company)->where('t_inventory_assets.id_warehouse', $id_warehouse)->delete();
                                foreach ($request->iden as $iden) {
                                    DB::table('t_outbound_inv_detail')->insert([
                                        'id_outbound' => $idOutbound,
                                        'idassets' => $request->input('ids_'.$iden),
                                        'qty' => $request->input('qty_'.$iden),
                                        'status' => 'Active',
                                        'created_at' => $request->input('created_at_'.$iden),
                                        'created_by' => $request->input('created_by_'.$iden),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'updated_by' => Auth::user()->id
                                    ]);
                                    DB::table('t_inventory_assets')->insert([
                                        'inout_id' => $idOutbound,
                                        'idassets' => $request->input('ids_'.$iden),
                                        'cqty' => $request->input('qty_'.$iden),
                                        'cbalance' => '0',
                                        'sbalance' => '0',
                                        'wbalance' => '0',
                                        'id_company' => $id_company,
                                        'id_warehouse' => $id_warehouse,
                                        'created_at' => $request->input('created_at_'.$iden),
                                        'created_by' => $request->input('created_by_'.$iden),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'updated_by' => Auth::user()->id,
                                        'status' => 'Active'
                                    ]);
                                }
                                if (!empty($rowsProducts)) {
                                    foreach ($rowsProducts as $key) {
                                        DB::table('t_outbound_inv_detail')->insert([
                                            'id_outbound' => $idOutbound,
                                            'idassets' => $key['ids'],
                                            'qty' => $key['qtys'],
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'created_by' => Auth::user()->id,
                                            'status' => 'Active'
                                        ]);
                                        DB::table('t_inventory_assets')->insert([
                                            'inout_id' => $idOutbound,
                                            'idassets' => $key['ids'],
                                            'cqty' => $key['qtys'],
                                            'cbalance' => '0',
                                            'sbalance' => '0',
                                            'wbalance' => '0',
                                            'id_company' => $id_company,
                                            'id_warehouse' => $id_warehouse,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'created_by' => Auth::user()->id,
                                            'status' => 'Active'
                                        ]);
                                    }
                                }
                            });
                        alert()->success('Success', 'Outbound Inventory Has Been Edited');
                        return to_route('inbound-inventory.list');
                    }else {
                        alert()->error('Error', 'List Outbound Inventory Empty');
                        return to_route('inbound-inventory.list');
                    }
                } else {
                    alert()->error('Error', 'Outbound Inventory Already Printed');
                    return to_route('inbound-inventory.list');
                }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function submitOutbound(Request $request, $outboundId)
    {
        try {
            $dataOutbound=DB::table('t_outbound_inv')->where('t_outbound_inv.idrec', $outboundId)->first();
            $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataOutbound->id_company)->first();
            $first_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('first_name')->first();
            $last_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('last_name')->first();
            $approvalstat = $dataOutbound->approvalstat;
            // if ($request->hasFile('file')) {
            //     $filePdf = $request->file('file');
            //     if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
            //         alert()->error('Error', 'File to Large, Please compress File');
            //         return response()->json(["st" => '2']);
            //     }    
            //     $pdf = $filePdf->openFile()->fread($filePdf->getSize());
            // } else {
            //        $pdf = null;
            // }

            $approvalTo = $request->input('approval_to');

            $email = DB::table('users')->where('id', $approvalTo)->pluck('real_email')->first();
    
            $token = (string)Str::uuid();
    
            $user = DB::table('users')->where('email', $email)->pluck('username')->first();
            if ($approvalstat == 'Draft') {
                DB::table('outbound_approve_token')->insert([
                    'email'=> $email,
                    'token'=> $token,
                    'is_active' => 1,
                    'expired_at' => Carbon::now()->addHour(),
                    'created_at' => Carbon::now()
                ]);
                
                $data = [
                    'url' => route('outbound.approvepage', [
                        'outboundId' => $outboundId,
                        'token' => $token
                    ]),
                    'logo_filename' => $datacomps->logo_filename,
                    'company' => $datacomps->name,
                    'address' => $datacomps->address,
                    'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                    'outNo' => $dataOutbound->id_outbound,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                ];
                Mail::send('outbound_approval', $data, function($message) use($email, $user, $datacomps){
                    $message->to($email, $user)->subject(''. $datacomps->name .' - Outbound Inventory Approval');
                });
                DB::table('t_outbound_inv')->where('idrec', $outboundId)->update([
                    'approvalstat' => 'Site Approved',
                    'approval_to' => $request->input('approval_to'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
                DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                    'status' => 'Site Approved',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
                DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                    'status' => 'Site Approved',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
    
                alert()->success('Success', 'Outbound Inventory Has Been Submited, Waiting Approval');
                return to_route('outbound-printsubmit');
            } else {
                alert()->error('Error', 'Outbound Inventory Already Submitted');
                return to_route('outbound-printsubmit');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function cancelOutbound($outboundId)
    {
        try {
            DB::table('t_outbound_inv')->where('idrec', $outboundId)->update([
                'approvalstat' => 'Canceled'
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully Canceled Outbound Inventory",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function deleteOutbound($outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')->where('idrec', $outboundId)->first();
        try {
            DB::table('t_outbound_inv')->where('idrec', $outboundId)->update([
                'approvalstat' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                'status' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                'status' => 'Deleted',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully Canceled Outbound Inventory",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function viewFile($outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')->where('idrec', $outboundId)->select('file', 'id_outbound')->first();
        $filename = $dataOutbound->id_outbound . '.pdf';
        $fileOutbound = $dataOutbound->file;

        return Response::make($fileOutbound, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function outboundApproval()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.inventory.outbound-order.index', compact('dataChildCompany', 'department'));
    }

    public function outboundGetApproval(Request $request)
    {
        $user = Auth::user()->id;
        $dataOutboundQuery = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_employees.first_name',
            'm_employees.last_name'
        );
        
        if ($request->input('status') != 'No'){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.approval_to', $user)->where('t_outbound_inv.approvalstat', '=', 'Site Approved');
        }else if ($request->input('status') != 'Yes'){
            if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
                $dataOutbound = $dataOutboundQuery->orderBy('t_outbound_inv.id_outbound', 'desc');
            } else {
                $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.id_company', '=', Auth::user()->company_id);
            }
        }
        if ($request->input('company') != null){
            $dataOutboundQuery = $dataOutboundQuery->where('t_outbound_inv.id_company', $request->company);
        }

        $dataOutbound = $dataOutboundQuery->orderBy('t_outbound_inv.id_outbound', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataOutbound)
            ->editColumn('total_qty', function ($dataOutbound) {
                return "" . "" . number_format($dataOutbound->total_qty, 0, ',', '.');
            })
            ->editColumn('first_name', function ($dataOutbound) {
                return $dataOutbound->first_name . " " . $dataOutbound->last_name;
            })
            ->editColumn('date', function ($dataOutbound) {
                return date('Y-m-d', strtotime($dataOutbound->date));
            })
            ->addColumn('action', function ($dataOutbound) use ($user) {
                if ($dataOutbound->approvalstat == 'Site Approved') {
                    return '
                    <a href = "/inventory/outbound-inventory/approve1/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }else if ($dataOutbound->approvalstat == 'HQ 1 Approved' && $dataOutbound->approval_to == $user) {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>
                    
                    <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataOutbound->idrec.'"
                    >Cancel</button>
                    </div>';
                }elseif ($dataOutbound->approvalstat == 'Approved' || $dataOutbound->approvalstat == 'Draft' || $dataOutbound->approvalstat == 'Printed' || $dataOutbound->approvalstat == 'Denied' || $dataOutbound->approvalstat == 'Canceled') {
                    return '
                    <div class="flex flex-row justify-center">
                    <a href = "/inventory/outbound-inventory/list/view/' . $dataOutbound->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-sky-500 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
                    >View</a>';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function outboundApprove1(Request $request, $outboundId)
    {
        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();

        return view('pages.inventory.outbound-order.approval1', compact('dataOutbound', 'dataOutboundItem'));
    }

    public function outboundApproved1Page(Request $request, $outboundId)
    {   
        $token = $request->input('token');

        $checkToken = DB::table('outbound_approve_token')->select('is_active', 'expired_at')->where('token', $token)->first();

        $dataOutbound = DB::table('t_outbound_inv')
        ->leftJoin('m_child_company', 't_outbound_inv.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_outbound_inv.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->leftJoin('m_employees', 't_outbound_inv.idemployee', 'm_employees.idemployee')
        ->select(
            't_outbound_inv.*',
            'm_child_company.name as companyName',
            'm_site_warehouse.w_name',
            'm_site_warehouse.w_address',
            'm_site_warehouse.w_province',
            'm_site_warehouse.w_city',
            'm_site_warehouse.w_country',
            'm_site_warehouse.w_zipcode',
            'm_employees.first_name',
            'm_employees.last_name',
            'm_employees.department',
            'm_employees.position',
            DB::raw("CAST(total_qty AS DECIMAL(18,0)) AS grandTotal")
        )->where('t_outbound_inv.idrec', $outboundId)->first();

        $idOutbound = $dataOutbound->id_outbound;

        $dataOutboundItem = DB::table('t_outbound_inv_detail')
        ->leftJoin('inventory_assets', 't_outbound_inv_detail.idassets', 'inventory_assets.idassets')
        ->select('t_outbound_inv_detail.*', 'inventory_assets.name', 'inventory_assets.unit')
        ->where('t_outbound_inv_detail.id_outbound', $idOutbound)->orderBy('t_outbound_inv_detail.idrec', 'asc')->get();
        // if (Auth::user()->company_id == '0' || Auth::user()->company_id == '999' || Auth::user()->company_id == '888') {
        // } else {
        //     $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        //     // $dataUser = DB::table('m_approval2_rab')->leftJoin('users', 'm_approval2_rab.id', 'users.id')->select('m_approval2_rab.id', 'users.company_id', 'users.username')->where('users.company_id', $userByCompany)->orderBy('users.username', 'asc')->get();
        // }

        // if ($checkToken->is_active == 0) {
        //     alert()->error('Error', 'Link was not Active');
        // }

        // if ($expired_at->lt(Carbon::now()) ) {
        //     alert()->error('Error', 'Link was Expired');
        //     return view('/');
        // }
        return view('outbound_approvalpage', compact('dataOutbound', 'dataOutboundItem'));
    }

    public function outboundUpdateStatus (Request $request, $outboundId)
    {
        $status = $request->input('status');
        $dataOutbound=DB::table('t_outbound_inv')->where('t_outbound_inv.idrec', $outboundId)->first();
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataOutbound->id_company)->first();
        $first_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('first_name')->first();
        $last_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('last_name')->first();
        $approvalstat = $dataOutbound->approvalstat;
        $email1 = DB::table('users')->where('id', $dataOutbound->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        try {
            if ($approvalstat == 'Site Approved') {
                if ($status == 'Approved') {   
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => Auth::user()->username,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    Mail::send('outbound_approve', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Approved');
                    });
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Approved',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => Auth::user()->username,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Approved',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Approved',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Has Been Approved');
                    return to_route('outbound-approvalga');
        
                } else if ($status == 'Denied') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => Auth::user()->username,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    Mail::send('outbound_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Denied');
                    });
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Denied',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => Auth::user()->username,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Denied',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Denied',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Has Been Denied');
                    return to_route('outbound-approvalga');
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => Auth::user()->username,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    Mail::send('outbound_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Return to Draft');
                    });
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => Auth::user()->username,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Active',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Active',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Return to Draft');
                    return to_route('outbound-approvalga');
                }
            } else {
                alert()->error('Error', 'Outbound Inventory Already Approved/Denied');
                return to_route('outbound-approvalga');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }
    public function outboundApproved1 (Request $request, $outboundId)
    {
        $status = $request->input('status');
        $dataOutbound=DB::table('t_outbound_inv')->where('t_outbound_inv.idrec', $outboundId)->first();
        $id=$dataOutbound->idrec;
        $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $dataOutbound->id_company)->first();
        $first_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('first_name')->first();
        $last_name = DB::table('m_employees')->where('idemployee', $dataOutbound->idemployee)->pluck('last_name')->first();
        $approvalstat = $dataOutbound->approvalstat;
        $approvedBy = DB::table('users')->where('id', $dataOutbound->approval_to)->pluck('username')->first();
        $email1 = DB::table('users')->where('id', $dataOutbound->created_by)->pluck('real_email')->first();
        $applicant = DB::table('users')->where('real_email', $email1)->pluck('username')->first();
        $token1 = $request->input('token');

        try {
            if ($approvalstat == 'Site Approved') {
                if ($status == 'Approved') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => $approvedBy,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    DB::table('outbound_approve_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    Mail::send('outbound_approve', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Approved');
                    });
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound, $approvedBy){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Approved',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => $approvedBy
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Approved',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Approved',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Has Been Approved');
                    return to_route('outbound.approvepage', [
                        'outboundId' => $outboundId,
                        'token' => $token1
                    ]);
                } else if ($status == 'Denied') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => $approvedBy,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    DB::table('outbound_approve_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    Mail::send('outbound_denied', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Denied');
                    });
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound, $approvedBy){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Denied',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => $approvedBy
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Denied',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Denied',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Has Been Denied');
                    return to_route('outbound.approvepage', [
                        'outboundId' => $outboundId,
                        'token' => $token1
                    ]);
                }else if ($status == 'Return to Draft') {
                    $data = [
                        'logo_filename' => $datacomps->logo_filename,
                        'company' => $datacomps->name,
                        'address' => $datacomps->address,
                        'formDate' => date('d F Y', strtotime($dataOutbound->date)),
                        'outNo' => $dataOutbound->id_outbound,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'approvedby' => $approvedBy,
                        'gtotal' => number_format($dataOutbound->total_qty, 0, ',', '.')
                    ];
                    Mail::send('outbound_draft', $data, function($message) use($email1, $applicant, $datacomps){
                        $message->to($email1, $applicant)->subject(''. $datacomps->name .' - Outbound Inventory Return to Draft');
                    });
                    DB::table('outbound_approve_token')->where('token', $token1)->update([
                        'is_active' => 0
                    ]);
                    DB::transaction(function () use ($request, $outboundId, $dataOutbound, $approvedBy){
                        DB::table('t_outbound_inv')
                        ->where('idrec', $outboundId)
                        ->update([
                            'approvalstat' => 'Draft',
                            'approvaldate' => date('Y-m-d'),
                            'remarks' => $request->input('remarks1'),
                            'approved1by' => $approvedBy
                        ]);
                        DB::table('t_outbound_inv_detail')->where('id_outbound', $dataOutbound->id_outbound)->update([
                            'status' => 'Active',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        DB::table('t_inventory_assets')->where('inout_id', $dataOutbound->id_outbound)->where('id_company', $dataOutbound->id_company)->where('id_warehouse', $dataOutbound->id_warehouse)->update([
                            'status' => 'Active',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    });
                    alert()->success('Success', 'Outbound Inventory Return to Draft');
                    return to_route('outbound.approvepage', [
                        'outboundId' => $outboundId,
                        'token' => $token1
                    ]);
                }
            } else {
                alert()->error('Error', 'Outbound Inventory Already Approved/Denied');
                return to_route('outbound.approvepage', [
                    'outboundId' => $outboundId,
                    'token' => $token1
                ]);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function outboundapprovalto()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-outboundapproval.index', compact('dataChildCompany', 'dataUser'));
    }

    public function outboundapprovaltoonly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataUser = DB::table('users')->select('users.id', 'users.company_id', 'users.username')->orderBy('users.username', 'asc')->get();
        return view('pages.m-approval.m-outboundapproval.listonly', compact('dataChildCompany', 'dataUser'));
    }

    public function outboundapprovaltoDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-outboundapproval.m-approvalto-delete', compact('dataChildCompany'));
    }

    public function outboundapprovaltoEditPage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.m-approval.m-outboundapproval.edit', compact('dataChildCompany'));
    }

    public function outboundapprovaltoCreate(Request $request)
    {
        $approvalian = $request->input('approval_to');
        $company = $request->input('company');

        $uniqueAcc = DB::table('m_approval_outbound')->where('id', $approvalian)->where('id_company', $company)->first();
        if ($uniqueAcc  == null) {
            DB::transaction(function() use($request){
                DB::table('m_approval_outbound')->insert([
                    'id' => $request->input('approval_to'),
                    'id_company' => $request->input('company'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d')
                ]);
            });
            alert()->success('Success', 'Outbound Inventory Approval To Has Been Created');
            return to_route('outboundapprovalto');
        } else {
            alert()->error('Error', 'Outbound Inventory Approval To Already Exist');
            return to_route('outboundapprovalto');
        }
    }

    public function outboundapprovaltoUpdate(Request $request, $id)
    {
        $approvalian = $request->input('approval_to');

        $uniqueAcc = DB::table('m_approval_outbound')->where('id', $approvalian)->first();
            
        if ($request) {
            DB::transaction(function() use($request, $id){
                DB::table('m_approval_outbound')->where('m_approval_outbound.idrec', $id)->update([
                    'id_company' => $request->input('company')
                ]);
            });
            alert()->success('Success', 'Outbound Inventory Approval To Has Been Updated');
            return to_route('outboundapprovalto.editpage');
        } else {
            alert()->error('Error', 'Outbound Inventory Approval To Already Exist');
            return to_route('outboundapprovalto.editpage');
        }
    }

    public function outboundapprovaltoGetData(Request $request)
    {
        $dataApprovaToQuery = DB::table('m_approval_outbound')
        ->leftJoin('users', 'm_approval_outbound.id', 'users.id')
        ->leftJoin('m_child_company', 'm_approval_outbound.id_company', 'm_child_company.id_company')
        ->select('m_approval_outbound.*', 'users.username', 'users.email', 'users.role_name', 'm_child_company.name as companyName');
        // DB::raw('CASE WHEN users.company_id = 0 THEN (SELECT name FROM m_child_company WHERE id_company = 1) ELSE m_child_company.name END as companyName')

        if ($request->input('company') != null){
            $dataApprovaToQuery = $dataApprovaToQuery->where('m_approval_outbound.id_company', $request->company);
        }

        $dataApprovalTo = $dataApprovaToQuery;
        if ($request->ajax()) {
            return DataTables::of($dataApprovalTo)
            ->addColumn('action', function ($dataApprovalTo) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id="'.$dataApprovalTo->idrec.'" data-username="'.$dataApprovalTo->username.'"
                                data-email = "' . $dataApprovalTo->email . '" data-id_company = "' . $dataApprovalTo->id_company . '"
                                
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Outbound Apptoval To</div>
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
            ->addColumn('action1', function ($dataApprovalTo) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id="'.$dataApprovalTo->id.'" data-idrec="'.$dataApprovalTo->idrec.'" data-username = "' . $dataApprovalTo->username . '" data-email = "' . $dataApprovalTo->email . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function outboundapprovaltoDelete($idrec)
    {
        try {
            DB::transaction(function() use($idrec){
                DB::table('m_approval_outbound')->where('idrec', $idrec)->delete();
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Approval to",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function vehicle()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-vehicle.index', compact('dataChildCompany'));
    }

    public function vehicleList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-vehicle.list', compact('dataChildCompany'));
    }

    public function vehicleForm()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
        ->where('m_child_company.id_company', $user)->first();
        return view('pages.ga.data-master.m-vehicle.m-vehicle-form', compact('dataChildCompany', 'fixCompany'));
    }

    public function vehicleEdit()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')
        ->where('m_child_company.id_company', $user)->first();
        return view('pages.ga.data-master.m-vehicle.m-vehicle-edit', compact('dataChildCompany', 'fixCompany'));
    }

    public function vehicleDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-vehicle.m-vehicle-delete', compact('dataChildCompany'));
    }

    public function vehicleCreate(Request $request)
    {
        $vehicle_number = $request->input('vehicle_number');

        $vehicleUnique = DB::table('m_vehicle')->select('vehicle_number')->where('vehicle_number', $vehicle_number)->first();
            
        if ($vehicleUnique == null) {
                DB::table('m_vehicle')->insert([
                    'id_company' => $request->input('company'),
                    'vehicle_type' => $request->input('vehicle_type'),
                    'vehicle_number' => $request->input('vehicle_number'),
                    'engine_number' => $request->input('engine_number'),
                    'frame_number' => $request->input('frame_number'),
                    'active_date' => $request->input('active_date'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'Active'
                ]);
            alert()->success('Success', 'Data Vehicle Has Been Created');
            return to_route('vehicle.form');
        } else {
            alert()->error('Error', 'Data Vehicle Already Exist');
            return to_route('vehicle.form');
        }
    }

    public function vehicleGetData(Request $request)
    {
        $dataVehicleQuery = DB::table('m_vehicle')->leftJoin('m_child_company', 'm_vehicle.id_company', 'm_child_company.id_company')
        ->select('m_vehicle.*', 'm_child_company.name')->where('m_vehicle.status', '=', 'Active')->orderBy('m_vehicle.idrec', 'asc');

        if ($request->input('company') != null){
            $dataVehicleQuery = $dataVehicleQuery->where('m_vehicle.id_company', $request->company);
        }

        if ($request->input('vehicle_type') != null){
            $dataVehicleQuery = $dataVehicleQuery->where('m_vehicle.vehicle_type', $request->vehicle_type);
        }

        $dataVehicle = $dataVehicleQuery;

        if ($request->ajax()) {
            return DataTables::of($dataVehicle)
            ->editColumn('active_date', function ($dataVehicle) {
                return date('Y-m-d', strtotime($dataVehicle->active_date));
            })
            ->addColumn('action', function ($dataVehicle) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_vehicle="'.$dataVehicle->idrec.'" data-vehicle = "' . $dataVehicle->vehicle_number . '"
                                data-engine_number = "' . $dataVehicle->engine_number . '" data-frame_number = "' . $dataVehicle->frame_number . '" data-active_date = "' . $dataVehicle->active_date . '"
                                data-vehicle_type = "' . $dataVehicle->vehicle_type . '" data-id_company = "' . $dataVehicle->id_company . '"
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Vehicle</div>
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
            ->addColumn('action1', function ($dataVehicle) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id_vehicle="'.$dataVehicle->idrec.'" data-vehicle = "' . $dataVehicle->vehicle_number . '"
                        >Delete
                    </button>
                </div>';
            })
            ->addColumn('action2', function ($dataVehicle) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id_vehicle="'.$dataVehicle->idrec.'" data-vehicle_number = "' . $dataVehicle->vehicle_number . '" id="select"
                    >Select</button>
                </div>';
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function vehicleUpdate(Request $request, $idBank)
    {
        $bankir = $request->input('bank1');

        $bankName = DB::table('m_vehicle')->select('vehicle_number')->where('vehicle_number', $bankir)->first();
            
        if ($bankName == null) {
            DB::table('m_vehicle')->where('idrec', $idBank)->update([
                'id_company' => $request->input('company'),
                'vehicle_type' => $request->input('vehicle_type'),
                'vehicle_number' => $request->input('vehicle_number'),
                'engine_number' => $request->input('engine_number'),
                'frame_number' => $request->input('frame_number'),
                'active_date' => $request->input('active_date'),
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    
            alert()->success('Success', 'Vehicle Has Been Updated');
            return to_route('vehicle.edit');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('vehicle.edit');
        }
    }

    public function vehicleDelete($idBank)
    {
        try {
            DB::table('m_vehicle')->where('idrec', $idBank)->update([
                'status' => 'Non Active',
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d')
            ]);
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Vehicle",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
