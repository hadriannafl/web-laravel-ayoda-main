<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use PhpParser\Node\Stmt\ElseIf_;

class PaymentController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }
    
    public function paymentListOnly()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.finance.payment.list.payment-list-only', compact('dataChildCompany'));
    }

    public function paymentList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.finance.payment.list.payment-list', compact('dataChildCompany'));
    }

    public function payUpdate()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.finance.payment.list.update-payment', compact('dataChildCompany'));
    }

    public function paymentUpdatePage($payId)
    {
        // $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        // $dataCPdetail = DB::table('t_costpayment_detail')->where('idrec', $payId)->first();
        // $dataCP = DB::table('t_costpayment')->where('id_costpayment', $dataCPdetail->id_costpayment)->first();
        // $totalPaidQuery = DB::table('t_costpayment_detail')
        // ->select(DB::raw("SUM(t_costpayment_detail.amount_paid) AS totalis_amount"))
        // ->where('id_costpayment', $dataCP->id_costpayment)
        // ->where('aktifyn', '!=', 'N')
        // ->first();
        // $totalPaid = $totalPaidQuery->totalis_amount;
        // $balanacesss = $dataCP->balance + $dataCPdetail->amount_paid;
        // if ($dataCP->form_type == 'Cost Center') {
        //     $dataDetailCP = DB::table('t_costcenter_detail')
        //     ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
        //     ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
        //     ->where('t_costcenter_detail.idreqform', $dataCP->id_costpayment)->where('t_costcenter_detail.status', '=', 'Active')->get()->toArray();
        // } else{
        //     $dataDetailCP = DB::table('t_reimburse_request_detail')
        //     ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
        //     ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
        //     ->where('t_reimburse_request_detail.idreqform', $dataCP->id_costpayment)->where('t_reimburse_request_detail.status', '=', 'Active')->get()->toArray();
        // }
        // $dataCurrency = DB::table('currency')
        // ->select('*')->get();

        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataHeadCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', '=', '1')->first();
        if ($user == '0' || $user == '1') {
            $dataChildCompany1 = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', '=', '1')->first();
        } else {
            $dataChildCompany1 = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', $user)->first();
        }
        $dataCurrency = DB::table('currency')->select('*')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $cidBank = DB::table('m_cid_bank')->leftJoin('m_bank', 'm_cid_bank.id_bank', 'm_bank.id_bank')->select('m_cid_bank.*', 'm_bank.name as bankName')->where('m_cid_bank.aktifyn', '=', 'Y')->get();
        $dataCPdetail = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->join('m_child_company', 't_costpayment_detail.id_company', 'm_child_company.id_company')
        ->select(
            't_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.id_payment', 't_costpayment_detail.date', 't_costpayment_detail.payment_date', 't_costpayment_detail.payee_date', 't_costpayment_detail.bank_date', 't_costpayment_detail.transaction_number', 't_costpayment_detail.id_company',
            't_costpayment_detail.payment_type', 't_costpayment_detail.currency', 't_costpayment_detail.crate', 't_costpayment_detail.amount_paid', 't_costpayment_detail.companyId', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number', 't_costpayment_detail.file_stat', 't_costpayment_detail.beneficiary_bank',
            't_costpayment_detail.beneficiary_name', 't_costpayment_detail.beneficiary_acc', 't_costpayment_detail.rounding', 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.remarks', 't_costpayment_detail.created_at', 't_costpayment_detail.created_by',
            't_costpayment_detail.checked_by', 't_costpayment_detail.approved_by', 't_costpayment_detail.released_by', 't_costpayment_detail.aktifyn', 't_costpayment_detail.previous_payment',
            't_costpayment.id_company as compss',
            't_costpayment.date as dateForm',
            't_costpayment.due_date',
            't_costpayment.applicant',
            't_costpayment.form_type',
            't_costpayment.currency',
            'm_child_company.name as companyName',
            'm_child_company.address',
            'm_child_company.logo_filename',
            'm_child_company.company_type',
            DB::raw('t_costpayment_detail.amount_paid - t_costpayment_detail.rounding + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge AS total_amount'),
            DB::raw('t_costpayment_detail.amount_paid - t_costpayment_detail.rounding AS beforeRounding')
        )->where('t_costpayment_detail.idrec', $payId)->first();
        $mathPayment = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->select(
            DB::raw('SUM(t_costpayment.balance) AS balancing'),
            DB::raw('SUM(t_costpayment_detail.amount_paid) AS totals_amount'),
            DB::raw('SUM(t_costpayment_detail.amount_paid - t_costpayment_detail.rounding) AS beforeRoundings'),
            DB::raw('SUM(t_costpayment_detail.amount_paid) AS mounts'),
            DB::raw('SUM(t_costpayment_detail.rounding) AS rounds'),
            DB::raw('SUM(t_costpayment_detail.bank_charge) AS charges'),
            DB::raw('SUM(t_costpayment_detail.duty_stamp_charge) AS dutys'),
            DB::raw('SUM(t_costpayment_detail.other_charge) AS others')
        )
        ->where('t_costpayment_detail.id_payment', $dataCPdetail->id_payment)
        ->first();
        $approvespay = $mathPayment->totals_amount + $mathPayment->balancing;
        $totalsAmount = $mathPayment->totals_amount + $dataCPdetail->rounding + $dataCPdetail->bank_charge + $dataCPdetail->duty_stamp_charge + $dataCPdetail->other_charge;
        $dataCPdetail1 = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->select(
            't_costpayment_detail.*', 't_costpayment.date as dateForm',
        )->where('t_costpayment_detail.id_payment', $dataCPdetail->id_payment)->orderBy('idrec', 'asc')->get();
        $dataCPdetail1Count = $dataCPdetail1->count();

        // return view('pages.finance.payment.list.updatepage', compact('dataCP', 'dataCPdetail', 'dataDetailCP', 'dataChildCompany', 'dataCurrency', 'balanacesss', 'totalPaid'));
        return view('pages.finance.payment.list.updatepage', compact('dataChildCompany', 'dataChildCompany1', 'dataHeadCompany','dataCurrency', 'bank', 'cidBank', 'dataCPdetail', 'dataCPdetail1', 'mathPayment', 'dataCPdetail1Count', 'totalsAmount', 'approvespay'));
    }

    public function paymentUpdate(Request $request, $payId)
    {
        // Step 1: Retrieve the most recent idrec for each id_costpayment
        $latestRecordsQuery = DB::table('t_costpayment_detail')
        ->select(DB::raw('MAX(idrec) as latest_idrec'), 'id_costpayment')
        ->where('aktifyn', '=', 'Y')
        ->groupBy('id_costpayment');
    
        // Convert the query into a subquery for easier joining
        $latestRecords = DB::table(DB::raw("({$latestRecordsQuery->toSql()}) as latest_records"))
            ->mergeBindings($latestRecordsQuery)
            ->select('latest_records.latest_idrec')
            ->pluck('latest_idrec')->toArray();

        // Check if payId is in the list of latest records
        if (!in_array($payId, $latestRecords)) {
            alert()->error('Gagal', 'Payment is not latest');
            return to_route('payment-list.payupdate');
        }

        $amount1 = str_replace('.', '', $request->input('amount'));
        $amount = str_replace(',', '.', $amount1);
        $bank_charge1 = str_replace('.', '', $request->input('bank_charge')) ?: 0;
        $bank_charge = str_replace(',', '.', $bank_charge1);
        $duty_stamp_charge1 = str_replace('.', '', $request->input('duty_stamp_charge')) ?: 0;
        $duty_stamp_charge = str_replace(',', '.', $duty_stamp_charge1);
        $other_charge1 = str_replace('.', '', $request->input('other_charge')) ?: 0;
        $other_charge = str_replace(',', '.', $other_charge1);
        $dataCPdetail = DB::table('t_costpayment_detail')->where('idrec', $payId)->first();
        $dataCP = DB::table('t_costpayment')->where('id_costpayment', $dataCPdetail->id_costpayment)->first();
        try {
            if ($dataCPdetail->aktifyn == 'Y' && $amount != '0') {
                if ($dataCPdetail->payment_type == 'A/P') {
                    DB::transaction(function () use ($request, $payId, $dataCP, $dataCPdetail, $bank_charge, $amount, $duty_stamp_charge, $other_charge){
                        DB::table('t_costpayment')->where('id_costpayment', $dataCPdetail->id_costpayment)->update([
                            'balance' => $dataCP->balance + $dataCPdetail->amount_paid - $amount,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->where('idrec', $payId)->update([
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'amount_paid' => $amount,
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'checked_by' => $request->input('checked_by'),
                            'approved_by' => $request->input('approved_by'),
                            'released_by' => $request->input('released_by'),
                        ]);
                    });
                } else {
                    DB::transaction(function () use ($request, $payId, $dataCPdetail, $bank_charge, $amount, $duty_stamp_charge, $other_charge){
                        DB::table('t_costpayment')->where('id_costpayment', $dataCPdetail->id_costpayment)->update([
                            'npwp_id' => $request->input('npwp'),
                            'npwp_name' => $request->input('npwp_name'),
                            'npwp_address' => $request->input('npwp_address'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->where('idrec', $payId)->update([
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'amount_paid' => $amount,
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'checked_by' => $request->input('checked_by'),
                            'approved_by' => $request->input('approved_by'),
                            'released_by' => $request->input('released_by'),
                        ]);
                    });
                }
                alert()->success('Success', 'Payment Has Been Edited');
                return to_route('payment-list.payupdate');
            } else {
                alert()->error('Gagal', 'Payment Not Active or Amount Cannot 0 Value');
                return to_route('payment-list.payupdate');
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function paymentForm(Request $request, $cpId)
    {
        $user = Auth::user()->company_id;
        $dataCP = DB::table('t_costpayment')->where('idrec', $cpId)->first();
        $totalPaidQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw("SUM(t_costpayment_detail.amount_paid) AS totalis_amount"))
            ->where('id_costpayment', $dataCP->id_costpayment)
            ->where('aktifyn', '!=', 'N')
            ->first();
        // $totalPaid = $totalPaidQuery->totalis_amount;
        $totalPaid = $dataCP->approved_total - $dataCP->balance;
        if ($dataCP->form_type == 'Cost Center') {
            $dataDetailCP = DB::table('t_costcenter_detail')
            ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
            ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
            ->where('t_costcenter_detail.idreqform', $dataCP->id_costpayment)->where('t_costcenter_detail.status', '=', 'Active')->get()->toArray();
        } else if ($dataCP->form_type == 'Reimburse'){
            $dataDetailCP = DB::table('t_reimburse_request_detail')
            ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
            ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
            ->where('t_reimburse_request_detail.idreqform', $dataCP->id_costpayment)->where('t_reimburse_request_detail.status', '=', 'Active')->get()->toArray();
        } else if ($dataCP->form_type == 'RAB'){
            $dataDetailCP = DB::table('t_rab_detail')
            ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.rab_calc_type as cost_type', 't_rab_detail.name_rab_detail as desc', 't_rab_detail.total as paid_total', 't_rab_detail.remarks', 't_rab_detail.date_rab as date')
            ->where('t_rab_detail.id_rab', $dataCP->id_costpayment)->where('t_rab_detail.status', '=', 'Active')->get()->toArray();
        }
        $dataHeadCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', '=', '1')->first();
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', $dataCP->id_company)->first();
        $dataCurrency = DB::table('currency')->select('*')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $cidBank = DB::table('m_cid_bank')->leftJoin('m_bank', 'm_cid_bank.id_bank', 'm_bank.id_bank')->select('m_cid_bank.*', 'm_bank.name as bankName')->where('m_cid_bank.aktifyn', '=', 'Y')->get();
        return view('pages.finance.payment.list.form', compact('dataChildCompany', 'dataHeadCompany', 'dataCP', 'dataCurrency', 'dataDetailCP', 'bank', 'cidBank', 'totalPaid'));
    }

    public function formPayment(Request $request)
    {
        $user = Auth::user()->company_id;
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataHeadCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', '=', '1')->first();
        if ($user == '0' || $user == '1') {
            $dataChildCompany1 = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', '=', '1')->first();
        } else {
            $dataChildCompany1 = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('m_child_company.id_company', $user)->first();
        }
        $dataCurrency = DB::table('currency')->select('*')->get();
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        $cidBank = DB::table('m_cid_bank')->leftJoin('m_bank', 'm_cid_bank.id_bank', 'm_bank.id_bank')->select('m_cid_bank.*', 'm_bank.name as bankName')->where('m_cid_bank.aktifyn', '=', 'Y')->get();
        return view('pages.finance.payment.list.multiform', compact('dataChildCompany', 'dataChildCompany1', 'dataHeadCompany','dataCurrency', 'bank', 'cidBank'));
    }

    public function confirmPay()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.finance.payment.list.confirm-payment', compact('dataChildCompany'));
    }

    public function cancelPay()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.finance.payment.list.cancel-payment', compact('dataChildCompany'));
    }

    public function confirmPaymentPage($payId)
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        $dataCPDetail = DB::table('t_costpayment_detail')->select('t_costpayment_detail.*', DB::raw('t_costpayment_detail.amount_paid + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge AS total_amount'))->where('idrec', $payId)->first();
        $id_costpaymet = $dataCPDetail->id_costpayment;
        $dataCP = DB::table('t_costpayment')->where('id_costpayment', $id_costpaymet)->first();
        $totalPaidQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw("SUM(t_costpayment_detail.amount_paid) AS totalis_amount"))
            ->where('id_costpayment', $dataCP->id_costpayment)
            ->where('aktifyn', '!=', 'N')
            ->first();
        $totalPaid = $totalPaidQuery->totalis_amount;
        if ($dataCP->form_type == 'Cost Center') {
            $dataDetailCP = DB::table('t_costcenter_detail')
            ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
            ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
            ->where('t_costcenter_detail.idreqform', $dataCP->id_costpayment)->where('t_costcenter_detail.status', '=', 'Active')->get()->toArray();
        } elseif ($dataCP->form_type == 'Reimburse'){
            $dataDetailCP = DB::table('t_reimburse_request_detail')
            ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
            ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
            ->where('t_reimburse_request_detail.idreqform', $dataCP->id_costpayment)->where('t_reimburse_request_detail.status', '=', 'Active')->get()->toArray();
        }elseif ($dataCP->form_type == 'RAB') {
            $dataDetailCP = DB::table('t_rab_detail')
            ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.name_rab_detail', 't_rab_detail.days',
            't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category', 't_rab_detail.date_rab'
            , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
            ->where('t_rab_detail.id_rab', $dataCP->id_costpayment)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get()->toArray();
        }elseif ($dataCP->form_type == 'PO') {
            $dataDetailCP = DB::table('t_po')
            ->select('t_po.idrec', 't_po.id_company', 't_po.date_po', 't_po.due_date', 't_po.no_po', 't_po.no_invoice', 't_po.no_rab', 't_po.idemployee', 't_po.po_title', 't_po.idsupplier', 't_po.currency', 't_po.crate', 't_po.total',
            't_po.ppn', 't_po.gtotal', 't_po.wht', 't_po.amount_due', 't_po.status', 't_po.created_at', 't_po.created_by', 't_po.updated_at', 't_po.updated_by',)->where('t_po.no_po', $dataCP->id_costpayment)->get()->toArray();
        }
        $mathPayment = DB::table('t_costpayment_detail')
        ->select(
            DB::raw('SUM(t_costpayment_detail.amount_paid + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge) AS totals_amount'),
            DB::raw('SUM(t_costpayment_detail.amount_paid + t_costpayment_detail.rounding) AS beforeRoundings'),
            DB::raw('SUM(t_costpayment_detail.rounding) AS rounds'),
            DB::raw('SUM(t_costpayment_detail.bank_charge) AS charges'),
            DB::raw('SUM(t_costpayment_detail.duty_stamp_charge) AS dutys'),
            DB::raw('SUM(t_costpayment_detail.other_charge) AS others')
        )
        ->where('t_costpayment_detail.id_payment', $dataCPDetail->id_payment)
        ->first();
        $dataCPdetail1 = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->select(
            't_costpayment_detail.*', 't_costpayment.date as dateForm',
        )->where('t_costpayment_detail.id_payment', $dataCPDetail->id_payment)->get();
        return view('pages.finance.payment.list.confirm-page', compact('dataChildCompany', 'dataCP', 'dataDetailCP', 'dataCPDetail', 'totalPaid', 'dataCPdetail1', 'mathPayment'));
    }

    public function paymentCreate(Request $request)
    {
        $company = $request->input('company_id');
        $payfrom = $request->input('payfrom');
        $pv_code = DB::table('m_cid_bank')->where('id_cidb', $payfrom)->pluck('pv_code')->first();
        $initials = DB::table('m_child_company')->select('initials', 'name')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('dates');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/PV/';
        $indicator1 = $yearNowSubstring . $mm . '/' . $initials . '' . $pv_code . '/PV/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_costpayment_detail')
            ->where('id_payment', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();
        $maxIdRecord1 = DB::table('t_costpayment_detail')
            ->where('id_payment', 'like', $indicator1 . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($pv_code) || $dateInput < date('2024-09-01')) {
            if (is_null($maxIdRecord)) {
                $PVID = $indicator . '1';
            } else {
                $maxId = $maxIdRecord->id_payment;
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
    
                $PVID = $indicator . $countIndicator;
            }
        } else{
            if (is_null($maxIdRecord1)) {
                $PVID = $indicator1 . '1';
            } else {
                $maxId = $maxIdRecord1->id_payment;
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
    
                $PVID = $indicator1 . $countIndicator;
            }
        }
        $cpId = $request->input('single_costpayment');
        $dataCP = DB::table('t_costpayment')->select('*')->where('t_costpayment.id_costpayment', $cpId)->first();
        // $maxId = DB::table('t_costpayment_detail')
        // ->max('idrec');

        // if (is_null($maxId)) {
        //     $id = 1;
        // } else {
        //     $runningNumber = $maxId;
        //     $id = $runningNumber + 1;
        // }
        $amount1 = str_replace('.', '', $request->input('amount'));
        $amount = str_replace(',', '.', $amount1);
        $bank_charge1 = str_replace('.', '', $request->input('bank_charge')) ?: 0;
        $bank_charge = str_replace(',', '.', $bank_charge1);
        $duty_stamp_charge1 = str_replace('.', '', $request->input('duty_stamp_charge')) ?: 0;
        $duty_stamp_charge = str_replace(',', '.', $duty_stamp_charge1);
        $other_charge1 = str_replace('.', '', $request->input('other_charge')) ?: 0;
        $other_charge = str_replace(',', '.', $other_charge1);
        $round1 = str_replace('.', '', $request->input('lessRounding')) ?: 0;
        $round = str_replace(',', '.', $round1);
        $gtotal = $request->input('grandtotal1');
        
        $previousePaymentQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw("SUM(t_costpayment_detail.amount_paid + t_costpayment_detail.rounding) AS total_amount"))
            ->where('id_costpayment', $dataCP->id_costpayment)
            ->where('aktifyn', '!=', 'N')
            ->first();

        if (is_null($previousePaymentQuery)) {
            $previousePayment = '0';
        } else {
            $previousePayment = $dataCP->approved_total - $dataCP->balance;
        }
        $rowsProducts = $request->get('rows');
        
        try {
            if (is_array($rowsProducts) && count($rowsProducts) > 1) {
                if (is_array($rowsProducts) && count($rowsProducts) > 1 && ($amount < $gtotal)) {
                    return response()->json(["st" => '3']);
                }
                $allSuccess = true; // Flag to track success of all operations

                DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment, $round, $rowsProducts, &$allSuccess) {
                    foreach ($rowsProducts as $key) {
                        $paymentBalance = DB::table('t_costpayment')
                            ->where('id_costpayment', $key['ids'])
                            ->value('balance');

                        $previousePaymentssQuery = DB::table('t_costpayment_detail')
                            ->select(DB::raw("SUM(t_costpayment_detail.amount_paid) AS total_amount"))
                            ->where('id_costpayment', $key['ids'])
                            ->where('aktifyn', '!=', 'N')
                            ->first();

                        if (is_null($previousePaymentssQuery) || $previousePaymentssQuery->total_amount == null) {
                            $prevPay = '0';
                        } else {
                            // Menghitung previous payment berdasarkan approved_total dan balance
                            $prevPay = $previousePaymentssQuery->total_amount;
                        }

                        if ($paymentBalance === null || $paymentBalance < $key['totals']) {
                            $allSuccess = false; // Set flag to false if any condition fails
                            return false; // Rollback transaction
                        }

                        // Continue with the update and insertion if balance is sufficient
                        if ($amount != '0') {
                            DB::table('t_costpayment')->where('id_costpayment', $key['ids'])->update([
                                'npwp_id' => $request->input('npwp'),
                                'npwp_name' => $request->input('npwp_name'),
                                'npwp_address' => $request->input('npwp_address'),
                                'balance' => $key['balances'] - $key['totals'],
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->id
                            ]);
        
                            DB::table('t_costpayment_detail')->insert([
                                'id_costpayment' => $key['ids'],
                                'id_payment' => $PVID,
                                'date' => $request->input('dates'),
                                'payment_date' => $request->input('payment_date'),
                                'id_company' => $request->input('company_id'),
                                'payment_type' => $request->input('payment_type'),
                                'currency' => $request->input('currency'),
                                'crate' => $key['crates'],
                                'amount_paid' => $key['totals'],
                                'companyId' => $request->input('companyID'),
                                'payee_bank' => $request->input('payee_bank'),
                                'payee_number' => $request->input('payee_acc'),
                                'beneficiary_bank' => $dataCP->beneficiary_bank,
                                'beneficiary_name' => $dataCP->beneficiary_name,
                                'beneficiary_acc' => $dataCP->beneficiary_acc,
                                'rounding' => $round,
                                'bank_charge' => $bank_charge,
                                'duty_stamp_charge' => $duty_stamp_charge,
                                'other_charge' => $other_charge,
                                'remarks' => $key['descs'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'checked_by' => $request->input('checked_by'),
                                'approved_by' => $request->input('approved_by'),
                                'released_by' => $request->input('released_by'),
                                'created_by' => Auth::user()->id,
                                'aktifyn' => 'Y',
                                // 'print_status' => 'N',
                                'previous_payment' => $prevPay
                            ]);
                        }
                    }
                });

                if ($allSuccess) {
                    alert()->success('Success', 'Payment Form Detail #' . $PVID . ' Has Been Created');
                    return response()->json(["st" => '1']);
                } else {
                    return response()->json(["st" => '4']);
                }
                // DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment, $round, $rowsProducts){
                //     foreach ($rowsProducts as $key) {
                //         $paymentBalance = DB::table('t_costpayment')->where('id_costpayment', $key['ids'])->pluck(['balance'])->first();
                //         if ($paymentBalance >= $key['totals'] && $amount != '0') {
                //             DB::table('t_costpayment')->where('id_costpayment', $key['ids'])->update([
                //                 'npwp_id' => $request->input('npwp'),
                //                 'npwp_name' => $request->input('npwp_name'),
                //                 'npwp_address' => $request->input('npwp_address'),
                //                 'balance' => $key['balances'] - $key['totals'],
                //                 'updated_at' => date('Y-m-d H:i:s'),
                //                 'updated_by' => Auth::user()->username
                //             ]);
        
                //             DB::table('t_costpayment_detail')->insert([
                //                 'id_costpayment' => $key['ids'],
                //                 'id_payment' => $PVID,
                //                 'date' => $request->input('dates'),
                //                 'payment_date' => $request->input('payment_date'),
                //                 'id_company' => $request->input('company_id'),
                //                 'payment_type' => $request->input('payment_type'),
                //                 'currency' => $request->input('currency'),
                //                 'crate' => $key['crates'],
                //                 'amount_paid' => $key['totals'],
                //                 'companyId' => $request->input('companyID'),
                //                 'payee_bank' => $request->input('payee_bank'),
                //                 'payee_number' => $request->input('payee_acc'),
                //                 'beneficiary_bank' => $dataCP->beneficiary_bank,
                //                 'beneficiary_name' => $dataCP->beneficiary_name,
                //                 'beneficiary_acc' => $dataCP->beneficiary_acc,
                //                 'rounding' => $round,
                //                 'bank_charge' => $bank_charge,
                //                 'duty_stamp_charge' => $duty_stamp_charge,
                //                 'other_charge' => $other_charge,
                //                 'remarks' => $key['descs'],
                //                 'created_at' => date('Y-m-d H:i:s'),
                //                 'checked_by' => $request->input('checked_by'),
                //                 'approved_by' => $request->input('approved_by'),
                //                 'released_by' => $request->input('released_by'),
                //                 'created_by' => Auth::user()->username,
                //                 'aktifyn' => 'Y',
                //                 // 'print_status' => 'N',
                //                 'previous_payment' => $previousePayment
                //             ]);
                //             alert()->success('Success', 'Payment Form Detail #' . $PVID . ' Has Been Created');
                //             return response()->json(["st" => '1']);
                //         }elseif ($paymentBalance < $key['totals'] && $amount != '0') {
                //             return response()->json(["st" => '4']);
                //         }elseif ($amount != '0') {
                //             return response()->json(["st" => '2']);
                //         }
                //     }
                // });
            }
            if (is_array($rowsProducts) && count($rowsProducts) === 1) {
                if ($dataCP->balance >= $amount && $amount != '0') {
                    DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment, $round, $rowsProducts){
                        foreach ($rowsProducts as $key) {
                            DB::table('t_costpayment')->where('id_costpayment', $key['ids'])->update([
                                'npwp_id' => $request->input('npwp'),
                                'npwp_name' => $request->input('npwp_name'),
                                'npwp_address' => $request->input('npwp_address'),
                                'balance' => $dataCP->balance - $amount,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->id
                            ]);
        
                            DB::table('t_costpayment_detail')->insert([
                                'id_costpayment' => $key['ids'],
                                'id_payment' => $PVID,
                                'date' => $request->input('dates'),
                                'payment_date' => $request->input('payment_date'),
                                'id_company' => $request->input('company_id'),
                                'payment_type' => $request->input('payment_type'),
                                'currency' => $request->input('currency'),
                                'crate' => $dataCP->crate,
                                'amount_paid' => $amount,
                                'companyId' => $request->input('companyID'),
                                'payee_bank' => $request->input('payee_bank'),
                                'payee_number' => $request->input('payee_acc'),
                                'beneficiary_bank' => $dataCP->beneficiary_bank,
                                'beneficiary_name' => $dataCP->beneficiary_name,
                                'beneficiary_acc' => $dataCP->beneficiary_acc,
                                'rounding' => $round,
                                'bank_charge' => $bank_charge,
                                'duty_stamp_charge' => $duty_stamp_charge,
                                'other_charge' => $other_charge,
                                'remarks' => $key['descs'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'checked_by' => $request->input('checked_by'),
                                'approved_by' => $request->input('approved_by'),
                                'released_by' => $request->input('released_by'),
                                'created_by' => Auth::user()->id,
                                'aktifyn' => 'Y',
                                // 'print_status' => 'N',
                                'previous_payment' => $previousePayment
                            ]);
                        }
                    });
                    alert()->success('Success', 'Payment Form Detail #' . $PVID . ' Has Been Created');
                    // return to_route('payment-listonly');
                    return response()->json(["st" => '1']);
                }elseif ($dataCP->balance < $amount && $amount != '0') {
                    return response()->json(["st" => '0']);
                }elseif ($amount == '0') {
                    return response()->json(["st" => '2']);
                }
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function paymentCreates(Request $request, $cpId)
    {
        $company = $request->input('company_id');  
        $initials = DB::table('m_child_company')->select('initials', 'name')->where('id_company', $company)->first();
        $initials = $initials ? $initials->initials : null;

        if (!$initials) {
            // Tangani kasus jika $initials tidak ditemukan
        }

        $dateInput = $request->input('dates');
        $mm = date('m', strtotime($dateInput));
        $yearNow = date('Y', strtotime($dateInput));
        $yearNowSubstring = substr($yearNow, -2);

        $indicator = $yearNowSubstring . $mm . '/' . $initials . '/PV/';

        // Lakukan kueri untuk mencari nilai maksimal
        $maxIdRecord = DB::table('t_costpayment_detail')
            ->where('id_payment', 'like', $indicator . '%')
            ->orderBy('idrec', 'desc')
            ->first();

        if (is_null($maxIdRecord)) {
            $PVID = $indicator . '1';
        } else {
            $maxId = $maxIdRecord->id_payment;
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

            $PVID = $indicator . $countIndicator;
        }
        $dataCP = DB::table('t_costpayment')->select('*')->where('t_costpayment.idrec', $cpId)->first();
        $maxId = DB::table('t_costpayment_detail')
        ->max('idrec');

        if (is_null($maxId)) {
            $id = 1;
        } else {
            $runningNumber = $maxId;
            $id = $runningNumber + 1;
        }
        $amount1 = str_replace('.', '', $request->input('amount'));
        $amount = str_replace(',', '.', $amount1);
        $bank_charge1 = str_replace('.', '', $request->input('bank_charge')) ?: 0;
        $bank_charge = str_replace(',', '.', $bank_charge1);
        $duty_stamp_charge1 = str_replace('.', '', $request->input('duty_stamp_charge')) ?: 0;
        $duty_stamp_charge = str_replace(',', '.', $duty_stamp_charge1);
        $other_charge1 = str_replace('.', '', $request->input('other_charge')) ?: 0;
        $other_charge = str_replace(',', '.', $other_charge1);
        $round1 = str_replace('.', '', $request->input('lessRounding')) ?: 0;
        $round = str_replace(',', '.', $round1);
        
        $previousePaymentQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw("SUM(t_costpayment_detail.amount_paid) AS total_amount"))
            ->where('id_costpayment', $dataCP->id_costpayment)
            ->where('aktifyn', '!=', 'N')
            ->first();

        if (is_null($previousePaymentQuery)) {
            $previousePayment = '0';
        } else {
            $previousePayment = $dataCP->approved_total - $dataCP->balance;
        }
        
        try {
            if ($dataCP->balance >= $amount && $amount != '0') {
                if ($request->input('payment_type') == 'A/P') {
                    DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment, $round){
                        // dd($previousePayment);
                        DB::table('t_costpayment')->where('idrec', $cpId)->update([
                            'npwp_id' => $request->input('npwp'),
                            'npwp_name' => $request->input('npwp_name'),
                            'npwp_address' => $request->input('npwp_address'),
                            'balance' => $dataCP->balance - $amount - $round,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->insert([
                            'id_costpayment' => $dataCP->id_costpayment,
                            'id_payment' => $PVID,
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'id_company' => $request->input('company_id'),
                            'payment_type' => $request->input('payment_type'),
                            'currency' => $request->input('currency'),
                            'crate' => $dataCP->crate,
                            'amount_paid' => $amount,
                            'companyId' => $request->input('companyID'),
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'beneficiary_bank' => $dataCP->beneficiary_bank,
                            'beneficiary_name' => $dataCP->beneficiary_name,
                            'beneficiary_acc' => $dataCP->beneficiary_acc,
                            'rounding' => $round,
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'checked_by' => $request->input('checked_by'),
                            'approved_by' => $request->input('approved_by'),
                            'released_by' => $request->input('released_by'),
                            'created_by' => Auth::user()->username,
                            'aktifyn' => 'Y',
                            // 'print_status' => 'N',
                            'previous_payment' => $previousePayment
                        ]);
                    });
                }else {
                    DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment){
                        DB::table('t_costpayment')->where('idrec', $cpId)->update([
                            'npwp_id' => $request->input('npwp'),
                            'npwp_name' => $request->input('npwp_name'),
                            'npwp_address' => $request->input('npwp_address'),
                            'balance_wht' => $request->input('balances'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->insert([
                            'id_costpayment' => $dataCP->id_costpayment,
                            'id_payment' => $PVID,
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'id_company' => $request->input('company_id'),
                            'payment_type' => $request->input('payment_type'),
                            'currency' => $request->input('currency'),
                            'crate' => $dataCP->crate,
                            'amount_paid' => $amount,
                            'companyId' => $request->input('companyID'),
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'beneficiary_bank' => $dataCP->beneficiary_bank,
                            'beneficiary_name' => $dataCP->beneficiary_name,
                            'beneficiary_acc' => $dataCP->beneficiary_acc,
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'checked_by' => $request->input('checked_by'),
                            'approved_by' => $request->input('approved_by'),
                            'released_by' => $request->input('released_by'),
                            'created_by' => Auth::user()->username,
                            'aktifyn' => 'Y',
                            // 'print_status' => 'N',
                            'previous_payment' => $previousePayment
                        ]);
                    });
                }
                alert()->success('Success', 'Payment Form Detail Has Been Created');
                return to_route('payment-listonly');
                // return response()->json(["st" => '1']);
            } elseif ($dataCP->balance_wht >= $amount && $amount != '0'){
                if ($request->input('payment_type') == 'A/P') {
                    DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge, $previousePayment){
                        DB::table('t_costpayment')->where('idrec', $cpId)->update([
                            'npwp_id' => $request->input('npwp'),
                            'npwp_name' => $request->input('npwp_name'),
                            'npwp_address' => $request->input('npwp_address'),
                            'balance' => $request->input('balances'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->insert([
                            'id_costpayment' => $dataCP->id_costpayment,
                            'id_payment' => $PVID,
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'id_company' => $request->input('company_id'),
                            'payment_type' => $request->input('payment_type'),
                            'currency' => $request->input('currency'),
                            'crate' => $dataCP->crate,
                            'amount_paid' => $amount,
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'beneficiary_bank' => $dataCP->beneficiary_bank,
                            'beneficiary_name' => $dataCP->beneficiary_name,
                            'beneficiary_acc' => $dataCP->beneficiary_acc,
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => Auth::user()->username,
                            'aktifyn' => 'Y',
                            // 'print_status' => 'N',
                            'previous_payment' => $previousePayment
                        ]);
                    });
                }else {
                    DB::transaction(function () use ($request, $cpId, $dataCP, $bank_charge, $PVID, $amount, $duty_stamp_charge, $other_charge){
                        DB::table('t_costpayment')->where('idrec', $cpId)->update([
                            'npwp_id' => $request->input('npwp'),
                            'npwp_name' => $request->input('npwp_name'),
                            'npwp_address' => $request->input('npwp_address'),
                            'balance_wht' => $request->input('balances'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->username
                        ]);

                        DB::table('t_costpayment_detail')->insert([
                            'id_costpayment' => $dataCP->id_costpayment,
                            'id_payment' => $PVID,
                            'date' => $request->input('dates'),
                            'payment_date' => $request->input('payment_date'),
                            'id_company' => $request->input('company_id'),
                            'payment_type' => $request->input('payment_type'),
                            'currency' => $request->input('currency'),
                            'crate' => $dataCP->crate,
                            'amount_paid' => $amount,
                            'payee_bank' => $request->input('payee_bank'),
                            'payee_number' => $request->input('payee_acc'),
                            'beneficiary_bank' => $dataCP->beneficiary_bank,
                            'beneficiary_name' => $dataCP->beneficiary_name,
                            'beneficiary_acc' => $dataCP->beneficiary_acc,
                            'bank_charge' => $bank_charge,
                            'duty_stamp_charge' => $duty_stamp_charge,
                            'other_charge' => $other_charge,
                            'remarks' => $request->input('remarks'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => Auth::user()->username,
                            'aktifyn' => 'Y',
                            // 'print_status' => 'N',

                        ]);
                    });
                }
                alert()->success('Success', 'Payment Form Detail Has Been Created');
                // return to_route('payment-listonly');
                return response()->json(["st" => '1']);
            }elseif ($dataCP->balance < $amount && $amount != '0') {
                return response()->json(["st" => '0']);
            }elseif ($dataCP->balance_wht < $amount && $amount != '0') {
                return response()->json(["st" => '0']);
            }elseif ($amount == '0') {
                return response()->json(["st" => '2']);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    // public function confirmPayment(Request $request, $payId)
    // {
    //     $dataCPDetail = DB::table('t_costpayment_detail')->where('idrec', $payId)->first();
    //     $id_costpayment = $dataCPDetail->id_costpayment;
    //     $id_payment = $dataCPDetail->id_payment;
    //     $dataCP = DB::table('t_costpayment')->where('id_costpayment', $id_costpayment)->first();
    //     if ($request->hasFile('files')) {
    //         $filePdf = $request->file('files'); 
    //         if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
    //             alert()->error('Error', 'File to Large, Please compress File');
    //             return response()->json(["st" => '2']);
    //         } 
    //         $file = base64_encode($filePdf->openFile()->fread($filePdf->getSize()));
    //     } else {
    //        $file = null;
    //     }
    //     // && $dataCP->balance_wht == '0'
    //     try {
    //             if ($dataCP->balance == '0') {
    //                 if ($dataCPDetail->aktifyn == 'F') {
    //                     DB::transaction(function () use ($id_costpayment, $id_payment, $payId, $file, $request){
    //                         DB::table('t_costpayment')->where('id_costpayment', $id_costpayment)->update([
    //                             'status' => 'Paid'
    //                         ]);
    //                         DB::table('t_costpayment_detail')->where('id_payment', $id_payment)->update([
    //                             'aktifyn' => 'P',
    //                             'file' => $file,
    //                             'file_stat' => '1',
    //                             // 'payee_date' => $request->input('payee_date'),
    //                             'bank_date' => $request->input('bank_date'),
    //                             'transaction_number' => $request->input('transactions')
    //                         ]);
    //                     });
    //                     alert()->success('Success', 'Payment Has Been Submitted');
    //                     return response()->json(["st" => '1']);
    //                 } else {
    //                     alert()->error('Error', 'Payment Already Submitted');
    //                     return response()->json(["st" => '3']);
    //                 }
    //             }else {
    //                 if ($dataCPDetail->aktifyn == 'F') {
    //                     DB::transaction(function () use ($id_costpayment, $id_payment, $payId, $file, $request){
    //                         DB::table('t_costpayment')->where('id_payment', $id_payment)->update([
    //                             'status' => 'Partial'
    //                         ]);
    //                         DB::table('t_costpayment_detail')->where('id_payment', $id_payment)->update([
    //                             'aktifyn' => 'P',
    //                             'file' => $file,
    //                             'file_stat' => '1',
    //                             // 'payee_date' => $request->input('payee_date'),
    //                             'bank_date' => $request->input('bank_date'),
    //                             'transaction_number' => $request->input('transactions')
    //                         ]);
    //                     });
    //                     alert()->success('Success', 'Payment Has Been Submitted');
    //                     return response()->json(["st" => '1']);
    //                 } else {
    //                     alert()->error('Error', 'Payment Already Submitted');
    //                     return response()->json(["st" => '3']);
    //                 }
    //             }
    //         DB::commit();
    //     } catch (Exception $ex) {
    //         DB::rollback();
    //         return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
    //     }
    // }

    public function confirmPayment(Request $request, $payId)
    {
        $dataCPDetail = DB::table('t_costpayment_detail')->where('idrec', $payId)->first();
        $id_payment = $dataCPDetail->id_payment;

        // Ambil semua id_costpayment yang terkait dengan id_payment
        $id_costpayments = DB::table('t_costpayment_detail')
            ->where('id_payment', $id_payment)
            ->pluck('id_costpayment'); // Dapatkan semua id_costpayment sebagai array

        if ($request->hasFile('files')) {
            $filePdf = $request->file('files');
            if ($filePdf->getSize() > 12582912) { // 5 MB in bytes
                alert()->error('Error', 'File too large, please compress file');
                return response()->json(["st" => '2']);
            }
            $file = $filePdf->openFile()->fread($filePdf->getSize());
        } else {
            $file = null;
        }

        try {
            // if ($filePdf === null) {
            //     return response()->json(["st" => '2']);
            // }
            DB::transaction(function () use ($dataCPDetail, $id_costpayments, $id_payment, $file, $request) {
                foreach ($id_costpayments as $id_costpayment) {
                    // Ambil dataCP untuk setiap id_costpayment
                    $dataCP = DB::table('t_costpayment')->where('id_costpayment', $id_costpayment)->first();

                    if ($dataCP->balance == '0') {
                        if ($dataCPDetail->aktifyn == 'F') {
                            DB::table('t_costpayment')->where('id_costpayment', $id_costpayment)->update([
                                'status' => 'Paid'
                            ]);
                        } else {
                            alert()->error('Error', 'Payment already submitted');
                            return response()->json(["st" => '3']);
                        }
                    } else {
                        if ($dataCPDetail->aktifyn == 'F') {
                            DB::table('t_costpayment')->where('id_costpayment', $id_costpayment)->update([
                                'status' => 'Partial'
                            ]);
                        } else {
                            alert()->error('Error', 'Payment already submitted');
                            return response()->json(["st" => '3']);
                        }
                    }

                    // Update data di t_costpayment_detail
                    DB::table('t_costpayment_detail')->where('id_payment', $id_payment)->update([
                        'aktifyn' => 'P',
                        'file' => $file,
                        'file_stat' => '1',
                        'bank_date' => $request->input('bank_date'),
                        'transaction_number' => $request->input('transactions')
                    ]);
                }
            });

            alert()->success('Success', 'Payment has been submitted');
            return response()->json(["st" => '1']);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(["st" => '0', 'error' => $ex->getMessage()]);
        }
    }

    public function paymentListGetData(Request $request)
    {
        $startdate = $request->input('from');
        $enddate = $request->input('to');
        $dataCostPaymentQuery = DB::table('t_costpayment')
        ->leftJoin('users', 't_costpayment.created_by', 'users.id')
        ->leftJoin('m_bank', 't_costpayment.beneficiary_bank', 'm_bank.id_bank')
        ->leftJoin('m_child_company', 't_costpayment.id_company', 'm_child_company.id_company')
        ->leftJoin('t_rab', 't_costpayment.id_costpayment', 't_rab.id_rab')
        ->leftJoin('t_costcenter', 't_costpayment.id_costpayment', 't_costcenter.idreqform')
        ->leftJoin('t_reimburse_request', 't_costpayment.id_costpayment', 't_reimburse_request.idreqform')
        ->leftJoin('t_po', 't_costpayment.id_costpayment', 't_po.no_po')
        ->select(
            't_costpayment.*',
            'users.username',
            'm_child_company.name as companyName',
            't_costcenter.idsupplier',
            't_costcenter.department',
            't_rab.name_rab',
            't_po.po_title',
            'm_bank.name as bankName'
        )->where('t_costpayment.aktifyn', '=', 'Y');

        if ($startdate && $enddate) {
            $dataCostPaymentQuery->whereDate('t_costpayment.date', '>=', $startdate)
                ->whereDate('t_costpayment.date', '<=', $enddate);
        }

        if ($request->input('company')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.id_company', $request->company);
        }
        if ($request->input('status')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.status', $request->status);
        }else {
            if ($request->input('company')){
                $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.id_company', $request->company);
            }
            $dataCostPaymentQuery = $dataCostPaymentQuery->where(function ($query) {
                $query->where('t_costpayment.status', '=', 'A/P')->orWhere('t_costpayment.status', '=', 'Partial');
            });
        }

        $dataCostPayment = $dataCostPaymentQuery->where('t_costpayment.aktifyn', '=', 'Y');

        if ($request->ajax()) {
            return DataTables::of($dataCostPayment)
            ->editColumn('due_date', function ($dataCostPayment) {
                if ($dataCostPayment->due_date) {
                    return date('Y-m-d', strtotime($dataCostPayment->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPayment) {
                if (is_numeric($dataCostPayment->created_by)) {
                    return $dataCostPayment->username;
                } else {
                    return $dataCostPayment->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPayment) {
                return date('Y-m-d', strtotime($dataCostPayment->date));
            })
            ->editColumn('subtotal', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->subtotal, 0, ',', '.');
            })
            ->editColumn('vat', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->vat, 0, ',', '.');
            })
            ->editColumn('total', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total, 0, ',', '.');
            })
            ->editColumn('wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->wht, 0, ',', '.');
            })
            ->editColumn('total_paid', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPayment) {
                if ($dataCostPayment->status == 'Paid' || $dataCostPayment->balance == '0') {                    
                    return '
                    <div class="flex flex-row justify-center"> 
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cp="'.$dataCostPayment->id_costpayment.'" data-id="'.$dataCostPayment->idrec.'"
                                data-company = "' . $dataCostPayment->company . '" data-form_type = "' . $dataCostPayment->form_type . '" data-date ="'.$dataCostPayment->date.'" data-due_date ="'.$dataCostPayment->due_date.'" data-status = "' . $dataCostPayment->status . '"
                                data-approved_total="'.$dataCostPayment->approved_total.'" data-dp_amount="'.$dataCostPayment->dp_amount.'" data-applicant = "' . $dataCostPayment->applicant . '" data-currency = "' . $dataCostPayment->currency . '" data-crate = "' . $dataCostPayment->crate . '" data-subtotal = "' . $dataCostPayment->subtotal . '" data-vat="'.$dataCostPayment->vat.'" data-total="'.$dataCostPayment->total.'" data-wht="'.$dataCostPayment->wht.'" data-total_paid="'.$dataCostPayment->total_paid.'"
                                data-beneficiary_bank = "'.$dataCostPayment->beneficiary_bank.'" data-beneficiary_name = "'.$dataCostPayment->beneficiary_name.'" data-beneficiary_acc = "'.$dataCostPayment->beneficiary_acc.'" data-balance="'.$dataCostPayment->balance.'" data-balance_wht="'.$dataCostPayment->balance_wht.'" data-created_by="'.$dataCostPayment->created_by.'"
                            >View Detail</button>
                            
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
                                            <div class="font-semibold text-slate-800 text-sm">View Detail</div>
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
                            <button  class="btn btn-sm btn-pay text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cp="'.$dataCostPayment->id_costpayment.'" data-id="'.$dataCostPayment->idrec.'"
                                data-company = "' . $dataCostPayment->company . '" data-form_type = "' . $dataCostPayment->form_type . '" data-date ="'.$dataCostPayment->date.'" data-due_date ="'.$dataCostPayment->due_date.'" data-status = "' . $dataCostPayment->status . '"
                                data-approved_total="'.$dataCostPayment->approved_total.'" data-dp_amount="'.$dataCostPayment->dp_amount.'" data-applicant = "' . $dataCostPayment->applicant . '" data-currency = "' . $dataCostPayment->currency . '" data-crate = "' . $dataCostPayment->crate . '" data-subtotal = "' . $dataCostPayment->subtotal . '" data-vat="'.$dataCostPayment->vat.'" data-total="'.$dataCostPayment->total.'" data-wht="'.$dataCostPayment->wht.'" data-total_paid="'.$dataCostPayment->total_paid.'"
                                data-beneficiary_bank = "'.$dataCostPayment->beneficiary_bank.'" data-beneficiary_name = "'.$dataCostPayment->beneficiary_name.'" data-beneficiary_acc = "'.$dataCostPayment->beneficiary_acc.'" data-balance="'.$dataCostPayment->balance.'" data-balance_wht="'.$dataCostPayment->balance_wht.'" data-created_by="'.$dataCostPayment->created_by.'"
                            >Payment History</button>
                            
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
                                            <div class="font-semibold text-slate-800 text-sm">View Payment History</div>
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
                }elseif ($dataCostPayment->status == 'Partial') {
                    return '
                    <div class="flex flex-row justify-center"> 
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cp="'.$dataCostPayment->id_costpayment.'" data-id="'.$dataCostPayment->idrec.'"
                                data-company = "' . $dataCostPayment->company . '" data-form_type = "' . $dataCostPayment->form_type . '" data-date ="'.$dataCostPayment->date.'" data-due_date ="'.$dataCostPayment->due_date.'" data-status = "' . $dataCostPayment->status . '"
                                data-approved_total="'.$dataCostPayment->approved_total.'" data-dp_amount="'.$dataCostPayment->dp_amount.'" data-applicant = "' . $dataCostPayment->applicant . '" data-currency = "' . $dataCostPayment->currency . '" data-crate = "' . $dataCostPayment->crate . '" data-subtotal = "' . $dataCostPayment->subtotal . '" data-vat="'.$dataCostPayment->vat.'" data-total="'.$dataCostPayment->total.'" data-wht="'.$dataCostPayment->wht.'" data-total_paid="'.$dataCostPayment->total_paid.'"
                                data-beneficiary_bank = "'.$dataCostPayment->beneficiary_bank.'" data-beneficiary_name = "'.$dataCostPayment->beneficiary_name.'" data-beneficiary_acc = "'.$dataCostPayment->beneficiary_acc.'" data-balance="'.$dataCostPayment->balance.'" data-balance_wht="'.$dataCostPayment->balance_wht.'" data-created_by="'.$dataCostPayment->created_by.'"
                            >View Detail</button>
                            
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
                                            <div class="font-semibold text-slate-800 text-sm">View Payment Detail</div>
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
                            <button  class="btn btn-sm btn-pay text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cp="'.$dataCostPayment->id_costpayment.'" data-id="'.$dataCostPayment->idrec.'"
                                data-company = "' . $dataCostPayment->company . '" data-form_type = "' . $dataCostPayment->form_type . '" data-date ="'.$dataCostPayment->date.'" data-due_date ="'.$dataCostPayment->due_date.'" data-status = "' . $dataCostPayment->status . '"
                                data-approved_total="'.$dataCostPayment->approved_total.'" data-dp_amount="'.$dataCostPayment->dp_amount.'" data-applicant = "' . $dataCostPayment->applicant . '" data-currency = "' . $dataCostPayment->currency . '" data-crate = "' . $dataCostPayment->crate . '" data-subtotal = "' . $dataCostPayment->subtotal . '" data-vat="'.$dataCostPayment->vat.'" data-total="'.$dataCostPayment->total.'" data-wht="'.$dataCostPayment->wht.'" data-total_paid="'.$dataCostPayment->total_paid.'"
                                data-beneficiary_bank = "'.$dataCostPayment->beneficiary_bank.'" data-beneficiary_name = "'.$dataCostPayment->beneficiary_name.'" data-beneficiary_acc = "'.$dataCostPayment->beneficiary_acc.'" data-balance="'.$dataCostPayment->balance.'" data-balance_wht="'.$dataCostPayment->balance_wht.'" data-created_by="'.$dataCostPayment->created_by.'"
                            >Payment History</button>
                            
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
                                            <div class="font-semibold text-slate-800 text-sm">View Payment History</div>
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
                }elseif ($dataCostPayment->status == 'A/P') {
                    return '
                    <div class="flex flex-row justify-center">  
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-sky-500 hover:bg-sky-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cp="'.$dataCostPayment->id_costpayment.'" data-id="'.$dataCostPayment->idrec.'"
                                data-company = "' . $dataCostPayment->company . '" data-form_type = "' . $dataCostPayment->form_type . '" data-date ="'.$dataCostPayment->date.'" data-due_date ="'.$dataCostPayment->due_date.'" data-status = "' . $dataCostPayment->status . '"
                                data-approved_total="'.$dataCostPayment->approved_total.'" data-dp_amount="'.$dataCostPayment->dp_amount.'" data-applicant = "' . $dataCostPayment->applicant . '" data-currency = "' . $dataCostPayment->currency . '" data-crate = "' . $dataCostPayment->crate . '" data-subtotal = "' . $dataCostPayment->subtotal . '" data-vat="'.$dataCostPayment->vat.'" data-total="'.$dataCostPayment->total.'" data-wht="'.$dataCostPayment->wht.'" data-total_paid="'.$dataCostPayment->total_paid.'"
                                data-beneficiary_bank = "'.$dataCostPayment->beneficiary_bank.'" data-beneficiary_name = "'.$dataCostPayment->beneficiary_name.'" data-beneficiary_acc = "'.$dataCostPayment->beneficiary_acc.'" data-balance="'.$dataCostPayment->balance.'" data-balance_wht="'.$dataCostPayment->balance_wht.'" data-created_by="'.$dataCostPayment->created_by.'"
                            >View Detail</button>
                            
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
                                            <div class="font-semibold text-slate-800 text-sm">View Payment Detail</div>
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
                        <button  class="btn btn-sm btn-cancel text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1"
                            data-id="'.$dataCostPayment->idrec.'"
                        >Return to Draft</button>
                    </div>';
                }
            })
            // <a href = "/finance/payment/list/form/' . $dataCostPayment->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-purple-500 hover:bg-purple-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
            // >Payment</a>
            ->addColumn('action2', function ($dataCostPayment) {
                return '
                    <div class="flex flex-row justify-center">
                        <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataCostPayment->idrec . '"
                        data-id_costpayment="' . $dataCostPayment->id_costpayment . '" data-id_company="' . $dataCostPayment->id_company . '" data-company_name="' . $dataCostPayment->companyName . '" data-company="' . $dataCostPayment->company . '" data-idsupplier="' . $dataCostPayment->idsupplier . '"
                        data-form_type="' . $dataCostPayment->form_type . '" data-beneficiary_bank="' . $dataCostPayment->beneficiary_bank . '" data-beneficiary_name="' . $dataCostPayment->beneficiary_name . '" data-beneficiary_acc="' . $dataCostPayment->beneficiary_acc . '" data-approved_total="' . $dataCostPayment->approved_total . '"
                        data-approved_total="' . $dataCostPayment->approved_total . '" data-department="' . $dataCostPayment->department . '" data-name_rab="' . $dataCostPayment->name_rab . '" data-po_title="' . $dataCostPayment->po_title . '" data-status="' . $dataCostPayment->status . '" data-currency="' . $dataCostPayment->currency . '" data-crate="' . $dataCostPayment->crate . '"
                        >Select</button>
                    </div>'; 
            })
            ->rawColumns(['action', 'action2'])
            ->make();
        }
        // <a href = "/finance/payment/list/form/' . $dataCostPayment->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-purple-500 hover:bg-purple-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
        // >Multi Payment</a>
    }

    public function returnpayment($cpId)
    {
        try {
            $dataCostpayment = DB::table('t_costpayment')->where('idrec', $cpId)->first();
            $dataPaymentDetail = DB::table('t_costpayment_detail')->where('id_costpayment', $dataCostpayment->id_costpayment)->pluck('id_costpayment')->first();
            if(is_null($dataPaymentDetail)){
                If ($dataCostpayment->form_type = 'RAB') {
                    DB::table('t_rab')->where('id_rab', $dataCostpayment->id_costpayment)->update([
                        'approvalstat' => 'Draft',
                        'print_status' => 'N',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                } elseif ($dataCostpayment->form_type = 'Cost Center') {
                    DB::table('t_costcenter')->where('idreqform', $dataCostpayment->id_costpayment)->update([
                        'approvalstat' => 'Draft',
                        'print_status' => 'N',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                } elseif ($dataCostpayment->form_type = 'Reimburse') {                    
                    DB::table('t_reimburse_request')->where('idreqform', $dataCostpayment->id_costpayment)->update([
                        'approvalstat' => 'Draft',
                        'print_status' => 'N',
                        'updated_at' => date('Y-m-d'),
                        'updated_by' => Auth::user()->id
                    ]);
                } elseif ($dataCostpayment->form_type = 'PO') {                    
                    
                }

                DB::table('t_costpayment')->where('id_costpayment', $dataCostpayment->id_costpayment)->delete();
                return response()->json([
                    'status' => 1,
                    'message' => "Form returned to draft successfully!",
                ]);
            } elseif ($dataPaymentDetail != null) {
                return response()->json([
                    'status' => 2,
                    'message' => "Cannot cancel form. This form has linked to a PV",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }


    public function paymentSelect(Request $request)
    {
        $dataCostPaymentQuery = DB::table('t_costpayment')
        ->leftJoin('users', 't_costpayment.created_by', 'users.id')
        ->leftJoin('m_bank', 't_costpayment.beneficiary_bank', 'm_bank.id_bank')
        ->leftJoin('m_child_company', 't_costpayment.id_company', 'm_child_company.id_company')
        ->leftJoin('t_rab', 't_costpayment.id_costpayment', 't_rab.id_rab')
        ->leftJoin('t_costcenter', 't_costpayment.id_costpayment', 't_costcenter.idreqform')
        ->leftJoin('t_reimburse_request', 't_costpayment.id_costpayment', 't_reimburse_request.idreqform')
        ->leftJoin('t_po', 't_costpayment.id_costpayment', 't_po.no_po')
        ->select(
            't_costpayment.*',
            'users.username',
            'm_child_company.name as companyName',
            't_costcenter.idsupplier',
            't_costcenter.department',
            't_rab.name_rab',
            't_reimburse_request.note',
            't_po.po_title',
            'm_bank.name as bankName'
        )->where('t_costpayment.aktifyn', '=', 'Y')->where('t_costpayment.balance', '!=', '0')->where('t_costpayment.status', '!=', 'Canceled');

        if ($request->input('company')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.id_company', $request->company);
        }
        if ($request->input('status')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.status', $request->status);
        }else {
            if ($request->input('company')){
                $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.id_company', $request->company);
            }
            $dataCostPaymentQuery = $dataCostPaymentQuery->where(function ($query) {
                $query->where('t_costpayment.status', '=', 'A/P')->orWhere('t_costpayment.status', '=', 'Partial');
            });
        }

        $dataCostPayment = $dataCostPaymentQuery->where('t_costpayment.aktifyn', '=', 'Y')->where('t_costpayment.balance', '!=', '0')->where('t_costpayment.status', '!=', 'Canceled');
        
        if ($request->ajax()) {
            return DataTables::of($dataCostPayment)
            ->editColumn('due_date', function ($dataCostPayment) {
                if ($dataCostPayment->due_date) {
                    return date('Y-m-d', strtotime($dataCostPayment->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPayment) {
                if (is_numeric($dataCostPayment->created_by)) {
                    return $dataCostPayment->username;
                } else {
                    return $dataCostPayment->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPayment) {
                return date('Y-m-d', strtotime($dataCostPayment->date));
            })
            ->editColumn('subtotal', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->subtotal, 0, ',', '.');
            })
            ->editColumn('vat', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->vat, 0, ',', '.');
            })
            ->editColumn('total', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total, 0, ',', '.');
            })
            ->editColumn('wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->wht, 0, ',', '.');
            })
            ->editColumn('total_paid', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPayment) {
                $department = htmlspecialchars($dataCostPayment->department, ENT_QUOTES, 'UTF-8');
                $name_rab = htmlspecialchars($dataCostPayment->name_rab, ENT_QUOTES, 'UTF-8');
                $note = htmlspecialchars($dataCostPayment->note, ENT_QUOTES, 'UTF-8');
                $po_title = htmlspecialchars($dataCostPayment->po_title, ENT_QUOTES, 'UTF-8');
                return '
                    <div class="flex flex-row justify-center">
                        <button type="button" class="btn btn-xs btn-select text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataCostPayment->idrec . '"
                        data-id_costpayment="' . $dataCostPayment->id_costpayment . '" data-id_company="' . $dataCostPayment->id_company . '" data-company_name="' . $dataCostPayment->companyName . '" data-company="' . $dataCostPayment->company . '" data-idsupplier="' . $dataCostPayment->idsupplier . '"
                        data-form_type="' . $dataCostPayment->form_type . '" data-beneficiary_bank="' . $dataCostPayment->beneficiary_bank . '" data-beneficiary_name="' . $dataCostPayment->beneficiary_name . '" data-beneficiary_acc="' . $dataCostPayment->beneficiary_acc . '" data-approved_total="' . $dataCostPayment->approved_total . '"
                        data-approved_total="' . $dataCostPayment->approved_total . '" data-balance="' . $dataCostPayment->balance . '" data-department="' . $department . '" data-name_rab="' . $name_rab . '" data-po_title="' . $po_title . '" data-status="' . $dataCostPayment->status . '" data-currency="' . $dataCostPayment->currency . '" data-crate="' . $dataCostPayment->crate . '"
                        data-note="' . $note . '"
                        >Select</button>
                    </div>'; 
            })
            ->rawColumns(['action'])
            ->make();
        }
        // <a href = "/finance/payment/list/form/' . $dataCostPayment->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-purple-500 hover:bg-purple-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
        // >Multi Payment</a>
    }
    public function selectPayment(Request $request)
    {
        $dataCostPaymentQuery = DB::table('t_costpayment')
        ->leftJoin('users', 't_costpayment.created_by', 'users.id')
        ->leftJoin('m_bank', 't_costpayment.beneficiary_bank', 'm_bank.id_bank')
        ->leftJoin('m_child_company', 't_costpayment.id_company', 'm_child_company.id_company')
        ->leftJoin('t_rab', 't_costpayment.id_costpayment', 't_rab.id_rab')
        ->leftJoin('t_costcenter', 't_costpayment.id_costpayment', 't_costcenter.idreqform')
        ->leftJoin('t_reimburse_request', 't_costpayment.id_costpayment', 't_reimburse_request.idreqform')
        ->leftJoin('t_po', 't_costpayment.id_costpayment', 't_po.no_po')
        ->select(
            't_costpayment.*',
            'users.username',
            'm_child_company.name as companyName',
            't_costcenter.idsupplier',
            't_costcenter.department',
            't_rab.name_rab',
            't_reimburse_request.note',
            't_po.po_title',
            'm_bank.name as bankName'
        )->where('t_costpayment.aktifyn', '=', 'Y')->where('t_costpayment.balance', '!=', '0')->where('t_costpayment.status', '!=', 'Canceled');
        if ($request->input('formstypes')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.form_type', $request->formstypes);
        }
        if ($request->input('stats')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.status', $request->stats);
        }
        if ($request->input('id_company')){
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.id_company', $request->id_company);
        }
        // if ($request->input('idsupplier')){
        //     $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costcenter.idsupplier', $request->idsupplier);
        // }
        if ($request->input('beneficiary')) {
            $dataCostPaymentQuery = $dataCostPaymentQuery->where('t_costpayment.beneficiary_acc', $request->beneficiary);
        }

        $dataCostPayment = $dataCostPaymentQuery->where('t_costpayment.aktifyn', '=', 'Y')->where('t_costpayment.status', '!=', 'Canceled');

        if ($request->ajax()) {
            return DataTables::of($dataCostPayment)
            ->editColumn('due_date', function ($dataCostPayment) {
                if ($dataCostPayment->due_date) {
                    return date('Y-m-d', strtotime($dataCostPayment->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPayment) {
                if (is_numeric($dataCostPayment->created_by)) {
                    return $dataCostPayment->username;
                } else {
                    return $dataCostPayment->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPayment) {
                return date('Y-m-d', strtotime($dataCostPayment->date));
            })
            ->editColumn('subtotal', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->subtotal, 0, ',', '.');
            })
            ->editColumn('vat', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->vat, 0, ',', '.');
            })
            ->editColumn('total', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total, 0, ',', '.');
            })
            ->editColumn('wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->wht, 0, ',', '.');
            })
            ->editColumn('total_paid', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->total_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPayment) {
                return "" . "" . number_format($dataCostPayment->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPayment) {
                $department = htmlspecialchars($dataCostPayment->department, ENT_QUOTES, 'UTF-8');
                $name_rab = htmlspecialchars($dataCostPayment->name_rab, ENT_QUOTES, 'UTF-8');
                $note = htmlspecialchars($dataCostPayment->note, ENT_QUOTES, 'UTF-8');
                $po_title = htmlspecialchars($dataCostPayment->po_title, ENT_QUOTES, 'UTF-8');
                return '
                    <div class="flex flex-row justify-center">
                        <button type="button" class="btn btn-xs btn-select1 text-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="modalOpen = false"  data-id="' . $dataCostPayment->idrec . '"
                        data-id_costpayment="' . $dataCostPayment->id_costpayment . '" data-id_company="' . $dataCostPayment->id_company . '" data-company_name="' . $dataCostPayment->companyName . '" data-company="' . $dataCostPayment->company . '" data-idsupplier="' . $dataCostPayment->idsupplier . '"
                        data-form_type="' . $dataCostPayment->form_type . '" data-beneficiary_bank="' . $dataCostPayment->beneficiary_bank . '" data-beneficiary_name="' . $dataCostPayment->beneficiary_name . '" data-beneficiary_acc="' . $dataCostPayment->beneficiary_acc . '" data-approved_total="' . $dataCostPayment->approved_total . '"
                        data-approved_total="' . $dataCostPayment->approved_total . '" data-balance="' . $dataCostPayment->balance . '" data-department="' . $department . '" data-name_rab="' . $name_rab . '" data-po_title="' . $po_title . '" data-status="' . $dataCostPayment->status . '" data-currency="' . $dataCostPayment->currency . '" data-crate="' . $dataCostPayment->crate . '"
                        data-note="' . $note . '"
                        >Select</button>
                    </div>'; 
            })
            ->rawColumns(['action'])
            ->make();
        }
        // <a href = "/finance/payment/list/form/' . $dataCostPayment->idrec . '" class="btn btn-sm text-sm text-white ml-1 bg-purple-500 hover:bg-purple-600" background-color: rgb(245 158 11); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"    
        // >Multi Payment</a>
    }

    public function paymentListGetDetail(Request $request)
    {
        // Step 1: Retrieve the most recent idrec for each id_costpayment
        $latestRecordsQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw('MAX(idrec) as latest_idrec'), 'id_costpayment')
            ->where('aktifyn', '!=', 'N')
            ->groupBy('id_costpayment');
         
        // Convert the query into a subquery for easier joining
        $latestRecords = DB::table(DB::raw("({$latestRecordsQuery->toSql()}) as latest_records"))
            ->mergeBindings($latestRecordsQuery)
            ->select('latest_records.latest_idrec')
            ->pluck('latest_idrec')->toArray();

        $startdate = $request->input('from');
        $enddate = $request->input('to');

        $dataCostPaymentDetailQuery = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->leftJoin('users', 't_costpayment_detail.created_by', 'users.id')
        ->leftJoin('m_child_company as company_applicant', 't_costpayment.id_company', 'company_applicant.id_company')
        ->leftJoin('m_child_company as company_charge', 't_costpayment_detail.id_company', 'company_charge.id_company')
        ->select(
            't_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.id_payment', 't_costpayment_detail.date', 't_costpayment_detail.payment_date', 't_costpayment_detail.payee_date', 't_costpayment_detail.bank_date', 't_costpayment_detail.transaction_number', 't_costpayment_detail.id_company',
            't_costpayment_detail.payment_type', 't_costpayment_detail.currency', 't_costpayment_detail.crate', 't_costpayment_detail.amount_paid', 't_costpayment_detail.companyId', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number', 't_costpayment_detail.file_stat', 't_costpayment_detail.beneficiary_bank',
            't_costpayment_detail.beneficiary_name', 't_costpayment_detail.beneficiary_acc', 't_costpayment_detail.rounding', 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.remarks', 't_costpayment_detail.created_at', 't_costpayment_detail.created_by',
            't_costpayment_detail.checked_by', 't_costpayment_detail.approved_by', 't_costpayment_detail.released_by', 't_costpayment_detail.aktifyn', 't_costpayment_detail.previous_payment',
            't_costpayment.date as dateForm',
            't_costpayment.company',
            't_costpayment.due_date',
            't_costpayment.total_paid',
            't_costpayment.wht',
            't_costpayment.balance',
            't_costpayment.balance_wht',
            't_costpayment.applicant',
            't_costpayment.form_type',
            't_costpayment.currency',
            't_costpayment.crate',
            't_costpayment.status',
            'users.username',
            'company_applicant.name as companyName',
            'company_applicant.address',
            'company_applicant.logo_filename',
            'company_applicant.company_type',
            'company_charge.name as companyCharge',
            DB::raw("
                case
                    when t_costpayment_detail.aktifyn = 'Y' then 'A/P'
                    when t_costpayment_detail.aktifyn = 'N' then 'Canceled'
                    when t_costpayment_detail.aktifyn = 'P' then 'Paid'
                    when t_costpayment_detail.aktifyn = 'F' then 'Printed'
                    else 'unknown status'
                end as aktif
                ")
        )->where('t_costpayment_detail.aktifyn', '!=', 'N');

        if ($startdate && $enddate) {
            $dataCostPaymentDetailQuery->whereDate('t_costpayment_detail.payment_date', '>=', $startdate)
                ->whereDate('t_costpayment_detail.payment_date', '<=', $enddate);
        }

        if ($request->input('status')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.aktifyn', $request->status);
        }
        if ($request->input('company')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.id_company', $request->company);
        }

        $dataCostPaymentDetail = $dataCostPaymentDetailQuery->where('t_costpayment_detail.aktifyn', '!=', 'N')->get();

        if ($request->ajax()) {
            return DataTables::of($dataCostPaymentDetail)
            ->editColumn('due_date', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->due_date) {
                    return date('Y-m-d', strtotime($dataCostPaymentDetail->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPaymentDetail) {
                if (is_numeric($dataCostPaymentDetail->created_by)) {
                    return $dataCostPaymentDetail->username;
                } else {
                    return $dataCostPaymentDetail->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPaymentDetail) {
                return date('Y-m-d', strtotime($dataCostPaymentDetail->date));
            })
            ->editColumn('amount_paid', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->amount_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->file_stat == '1' && $dataCostPaymentDetail->aktifyn == 'P') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/viewfile/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                            View Attachment
                        </a>
                    </div>';
                } elseif ($dataCostPaymentDetail->aktifyn == 'Y'){
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/print/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;">
                            Print Voucher
                        </a>
                    </div>';
                } elseif ($dataCostPaymentDetail->aktifyn == 'F') {
                    return '';
                }
            })
            ->addColumn('action1', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->aktifyn == 'P') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/print/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-sky-500 hover:bg-sky-600 ml-1">
                            View PV
                        </a>
                        <a href="/finance/payment/list/viewfile/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                            View Attachment
                        </a>
                    </div>';
                } elseif ($dataCostPaymentDetail->aktifyn == 'F') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/confirmpaymentpage/' . $dataCostPaymentDetail->idrec . '" class="btn btn-sm text-sm text-white bg-emerald-500 hover:bg-emerald-600 ml-1">
                            Confirm Payment
                        </a>
                    </div>';
                } elseif ($dataCostPaymentDetail->aktifyn == 'Y') {
                    return '';
                }
            })
            ->addColumn('action2', function ($dataCostPaymentDetail) use ($latestRecords) {
                if (in_array($dataCostPaymentDetail->idrec, $latestRecords)) {
                    if ($dataCostPaymentDetail->file_stat == '1') {
                        return '
                        <div class="flex flex-row justify-center">
                            <a href="/finance/payment/list/viewfile/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                                View Attachment
                            </a>
    
                            <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                                data-id="'.$dataCostPaymentDetail->idrec.'" data-cost="'.$dataCostPaymentDetail->id_costpayment.'" data-payments="'.$dataCostPaymentDetail->id_payment.'" data-balance="'.$dataCostPaymentDetail->balance.'" data-balance_wht="'.$dataCostPaymentDetail->balance_wht.'" data-total_paid="'.$dataCostPaymentDetail->total_paid.'" data-wht="'.$dataCostPaymentDetail->wht.'"
                            >Cancel</button>
                        </div>';
                    } else {
                        return '
                        <div class="flex flex-row justify-center">
                            <button  class="btn btn-sm btn-cancel text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                                data-id="'.$dataCostPaymentDetail->idrec.'" data-cost="'.$dataCostPaymentDetail->id_costpayment.'" data-payments="'.$dataCostPaymentDetail->id_payment.'" data-balance="'.$dataCostPaymentDetail->balance.'" data-balance_wht="'.$dataCostPaymentDetail->balance_wht.'" data-total_paid="'.$dataCostPaymentDetail->total_paid.'" data-wht="'.$dataCostPaymentDetail->wht.'"
                            >Cancel</button>
                        </div>';
                    }
                } else {
                    if ($dataCostPaymentDetail->file_stat == '1') {
                        return '
                            <div class="flex flex-row justify-center">
                                <a href="/finance/payment/list/viewfile/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                                    View Attachment
                                </a>
                            </div>'; 
                    } else {
                        return '';
                    }
                }
            })
            ->rawColumns(['action', 'action1', 'action2'])
            ->make();
        }
    }

    public function paymentListGetDetail1(Request $request)
    {
        $startdate = $request->input('from');
        $enddate = $request->input('to');
        $dataCostPaymentDetailQuery = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->leftJoin('users', 't_costpayment_detail.created_by', 'users.id')
        ->leftJoin('m_child_company as company_applicant', 't_costpayment.id_company', 'company_applicant.id_company')
        ->leftJoin('m_child_company as company_charge', 't_costpayment_detail.id_company', 'company_charge.id_company')
        ->select(
            't_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.id_payment', 't_costpayment_detail.date', 't_costpayment_detail.payment_date', 't_costpayment_detail.payee_date', 't_costpayment_detail.bank_date', 't_costpayment_detail.transaction_number', 't_costpayment_detail.id_company',
            't_costpayment_detail.payment_type', 't_costpayment_detail.currency', 't_costpayment_detail.crate', 't_costpayment_detail.amount_paid', 't_costpayment_detail.companyId', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number', 't_costpayment_detail.file_stat', 't_costpayment_detail.beneficiary_bank',
            't_costpayment_detail.beneficiary_name', 't_costpayment_detail.beneficiary_acc', 't_costpayment_detail.rounding', 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.remarks', 't_costpayment_detail.created_at', 't_costpayment_detail.created_by',
            't_costpayment_detail.checked_by', 't_costpayment_detail.approved_by', 't_costpayment_detail.released_by', 't_costpayment_detail.aktifyn', 't_costpayment_detail.previous_payment',
            't_costpayment.date as dateForm',
            't_costpayment.company',
            't_costpayment.due_date',
            't_costpayment.total_paid',
            't_costpayment.wht',
            't_costpayment.balance',
            't_costpayment.balance_wht',
            't_costpayment.applicant',
            't_costpayment.form_type',
            't_costpayment.currency',
            't_costpayment.crate',
            't_costpayment.status',
            'users.username',
            'company_applicant.name as companyName',
            'company_applicant.address',
            'company_applicant.logo_filename',
            'company_applicant.company_type',
            'company_charge.name as companyCharge',
            DB::raw("
                case
                    when t_costpayment_detail.aktifyn = 'Y' then 'A/P'
                    when t_costpayment_detail.aktifyn = 'N' then 'Canceled'
                    when t_costpayment_detail.aktifyn = 'P' then 'Paid'
                    when t_costpayment_detail.aktifyn = 'F' then 'Printed'
                    else 'unknown status'
                end as aktif
                ")
        );

        if ($startdate && $enddate) {
            $dataCostPaymentDetailQuery->whereDate('t_costpayment_detail.payment_date', '>=', $startdate)
                ->whereDate('t_costpayment_detail.payment_date', '<=', $enddate);
        }

        if ($request->input('status')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.aktifyn', $request->status);
        }
        if ($request->input('company')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.id_company', $request->company);
        }

        $dataCostPaymentDetail = $dataCostPaymentDetailQuery;

        if ($request->ajax()) {
            return DataTables::of($dataCostPaymentDetail)
            ->editColumn('due_date', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->due_date) {
                    return date('Y-m-d', strtotime($dataCostPaymentDetail->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPaymentDetail) {
                if (is_numeric($dataCostPaymentDetail->created_by)) {
                    return $dataCostPaymentDetail->username;
                } else {
                    return $dataCostPaymentDetail->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPaymentDetail) {
                return date('Y-m-d', strtotime($dataCostPaymentDetail->date));
            })
            ->editColumn('amount_paid', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->amount_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->aktifyn == 'Y') {
                    return '
                    <div class="flex flex-row justify-center">
                        <button  class="btn btn-sm btn-print text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;"
                            data-id="'.$dataCostPaymentDetail->idrec.'" data-cost="'.$dataCostPaymentDetail->id_costpayment.'" data-payments="'.$dataCostPaymentDetail->id_payment.'" data-balance="'.$dataCostPaymentDetail->balance.'" data-balance_wht="'.$dataCostPaymentDetail->balance_wht.'" data-total_paid="'.$dataCostPaymentDetail->total_paid.'" data-wht="'.$dataCostPaymentDetail->wht.'"
                        >Print Voucher</button>
                    </div>';
                }elseif ($dataCostPaymentDetail->aktifyn == 'P') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/print/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-sky-500 hover:bg-sky-600 ml-1">
                            View PV
                        </a>
                        <a href="/finance/payment/list/viewfile/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                            View Attachment
                        </a>
                    </div>';
                }elseif ($dataCostPaymentDetail->aktifyn == 'N') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/print/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;">
                            Reprint
                        </a>
                    </div>';
                }elseif ($dataCostPaymentDetail->aktifyn == 'F') {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/print/' . $dataCostPaymentDetail->idrec . '" target="_blank" class="btn btn-sm text-sm text-white ml-1" style="background-color: rgb(2 132 199); transition: background-color 0.3s ease-in-out;transition: background-color 0.3s ease-in-out;">
                            Reprint
                        </a>
                    </div>';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function paymentListGetDetail2(Request $request)
    {
        // Step 1: Retrieve the most recent idrec for each id_costpayment
        $latestRecordsQuery = DB::table('t_costpayment_detail')
            ->select(DB::raw('MAX(idrec) as latest_idrec'), 'id_costpayment')
            ->where('aktifyn', '=', 'Y')
            ->groupBy('id_costpayment');
         
        // Convert the query into a subquery for easier joining
        $latestRecords = DB::table(DB::raw("({$latestRecordsQuery->toSql()}) as latest_records"))
            ->mergeBindings($latestRecordsQuery)
            ->select('latest_records.latest_idrec')
            ->pluck('latest_idrec')->toArray();
        
        $startdate = $request->input('from');
        $enddate = $request->input('to');

        $dataCostPaymentDetailQuery = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->leftJoin('users', 't_costpayment_detail.created_by', 'users.id')
        ->leftJoin('m_child_company as company_applicant', 't_costpayment.id_company', 'company_applicant.id_company')
        ->leftJoin('m_child_company as company_charge', 't_costpayment_detail.id_company', 'company_charge.id_company')
        ->select(
            't_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.id_payment', 't_costpayment_detail.date', 't_costpayment_detail.payment_date', 't_costpayment_detail.payee_date', 't_costpayment_detail.bank_date', 't_costpayment_detail.transaction_number', 't_costpayment_detail.id_company',
            't_costpayment_detail.payment_type', 't_costpayment_detail.currency', 't_costpayment_detail.crate', 't_costpayment_detail.amount_paid', 't_costpayment_detail.companyId', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number', 't_costpayment_detail.file_stat', 't_costpayment_detail.beneficiary_bank',
            't_costpayment_detail.beneficiary_name', 't_costpayment_detail.beneficiary_acc', 't_costpayment_detail.rounding', 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.remarks', 't_costpayment_detail.created_at', 't_costpayment_detail.created_by',
            't_costpayment_detail.checked_by', 't_costpayment_detail.approved_by', 't_costpayment_detail.released_by', 't_costpayment_detail.aktifyn', 't_costpayment_detail.previous_payment',
            't_costpayment.date as dateForm',
            't_costpayment.company',
            't_costpayment.due_date',
            't_costpayment.total_paid',
            't_costpayment.wht',
            't_costpayment.balance',
            't_costpayment.balance_wht',
            't_costpayment.applicant',
            't_costpayment.form_type',
            't_costpayment.currency',
            't_costpayment.crate',
            't_costpayment.status',
            'users.username',
            'company_applicant.name as companyName',
            'company_applicant.address',
            'company_applicant.logo_filename',
            'company_applicant.company_type',
            'company_charge.name as companyCharge',
            DB::raw("
                case
                    when t_costpayment_detail.aktifyn = 'Y' then 'A/P'
                    when t_costpayment_detail.aktifyn = 'N' then 'Canceled'
                    when t_costpayment_detail.aktifyn = 'P' then 'Paid'
                    when t_costpayment_detail.aktifyn = 'F' then 'Printed'
                    else 'unknown status'
                end as aktif
                ")
        )->where('t_costpayment_detail.aktifyn', '!=', 'N');
        if ($startdate && $enddate) {
            $dataCostPaymentDetailQuery->whereDate('t_costpayment_detail.payment_date', '>=', $startdate)
                ->whereDate('t_costpayment_detail.payment_date', '<=', $enddate);
        }

        if ($request->input('status')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.aktifyn', $request->status);
        }
        if ($request->input('company')){
            $dataCostPaymentDetailQuery = $dataCostPaymentDetailQuery->where('t_costpayment_detail.id_company', $request->company);
        }
        $dataCostPaymentDetail = $dataCostPaymentDetailQuery->get();

        if ($request->ajax()) {
            return DataTables::of($dataCostPaymentDetail)
            ->editColumn('due_date', function ($dataCostPaymentDetail) {
                if ($dataCostPaymentDetail->due_date) {
                    return date('Y-m-d', strtotime($dataCostPaymentDetail->due_date));
                } else {
                    return '';
                }
            })
            ->editColumn('created_by', function ($dataCostPaymentDetail) {
                if (is_numeric($dataCostPaymentDetail->created_by)) {
                    return $dataCostPaymentDetail->username;
                } else {
                    return $dataCostPaymentDetail->created_by;
                }
            })
            ->editColumn('date', function ($dataCostPaymentDetail) {
                return date('Y-m-d', strtotime($dataCostPaymentDetail->date));
            })
            ->editColumn('amount_paid', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->amount_paid, 0, ',', '.');
            })
            ->editColumn('balance', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance, 0, ',', '.');
            })
            ->editColumn('balance_wht', function ($dataCostPaymentDetail) {
                return "" . "" . number_format($dataCostPaymentDetail->balance_wht, 0, ',', '.');
            })
            ->addColumn('action', function ($dataCostPaymentDetail) use ($latestRecords) {
                $now = Carbon::now();
                $createdAt = Carbon::parse($dataCostPaymentDetail->created_at);
                $hoursDiff = $createdAt->diffInHours($now);
                
                if (in_array($dataCostPaymentDetail->idrec, $latestRecords) && $dataCostPaymentDetail->aktifyn == 'Y' && $hoursDiff <= 24) {
                    return '
                    <div class="flex flex-row justify-center">
                        <a href="/finance/payment/list/updatepage/' . $dataCostPaymentDetail->idrec . '" class="btn btn-sm text-sm text-white bg-amber-500 hover:bg-amber-600 ml-1">
                            Edit
                        </a>
                    </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['action'])
            ->make();
        }
    }

    public function paymentDetailGetData($cpId)
    {
        $dataCP = DB::table('t_costpayment')->select('idrec', 'id_costpayment', 'form_type')->where('idrec', $cpId)->first();
        if ($dataCP->form_type == 'Cost Center') {
            $dataDetailCP = DB::table('t_costcenter_detail')
            ->leftJoin('m_cost_center_type', 't_costcenter_detail.type', 'm_cost_center_type.id')
            ->select('t_costcenter_detail.*', 'm_cost_center_type.cost_type')
            ->where('t_costcenter_detail.idreqform', $dataCP->id_costpayment)->where('t_costcenter_detail.status', '=', 'Active')->get()->toArray();
        } elseif ($dataCP->form_type == 'Reimburse'){
            $dataDetailCP = DB::table('t_reimburse_request_detail')
            ->leftJoin('m_reimbursement_type', 't_reimburse_request_detail.type', 'm_reimbursement_type.id')
            ->select('t_reimburse_request_detail.*','m_reimbursement_type.reimburse_type')
            ->where('t_reimburse_request_detail.idreqform', $dataCP->id_costpayment)->where('t_reimburse_request_detail.status', '=', 'Active')->get()->toArray();
        }elseif ($dataCP->form_type == 'RAB') {
            $dataDetailCP = DB::table('t_rab_detail')
            ->select('t_rab_detail.idrec', 't_rab_detail.id_rab', 't_rab_detail.id_rab_item', 't_rab_detail.qty', 't_rab_detail.unit', 't_rab_detail.total', 't_rab_detail.status', 't_rab_detail.rab_calc_type', 't_rab_detail.name_rab_detail', 't_rab_detail.days',
            't_rab_detail.amount', 't_rab_detail.balance', 't_rab_detail.total', 't_rab_detail.created_by', 't_rab_detail.created_at', 't_rab_detail.category', 't_rab_detail.sub_category', 't_rab_detail.date_rab'
            , 't_rab_detail.name_rab_detail as detail', 't_rab_detail.remarks')
            ->where('t_rab_detail.id_rab', $dataCP->id_costpayment)->where('t_rab_detail.status', '=', 'Active')->orderBy('t_rab_detail.idrec', 'asc')->get()->toArray();
        }elseif ($dataCP->form_type == 'PO') {
            $dataDetailCP = DB::table('t_po')
            ->select('t_po.idrec', 't_po.id_company', 't_po.date_po', 't_po.due_date', 't_po.no_po', 't_po.no_invoice', 't_po.no_rab', 't_po.idemployee', 't_po.po_title', 't_po.idsupplier', 't_po.currency', 't_po.crate', 't_po.total',
            't_po.ppn', 't_po.gtotal', 't_po.wht', 't_po.amount_due', 't_po.status', 't_po.created_at', 't_po.created_by', 't_po.updated_at', 't_po.updated_by',)->where('t_po.no_po', $dataCP->id_costpayment)->get()->toArray();
        }

        return $dataDetailCP;
    }

    public function payDetail($cpId)
    {
        $dataCP = DB::table('t_costpayment')->where('idrec', $cpId)->pluck('id_costpayment')->first();
        $DetailCP = DB::table('t_costpayment_detail')->select('t_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.payment_date', 't_costpayment_detail.id_payment', 't_costpayment_detail.payment_type', 't_costpayment_detail.amount_paid', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number'
        , 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.file_stat', 't_costpayment_detail.aktifyn', 
        DB::raw("
        case
            when t_costpayment_detail.aktifyn = 'Y' then 'A/P'
            when t_costpayment_detail.aktifyn = 'N' then 'Canceled'
            when t_costpayment_detail.aktifyn = 'P' then 'Paid'
            when t_costpayment_detail.aktifyn = 'F' then 'Printed'
            else 'unknown status'
        end as aktif
        "), 't_costpayment_detail.previous_payment', DB::raw('t_costpayment_detail.amount_paid + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge AS total_amount'), DB::raw("(SELECT SUM(amount_paid) FROM t_costpayment_detail WHERE id_costpayment = '$dataCP' AND aktifyn != 'N') AS totalasAmount"),
        DB::raw("(SELECT SUM(t_costpayment_detail.amount_paid + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge) FROM t_costpayment_detail WHERE id_costpayment = '$dataCP' AND aktifyn != 'N') AS totalasPaid"))
        ->where('t_costpayment_detail.id_costpayment', $dataCP)->orderBy('t_costpayment_detail.idrec', 'asc')->get();

        return $DetailCP;
    }

    public function paymentFile($payId)
    {
        $data = DB::table('t_costpayment_detail')->where('idrec', $payId)->select('file', 'id_costpayment')->first();
        $filename = $data->id_costpayment . '';
        $file = $data->file;

        return Response::make($file, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->file),
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }

    public function print($payId)
    {
        $dataCPdetail = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->leftJoin('users', 't_costpayment_detail.created_by', 'users.id')
        ->join('m_child_company', 't_costpayment_detail.id_company', 'm_child_company.id_company')
        ->select(
            't_costpayment_detail.idrec', 't_costpayment_detail.id_costpayment', 't_costpayment_detail.id_payment', 't_costpayment_detail.date', 't_costpayment_detail.payment_date', 't_costpayment_detail.payee_date', 't_costpayment_detail.bank_date', 't_costpayment_detail.transaction_number', 't_costpayment_detail.id_company',
            't_costpayment_detail.payment_type', 't_costpayment_detail.currency', 't_costpayment_detail.crate', 't_costpayment_detail.amount_paid', 't_costpayment_detail.companyId', 't_costpayment_detail.payee_bank', 't_costpayment_detail.payee_number', 't_costpayment_detail.file_stat', 't_costpayment_detail.beneficiary_bank',
            't_costpayment_detail.beneficiary_name', 't_costpayment_detail.beneficiary_acc', 't_costpayment_detail.rounding', 't_costpayment_detail.bank_charge', 't_costpayment_detail.duty_stamp_charge', 't_costpayment_detail.other_charge', 't_costpayment_detail.remarks', 't_costpayment_detail.created_at', 't_costpayment_detail.created_by',
            't_costpayment_detail.checked_by', 't_costpayment_detail.approved_by', 't_costpayment_detail.released_by', 't_costpayment_detail.aktifyn', 't_costpayment_detail.previous_payment',
            't_costpayment.date as dateForm',
            't_costpayment.due_date',
            't_costpayment.applicant',
            't_costpayment.form_type',
            't_costpayment.currency',
            'm_child_company.name as companyName',
            'm_child_company.address',
            'm_child_company.logo_filename',
            'm_child_company.company_type',
            'users.username',
            DB::raw('t_costpayment_detail.amount_paid - t_costpayment_detail.rounding + t_costpayment_detail.bank_charge + t_costpayment_detail.duty_stamp_charge + t_costpayment_detail.other_charge AS total_amount'),
            DB::raw('t_costpayment_detail.amount_paid - t_costpayment_detail.rounding AS beforeRounding')
        )->where('t_costpayment_detail.idrec', $payId)->first();
        $mathPayment = DB::table('t_costpayment_detail')
        ->select(
            DB::raw('SUM(t_costpayment_detail.amount_paid) AS totals_amount'),
            DB::raw('SUM(t_costpayment_detail.amount_paid - t_costpayment_detail.rounding) AS beforeRoundings'),
            DB::raw('SUM(t_costpayment_detail.amount_paid) AS mounts'),
            DB::raw('SUM(t_costpayment_detail.rounding) AS rounds'),
            DB::raw('SUM(t_costpayment_detail.bank_charge) AS charges'),
            DB::raw('SUM(t_costpayment_detail.duty_stamp_charge) AS dutys'),
            DB::raw('SUM(t_costpayment_detail.other_charge) AS others')
        )
        ->where('t_costpayment_detail.id_payment', $dataCPdetail->id_payment)
        ->first();
        
        $totalsAmount = $mathPayment->totals_amount + $dataCPdetail->rounding + $dataCPdetail->bank_charge + $dataCPdetail->duty_stamp_charge + $dataCPdetail->other_charge;
        
        $dataCPdetail1 = DB::table('t_costpayment_detail')
        ->leftJoin('t_costpayment', 't_costpayment_detail.id_costpayment', 't_costpayment.id_costpayment')
        ->select(
            't_costpayment_detail.*', 't_costpayment.date as dateForm',
        )->where('t_costpayment_detail.id_payment', $dataCPdetail->id_payment)->orderBy('idrec', 'asc')->get();
        $dataCPdetail1Count = $dataCPdetail1->count();
        return view('pages.finance.payment.list.print', compact('dataCPdetail', 'dataCPdetail1', 'mathPayment', 'dataCPdetail1Count', 'totalsAmount'));
    }
    
    public function cancelPayment($cpId)
    {
        // Step 1: Retrieve the most recent idrec for each id_costpayment
        $latestRecordsQuery = DB::table('t_costpayment_detail')
        ->select(DB::raw('MAX(idrec) as latest_idrec'), 'id_costpayment')
        ->where('aktifyn', '!=', 'N')
        ->groupBy('id_costpayment');
    
        // Convert the query into a subquery for easier joining
        $latestRecords = DB::table(DB::raw("({$latestRecordsQuery->toSql()}) as latest_records"))
            ->mergeBindings($latestRecordsQuery)
            ->select('latest_records.latest_idrec')
            ->pluck('latest_idrec')->toArray();

        // Check if payId is in the list of latest records
        if (!in_array($cpId, $latestRecords)) {
            return response()->json([
                'status' => 2,
                'message' => "Payment is not latest",
            ]);
        }
        $dataCPDetail = DB::table('t_costpayment_detail')->where('idrec', $cpId)->first();
        $dataCP = DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->first();
        $balanceAP = $dataCP->balance + $dataCPDetail->amount_paid;
        $balanceWHT = $dataCP->balance_wht + $dataCPDetail->amount_paid;
        try {
            if ($dataCPDetail->aktifyn != 'N') {
                if ($dataCPDetail->payment_type == 'A/P') {
                    if ($dataCP->balance < $dataCP->total_paid) {
                        DB::transaction(function () use ($balanceAP, $dataCPDetail, $cpId){
                            DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->update([
                                'balance' => $balanceAP
                            ]);
                            DB::table('t_costpayment_detail')->where('idrec', $cpId)->update([
                                'aktifyn' => 'N'
                            ]);
                        });
                    } else if ($dataCP->balance == $dataCP->total_paid){
                        DB::transaction(function () use ($cpId){
                            DB::table('t_costpayment_detail')->where('idrec', $cpId)->update([
                                'aktifyn' => 'N'
                            ]);
                        });
                    }
                } elseif ($dataCPDetail->payment_type == 'WHT') {
                    if ($dataCP->balance_wht < $dataCP->wht) {
                        DB::transaction(function () use ($balanceWHT, $dataCPDetail, $cpId){
                            DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->update([
                                'balance_wht' => $balanceWHT
                            ]);
                            DB::table('t_costpayment_detail')->where('idrec', $cpId)->update([
                                'aktifyn' => 'N'
                            ]);
                        });
                    }else if($dataCP->balance_wht == $dataCP->wht){
                        DB::transaction(function () use ($cpId){
                            DB::table('t_costpayment_detail')->where('idrec', $cpId)->update([
                                'aktifyn' => 'N'
                            ]);
                        });
                    }
                }
                return response()->json([
                    'status' => 1,
                    'message' => "successfully canceled payment",
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "Payment Already Canceled",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function paymentPrintUpdate($payId)
    {
        $dataCPDetail = DB::table('t_costpayment_detail')->where('idrec', $payId)->first();
        try {
            if ($dataCPDetail->aktifyn == 'Y') {
                DB::transaction(function () use ($dataCPDetail){
                    DB::table('t_costpayment_detail')->where('id_payment', $dataCPDetail->id_payment)->update([
                        'aktifyn' => 'F'
                    ]);
                });
                return response()->json([
                    'status' => 1,
                    'message' => "successfully print payment",
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "Payment Already Printed",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function updateStatus($cpId)
    {
        try {
            $dataCPDetail = DB::table('t_costpayment_detail')->where('idrec', $cpId)->first();
            $dataCP = DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->first();
            // && $dataCP->balance_wht == $dataCP->wht
            if ($dataCP->balance == $dataCP->total_paid) {
                DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->update([
                    'status' => 'A/P',
                ]);
                return response()->json([
                    'status' => 1,
                    'message' => "successfully canceled payment",
                ]);
            } else {
                DB::table('t_costpayment')->where('id_costpayment', $dataCPDetail->id_costpayment)->update([
                    'status' => 'Partial',
                ]);
            }
            return response()->json([
                'status' => 1,
                'message' => "successfully canceled payment",
            ]);
 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function cidBank()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-cidbank.index', compact('dataChildCompany'));
    }

    public function cidBankList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-cidbank.list', compact('dataChildCompany'));
    }

    public function cidBankForm()
    {
        $user = Auth::user()->company_id;
        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        }
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-cidbank.m-cidbank-form', compact('dataChildCompany', 'bank'));
    }

    public function cidBankEdit()
    {
        $user = Auth::user()->company_id;
        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        }
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('id_bank', 'asc')->get();
        return view('pages.ga.data-master.m-cidbank.m-cidbank-edit', compact('dataChildCompany', 'bank'));
    }

    public function cidBankDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-cidbank.m-cidbank-delete', compact('dataChildCompany'));
    }

    public function cidBankCreate(Request $request)
    {
        $bank_acc = $request->input('bank_acc');

        $uniqueAcc = DB::table('m_cid_bank')->where('bank_acc', $bank_acc)->first();
            
        if ($uniqueAcc == null) {
            DB::transaction(function() use($request){
                DB::table('m_cid_bank')->insert([
                    'id_company' => $request->input('company_id'),
                    'cidbank' => $request->input('cidbank'),
                    'id_bank' => $request->input('id_bank'),
                    'bank_acc' => $request->input('bank_acc'),
                    'acc_holder' => $request->input('acc_holder'),
                    'pv_code' => $request->input('pv_code'),
                    'aktifyn' => 'Y',
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            });
            alert()->success('Success', 'Bank CID Has Been Created');
            return to_route('cidbank.form');
        } else {
            alert()->error('Error', 'Bank CID Already Exist');
            return to_route('cidbank.form');
        }
    }

    public function cidBankGetData(Request $request)
    {
        $dataCidBankQuery = DB::table('m_cid_bank')
        ->leftJoin('m_child_company', 'm_cid_bank.id_company', 'm_child_company.id_company')
        ->leftJoin('m_bank', 'm_cid_bank.id_bank', 'm_bank.id_bank')
        ->select('m_cid_bank.*', 'm_bank.name as bankName', 'm_child_company.name as companyName')->where('aktifyn', '=', 'Y'); 

        if ($request->input('company') != null){
            $dataCidBankQuery = $dataCidBankQuery->where('m_cid_bank.id_company', $request->company);
        }

        $dataCidBank = $dataCidBankQuery;
        if ($request->ajax()) {
            return DataTables::of($dataCidBank)
            ->editColumn('created_at', function ($dataCidBank) {
                return date('Y-m-d', strtotime($dataCidBank->created_at));
            })
            ->addColumn('action', function ($dataCidBank) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cidb="'.$dataCidBank->id_cidb.'" data-id_bank="'.$dataCidBank->id_bank.'"
                                data-id_company = "' . $dataCidBank->id_company . '" data-cidbank = "' . $dataCidBank->cidbank . '" data-bank_acc = "' . $dataCidBank->bank_acc . '" 
                                data-acc_holder = "' . $dataCidBank->acc_holder . '" data-pv_code = "' . $dataCidBank->pv_code . '"
                                
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit Bank CID</div>
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
            ->addColumn('action1', function ($dataCidBank) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id_cidb="'.$dataCidBank->id_cidb.'" data-cidbank = "' . $dataCidBank->cidbank . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function cidBankUpdate(Request $request, $id_cidb)
    {
        $bank_acc = $request->input('bank_acc');

        $uniqueAcc = DB::table('m_cid_bank')->where('bank_acc', $bank_acc)->first();

        $bank_acc = $request->input('bank_acc1');
        $id_bank = $request->input('id_bank1');
        $idCompany = $request->input('company_id1');
        $benefname = $request->input('acc1_holder');
        $pv_code = $request->input('pv_code1');
        $cidbank = $request->input('cidbank1');

        $uniqueAcc = DB::table('m_cid_bank')->where('aktifyn', '=', 'Y')->where('bank_acc', $bank_acc)->first();
        $dataAcc = DB::table('m_cid_bank')->where('aktifyn', '=', 'Y')->where('bank_acc', $bank_acc)->first();
        $bank = DB::table('m_bank')->where('id_bank', $id_bank)->pluck('name')->first();

        $isDifferent = (
            $uniqueAcc->id_bank != $id_bank ||
            $uniqueAcc->id_company != $idCompany ||
            $uniqueAcc->pv_code != $pv_code ||
            $uniqueAcc->acc_holder != $benefname ||
            $uniqueAcc->cidbank != $cidbank ||
            $uniqueAcc->bank_acc != $bank_acc
        );
            
        if ($dataAcc == null || ($dataAcc->id_cidb == $id_cidb && $isDifferent)) {
            DB::transaction(function() use($request, $id_cidb){
                DB::table('m_cid_bank')->where('id_cidb', $id_cidb)->update([
                    'id_company' => $request->input('company_id1'),
                    'cidbank' => $request->input('cidbank1'),
                    'id_bank' => $request->input('id_bank1'),
                    'bank_acc' => $request->input('bank_acc1'),
                    'acc_holder' => $request->input('acc1_holder'),
                    'pv_code' => $request->input('pv_code1'),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            });
            alert()->success('Success', 'Bank CID Has Been Updated');
            return to_route('cidbank.edit');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('cidbank.edit');
        }
    }

    public function cidBankDelete($id_cidb)
    {
        try {
            DB::transaction(function() use($id_cidb){
                DB::table('m_cid_bank')->where('id_cidb', $id_cidb)->update([
                    'aktifyn' => 'N',
                    'updated_by' => Auth::user()->id,
                    'updated_at'=> date('Y-m-d')
                ]);
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Bank CID",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function rabBank()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-rabbank.index', compact('dataChildCompany'));
    }

    public function rabBankList()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-rabbank.list', compact('dataChildCompany'));
    }

    public function rabBankForm()
    {
        $user = Auth::user()->company_id;
        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        }
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
        return view('pages.ga.data-master.m-rabbank.m-rabbank-form', compact('dataChildCompany', 'bank'));
    }

    public function rabBankEdit()
    {
        $user = Auth::user()->company_id;
        if ($user == '0' || $user == '999' || $user == '888') {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->orderBy('name', 'asc')->where('status', '=', 'Active')->get();
        } else {
            $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name')->where('m_child_company.id_company', $user)->first();
        }
        $bank = DB::table('m_bank')->where('status', '=', 'Active')->orderBy('id_bank', 'asc')->get();
        return view('pages.ga.data-master.m-rabbank.m-rabbank-edit', compact('dataChildCompany', 'bank'));
    }

    public function rabBankDeletePage()
    {
        $dataChildCompany = DB::table('m_child_company')->select('m_child_company.id_company', 'm_child_company.name', 'm_child_company.status')->where('status', '=', 'Active')->orderBy('m_child_company.name', 'asc')->get();
        return view('pages.ga.data-master.m-rabbank.m-rabbank-delete', compact('dataChildCompany'));
    }

    public function rabBankCreate(Request $request)
    {
        $bank_acc = $request->input('beneficiary_acc');
        $id_bank = $request->input('id_bank');

        $uniqueAcc = DB::table('m_benef_bank')->where('beneficiary_acc', $bank_acc)->first();
        $bank = DB::table('m_bank')->where('id_bank', $id_bank)->pluck('name')->first();
            
        if ($uniqueAcc == null) {
            DB::transaction(function() use($request, $bank){
                DB::table('m_benef_bank')->insert([
                    'id_company' => $request->input('company_id'),
                    'beneficiary_bank' => $bank,
                    'id_bank' => $request->input('id_bank'),
                    'beneficiary_acc' => $request->input('beneficiary_acc'),
                    'beneficiary_name' => $request->input('beneficiary_name'),
                    'desc' => $request->input('desc'),
                    'aktifyn' => 'Y',
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            });
            alert()->success('Success', 'Beneficiary Bank Has Been Created');
            return to_route('rabbank.form');
        } else {
            alert()->error('Error', 'Beneficiary Bank Already Exist');
            return to_route('rabbank.form');
        }
    }

    public function rabBankGetData(Request $request)
    {
        $dataCidBankQuery = DB::table('m_benef_bank')
        ->leftJoin('m_child_company', 'm_benef_bank.id_company', 'm_child_company.id_company')
        ->leftJoin('m_bank', 'm_benef_bank.id_bank', 'm_bank.id_bank')
        ->select('m_benef_bank.*', 'm_bank.name as bankName', 'm_child_company.name as companyName')->where('aktifyn', '=', 'Y'); 

        if ($request->input('company') != null){
            $dataCidBankQuery = $dataCidBankQuery->where('m_benef_bank.id_company', $request->company);
        }

        $dataCidBank = $dataCidBankQuery;
        if ($request->ajax()) {
            return DataTables::of($dataCidBank)
            ->editColumn('created_at', function ($dataCidBank) {
                return date('Y-m-d', strtotime($dataCidBank->created_at));
            })
            ->addColumn('action', function ($dataCidBank) {
                    return '   
                    <div class="flex flex-row justify-center">          
                        <div x-data="{ modalOpen: false }">
                            <button  class="btn btn-sm btn-modal text-sm bg-amber-500 hover:bg-amber-600 text-white ml-1" 
                                @click.prevent="modalOpen = true" aria-controls="scrollbar-modal" data-id_cidb="'.$dataCidBank->id_benef.'" data-id_bank="'.$dataCidBank->id_bank.'"
                                data-id_company = "' . $dataCidBank->id_company . '" data-bank_acc = "' . $dataCidBank->beneficiary_acc . '" data-acc_holder = "' . $dataCidBank->beneficiary_name . '"
                                data-desc = "' . $dataCidBank->desc . '"
                                
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
                                            <div class="font-semibold text-slate-800 text-sm">Edit RAB Beneficiary Bank</div>
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
            ->addColumn('action1', function ($dataCidBank) {
                return '   
                <div class="flex flex-row justify-center">  
                    <button  class="btn btn-sm btn-delete text-sm bg-red-500 hover:bg-red-600 text-white ml-1"
                        data-id_cidb="'.$dataCidBank->id_benef.'" data-cidbank = "' . $dataCidBank->beneficiary_name . '"
                        >Delete
                    </button>
                </div>';
            })
            ->rawColumns(['action', 'action1'])
            ->make();
        }
    }

    public function rabBankUpdate(Request $request, $id_cidb)
    {
        $bank_acc = $request->input('beneficiary_acc1');
        $id_bank = $request->input('id_bank1');
        $idCompany = $request->input('company_id1');
        $benefAcc = $request->input('beneficiary_acc1');
        $benefname = $request->input('beneficiary_name1');
        $desc = $request->input('desc1');

        $uniqueAcc = DB::table('m_benef_bank')->where('aktifyn', '=', 'Y')->where('beneficiary_acc', $bank_acc)->first();
        $dataAcc = DB::table('m_benef_bank')->where('aktifyn', '=', 'Y')->where('beneficiary_acc', $bank_acc)->first();
        $bank = DB::table('m_bank')->where('id_bank', $id_bank)->pluck('name')->first();

        $isDifferent = (
            $uniqueAcc->id_bank != $id_bank ||
            $uniqueAcc->id_company != $idCompany ||
            $uniqueAcc->beneficiary_acc != $benefAcc ||
            $uniqueAcc->beneficiary_name != $benefname ||
            $uniqueAcc->desc != $desc
        );
            
        if ($dataAcc == null || ($dataAcc->id_benef == $id_cidb && $isDifferent)) {
            DB::transaction(function() use($request, $id_cidb, $bank){
                DB::table('m_benef_bank')->where('id_benef', $id_cidb)->update([
                    'id_company' => $request->input('company_id1'),
                    'id_bank' => $request->input('id_bank1'),
                    'beneficiary_bank' => $bank,
                    'beneficiary_acc' => $request->input('beneficiary_acc1'),
                    'beneficiary_name' => $request->input('beneficiary_name1'),
                    'desc' => $request->input('desc1'),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            });
            alert()->success('Success', 'Beneficiary Bank Has Been Updated');
            return to_route('rabbank.edit');
        } else {
            alert()->error('Error', 'Error Occured');
            return to_route('rabbank.edit');
        }
    }

    public function rabBankDelete($id_cidb)
    {
        try {
            DB::transaction(function() use($id_cidb){
                DB::table('m_benef_bank')->where('id_benef', $id_cidb)->update([
                    'aktifyn' => 'N',
                    'updated_by' => Auth::user()->id,
                    'updated_at'=> date('Y-m-d')
                ]);
            });
            return response()->json([
                'status' => 1,
                'message' => "successfully deleted Benef Bank",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }
}