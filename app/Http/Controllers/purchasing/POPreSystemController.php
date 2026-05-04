<?php

namespace App\Http\Controllers\purchasing;

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

use function PHPUnit\Framework\isNull;

class POPreSystemController extends Controller
{
    public function poForm()
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        $department = DB::table('m_department')->select('*')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $currency = DB::table('currency')->orderBy('currency', 'asc')->get();
        $supplier = DB::table('m_vendors')->where('status', '=', 'ACTIVE')->orderBy('name', 'asc')->get();
        return view('pages.purchasing.po-presystem.form', compact('dataChildCompany','fixCompany', 'department', 'currency', 'supplier'));
    }

    public function poList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.purchasing.po-presystem.polist', compact('dataChildCompany'));
    }

    public function poListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.purchasing.po-presystem.polist-only', compact('dataChildCompany'));
    }

    public function poEdit()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.purchasing.po-presystem.editpolist', compact('dataChildCompany'));
    }
    public function poCreate(Request $request)
    {
        $existInvoice = $request->input('no_invoice');
        $total1 = str_replace('.', '', $request->input('total'));
        $total = str_replace(',', '.', $total1);
        $ppn1 = str_replace('.', '', $request->input('ppn'));
        $ppn = str_replace(',', '.', $ppn1);
        $gtotal1 = str_replace('.', '', $request->input('gtotal'));
        $gtotal = str_replace(',', '.', $gtotal1);
        $wht1 = str_replace('.', '', $request->input('wht'));
        $wht = str_replace(',', '.', $wht1);
        $amount_due1 = str_replace('.', '', $request->input('amount_due'));
        $amount_due = str_replace(',', '.', $amount_due1);
        $crate1 = str_replace('.', '', $request->input('crate'));
        $crate = str_replace(',', '.', $crate1);
        $dataPO = DB::table('t_po')->where('t_po.no_invoice', $existInvoice)->pluck('no_invoice')->first();
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
        $dataVendors = DB::table('m_vendors')->where('idsupplier', $request->input('idsupplier'))->first();
        try {
            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
            if ($dataPO == null) {
                DB::table('t_po')->insert([
                    'id_company' => $request->input('company'),
                    'date_po' => $request->input('date_po'),
                    'due_date' => $request->input('due_date'),
                    'no_po' => $request->input('no_po'),
                    'no_invoice' => $request->input('no_invoice'),
                    'no_rab' => $request->input('no_rab'),
                    'idemployee' => $request->input('idemployee'),
                    'po_title' => $request->input('po_title'),
                    'idsupplier' => $request->input('idsupplier'),
                    'currency' => $request->input('currency'),
                    'crate' => $crate,
                    'total' => $total,
                    'ppn' => $ppn,
                    'gtotal' => $gtotal,
                    'wht' => $wht,
                    'amount_due' => $amount_due,
                    'status' => 'A/P',
                    'file' => $pdf,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id
                ]);
                DB::table('t_costpayment')->insert([
                    'id_costpayment' => $request->input('no_po'),
                    'id_company' => $request->input('company'),
                    'company' => $request->input('companyTest'),
                    'date' => $request->input('date_po'),
                    'due_date' => $request->input('due_date'),
                    'applicant' => $request->input('employee1'),
                    'currency' => $request->input('currency'),
                    'beneficiary_bank' => $dataVendors->bank_name,
                    'beneficiary_acc' => $dataVendors->bank_acc_num,
                    'beneficiary_name' => $dataVendors->bank_acc_name,
                    'crate' => $crate,
                    'subtotal' => $total,
                    'vat' => $ppn,
                    'total' => $gtotal,
                    'wht' => $wht,
                    'total_paid' => $amount_due,
                    'approved_total' => $amount_due,
                    'balance' => $amount_due,
                    'form_type' => 'PO',
                    'status' => 'A/P',
                    'aktifyn' => 'Y',
                    'print_status' => 'N',
                    'npwp_id' => $dataVendors->npwp_id,
                    'npwp_name' => $dataVendors->company_type.' '.$dataVendors->name,
                    'npwp_address' => $dataVendors->npwp_address,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        
                // alert()->success('Success', 'PO Pre System Has Been Created');
                return response()->json(["st" => '1']);
            } else {
                // alert()->error('Error', 'Invoice Already Submitted');
                return response()->json(["st" => '3']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function poListGetData(Request $request)
    {
        $dataPoQuery = DB::table('t_po')->leftJoin('m_child_company', 't_po.id_company', 'm_child_company.id_company')->leftJoin('m_vendors', 't_po.idsupplier', 'm_vendors.idsupplier')->leftJoin('m_employees', 't_po.idemployee', 'm_employees.idemployee')
        ->select('t_po.*', 'm_child_company.name as companyName', 'm_vendors.name as vendorsName', 'm_employees.first_name', 'm_employees.last_name');

        if ($request->input('company') != null){
            $dataPoQuery = $dataPoQuery->where('t_po.id_company', $request->company);
        }

        $dataPo = $dataPoQuery;

        if ($request->ajax()) {
            return DataTables::of($dataPo)
            ->editColumn('date_po', function ($dataPo) {
                return date('Y-m-d', strtotime($dataPo->date_po));
            })
            ->editColumn('first_name', function ($dataPo) {
                return "$dataPo->first_name" . " " . "$dataPo->last_name";
            })
            ->editColumn('total', function ($dataPo) {
                return "" . "" . number_format($dataPo->total, 0, ',', '.');
            })
            ->editColumn('ppn', function ($dataPo) {
                return "" . "" . number_format($dataPo->ppn, 0, ',', '.');
            })
            ->editColumn('gtotal', function ($dataPo) {
                return "" . "" . number_format($dataPo->gtotal, 0, ',', '.');
            })
            ->editColumn('wht', function ($dataPo) {
                return "" . "" . number_format($dataPo->wht, 0, ',', '.');
            })
            ->editColumn('amount_due', function ($dataPo) {
                return "" . "" . number_format($dataPo->amount_due, 0, ',', '.');
            })
            ->addColumn('action', function ($dataPo) {               
                    return '
                    <div class="flex flex-row justify-center"> 
                        <a href = "/purchasing/po-presystem/view/' . $dataPo->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>
                    </div>';     
            })
            ->addColumn('action2', function ($dataPo) {  
                if ($dataPo->status == 'A/P') {                                 
                    return '
                    <div class="flex flex-row justify-center"> 
                    <a href = "/purchasing/po-presystem/updatepage/' . $dataPo->idrec . '" class="btn btn-sm btn-modal text-sm text-white ml-1 bg-amber-500 hover:bg-amber-600"    
                            >Edit</a>
                    </div>';  
                } else {
                    return '
                    <div class="flex flex-row justify-center"> 
                        <a href = "/purchasing/po-presystem/view/' . $dataPo->idrec . '" class="btn btn-sm btn-modal text-sm bg-sky-500 text-white ml-1 hover:bg-sky-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"   
                        >View</a>
                    </div>';   
                }   
        })
            ->rawColumns(['action', 'action2'])
            ->make();
        }
    }

    public function poView($idPO)
    {
        $dataPO = DB::table('t_po')->leftJoin('m_child_company', 't_po.id_company', 'm_child_company.id_company')->leftJoin('m_employees', 't_po.idemployee', 'm_employees.idemployee')->leftJoin('m_vendors', 't_po.idsupplier', 'm_vendors.idsupplier')
        ->select('t_po.*', 'm_child_company.name as companyName', 'm_vendors.name as vendorName', 'm_employees.first_name', 'm_employees.last_name', 'm_employees.department', 'm_employees.position')->where('idrec', $idPO)->first();

        return view('pages.purchasing.po-presystem.view', compact('dataPO'));
    }

    public function viewFile($idPO)
    {
        $dataPO = DB::table('t_po')->where('idrec', $idPO)->select('file', 'no_invoice')->first();
        $filename = $dataPO->no_invoice . '.pdf';
        $filePO = $dataPO->file;

        return Response::make($filePO, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function poUpdatePage($idPO)
    {
        $dataPO = DB::table('t_po')->leftJoin('m_child_company', 't_po.id_company', 'm_child_company.id_company')->leftJoin('m_employees', 't_po.idemployee', 'm_employees.idemployee')->leftJoin('m_vendors', 't_po.idsupplier', 'm_vendors.idsupplier')
        ->select('t_po.*', 'm_child_company.name as companyName', 'm_vendors.name as vendorName', 'm_employees.first_name', 'm_employees.last_name', 'm_employees.department', 'm_employees.position')->where('idrec', $idPO)->first();
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('status', '=','Active')->orderBy('m_child_company.name', 'asc')->get();
        $fixCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        $supplier = DB::table('m_vendors')->where('status', '=', 'ACTIVE')->orderBy('name', 'asc')->get();
        $currency = DB::table('currency')->orderBy('currency', 'asc')->get();

        return view('pages.purchasing.po-presystem.updatepage', compact('dataPO', 'dataChildCompany', 'fixCompany', 'supplier', 'currency'));
    }

    public function poUpdate(Request $request, $idPO)
    {
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
         // Initializing variables
         $noINV = $request->input('no_invoice');
         $companskuy = $request->input('company');
         $po_date = $request->input('date_po');
         $date_due = $request->input('due_date');
         $po_no = $request->input('no_po');
         $rab_no = $request->input('no_rab');
         $employeeid = $request->input('idemployee');
         $title_po = $request->input('po_title');
         $supp = $request->input('id_supplier');
         $curs = $request->input('currency');

         // Formatting numerical input values
         $total1 = str_replace('.', '', $request->input('total'));
         $total = str_replace(',', '.', $total1);
         $ppn1 = str_replace('.', '', $request->input('ppn'));
         $ppn = str_replace(',', '.', $ppn1);
         $gtotal1 = str_replace('.', '', $request->input('gtotal'));
         $gtotal = str_replace(',', '.', $gtotal1);
         $wht1 = str_replace('.', '', $request->input('wht'));
         $wht = str_replace(',', '.', $wht1);
         $amount_due1 = str_replace('.', '', $request->input('amount_due'));
         $amount_due = str_replace(',', '.', $amount_due1);
         $crate1 = str_replace('.', '', $request->input('crate'));
         $crate = str_replace(',', '.', $crate1);

         // Retrieving PO data by ID
         $dataPO = DB::table('t_po')->where('idrec', $idPO)->first();

         // Checking if the invoice already exists
         $existInvoice = DB::table('t_po')->where('no_invoice', $noINV)->first();

         // Checking if there are any differences in the attributes
         $isDifferent = (
             $dataPO->id_company != $companskuy ||
             $dataPO->date_po != $po_date ||
             $dataPO->due_date != $date_due ||
             $dataPO->no_po != $po_no ||
             $dataPO->no_rab != $rab_no ||
             $dataPO->idemployee != $employeeid ||
             $dataPO->po_title != $title_po ||
             $dataPO->idsupplier != $supp ||
             $dataPO->currency != $curs ||
             $dataPO->crate != $crate || 
             $dataPO->total != $total || 
             $dataPO->ppn != $ppn || 
             $dataPO->gtotal != $gtotal || 
             $dataPO->wht != $wht || 
             $dataPO->amount_due != $amount_due 
         );

         $dataPayment = DB::table('t_costpayment')->where('id_costpayment', $dataPO->no_po)->first();
        try {
            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
            if ($existInvoice == null || ($existInvoice->idrec == $idPO && $isDifferent)) {
                if ($dataPO->status == 'A/P') {
                    if ($request->hasFile('file')) {
                        DB::table('t_po')->where('t_po.idrec', $idPO)->update([
                            'id_company' => $request->input('company'),
                            'date_po' => $request->input('date_po'),
                            'due_date' => $request->input('due_date'),
                            'no_po' => $request->input('no_po'),
                            'no_invoice' => $noINV,
                            'no_rab' => $request->input('no_rab'),
                            'idemployee' => $request->input('idemployee'),
                            'po_title' => $request->input('po_title'),
                            'idsupplier' => $request->input('idsupplier'),
                            'currency' => $request->input('currency'),
                            'crate' => $crate,
                            'total' => $total,
                            'ppn' => $ppn,
                            'gtotal' => $gtotal,
                            'wht' => $wht,
                            'amount_due' => $amount_due,
                            'file' => $pdf,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        if ($dataPayment->balance == $dataPayment->total_paid) {
                            DB::table('t_costpayment')->where('id_costpayment', $dataPO->no_po)->update([
                                'id_costpayment' => $request->input('no_po'),
                                'id_company' => $request->input('company'),
                                'company' => $request->input('companyTest'),
                                'date' => $request->input('date_po'),
                                'due_date' => $request->input('due_date'),
                                'applicant' => $request->input('employee1'),
                                'currency' => $request->input('currency'),
                                'crate' => $crate,
                                'subtotal' => $total,
                                'vat' => $ppn,
                                'total' => $gtotal,
                                'wht' => $wht,
                                'total_paid' => $amount_due,
                                'balance' => $amount_due,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->id
                            ]);
                        }
                
                        return response()->json(["st" => '1']);
                    } else {
                        DB::table('t_po')->where('t_po.idrec', $idPO)->update([
                            'id_company' => $request->input('company'),
                            'date_po' => $request->input('date_po'),
                            'due_date' => $request->input('due_date'),
                            'no_po' => $request->input('no_po'),
                            'no_invoice' => $noINV,
                            'no_rab' => $request->input('no_rab'),
                            'idemployee' => $request->input('idemployee'),
                            'po_title' => $request->input('po_title'),
                            'idsupplier' => $request->input('idsupplier'),
                            'currency' => $request->input('currency'),
                            'crate' => $crate,
                            'total' => $total,
                            'ppn' => $ppn,
                            'gtotal' => $gtotal,
                            'wht' => $wht,
                            'amount_due' => $amount_due,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                        if ($dataPayment->balance == $dataPayment->total_paid) {
                            DB::table('t_costpayment')->where('id_costpayment', $dataPO->no_po)->update([
                                'id_costpayment' => $request->input('no_po'),
                                'id_company' => $request->input('company'),
                                'company' => $request->input('companyTest'),
                                'date' => $request->input('date_po'),
                                'due_date' => $request->input('due_date'),
                                'applicant' => $request->input('employee1'),
                                'currency' => $request->input('currency'),
                                'crate' => $crate,
                                'subtotal' => $total,
                                'vat' => $ppn,
                                'total' => $gtotal,
                                'wht' => $wht,
                                'total_paid' => $amount_due,
                                'balance' => $amount_due,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->id
                            ]);
                        }
                
                        return response()->json(["st" => '1']);
                    }
                } else {
                    return response()->json(["st" => '4']);
                }
            } else {
                return response()->json(["st" => '3']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
