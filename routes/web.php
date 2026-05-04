<?php

use App\Http\Controllers\kpi\BudgetingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\calendar\CalendarController;
use App\Http\Controllers\calendar\CompanyCalendarController;
use App\Http\Controllers\CheckFixedAssetController;
use App\Http\Controllers\finance\ArDaysControllerFinance;
use App\Http\Controllers\finance\BalancesheetControllerFinance;
use App\Http\Controllers\finance\PnlsControllerFinance;
use App\Http\Controllers\finance\UploadTaxController;
use App\Http\Controllers\finance\PaymentController;
use App\Http\Controllers\ga\GeneralAffairController;
use App\Http\Controllers\ga\OfficeCatalogueController;
use App\Http\Controllers\ga\RabLpjController;
use App\Http\Controllers\ga\RabSummaryController;
use App\Http\Controllers\google\GoogleCalendarController;
use App\Http\Controllers\HR\AttendanceListAllController;
use App\Http\Controllers\HR\AttendanceListController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\HR\LeaveRequestController;
use App\Http\Controllers\HR\LeaveApprovalController;
use App\Http\Controllers\HR\LeaveAllowanceController;
use App\Http\Controllers\HR\LeaveApproval2Controller;
use App\Http\Controllers\HR\LeaveRequestAllController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\inventory\ExpiredGoodsController;
use App\Http\Controllers\inventory\InvAgingController;
use App\Http\Controllers\inventory\InventoryStockController;
use App\Http\Controllers\inventory\InvListController;
use App\Http\Controllers\inventory\InvCogsController;
use App\Http\Controllers\inventory\DoiController;
use App\Http\Controllers\inventory\TurnOverController;
use App\Http\Controllers\kanban\KanbanController;
use App\Http\Controllers\kpi\KpiController;
use App\Http\Controllers\kpi\WeeklyReportController;
use App\Http\Controllers\logistic\DamagedLostController;
use App\Http\Controllers\logistic\DoController;
use App\Http\Controllers\logistic\DoUpdateController;
use App\Http\Controllers\logistic\TrackingController;
use App\Http\Controllers\ManagementReport\ArDaysController;
use App\Http\Controllers\ManagementReport\BalancesheetController;
use App\Http\Controllers\ManagementReport\PnlsController;
use App\Http\Controllers\MenuSettingController;
use App\Http\Controllers\offering\ProductOfferingAllController;
use App\Http\Controllers\offering\ProductOfferingController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\purchasing\PurchasingController;
use App\Http\Controllers\purchasing\POPreSystemController;
use App\Http\Controllers\RabApprovalToController;
use App\Http\Controllers\request\DocumentRequestController;
use App\Http\Controllers\request\SampleRequestController;
use App\Http\Controllers\sales\SalesGlobalController;
use App\Http\Controllers\sales\TeamSalesController;
use App\Http\Controllers\sales\YourSalesController;
use App\Http\Controllers\sales\SalesInvoiceController;
use App\Http\Controllers\tugas\DeliveryReffController;
use App\Http\Controllers\tugas\ProyekController;
use App\Http\Controllers\tugas\ProyekSingleController;
use App\Http\Controllers\tugas\VisitingReportController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\ResetPasswordController;
use Faker\Guesser\Name;
use Illuminate\Auth\Notifications\ResetPassword;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/check', [TrackingController::class, 'index'])->name('tracking');
Route::get('/check/report/{doNumber}/{batchNo}/{productCode}', [TrackingController::class, 'report'])->name('tracking.report');
Route::get('/check/update', [TrackingController::class, 'updatePage'])->name('tracking.update');
Route::get('/check/productpage/{doNumber}/{batchNo}/{productCode}', [TrackingController::class, 'productPage'])->name('tracking.productpage');
Route::post('/check/{doNumber}', [TrackingController::class, 'updateDO'])->name('tracking.status');
Route::post('/check/{doNumber}/{batchNo}/{productCode}', [TrackingController::class, 'productDo'])->name('tracking.product');
Route::get('/check/photo1/{code}', [TrackingController::class, 'viewPhoto1'])->name('tracking.photo1');
Route::get('/check/photo2/{code}', [TrackingController::class, 'viewPhoto2'])->name('tracking.photo2');

Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('forgot.password');
Route::get('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
Route::post('/update-password', [ResetPasswordController::class, 'updatePassword'])->name('update.password');

Route::get('/purchase-approval/list/viewfile/{idPR}', [GeneralAffairController::class, 'purchaseViewFile'])->name('purchase-list.viewfile');
Route::get('/purchase-approval/list/quotation1/{idPR}', [GeneralAffairController::class, 'purchaseQuotation1'])->name('purchase-list.quotation1');
Route::get('/purchase-approval/list/quotation2/{idPR}', [GeneralAffairController::class, 'purchaseQuotation2'])->name('purchase-list.quotation2');
Route::get('/purchase-approval/list/quotation3/{idPR}', [GeneralAffairController::class, 'purchaseQuotation3'])->name('purchase-list.quotation3');
Route::get('/purchase-approve/app1/{idPR}', [GeneralAffairController::class, 'purchaseApproved1Page'])->name('purchase.approve1page');
Route::post('/purchase-approve/approve1/{idPR}', [GeneralAffairController::class, 'purchaseApproved1'])->name('purchase.approve1');

Route::get('/purchase-approve/app2/{idPR}', [GeneralAffairController::class, 'purchaseApproved2Page'])->name('purchase.approve2page');
Route::post('/purchase-approve/approve2/{idPR}', [GeneralAffairController::class, 'purchaseApproved2'])->name('purchase.approve2');

Route::get('/purchase-approve/app3/{idPR}', [GeneralAffairController::class, 'purchaseApproved3Page'])->name('purchase.approve3page');
Route::post('/purchase-approve/approve3/{idPR}', [GeneralAffairController::class, 'purchaseApproved3'])->name('purchase.approve3');

Route::get('/rab-approval/list/viewfile/{rabId}', [GeneralAffairController::class, 'viewFile'])->name('rab-list.viewfile');
Route::get('/rab-approve/app1/{rabId}', [GeneralAffairController::class, 'rabApproved1Page'])->name('rab.approve1page');
Route::post('/rab-approve/approve1/{rabId}', [GeneralAffairController::class, 'rabApproved1'])->name('rab.approve1');

Route::get('/rab-approve/app2/{rabId}', [GeneralAffairController::class, 'rabApproved2Page'])->name('rab.approve2page');
Route::post('/rab-approve/approve2/{rabId}', [GeneralAffairController::class, 'rabApproved2'])->name('rab.approve2');

Route::get('/rab-approve/app3/{rabId}', [GeneralAffairController::class, 'rabApproved3Page'])->name('rab.approve3page');
Route::post('/rab-approve/approve3/{rabId}', [GeneralAffairController::class, 'rabApproved3'])->name('rab.approve3');

Route::get('/reimburse-approval/list/viewfile/{idRR}', [GeneralAffairController::class, 'reimburseViewFile'])->name('reimburse-list.viewfile');
Route::get('/reimburse-approve/approve/{idRR}', [GeneralAffairController::class, 'reimburseApprovedPage'])->name('reimburse.approvepage');
Route::post('/reimburse-approve/approved/{idRR}', [GeneralAffairController::class, 'reimburseApproved'])->name('reimburse.approve');

Route::get('/reimburse-approve2/approve2/{idRR}', [GeneralAffairController::class, 'reimburseApproved2Page'])->name('reimburse2.approvepage');
Route::post('/reimburse-approve2/approved2/{idRR}', [GeneralAffairController::class, 'reimburseApproved2'])->name('reimburse2.approve');

Route::get('/assetTrack/fixedasset/{idfa}', [CheckFixedAssetController::class, 'fixedAssetPage'])->name('assetTrack.updatepage');
Route::post('/assetTrack/updatefixedasset/{idrec}', [CheckFixedAssetController::class, 'updateFixedAsset'])->name('assetTrack.update');

Route::get('/outbound-inventory/list/viewfile/{outboundId}', [InventoryStockController::class, 'viewFile'])->name('outbound-inventory.viewfile');
Route::get('/outbound-inventory/app/{outboundId}', [InventoryStockController::class, 'outboundApproved1Page'])->name('outbound.approvepage');
Route::post('/outbound-inventory/approve/{outboundId}', [InventoryStockController::class, 'outboundApproved1'])->name('outbound.approve');

Route::redirect('/', 'dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // ->middleware('checkRoleUser:500,501')

    Route::post('/update-gcal', [ProfileController::class, 'update'])->name('update.gcal');

    Route::prefix('management-report')->group(function () {
        Route::get('/ar-days', [ArDaysController::class, 'index'])->name('ar-days');
        Route::get('/ar-days/getdata', [ArDaysController::class, 'getData'])->name('ar-days.getdata');
        Route::get('/balancesheet/', [BalancesheetController::class, 'index'])->name('balancesheet');
        Route::get('/balancesheet/getdata', [BalancesheetController::class, 'getData'])->name('bs.getdata');
        Route::get('/balancesheet/file/{bsId}', [BalancesheetController::class, 'viewFile'])->name('bs.viewFile');
        Route::get('/pnls', [PnlsController::class, 'index'])->name('pnls');
        Route::get('/pnls/getdata', [PnlsController::class, 'getData'])->name('pnls.getdata');
        Route::get('/pnls/file/{pnlsId}', [PnlsController::class, 'viewFile'])->name('pnls.viewFile');
    });

    Route::prefix('inventory')->group(function () {
        Route::get('/expiredgoods', [ExpiredGoodsController::class, 'index'])->name('expiredgoods');
        Route::get('/expiredgoods/getdata', [ExpiredGoodsController::class, 'getData'])->name('expiredgoods.getdata');
        Route::get('/invaging', [InvAgingController::class, 'index'])->name('invaging');
        Route::get('/invaging/getdata', [InvAgingController::class, 'getData'])->name('invaging.getdata');
        Route::get('/invlist', [InvListController::class, 'index'])->name('invlist');
        Route::get('/invlist/getdata', [InvListController::class, 'getData'])->name('invlist.getdata');
        Route::get('/cogs', [InvCogsController::class, 'index'])->name('cogs');
        Route::get('/cogs/getdata', [InvCogsController::class, 'getData'])->name('cogs.getdata');
        Route::get('/doi', [DoiController::class, 'index'])->name('doi');
        Route::get('/doi/getdata', [DoiController::class, 'getData'])->name('doi.getdata');
        Route::get('/turnover', [TurnOverController::class, 'index'])->name('turnover');

        Route::get('/inbound-inventory/list', [InventoryStockController::class, 'stockList'])->name('inbound-inventory.list');
        Route::get('/inbound-inventory/listonly', [InventoryStockController::class, 'stockListonly'])->name('inbound-inventory.listonly');
        Route::get('/inbound-inventory/list/printconfirm', [InventoryStockController::class, 'inboundPrintConfirm'])->name('inbound-printconfirm');
        Route::get('/inbound-inventory/edit', [InventoryStockController::class, 'inboundListedit'])->name('inbound-inventoryedit');
        Route::get('/inbound-inventory/deletepage', [InventoryStockController::class, 'inboundListDeletePage'])->name('inbound-inventorydeletepage');
        Route::get('/inbound-inventory/form', [InventoryStockController::class, 'stockForm'])->name('inbound-inventory.form');
        Route::get('/inbound-inventory/list/view/{inboundId}', [InventoryStockController::class, 'inboundListView'])->name('inbound-inventory.view');
        Route::get('/inbound-inventory/list/viewfile/{inboundId}', [InventoryStockController::class, 'inboundViewFile'])->name('inbound-inventory.viewfile');
        Route::get('/inbound-inventory/list/updatepage/{inboundId}', [InventoryStockController::class, 'inboundListUpdatePage'])->name('inbound-inventory.updatepage');
        Route::post('/inbound-inventory/list/update/{inboundId}', [InventoryStockController::class, 'inboundListUpdate'])->name('inbound-inventory.update');
        Route::get('/inbound-inventory/list/print/{inboundId}', [InventoryStockController::class, 'inboundPrint'])->name('inbound-inventory.print');
        Route::post('/inbound-inventory/create', [InventoryStockController::class, 'stockCreate'])->name('inbound-inventory.create');
        Route::get('/inbound-inventory/list/signature/{inboundId}', [InventoryStockController::class, 'inboundSignature'])->name('inbound-inventory.signature');
        Route::post('/inbound-inventory/list/signatureupdate/{inboundId}', [InventoryStockController::class, 'inboundSignatureupdate'])->name('inbound-inventory.signatureupdate');
        Route::get('/inbound-inventory/list/confirmpage/{inboundId}', [InventoryStockController::class, 'inboundListConfirm'])->name('inbound-inventory.confirmpage');
        Route::post('/inbound-inventory/list/confirm/{inboundId}', [InventoryStockController::class, 'confirmInbound'])->name('inbound-approval.confirm');
        Route::get('/inbound-inventory/getdata', [InventoryStockController::class, 'stockGetData'])->name('inbound-inventory.getdata');
        Route::post('/inbound-inventory/delete/{inboundId}', [InventoryStockController::class, 'deleteInbound'])->name('inbound-inventory.delete');

        Route::get('/outbound-inventory', [InventoryStockController::class, 'outboundForm'])->name('outbound');
        Route::post('/outbound-inventory/create', [InventoryStockController::class, 'outboundCreate'])->name('outbound-inventory.create');

        Route::get('/outbound-inventory/request', [InventoryStockController::class, 'outboundList'])->name('outbound-inventory');
        Route::get('/outbound-inventory/list', [InventoryStockController::class, 'outboundListOnly'])->name('outbound-inventoryonly');
        Route::get('/outbound-inventory/edit', [InventoryStockController::class, 'outboundListedit'])->name('outbound-inventoryedit');
        Route::get('/outbound-inventory/deletepage', [InventoryStockController::class, 'outboundListDeletePage'])->name('outbound-inventorydeletepage');
        Route::get('/outbound-inventory/list/printsubmit', [InventoryStockController::class, 'outboundPrintSubmit'])->name('outbound-printsubmit');
        Route::get('/outbound-inventory/list/printlist', [InventoryStockController::class, 'outboundPrintList'])->name('outbound-printlist');
        Route::get('/outbound-inventory/list/signature/{outboundId}', [InventoryStockController::class, 'signature'])->name('outbound-inventory.signature');
        Route::post('/outbound-inventory/list/signatureupdate/{outboundId}', [InventoryStockController::class, 'signatureupdate'])->name('outbound-inventory.signatureupdate');
        Route::get('/outbound-inventory/list/print/{outboundId}', [InventoryStockController::class, 'print'])->name('outbound-inventory.print');
        Route::get('/outbound-inventory/list/getdata', [InventoryStockController::class, 'outboundListGetData'])->name('outbound-inventory.getdata');
        Route::get('/outbound-inventory/list/getprintsubmit', [InventoryStockController::class, 'outboundListGetPrintSubmit'])->name('outbound-inventory.getprintsubmit');
        Route::get('/outbound-inventory/list/getdataprint', [InventoryStockController::class, 'outboundListGetDataPrint'])->name('outbound-inventory.getdataprint');
        Route::get('/outbound-inventory/list/updatepage/{outboundId}', [InventoryStockController::class, 'outboundListUpdatePage'])->name('outbound-inventory.updatepage');
        Route::get('/outbound-inventory/list/submitpage/{outboundId}', [InventoryStockController::class, 'outboundListSubmit'])->name('outbound-inventory.submitpage');
        Route::get('/outbound-inventory/list/view/{outboundId}', [InventoryStockController::class, 'outboundListView'])->name('outbound-inventory.view');
        Route::post('/outbound-inventory/list/update/{outboundId}', [InventoryStockController::class, 'outboundListUpdate'])->name('outbound-inventory.update');
        Route::post('/outbound-inventory/list/submit/{outboundId}', [InventoryStockController::class, 'submitOutbound'])->name('outbound-approval.submit');
        Route::post('/outbound-inventory/cancel/{outboundId}', [InventoryStockController::class, 'cancelOutbound'])->name('outbound-inventory.canceled');
        Route::post('/outbound-inventory/delete/{outboundId}', [InventoryStockController::class, 'deleteOutbound'])->name('outbound-inventory.delete');

        Route::get('/outbound-inventory/approval1', [InventoryStockController::class, 'outboundApproval'])->name('outbound-approvalga');
        Route::get('/outbound-inventory/getdata', [InventoryStockController::class, 'outboundGetApproval'])->name('outbound-approvalga.getdata');
        Route::get('/outbound-inventory/approve/{outboundId}', [InventoryStockController::class, 'outboundApprove1'])->name('outbound-approve1');
        Route::post('/outbound-inventory/updatestatus/{outboundId}', [InventoryStockController::class, 'outboundUpdateStatus'])->name('outbound-approval.updatestatus');
    });

    Route::prefix('sales')->group(function () {
        Route::get('/salesglobal', [SalesGlobalController::class, 'index'])->name('salesglobal');
        Route::get('/salesglobal/getdata', [SalesGlobalController::class, 'getData'])->name('salesglobal.getdata');
        Route::get('/salesglobal/getdetail/{year}/{month}', [SalesGlobalController::class, 'getDetail'])->name('salesglobal.getdetail');
        Route::get('/team-sales', [TeamSalesController::class, 'index'])->name('teamsales');
        Route::get('/team-sales/getdata', [TeamSalesController::class, 'getData'])->name('teamsales.getdata');
        Route::get('/team-sales/getdetail/{year}/{month}/{salesman}', [TeamSalesController::class, 'getDetail'])->name('teamsales.getdetail');
        Route::get('/your-sales', [YourSalesController::class, 'index'])->name('yoursales');
        Route::get('/your-sales/getdata', [YourSalesController::class, 'getData'])->name('yoursales.getdata');
        Route::get('/your-sales/getdetail/{year}/{month}', [YourSalesController::class, 'getDetail'])->name('yoursales.getdetail');
        Route::get('/sales-invoice', [SalesInvoiceController::class, 'index'])->name('invoice');
        Route::get('/sales-invoice/getdata', [SalesInvoiceController::class, 'getData'])->name('invoice.getdata');
        Route::get('/sales-invoice/getdetail/{year}/{month}', [SalesInvoiceController::class, 'getDetail'])->name('invoice.getdetail');
        Route::get('/sales-invoice/file/{ordersId}', [SalesInvoiceController::class, 'viewFile'])->name('invoice.viewFile');
    });
    
    Route::prefix('purchasing')->group(function () {
        // Route::get('/purchase-request', [PurchasingController::class, 'form'])->name('purchase-request');
        // Route::post('/purchase-request/create', [PurchasingController::class, 'create'])->name('purchase-request.create');

        Route::get('/purchase-approval', [PurchasingController::class, 'approval'])->name('purchase-approval');
        Route::get('/purchase-approval/getdata', [PurchasingController::class, 'getApproval'])->name('purchase-approval.getdata');
        Route::get('/purchase-approval/getProduct/{idPO}', [PurchasingController::class, 'getProduct'])->name('purchase-approval.getproduct');
        Route::post('/purchase-approval/updateapprove/{idPO}', [PurchasingController::class, 'updateApprove'])->name('purchase-approval.updateapprove');
        Route::post('/purchase-approval/updatedenied/{idPO}', [PurchasingController::class, 'updateDenied'])->name('purchase-approval.updatedenied');

        Route::get('/purchase-order', [PurchasingController::class, 'order'])->name('purchase-order');
        Route::get('/purchase-order/getdata', [PurchasingController::class, 'getOrder'])->name('purchase-order.getdata');
        Route::get('/purchase-order/dashboard', [PurchasingController::class, 'purchaseDashboard'])->name('purchase-order.dashboard');

        Route::get('/purchase-kpi', [PurchasingController::class, 'kpi'])->name('purchase-kpi');
        Route::get('/purchase-kpi/getdata', [PurchasingController::class, 'getKpi'])->name('purchase-kpi.getdata');
        Route::get('/purchase-kpi/getdetail/{idKpi}', [PurchasingController::class, 'getDetail'])->name('purchase-kpi.getdetail');

        Route::get('/purchase-request', [GeneralAffairController::class, 'purchase'])->name('purchase-requestga');
        Route::get('/purchase-request/invasset', [GeneralAffairController::class, 'invAsset'])->name('purchase.invasset');
        Route::get('/purchase-request/purchasset', [GeneralAffairController::class, 'purchaseAsset'])->name('purchase.asset');
        Route::get('/purchase-request/address', [GeneralAffairController::class, 'devAddress'])->name('delivery.address');
        Route::post('/purchase-request/create', [GeneralAffairController::class, 'purchaseCreate'])->name('purchase-request.createga');

        Route::get('/purchase-approval/list/getdashboard', [GeneralAffairController::class, 'purchaseListGetDashboard'])->name('purchase-list.getdashboard');
        Route::get('/purchase-approval/request', [GeneralAffairController::class, 'purchaseList'])->name('purchase-list');
        Route::get('/purchase-approval/list', [GeneralAffairController::class, 'purchaseListOnly'])->name('purchase-list-only');
        Route::get('/purchase-approval/updateprice', [GeneralAffairController::class, 'purchaseUpdatePrice'])->name('purchase-updateprice');
        Route::get('/purchase-approval/printsubmit', [GeneralAffairController::class, 'purchasePrintSubmit'])->name('purchase-printsubmit');
        Route::get('/purchase-approval/submitquotation', [GeneralAffairController::class, 'purchaseQuoSub'])->name('purchase-submitquotation');
        Route::get('/purchase-approval/list/signature/{idPR}', [GeneralAffairController::class, 'purchaseSignature'])->name('purchase-list.signature');
        Route::post('/purchase-approval/list/signatureupdate/{idPR}', [GeneralAffairController::class, 'purchaseSignatureUpdate'])->name('purchase-list.signatureupdate');
        Route::get('/purchase-approval/list/print/{idPR}', [GeneralAffairController::class, 'purchasePrint'])->name('purchase-list.print');
        Route::get('/purchase-approval/list/selectrab', [GeneralAffairController::class, 'selectRab'])->name('purchase-list.selectrab');
        Route::get('/purchase-approval/list/selectrabdetail', [GeneralAffairController::class, 'selectRabDetail'])->name('purchase-list.selectrabdetail');
        Route::get('/purchase-approval/list/rabdetail/{rabId}', [GeneralAffairController::class, 'selectRabGetDetail'])->name('rabselect.getdetail');
        Route::get('/purchase-approval/list/getdata', [GeneralAffairController::class, 'purchaseListGetData'])->name('purchase-list.getdata');
        Route::get('/purchase-approval/list/getprice', [GeneralAffairController::class, 'purchaseListGetPrice'])->name('purchase-list.getprice');
        Route::get('/purchase-approval/list/getprintsubmit', [GeneralAffairController::class, 'purchaseListGetPrintSubmit'])->name('purchase-list.getprintsubmit');
        Route::get('/purchase-approval/list/getquotation', [GeneralAffairController::class, 'purchaseListGetQuotation'])->name('purchase-list.getquotation');
        Route::get('/purchase-approval/list/updatepage/{idPR}', [GeneralAffairController::class, 'purchaseUpdatePage'])->name('purchase-list.updatepage');
        Route::get('/purchase-approval/list/priceupdate/{idPR}', [GeneralAffairController::class, 'purchaseUpdatePage1'])->name('purchase-list.priceupdate');
        Route::get('/purchase-approval/list/submitpage/{idPR}', [GeneralAffairController::class, 'purchaseSubmitPage'])->name('purchase-list.submitpage');
        Route::get('/purchase-approval/list/submitapproval/{idPR}', [GeneralAffairController::class, 'purchaseSubmitApprovalPage'])->name('purchase-list.submitapproval');
        Route::get('/purchase-approval/list/quotationpage/{idPR}', [GeneralAffairController::class, 'purchaseQuotationPage'])->name('purchase-list.quotationpage');
        Route::get('/purchase-approval/list/clonepage/{idPR}', [GeneralAffairController::class, 'purchaseClonePage'])->name('purchase-list.clonepage');
        Route::get('/purchase-approval/list/view/{idPR}', [GeneralAffairController::class, 'purchaseView'])->name('purchase-list.view');
        Route::post('/purchase-approval/list/update/{idPR}', [GeneralAffairController::class, 'purchaseUpdate'])->name('purchase-list.update');
        Route::post('/purchase-approval/list/update1/{idPR}', [GeneralAffairController::class, 'purchaseUpdate1'])->name('purchase-list.update1');
        Route::post('/purchase-approval/list/submit/{idPR}', [GeneralAffairController::class, 'purchaseSubmit'])->name('purchase-list.submit');
        Route::post('/purchase-approval/list/submittedapproval/{idPR}', [GeneralAffairController::class, 'purchaseApprovalSubmit'])->name('purchase-list.submittedapproval');
        Route::post('/purchase-approval/list/quotationsubmit/{idPR}', [GeneralAffairController::class, 'quotationSubmit'])->name('purchase-list.quotationsubmit');
        Route::post('/purchase-approval/list/clone/{idPR}', [GeneralAffairController::class, 'purchaseClone'])->name('purchase-list.clone');
        Route::post('/purchase-approval/cancel/{idPR}', [GeneralAffairController::class, 'cancelPurchase'])->name('purchase-list.canceled');

        Route::get('/purchase-approval', [GeneralAffairController::class, 'purchaseApproval'])->name('purchase-approvalga');
        Route::get('/purchase-approval/getdata', [GeneralAffairController::class, 'purchaseGetApproval'])->name('purchase-approvalga.getdata');
        Route::get('/purchase-approval/approve1/{idPR}', [GeneralAffairController::class, 'purchaseApprove1'])->name('purchase-approve1');
        Route::post('/purchase-approval/updatestatus/{idPR}', [GeneralAffairController::class, 'purchaseUpdateStatus'])->name('purchase-approvalga.updatestatus');
        Route::post('/purchase-approval/cancel/{idPR}', [GeneralAffairController::class, 'cancelPurchase'])->name('purchase-approvalga.cancel');

        Route::get('/purchase-approval2', [GeneralAffairController::class, 'purchaseApproval2'])->name('purchase-approvalga2');
        Route::get('/purchase-approval2/getdata2', [GeneralAffairController::class, 'purchaseGetApproval2'])->name('purchase-approvalga2.getdata');
        Route::get('/purchase-approval2/approve2/{idPR}', [GeneralAffairController::class, 'purchaseApprove2'])->name('purchase-approve2');
        Route::post('/purchase-approval2/updatestatus2/{idPR}', [GeneralAffairController::class, 'purchaseUpdateStatus2'])->name('purchase-approvalga2.updatestatus');

        Route::get('/purchase-approval3', [GeneralAffairController::class, 'purchaseApproval3'])->name('purchase-approvalga3');
        Route::get('/purchase-approval3/getdata3', [GeneralAffairController::class, 'purchaseGetApproval3'])->name('purchase-approvalga3.getdata');
        Route::get('/purchase-approval3/approve3/{idPR}', [GeneralAffairController::class, 'purchaseApprove3'])->name('purchase-approve3');
        Route::post('/purchase-approval3/updatestatus3/{idPR}', [GeneralAffairController::class, 'purchaseUpdateStatus3'])->name('purchase-approvalga3.updatestatus');

        Route::get('/po-presystem', [POPreSystemController::class, 'poForm'])->name('po-presystem.form');
        Route::post('/po-presystem/create', [POPreSystemController::class, 'poCreate'])->name('po-presystem.create');
        Route::get('/po-presystem/request', [POPreSystemController::class, 'poList'])->name('po-presystem.list');
        Route::get('/po-presystem/list', [POPreSystemController::class, 'poListOnly'])->name('po-presystem.only');
        Route::get('/po-presystem/edit', [POPreSystemController::class, 'poEdit'])->name('po-presystem.edit');
        Route::get('/po-presystem/view/{idPO}', [POPreSystemController::class, 'poView'])->name('po-presystem.view');
        Route::get('/po-presystem/viewfile/{idPO}', [POPreSystemController::class, 'viewFile'])->name('po-presystem.viewfile');
        Route::get('/po-presystem/updatepage/{idPO}', [POPreSystemController::class, 'poUpdatePage'])->name('po-presystem.updatepage');
        Route::get('/po-presystem/getdata', [POPreSystemController::class, 'poListGetData'])->name('po-presystem.getdata');
        Route::post('/po-presystem/update/{idPO}', [POPreSystemController::class, 'poUpdate'])->name('po-presystem.update');
    });

    Route::prefix('logistic')->group(function () {
        Route::get('/do', [DoController::class, 'index'])->name('delivery-orders');
        Route::get('/do/getdata', [DoController::class, 'getData'])->name('delivery-orders.getdata');
        Route::get('/do/getdetail/{code}', [DoController::class, 'getDetail'])->name('delivery-orders.getdetail');
        Route::get('/do/photo1/{code}', [DoController::class, 'viewPhoto1'])->name('do.photo1');
        Route::get('/do/photo2/{code}', [DoController::class, 'viewPhoto2'])->name('do.photo2');
        Route::get('/do/getdashboard', [DoController::class, 'getDashboard'])->name('delivery-orders.getdashboard');

        Route::get('/doupdate', [DoUpdateController::class, 'index'])->name('do-update');
        Route::get('/doupdate/getdata', [DoUpdateController::class, 'getData'])->name('do-update.getdata');
        Route::get('/doupdate/getdetail/{code}', [DoUpdateController::class, 'getDetail'])->name('do-update.getdetail');
        Route::post('/doupdate/{doNumber}', [DoUpdateController::class, 'updateDO'])->name('do-update.status');
        Route::get('/doupdate/photo1/{code}', [DoUpdateController::class, 'viewPhoto1'])->name('do-update.photo1');
        Route::get('/doupdate/photo2/{code}', [DoUpdateController::class, 'viewPhoto2'])->name('do-update.photo2');
        Route::get('/doupdate/doupdatepage/{code}', [DoUpdateController::class, 'updatePage'])->name('do-update.updatepage');

        Route::get('/damage-lost', [DamagedLostController::class, 'index'])->name('damage-lost');
        Route::get('/damage-lost/getdata', [DamagedLostController::class, 'getData'])->name('damage-lost.getdata');
        Route::get('/damage-lost/getdetail/{doNumber}', [DamagedLostController::class, 'getDetail'])->name('damage-lost.getdetail');
        Route::get('/damage-lost/photo1/{doNumber}/{batchNo}/{productCode}', [DamagedLostController::class, 'viewPhoto1'])->name('damage-lost.photo1');
        Route::get('/damage-lost/photo2/{doNumber}/{batchNo}/{productCode}', [DamagedLostController::class, 'viewPhoto2'])->name('damage-lost.photo2');
        Route::get('/damage-lost/photo3/{doNumber}/{batchNo}/{productCode}', [DamagedLostController::class, 'viewPhoto3'])->name('damage-lost.photo3');
        Route::get('/damage-lost/photo4/{doNumber}/{batchNo}/{productCode}', [DamagedLostController::class, 'viewPhoto4'])->name('damage-lost.photo4');
    });
    
    Route::prefix('finance')->group(function () {
        Route::get('/ar-days', [ArDaysControllerFinance::class, 'index'])->name('ar-days-finance');
        Route::get('/ar-days/getdata', [ArDaysControllerFinance::class, 'getData'])->name('ar-days-finance.getdata');

        Route::get('/balancesheet/', [BalancesheetControllerFinance::class, 'index'])->name('balancesheet-finance');
        Route::get('/balancesheet/getdata', [BalancesheetControllerFinance::class, 'getData'])->name('bs-finance.getdata');
        Route::get('/balancesheet/file/{bsId}', [BalancesheetControllerFinance::class, 'viewFile'])->name('bs-finance.viewFile');

        Route::get('/pnls', [PnlsControllerFinance::class, 'index'])->name('pnls-finance');
        Route::get('/pnls/getdata', [PnlsControllerFinance::class, 'getData'])->name('pnls-finance.getdata');
        Route::get('/pnls/file/{pnlsId}', [PnlsControllerFinance::class, 'viewFile'])->name('pnls-finance.viewFile');

        Route::get('/costcenter-request', [GeneralAffairController::class, 'costcenter'])->name('costcenter-request');
        Route::post('/costcenter-request/create', [GeneralAffairController::class, 'costCreate'])->name('costcenter-request.create');

        Route::get('/costcenter-approval/list', [GeneralAffairController::class, 'costListOnly'])->name('cost-listonly');
        Route::get('/costcenter-approval/request', [GeneralAffairController::class, 'costList'])->name('cost-list');
        Route::get('/costcenter-approval/printvoucher', [GeneralAffairController::class, 'printVoucherCost'])->name('cost-list.printvoucher');
        Route::get('/costcenter-approval/submitpaymentproof', [GeneralAffairController::class, 'submitPaymentProof'])->name('cost-list.submitpaymentproof');
        Route::get('/costcenter-approval/editpaymentproof', [GeneralAffairController::class, 'editPaymentProof'])->name('cost-list.editpaymentproof');
        Route::get('/costcenter-approval/list/getdata', [GeneralAffairController::class, 'costListGetData'])->name('cost-list.getdata');
        Route::get('/costcenter-approval/list/getprintvoucher', [GeneralAffairController::class, 'costGetPrintVoucher'])->name('cost-list.getprintvoucher');
        Route::get('/costcenter-approval/list/getsubmitvoucher', [GeneralAffairController::class, 'costGetSubmitVoucher'])->name('cost-list.getsubmitvoucher');
        Route::get('/costcenter-approval/list/view/{idCC}', [GeneralAffairController::class, 'costView'])->name('cost-list.view');
        Route::get('/costcenter-approval/list/clonepage/{idCC}', [GeneralAffairController::class, 'costClonePage'])->name('cost-list.clonepage');
        Route::get('/costcenter-approval/list/updatepage/{idCC}', [GeneralAffairController::class, 'costUpdatePage'])->name('cost-list.updatepage');
        Route::get('/costcenter-approval/list/submitpage/{idCC}', [GeneralAffairController::class, 'costSubmitPage'])->name('cost-list.submitpage');
        Route::get('/costcenter-approval/submitpayment/{idCC}', [GeneralAffairController::class, 'submitPaymentPageCost'])->name('cost-list.submitpayment');
        Route::post('/costcenter-approval/list/submit/{idCC}', [GeneralAffairController::class, 'costSubmit'])->name('cost-list.submit');
        Route::post('/costcenter-approval/list/submitpay/{idCC}', [GeneralAffairController::class, 'costSubmitPay'])->name('cost-list.submitpay');
        Route::post('/costcenter-approval/list/signatureupdate/{idCC}', [GeneralAffairController::class, 'costSignatureUpdate'])->name('cost-list.signatureupdate');
        Route::get('/costcenter-approval/list/print/{idCC}', [GeneralAffairController::class, 'costPrint'])->name('cost-list.print');
        Route::get('/costcenter-approval/list/costfile/{idCC}', [GeneralAffairController::class, 'costViewFile'])->name('cost-list.costfile');
        Route::get('/costcenter-approval/list/costfiledp/{idCC}', [GeneralAffairController::class, 'costViewFileDP'])->name('cost-list.costfiledp');
        Route::get('/costcenter-approval/list/paymentfile/{idCC}', [GeneralAffairController::class, 'costViewPayment'])->name('cost-list.paymentfile');
        Route::post('/costcenter-approval/list/update/{idCC}', [GeneralAffairController::class, 'costListUpdate'])->name('cost-list.update');
        Route::post('/costcenter-approval/list/clone/{idCC}', [GeneralAffairController::class, 'costListClone'])->name('cost-list.clone');
        Route::delete('/costcenter-approval/list/deleteitem/{id}', [GeneralAffairController::class, 'deleteCostDetail'])->name('cost-list.deleteitem');

        Route::get('/costcenter-approval', [GeneralAffairController::class, 'costApproval'])->name('costcenter-approval');
        Route::get('/costcenter-approval/getdata', [GeneralAffairController::class, 'costGetApproval'])->name('costcenter-approval.getdata');
        Route::get('/costcenter-approval/approve1/{idCC}', [GeneralAffairController::class, 'costApprove1'])->name('costcenter-approval-approve1');
        Route::post('/costcenter-approval/updatestatus/{idCC}', [GeneralAffairController::class, 'costUpdateStatus'])->name('costcenter-approval-approvalga.updatestatus');
        Route::post('/costcenter-approval/cancel/{idCC}', [GeneralAffairController::class, 'cancelcost'])->name('costcenter-approval-approval.cancel');

        Route::get('/payment/list', [PaymentController::class, 'paymentListOnly'])->name('payment-listonly');
        Route::get('/payment/list/request', [PaymentController::class, 'paymentList'])->name('payment-list');
        Route::get('/payment/list/form/{cpId}', [PaymentController::class, 'paymentForm'])->name('payment-list.form');
        Route::get('/payment/list/formpayment', [PaymentController::class, 'formPayment'])->name('form.payment');
        Route::post('/payment/list/create', [PaymentController::class, 'paymentCreate'])->name('payment-list.create');
        // Route::post('/payment/list/create', [PaymentController::class, 'paymentCreates'])->name('payment-list.creates');
        Route::get('/payment/list/confirmpaymentlist', [PaymentController::class, 'confirmPay'])->name('payment-list.confirmpaymentlist');
        Route::get('/payment/list/cancelpaymentlist', [PaymentController::class, 'cancelPay'])->name('payment-list.cancelpaymentlist');
        Route::get('/payment/list/confirmpaymentpage/{payId}', [PaymentController::class, 'confirmPaymentPage'])->name('payment-list.confirmpaymentpage');
        Route::post('/payment/list/confirm/{payId}', [PaymentController::class, 'confirmPayment'])->name('payment-list.confirm');
        Route::get('/payment/list/print/{payId}', [PaymentController::class, 'print'])->name('payment-list.print');
        Route::get('/payment/list/getdata', [PaymentController::class, 'paymentListGetData'])->name('payment-list.getdata');
        Route::get('/payment/list/payselect', [PaymentController::class, 'paymentSelect'])->name('payment.select');
        Route::get('/payment/list/selectpay', [PaymentController::class, 'selectPayment'])->name('select.payment');
        Route::get('/payment/list/getdetail', [PaymentController::class, 'paymentListGetDetail'])->name('payment-list.getdetail');
        Route::get('/payment/list/getdetail1', [PaymentController::class, 'paymentListGetDetail1'])->name('payment-list.getdetail1');
        Route::get('/payment/list/getdetail2', [PaymentController::class, 'paymentListGetDetail2'])->name('payment-list.getdetail2');
        Route::get('/payment/list/getdatadetail/{cpId}', [PaymentController::class, 'paymentDetailGetData'])->name('payment-list.getdatadetail');
        Route::get('/payment/list/paydetail/{cpId}', [PaymentController::class, 'payDetail'])->name('payment-list.paydetail');
        Route::get('/payment/list/payupdate', [PaymentController::class, 'payUpdate'])->name('payment-list.payupdate');
        Route::get('/payment/list/updatepage/{payId}', [PaymentController::class, 'paymentUpdatePage'])->name('payment-list.updatepage');
        Route::post('/payment/list/update/{payId}', [PaymentController::class, 'paymentUpdate'])->name('payment-list.update');
        Route::post('/payment/list/printupdate/{payId}', [PaymentController::class, 'paymentPrintUpdate'])->name('payment-list.printupdate');
        Route::get('/payment/list/viewfile/{payId}', [PaymentController::class, 'paymentFile'])->name('payment-list.viewfile');
        Route::post('/payment/list/return/{cpId}', [PaymentController::class, 'returnpayment'])->name('payment-list.returnpayment');
        Route::post('/payment/list/cancel/{cpId}', [PaymentController::class, 'cancelPayment'])->name('purchase-list.canceled');
        Route::post('/payment/list/updatestatus/{cpId}', [PaymentController::class, 'updateStatus'])->name('purchase-list.updatestatus');
    });

    Route::prefix('efaktur')->group(function () {
        Route::get('/', [UploadTaxController::class, 'index'])->name('upload-tax');
        Route::get('/getdata', [UploadTaxController::class, 'getData'])->name('tax-getdata');
        Route::get('/{code}', [UploadTaxController::class, 'viewInv'])->name('tax-invoice');
        Route::post('/upload/{code}', [UploadTaxController::class, 'taxUpload'])->name('tax-upload');
        Route::post('/delete/{code}', [UploadTaxController::class, 'taxDelete'])->name('tax-delete');
    });

    Route::prefix('hr')->group(function () {
        Route::get('/leaverequest/leaverequests', [LeaveRequestController::class, 'index'])->name('leaverequests');
        Route::get('/leaverequest/leaverequests/getdata', [LeaveRequestController::class, 'getData'])->name('leaverequests.getdata');
        Route::get('/leaverequest/leaverequests/form', [LeaveRequestController::class, 'form'])->name('leaverequests.form');
        Route::post('/leaverequest/leaverequests/create', [LeaveRequestController::class, 'create'])->name('leaverequests.create');
        Route::get('/leaverequest/leaverequests/getdetail/{leaveId}', [LeaveRequestController::class, 'getDetail'])->name('leaverequests.getdetail');
        Route::get('/leaverequest/leaverequests/document/{leaveId}', [LeaveRequestController::class, 'viewDocument'])->name('leaverequests.document');

        Route::get('/leaverequest/leaverequest-all', [LeaveRequestAllController::class, 'index'])->name('leaverequest-all');
        Route::get('/leaverequest/leaverequest-all/getdata', [LeaveRequestAllController::class, 'getData'])->name('leaverequest-all.getdata');
        Route::get('/leaverequest/leaverequest-all/getdetail/{leaveId}', [LeaveRequestAllController::class, 'getDetail'])->name('leaverequest-all.getdetail');
        Route::get('/leaverequest/leaverequest-all/document/{leaveId}', [LeaveRequestAllController::class, 'viewDocument'])->name('leaverequest-all.document');

        Route::get('/leaveapproval', [LeaveApprovalController::class, 'index'])->name('leaveapproval');
        Route::get('/leaveapproval/getdata', [LeaveApprovalController::class, 'getData'])->name('leaveapproval.getdata');
        Route::get('/leaveapproval/getdetail/{leaveId}', [LeaveApprovalController::class, 'getDetail'])->name('leaveapproval.getdetail');
        Route::get('/leaveapproval/document/{leaveId}', [LeaveApprovalController::class, 'viewDocument'])->name('leaveapproval.document');
        Route::post('/leaveapproval/updateapprove/{leaveId}', [LeaveApprovalController::class, 'updateApprove'])->name('leaveapproval.updateapprove');
        Route::post('/leaveapproval/updatedenied/{leaveId}', [LeaveApprovalController::class, 'updateDenied'])->name('leaveapproval.updatedenied');

        Route::get('/leaveapproval2', [LeaveApproval2Controller::class, 'index'])->name('leaveapproval2');
        Route::get('/leaveapproval2/getdata', [LeaveApproval2Controller::class, 'getData'])->name('leaveapproval2.getdata');
        Route::get('/leaveapproval2/getdetail/{leaveId}', [LeaveApproval2Controller::class, 'getDetail'])->name('leaveapproval2.getdetail');
        Route::get('/leaveapproval2/document/{leaveId}', [LeaveApproval2Controller::class, 'viewDocument'])->name('leaveapproval2.document');
        Route::post('/leaveapproval2/updateapprove/{leaveId}', [LeaveApproval2Controller::class, 'updateApprove'])->name('leaveapproval2.updateapprove');
        Route::post('/leaveapproval2/updatedenied/{leaveId}', [LeaveApproval2Controller::class, 'updateDenied'])->name('leaveapproval2.updatedenied');

        Route::get('/leavallow', [LeaveAllowanceController::class, 'index'])->name('leaveallow');
        Route::get('/leavallow/getData', [LeaveAllowanceController::class, 'getData'])->name('leaveallow.getdata');
        Route::get('/leavallow/getdetail/{leaveId}', [LeaveAllowanceController::class, 'getDetail'])->name('leaveallow.getdetail');
        Route::get('/leavallow/document/{leaveId}', [LeaveAllowanceController::class, 'viewDocument'])->name('leaveallow.document');

        Route::get('/attendancelist/attendancelists', [AttendanceListController::class, 'index'])->name('attendancelist');
        Route::get('/attendancelist/attendancelists/getdata', [AttendanceListController::class, 'getData'])->name('attandance.getdata');

        Route::get('/attendancelist/attendancelist-all', [AttendanceListAllController::class, 'index'])->name('attendancelist-all');
        Route::get('/attendancelist/attendancelist-all/getdata', [AttendanceListAllController::class, 'getData'])->name('attendancelist-all.getdata');
        Route::get('/attendancelist/attendancelist-all/getdashboard', [AttendanceListAllController::class, 'getDashboard'])->name('attendancelist-all.getdashboard');

        Route::get('/employee/list', [EmployeeController::class, 'employeeOnly'])->name('employeeonly');
        Route::get('/employee', [EmployeeController::class, 'employee'])->name('employee');
        Route::get('/employee/form', [EmployeeController::class, 'employeeForm'])->name('employee.form');
        Route::get('/employee/edit', [EmployeeController::class, 'employeeEdit'])->name('employee.edit');
        Route::get('/employee/updatepage/{employeeId}', [EmployeeController::class, 'employeeupdatepage'])->name('employee.updatepage');
        Route::get('/employee/deletepage', [EmployeeController::class, 'employeeDeletePage'])->name('employee.deletepage');
        Route::get('/employee/getdata', [EmployeeController::class, 'employeeGetData'])->name('employee.getdata');
        Route::post('/employee/create', [EmployeeController::class, 'employeeCreate'])->name('employee.create');
        Route::post('/employee/update/{employeeId}', [EmployeeController::class, 'employeeUpdate'])->name('employee.update');
        Route::delete('/employee/delete/{employeeId}', [EmployeeController::class, 'employeeDelete'])->name('employee.delete');
    });

    Route::prefix('ga')->group(function () {
        Route::get('/inventory-code', [GeneralAffairController::class, 'codeForm'])->name('inventory-code');
        Route::get('/inventory-code/invbudget', [GeneralAffairController::class, 'invBudget'])->name('inventory-code.invbudget');
        Route::post('/inventory-code/create', [GeneralAffairController::class, 'codeCreate'])->name('inventory-code.create');

        Route::get('/reimburse-request', [GeneralAffairController::class, 'reimburse'])->name('reimburse-request');
        Route::post('/reimburse-request/create', [GeneralAffairController::class, 'reimburseCreate'])->name('reimburse-request.create');

        Route::get('/reimburse-approval', [GeneralAffairController::class, 'reimburseApproval'])->name('reimburse-approval');
        Route::get('/reimburse-approval/getdata', [GeneralAffairController::class, 'reimburseGetApproval'])->name('reimburse-approval.getdata');
        Route::get('/reimburse-approval/file/{id}', [GeneralAffairController::class, 'viewFileReimburse'])->name('reimburse-approval.file');
        Route::get('/reimburse-approval/approve1/{idRR}', [GeneralAffairController::class, 'reimburseApprove1'])->name('reimburse-approve1');
        Route::post('/reimburse-approval/updatestatus/{idRR}', [GeneralAffairController::class, 'reimburseUpdateStatus'])->name('reimburse-approvalga.updatestatus');
        Route::post('/reimburse-approval/cancel/{idRR}', [GeneralAffairController::class, 'cancelReimburse'])->name('reimburse-approval.cancel');

        Route::get('/reimburse-approval2', [GeneralAffairController::class, 'reimburseApproval2'])->name('reimburse-approval2');
        Route::get('/reimburse-approval/getdata2', [GeneralAffairController::class, 'reimburseGetApproval2'])->name('reimburse-approval2.getdata');
        Route::get('/reimburse-approval2/approve2/{idRR}', [GeneralAffairController::class, 'reimburseApprove2'])->name('reimburse-approve2');
        Route::post('/reimburse-approval2/updatestatus2/{idRR}', [GeneralAffairController::class, 'reimburseUpdateStatus2'])->name('reimburse-approvalga2.updatestatus');

        Route::get('/reimburse-approval/list', [GeneralAffairController::class, 'reimburseListOnly'])->name('reimburse-listonly');
        Route::get('/reimburse-approval/request', [GeneralAffairController::class, 'reimburseList'])->name('reimburse-list');
        Route::get('/reimburse-approval/printvoucher', [GeneralAffairController::class, 'printVoucher'])->name('reimburse-list.printvoucher');
        Route::get('/reimburse-approval/submitpaymentproof', [GeneralAffairController::class, 'submitPaymentProved'])->name('reimburse-list.submitpaymentprove');
        Route::get('/reimburse-approval/editpaymentproof', [GeneralAffairController::class, 'editPaymentProved'])->name('reimburse-list.editpaymentprove');
        Route::get('/reimburse-approval/list/getdata', [GeneralAffairController::class, 'ReimburseListGetData'])->name('reimburse-list.getdata');
        Route::get('/reimburse-approval/list/getprintvoucher', [GeneralAffairController::class, 'ReimburseGetPrintVoucher'])->name('reimburse-list.getprintvoucher');
        Route::get('/reimburse-approval/list/getsubmitvoucher', [GeneralAffairController::class, 'ReimburseGetSubmitVoucher'])->name('reimburse-list.getsubmitvoucher');
        Route::get('/reimburse-approval/list/view/{idRR}', [GeneralAffairController::class, 'reimburseView'])->name('reimburse-list.view');
        Route::get('/reimburse-approval/list/updatepage/{idRR}', [GeneralAffairController::class, 'reimburseUpdatePage'])->name('reimburse-list.updatepage');
        Route::get('/reimburse-approval/list/submitpage/{idRR}', [GeneralAffairController::class, 'reimburseSubmitPage'])->name('reimburse-list.submitpage');
        Route::get('/reimburse-approval/submitpayment/{idRR}', [GeneralAffairController::class, 'submitPaymentPage'])->name('reimburse-list.submitpayment');
        Route::post('/reimburse-approval/list/submit/{idRR}', [GeneralAffairController::class, 'reimburseSubmit'])->name('reimburse-list.submit');
        Route::post('/reimburse-approval/list/submitpay/{idRR}', [GeneralAffairController::class, 'reimburseSubmitPay'])->name('reimburse-list.submitpay');
        Route::get('/reimburse-approval/list/signature/{idRR}', [GeneralAffairController::class, 'reimburseSignature'])->name('reimburse-list.signature');
        Route::post('/reimburse-approval/list/signatureupdate/{idRR}', [GeneralAffairController::class, 'reimburseSignatureUpdate'])->name('reimburse-list.signatureupdate');
        Route::get('/reimburse-approval/list/print/{idRR}', [GeneralAffairController::class, 'reimbursePrint'])->name('reimburse-list.print');
        Route::get('/reimburse-approval/list/viewdocument/{idRR}', [GeneralAffairController::class, 'reimburseViewDocument'])->name('reimburse-list.viewdocument');
        Route::get('/reimburse-approval/list/getdashboard', [GeneralAffairController::class, 'ReimburseListGetDashboard'])->name('reimburse-list.getdashboard');
        Route::post('/reimburse-approval/list/update/{idRR}', [GeneralAffairController::class, 'ReimburseListUpdate'])->name('reimburse-list.update');
        Route::delete('/reimburse-approval/list/deleteitem/{id}', [GeneralAffairController::class, 'deleteReimburseDetail'])->name('reimburse-list.deleteitem');

        Route::get('/office-inventory', [GeneralAffairController::class, 'inventoryOnly'])->name('office-inventoryonly');
        Route::get('/office-inventory/code', [GeneralAffairController::class, 'inventory'])->name('office-inventory');
        Route::get('/office-inventory/edit', [GeneralAffairController::class, 'inventoryEdit'])->name('office-inventory.edit');
        Route::get('/office-inventory/deletepage', [GeneralAffairController::class, 'inventoryDeletePage'])->name('office-inventory.deletepage');
        Route::get('/office-inventory/updatepage/{idAsset}', [GeneralAffairController::class, 'inventoryUpdatePage'])->name('office-inventory.updatepage');
        Route::get('/office-inventory/view/{idAsset}', [GeneralAffairController::class, 'inventoryView'])->name('office-inventory.view');
        Route::get('/office-inventory/getdata1', [GeneralAffairController::class, 'getInv1'])->name('office-inventory.getdata1');
        Route::get('/office-inventory/getdata', [GeneralAffairController::class, 'getInv'])->name('office-inventory.getdata');
        Route::post('/office-inventory/upload/{idAsset}', [GeneralAffairController::class, 'postFile'])->name('office-inventory.upload');
        Route::get('/office-inventory/file/{idAsset}', [GeneralAffairController::class, 'viewFileInv'])->name('office-inventory.file');
        Route::get('/office-inventory/photo/{idAsset}', [GeneralAffairController::class, 'viewImgInv'])->name('office-inventory.photo');
        Route::delete('/office-inventory/delete/{idAsset}', [GeneralAffairController::class, 'inventoryDelete'])->name('office-inventory.delete');

        Route::get('/office-catalogue', [OfficeCatalogueController::class, 'catalogue'])->name('office-catalogue');
        Route::get('/office-catalogue/{category}', [OfficeCatalogueController::class, 'category'])->name('office-catalogue.category');

        Route::get('/asset-tracking', [GeneralAffairController::class, 'asset'])->name('asset-tracking');
        Route::get('/asset-tracking/getdata', [GeneralAffairController::class, 'getAsset'])->name('asset-tracking.getdata');
        
        Route::get('/anonymous-report', [GeneralAffairController::class, 'anonymous'])->name('anonymous-report');
        Route::get('/anonymous-report/getdata', [GeneralAffairController::class, 'getAnon'])->name('anonymous-report.getdata');

        Route::get('/rab', [GeneralAffairController::class, 'rabForm'])->name('rabga');
        Route::get('/rab/rabitem', [GeneralAffairController::class, 'rabItem'])->name('rab.item');
        Route::post('/rab/create', [GeneralAffairController::class, 'rabCreate'])->name('rab.createga');

        Route::get('/rab-approval/request', [GeneralAffairController::class, 'rabList'])->name('rab-list');
        Route::get('/rab-approval/list', [GeneralAffairController::class, 'rabListOnly'])->name('rab-listonly');
        Route::get('/rab-approval/list/printsubmit', [GeneralAffairController::class, 'rabPrintSubmit'])->name('rab-printsubmit');
        Route::get('/rab-approval/listenforced', [GeneralAffairController::class, 'rabListEnforced'])->name('rab-listenforced');
        Route::get('/rab-approval/list/signature/{rabId}', [GeneralAffairController::class, 'signature'])->name('rab-list.signature');
        Route::post('/rab-approval/list/signatureupdate/{rabId}', [GeneralAffairController::class, 'signatureupdate'])->name('rab-list.signatureupdate');
        Route::get('/rab-approval/list/print/{rabId}', [GeneralAffairController::class, 'print'])->name('rab-list.print');
        Route::get('/rab-approval/list/printedenforced/{rabId}', [GeneralAffairController::class, 'printedEnforced'])->name('rab-list.printedenforced');
        Route::get('/rab-approval/list/getdata', [GeneralAffairController::class, 'rabListGetData'])->name('rab-list.getdata');
        Route::get('/rab-approval/list/getprintsubmit', [GeneralAffairController::class, 'rabListGetPrintSubmit'])->name('rab-list.getprintsubmit');
        Route::get('/rab-approval/list/updatepage/{rabId}', [GeneralAffairController::class, 'rabListUpdatePage'])->name('rab-list.updatepage');
        Route::get('/rab-approval/list/getprintenforced', [GeneralAffairController::class, 'rabListGetPrintEnforced'])->name('rab-list.getprintenforced');
        Route::get('/rab-approval/list/submitpage/{rabId}', [GeneralAffairController::class, 'rabListSubmit'])->name('rab-list.submitpage');
        Route::get('/rab-approval/list/clonepage/{rabId}', [GeneralAffairController::class, 'rabListClonePage'])->name('rab-list.clonepage');
        Route::get('/rab-approval/list/view/{rabId}', [GeneralAffairController::class, 'rabListView'])->name('rab-list.view');
        Route::post('/rab-approval/list/update/{rabId}', [GeneralAffairController::class, 'rabListUpdate'])->name('rab-list.update');
        Route::post('/rab-approval/list/clone/{rabId}', [GeneralAffairController::class, 'rabListClone'])->name('rab-list.clone');
        Route::delete('/rab-approval/list/deleteitem/{rabId}', [GeneralAffairController::class, 'deleteItem'])->name('rab-list.deleteitem');
        Route::post('/rab-approval/list/submit/{rabId}', [GeneralAffairController::class, 'submitRab'])->name('rab-approvalga.submit');
        Route::post('/rab-approval/cancel/{rabId}', [GeneralAffairController::class, 'cancelRab'])->name('rab-approval.canceled');
        // Route::get('/rab-approval/list/getdashboard', [GeneralAffairController::class, 'rabListGetDashboard'])->name('rab-list.getdashboard');

        Route::get('/rab-approval', [GeneralAffairController::class, 'rabApproval'])->name('rab-approvalga');
        Route::get('/rab-approval/getdata', [GeneralAffairController::class, 'rabGetApproval'])->name('rab-approvalga.getdata');
        Route::get('/rab-approval/approve1/{rabId}', [GeneralAffairController::class, 'rabApprove1'])->name('rab-approve1');
        Route::post('/rab-approval/updatestatus/{rabId}', [GeneralAffairController::class, 'rabUpdateStatus'])->name('rab-approvalga.updatestatus');

        Route::get('/rab-approval2', [GeneralAffairController::class, 'rabApproval2'])->name('rab-approvalga2');
        Route::get('/rab-approval2/getdata2', [GeneralAffairController::class, 'rabGetApproval2'])->name('rab-approvalga2.getdata');
        Route::get('/rab-approval2/approve2/{rabId}', [GeneralAffairController::class, 'rabApprove2'])->name('rab-approve2');
        Route::post('/rab-approval2/updatestatus2/{rabId}', [GeneralAffairController::class, 'rabUpdateStatus2'])->name('rab-approvalga.updatestatus2');

        Route::get('/rab-approval3', [GeneralAffairController::class, 'rabApproval3'])->name('rab-approvalga3');
        Route::get('/rab-approval3/getdata3', [GeneralAffairController::class, 'rabGetApproval3'])->name('rab-approvalga3.getdata');
        Route::get('/rab-approval3/approve3/{rabId}', [GeneralAffairController::class, 'rabApprove3'])->name('rab-approve3');
        Route::post('/rab-approval3/updatestatus3/{rabId}', [GeneralAffairController::class, 'rabUpdateStatus3'])->name('rab-approvalga.updatestatus3');

        Route::get('/rab/summary', [RabSummaryController::class, 'rabSummary'])->name('rab-summary');
        Route::get('/rab/summarygetdata', [RabSummaryController::class, 'rabSummaryGetData'])->name('rab-summary.getdata');
        Route::post('/rab/summarypost', [RabSummaryController::class, 'rabSummaryPost'])->name('rab-summary.post');
        Route::get('/rab/summaryprint/{from}/{to}/{company}/{department?}', [RabSummaryController::class, 'rabSummaryPrint'])->name('rab-summary.print');

        Route::get('/fixedasset/form', [GeneralAffairController::class, 'fixedAssetForm'])->name('fixedasset');
        Route::get('/fixedasset/list', [GeneralAffairController::class, 'fixedAssetList'])->name('fixedasset.list');
        Route::get('/fixedasset/edit', [GeneralAffairController::class, 'editGenerateFA'])->name('fixedasset.editgenerate');
        Route::get('/fixedasset/generateFA', [GeneralAffairController::class, 'editGenerateFA2'])->name('fixedasset.generateFA');
        Route::post('/fixedasset/create', [GeneralAffairController::class, 'fixedAssetCreate'])->name('fixedasset.create');
        Route::get('/fixedasset/invfixasset', [GeneralAffairController::class, 'invFixAsset'])->name('fixedasset.invfixasset');
        Route::get('/fixedasset/getdata', [GeneralAffairController::class, 'getAssets'])->name('fixedasset.getdata');
        Route::get('/fixedasset/updatepage/{idForm}', [GeneralAffairController::class, 'assetsUpdatePage'])->name('fixedasset.updatepage');
        Route::post('/fixedasset/update/{idForm}', [GeneralAffairController::class, 'assetsUpdate'])->name('fixedasset.update');
        Route::get('/fixedasset/barcode/{idAsset}', [GeneralAffairController::class, 'assetsBarcode'])->name('fixedasset.barcode');
        Route::get('/fixedasset/qrcode/{idAsset}', [GeneralAffairController::class, 'assetsQrcode'])->name('fixedasset.qrcode');
        Route::get('/fixedasset/listformfa', [GeneralAffairController::class, 'listFormFaOnly'])->name('listformfa.listonly');
        Route::get('/fixedasset/formfa', [GeneralAffairController::class, 'listFormFa'])->name('listformfa.list');
        Route::get('/fixedasset/getdataform', [GeneralAffairController::class, 'getDataForm'])->name('listformfa.getdata');
        Route::get('/fixedasset/viewpageform/{idForm}', [GeneralAffairController::class, 'viewPageForm'])->name('listformfa.viewpageform');
        Route::get('/fixedasset/file/{idForm}', [GeneralAffairController::class, 'viewFileAssets'])->name('fixedasset.file');
        Route::delete('/fixedasset/delete/{idAsset}', [GeneralAffairController::class, 'assetsDelete'])->name('fixedasset.delete');
        Route::get('/fixedasset/generatepage/{idForm}', [GeneralAffairController::class, 'assetsGeneratePage'])->name('fixedasset.generatepage');
        Route::post('/fixedasset/generate', [GeneralAffairController::class, 'assetsGenerate'])->name('fixedasset.generate');

        Route::get('/assigned-asset', [GeneralAffairController::class, 'assignedForm'])->name('assigned-asset');
        Route::post('/assigned-asset/create', [GeneralAffairController::class, 'assignedCreate'])->name('assigned-asset.create');
        Route::get('/assigned-asset/list', [GeneralAffairController::class, 'assignedListOnly'])->name('assigned-asset.listonly');
        Route::get('/assigned-asset/request', [GeneralAffairController::class, 'assignedList'])->name('assigned-asset.list');
        Route::get('/assigned-asset/employee', [GeneralAffairController::class, 'getEmployee'])->name('assigned-asset.employee');
        Route::get('/assigned-asset/getdata', [GeneralAffairController::class, 'getAssigned'])->name('assigned-asset.getdata');
        Route::get('/assigned-asset/list/signature/{idassign}', [GeneralAffairController::class, 'assignedSignature'])->name('assigned-asset.signature');
        Route::post('/assigned-asset/list/signatureupdate/{idassign}', [GeneralAffairController::class, 'assignedSignatureupdate'])->name('assigned-asset.signatureupdate');
        Route::get('/assigned-asset/list/print/{idassign}', [GeneralAffairController::class, 'assignedPrint'])->name('assigned-asset.print');
        Route::get('/assigned-asset/list/updatepage/{idassign}', [GeneralAffairController::class, 'assignedUpdatePage'])->name('assigned-asset.updatepage');
        Route::get('/assigned-asset/list/submitpage/{idassign}', [GeneralAffairController::class, 'assignedSubmit'])->name('assigned-asset.submitpage');
        Route::get('/assigned-asset/list/view/{idassign}', [GeneralAffairController::class, 'assignedView'])->name('assigned-asset.view');
        Route::get('/assigned-asset/list/viewfile/{idassign}', [GeneralAffairController::class, 'assignedViewFile'])->name('assigned-asset.viewfile');
        Route::get('/assigned-asset/list/viewcondition/{idassign}', [GeneralAffairController::class, 'assignedViewCon'])->name('assigned-asset.viewcondition');
        Route::post('/assigned-asset/list/update/{idassign}', [GeneralAffairController::class, 'assignedUpdate'])->name('assigned-asset.update');
        Route::delete('/assigned-asset/list/deleteitem/{idassign}', [GeneralAffairController::class, 'deleteAssigned'])->name('assigned-asset.deleteitem');
        Route::post('/assigned-asset/list/submit/{idassign}', [GeneralAffairController::class, 'submitAssigned'])->name('assigned-asset.submit');
        Route::post('/assigned-asset/cancel/{idassign}', [GeneralAffairController::class, 'cancelAssigned'])->name('assigned-asset.canceled');
        
        Route::get('/assigned-approval', [GeneralAffairController::class, 'assignedApproval'])->name('assigned-approvalga');
        Route::get('/assigned-approval/getdata', [GeneralAffairController::class, 'assignedGetApproval'])->name('assigned-approvalga.getdata');
        Route::get('/assigned-approval/approve1/{idassign}', [GeneralAffairController::class, 'assignedApprove1'])->name('assigned-approve1');
        Route::post('/assigned-approval/updatestatus/{idassign}', [GeneralAffairController::class, 'assignedUpdateStatus'])->name('assigned-approvalga.updatestatus');

        Route::get('/assigned-approval2', [GeneralAffairController::class, 'assignedApproval2'])->name('assigned-approvalga2');
        Route::get('/assigned-approval2/getdata2', [GeneralAffairController::class, 'assignedGetApproval2'])->name('assigned-approvalga2.getdata');
        Route::get('/assigned-approval2/approve2/{idassign}', [GeneralAffairController::class, 'assignedApprove2'])->name('assigned-approve2');
        Route::post('/assigned-approval2/updatestatus2/{idassign}', [GeneralAffairController::class, 'assignedUpdateStatus2'])->name('assigned-approvalga.updatestatus2');
        
        Route::get('/rab-lpj', [RabLpjController::class, 'rabLpjList'])->name('rabLpjList');
        Route::get('/rab-lpj/getData', [RabLpjController::class, 'rabListGetData'])->name('rabLpjList.getData');
        Route::get('/rab-lpj-create', [RabLpjController::class, 'rabLpjCreate'])->name('rabLpjCreate');
        Route::get('/rab-lpj-create/getData', [RabLpjController::class, 'rabListGetData'])->name('rabLpjCreate.getData');
        Route::get('/rab-lpj-create/form', [RabLpjController::class, 'rabLpjFormCreate'])->name('rabLpjCreate.form');
        Route::get('/rab-lpj/form/selectRab', [RabLpjController::class, 'selectRab'])->name('rabLpj.selectrab');
        Route::get('/rab-lpj/form/selectRabDetail', [RabLpjController::class, 'selectRabDetail'])->name('rabLpj.selectrabdetail');
        // Route::get('/rab-lpj', [RabLpjController::class, 'rabLpjList'])->name('rabLpjList');
    });

    Route::prefix('data-master')->group(function () {
        Route::get('/m-child-company', [GeneralAffairController::class, 'childCompany'])->name('child-company');
        Route::get('/m-child-company/list', [GeneralAffairController::class, 'childCompanyList'])->name('child-companylist');
        Route::get('/m-child-company/form', [GeneralAffairController::class, 'childCompanyForm'])->name('child-company.form');
        Route::get('/m-child-company/edit', [GeneralAffairController::class, 'childCompanyEdit'])->name('child-company.edit');
        Route::get('/m-child-company/deletepage', [GeneralAffairController::class, 'childCompanyDeletePage'])->name('child-company.deletepage');
        Route::post('/m-child-company/create', [GeneralAffairController::class, 'childCompanyCreate'])->name('child-company.create');
        Route::get('/m-child-company/getdata', [GeneralAffairController::class, 'childCompanyGetData'])->name('child-company.getdata');
        Route::post('/m-child-company/update/{id}', [GeneralAffairController::class, 'childCompanyUpdate'])->name('child-company.update');
        Route::delete('/m-child-company/delete/{id}', [GeneralAffairController::class, 'childCompanyDelete'])->name('child-company.delete');
        Route::get('/m-child-company/viewLogo/{id}', [GeneralAffairController::class, 'viewLogo'])->name('child-company.viewLogo');
        Route::get('/m-child-company/viewNpwp/{id}', [GeneralAffairController::class, 'viewNpwp'])->name('child-company.viewNpwp');

        Route::get('/m-rab-item', [GeneralAffairController::class, 'masterRab'])->name('master-rab');
        Route::get('/m-rab-item/form', [GeneralAffairController::class, 'masterRabForm'])->name('master-rab.form');
        Route::get('/m-rab-item/edit', [GeneralAffairController::class, 'masterRabEdit'])->name('master-rab.edit');
        Route::get('/m-rab-item/deletepage', [GeneralAffairController::class, 'masterRabDeletePage'])->name('master-rab.deletepage');
        Route::post('/m-rab-item/create', [GeneralAffairController::class, 'masterRabCreate'])->name('master-rab.create');
        Route::get('/m-rab-item/getdata', [GeneralAffairController::class, 'masterRabGetData'])->name('master-rab.getdata');
        Route::post('/m-rab-item/update/{id}', [GeneralAffairController::class, 'masterRabUpdate'])->name('master-rab.update');
        Route::delete('/m-rab-item/delete/{id}', [GeneralAffairController::class, 'masterRabDelete'])->name('master-rab.delete');

        Route::get('/m-vendor', [GeneralAffairController::class, 'masterVendor'])->name('m-vendor');
        Route::get('/m-vendorlist', [GeneralAffairController::class, 'masterVendorList'])->name('m-vendorlist');
        Route::get('/m-vendor/form', [GeneralAffairController::class, 'masterVendorForm'])->name('m-vendor.form');
        Route::get('/m-vendor/edit', [GeneralAffairController::class, 'masterVendorEdit'])->name('m-vendor.edit');
        Route::get('/m-vendor/deletepage', [GeneralAffairController::class, 'masterVendorDeletePage'])->name('m-vendor.deletepage');
        Route::get('/m-vendor/getdata', [GeneralAffairController::class, 'masterVendorGetData'])->name('m-vendor.getdata');
        Route::post('/m-vendor/create', [GeneralAffairController::class, 'masterVendorCreate'])->name('m-vendor.create');
        Route::post('/m-vendor/update/{vendorId}', [GeneralAffairController::class, 'masterVendorUpdate'])->name('m-vendor.update');
        Route::delete('/m-vendor/delete/{vendorId}', [GeneralAffairController::class, 'masterVendorDelete'])->name('m-vendor.delete');
        Route::get('/m-vendor/select', [GeneralAffairController::class, 'vendorSelect'])->name('vendor.select');

        Route::get('/m-category', [GeneralAffairController::class, 'masterCategory'])->name('m-category');
        Route::get('/m-category/form', [GeneralAffairController::class, 'masterCategoryForm'])->name('m-category.form');
        Route::get('/m-category/edit', [GeneralAffairController::class, 'masterCategoryEdit'])->name('m-category.edit');
        Route::get('/m-category/deletepage', [GeneralAffairController::class, 'masterCategoryDeletePage'])->name('m-category.deletepage');
        Route::get('/m-category/getdata', [GeneralAffairController::class, 'masterCategoryGetData'])->name('m-category.getdata');
        Route::get('/m-category/getdata1', [GeneralAffairController::class, 'masterCategoryGetData1'])->name('m-category.getdata1');
        Route::post('/m-category/create', [GeneralAffairController::class, 'masterCategoryCreate'])->name('m-category.create');
        Route::post('/m-category/update/{catId}', [GeneralAffairController::class, 'masterCategoryUpdate'])->name('m-category.update');
        Route::delete('/m-category/delete/{catId}', [GeneralAffairController::class, 'masterCategoryDelete'])->name('m-category.delete');
        Route::get('/m-category/select', [GeneralAffairController::class, 'categorySelect'])->name('category.select');
        Route::get('/m-category/subcategoryselect', [GeneralAffairController::class, 'subCategorySelect'])->name('subcategory.selected');

        Route::get('/m-subcategory/{catId}', [GeneralAffairController::class, 'masterSubCategory'])->name('m-subcategory');
        Route::get('/m-subcategory/edit/{catId}', [GeneralAffairController::class, 'masterSubCategoryEdit'])->name('m-subcategory.edit');
        Route::get('/m-subcategory/deletepage/{catId}', [GeneralAffairController::class, 'masterSubCategoryDeletePage'])->name('m-subcategory.deletepage');
        Route::get('/m-subcategory/getdata/{catId}', [GeneralAffairController::class, 'masterSubCategoryGetData'])->name('m-subcategory.getdata');
        Route::post('/m-subcategory/create', [GeneralAffairController::class, 'masterSubCategoryCreate'])->name('m-subcategory.create');
        Route::post('/m-subcategory/update/{catId}', [GeneralAffairController::class, 'masterSubCategoryUpdate'])->name('m-subcategory.update');
        Route::delete('/m-subcategory/delete/{catId}', [GeneralAffairController::class, 'masterSubCategoryDelete'])->name('m-subcategory.delete');

        Route::get('/m-brand', [GeneralAffairController::class, 'masterBrand'])->name('m-brand');
        Route::get('/m-brand/list', [GeneralAffairController::class, 'masterBrandList'])->name('m-brandlist');
        Route::get('/m-brand/form', [GeneralAffairController::class, 'masterBrandForm'])->name('m-brand.form');
        Route::get('/m-brand/edit', [GeneralAffairController::class, 'masterBrandEdit'])->name('m-brand.edit');
        Route::get('/m-brand/deletepage', [GeneralAffairController::class, 'masterBrandDeletePage'])->name('m-brand.deletepage');
        Route::get('/m-brand/getdata', [GeneralAffairController::class, 'masterBrandGetData'])->name('m-brand.getdata');
        Route::get('/m-brand/getdata1', [GeneralAffairController::class, 'masterBrandGetData1'])->name('m-brand.getdata1');
        Route::post('/m-brand/create', [GeneralAffairController::class, 'masterBrandCreate'])->name('m-brand.create');
        Route::post('/m-brand/update/{brandId}', [GeneralAffairController::class, 'masterBrandUpdate'])->name('m-brand.update');
        Route::delete('/m-brand/delete/{brandId}', [GeneralAffairController::class, 'masterBrandDelete'])->name('m-brand.delete');
        Route::get('/m-brand/select', [GeneralAffairController::class, 'brandSelect'])->name('brand.select');
        Route::get('/m-brand/modelselect', [GeneralAffairController::class, 'modelSelect'])->name('model.selected');

        Route::get('/m-model/{brandId}', [GeneralAffairController::class, 'masterModel'])->name('m-model');
        Route::get('/m-model/edit/{brandId}', [GeneralAffairController::class, 'masterModelEdit'])->name('m-model.edit');
        Route::get('/m-model/deletepage/{brandId}', [GeneralAffairController::class, 'masterModelDeletePage'])->name('m-model.deletepage');
        Route::get('/m-model/getdata/{brandId}', [GeneralAffairController::class, 'masterModelGetData'])->name('m-model.getdata');
        Route::post('/m-model/create', [GeneralAffairController::class, 'masterModelCreate'])->name('m-model.create');
        Route::post('/m-model/update/{modelId}', [GeneralAffairController::class, 'masterModelUpdate'])->name('m-model.update');
        Route::delete('/m-model/delete/{modelId}', [GeneralAffairController::class, 'masterModelDelete'])->name('m-model.delete');

        Route::get('/m-department', [GeneralAffairController::class, 'masterDepartment'])->name('m-department');
        Route::get('/m-department/list', [GeneralAffairController::class, 'masterDepartmentList'])->name('m-departmentlist');
        Route::get('/m-department/form', [GeneralAffairController::class, 'masterDepartmentForm'])->name('m-department.form');
        Route::get('/m-department/edit', [GeneralAffairController::class, 'masterDepartmentEdit'])->name('m-department.edit');
        Route::get('/m-department/deletepage', [GeneralAffairController::class, 'masterDepartmentDeletePage'])->name('m-department.deletepage');
        Route::get('/m-department/getdata', [GeneralAffairController::class, 'masterDepartmentGetData'])->name('m-department.getdata');
        Route::get('/m-department/getdata1', [GeneralAffairController::class, 'masterDepartmentGetData1'])->name('m-department.getdata1');
        Route::post('/m-department/create', [GeneralAffairController::class, 'masterDepartmentCreate'])->name('m-department.create');
        Route::post('/m-department/update/{deptId}', [GeneralAffairController::class, 'masterDepartmentUpdate'])->name('m-department.update');
        Route::delete('/m-department/delete/{deptId}', [GeneralAffairController::class, 'masterDepartmentDelete'])->name('m-department.delete');

        Route::get('/m-subdepartment/{deptId}', [GeneralAffairController::class, 'masterSubDepartment'])->name('m-subdepartment');
        Route::get('/m-subdepartment/edit/{deptId}', [GeneralAffairController::class, 'masterSubDepartmentEdit'])->name('m-subdepartment.edit');
        Route::get('/m-subdepartment/deletepage/{deptId}', [GeneralAffairController::class, 'masterSubDepartmentDeletePage'])->name('m-subdepartment.deletepage');
        Route::get('/m-subdepartment/getdata/{deptId}', [GeneralAffairController::class, 'masterSubDepartmentGetData'])->name('m-subdepartment.getdata');
        Route::post('/m-subdepartment/create', [GeneralAffairController::class, 'masterSubDepartmentCreate'])->name('m-subdepartment.create');
        Route::post('/m-subdepartment/update/{subId}', [GeneralAffairController::class, 'masterSubDepartmentUpdate'])->name('m-subdepartment.update');
        Route::delete('/m-subdepartment/delete/{subId}', [GeneralAffairController::class, 'masterSubDepartmentDelete'])->name('m-subdepartment.delete');

        Route::get('/m-costcentertype', [GeneralAffairController::class, 'costType'])->name('costcenter-type');
        Route::get('/m-costcentertype/list', [GeneralAffairController::class, 'costTypeList'])->name('costcenter-typelist');
        Route::get('/m-costcentertype/form', [GeneralAffairController::class, 'costTypeForm'])->name('costcenter-type.form');
        Route::get('/m-costcentertype/edit', [GeneralAffairController::class, 'costTypeEdit'])->name('costcenter-type.edit');
        Route::get('/m-costcentertype/deletepage', [GeneralAffairController::class, 'costTypeDelete'])->name('costcenter-type.deletepage');
        Route::post('/m-costcentertype/create', [GeneralAffairController::class, 'costTypeCreate'])->name('costcenter-type.create');
        Route::get('/m-costcentertype/getdata', [GeneralAffairController::class, 'costTypeGetData'])->name('costcenter-type.getdata');
        Route::post('/m-costcentertype/update/{id}', [GeneralAffairController::class, 'costTypeUpdate'])->name('costcenter-type.update');
        Route::delete('/m-costcentertype/delete/{id}', [GeneralAffairController::class, 'costDelete'])->name('costcenter-type.delete');

        Route::get('/m-reimbursetype', [GeneralAffairController::class, 'reimburseType'])->name('reimburse-type');
        Route::get('/m-reimbursetype/list', [GeneralAffairController::class, 'reimburseTypeList'])->name('reimburse-typelist');
        Route::get('/m-reimbursetype/form', [GeneralAffairController::class, 'reimburseTypeForm'])->name('reimburse-type.form');
        Route::get('/m-reimbursetype/edit', [GeneralAffairController::class, 'reimburseTypeEdit'])->name('reimburse-type.edit');
        Route::get('/m-reimbursetype/deletepage', [GeneralAffairController::class, 'reimburseTypeDelete'])->name('reimburse-type.deletepage');
        Route::post('/m-reimbursetype/create', [GeneralAffairController::class, 'typeCreate'])->name('reimburse-type.create');
        Route::get('/m-reimbursetype/getdata', [GeneralAffairController::class, 'typeGetData'])->name('reimburse-type.getdata');
        Route::post('/m-reimbursetype/update/{id}', [GeneralAffairController::class, 'typeUpdate'])->name('reimburse-type.update');
        Route::delete('/m-reimbursetype/delete/{id}', [GeneralAffairController::class, 'typeDelete'])->name('reimburse-type.delete');
        
        Route::get('/m-site-warehouse', [GeneralAffairController::class, 'masterSite'])->name('m-site-warehouse');
        Route::get('/m-site-warehouse/list', [GeneralAffairController::class, 'masterSiteList'])->name('m-site-warehouselist');
        Route::get('/m-site-warehouse/form', [GeneralAffairController::class, 'masterSiteForm'])->name('m-site-warehouse.form');
        Route::get('/m-site-warehouse/edit', [GeneralAffairController::class, 'masterSiteEdit'])->name('m-site-warehouse.edit');
        Route::get('/m-site-warehouse/deletepage', [GeneralAffairController::class, 'masterSiteDeletePage'])->name('m-site-warehouse.deletepage');
        Route::get('/m-site-warehouse/getdata', [GeneralAffairController::class, 'masterSiteGetData'])->name('m-site-warehouse.getdata');
        Route::post('/m-site-warehouse/create', [GeneralAffairController::class, 'masterSiteCreate'])->name('m-site-warehouse.create');
        Route::post('/m-site-warehouse/update/{siteId}', [GeneralAffairController::class, 'masterSiteUpdate'])->name('m-site-warehouse.update');
        Route::delete('/m-site-warehouse/delete/{siteId}', [GeneralAffairController::class, 'masterSiteDelete'])->name('m-site-warehouse.delete');

        // Route::get('/m-delivery-address', [GeneralAffairController::class, 'deliveryAddress'])->name('delivery-address');
        // Route::get('/m-delivery-address/edit', [GeneralAffairController::class, 'deliveryAddressEdit'])->name('delivery-address.edit');
        // Route::get('/m-delivery-address/deletepage', [GeneralAffairController::class, 'deliveryAddressDeletePage'])->name('delivery-address.deletepage');
        // Route::get('/m-delivery-address/getdata', [GeneralAffairController::class, 'deliveryAddressGetData'])->name('delivery-address.getdata');
        // Route::post('/m-delivery-address/create1', [GeneralAffairController::class, 'deliveryAddressCreate1'])->name('delivery-address.create1');
        // Route::post('/m-delivery-address/create', [GeneralAffairController::class, 'deliveryAddressCreate'])->name('delivery-address.create');
        // Route::post('/m-delivery-address/update/{idrec}', [GeneralAffairController::class, 'deliveryAddressUpdate'])->name('delivery-address.update');
        // Route::delete('/m-delivery-address/delete/{idrec}', [GeneralAffairController::class, 'deliveryAddressDelete'])->name('delivery-address.delete');
        // Route::get('/m-delivery-address', [GeneralAffairController::class, 'deliveryAddress'])->name('delivery-address');

        Route::get('/m-department1', [GeneralAffairController::class, 'department1'])->name('m-department1');
        Route::get('/m-department1/form', [GeneralAffairController::class, 'department1Form'])->name('m-department1.form');
        Route::get('/m-department1/edit', [GeneralAffairController::class, 'department1Edit'])->name('m-department1.edit');
        Route::get('/m-department1/deletepage', [GeneralAffairController::class, 'department1DeletePage'])->name('m-department1.deletepage');
        Route::get('/m-department1/getdata', [GeneralAffairController::class, 'department1GetData'])->name('m-department1.getdata');
        Route::get('/m-department1/getdata1', [GeneralAffairController::class, 'department1GetData1'])->name('m-department1.getdata1');
        Route::post('/m-department1/create', [GeneralAffairController::class, 'department1Create'])->name('m-department1.create');
        Route::post('/m-department1/update/{idrec}', [GeneralAffairController::class, 'department1Update'])->name('m-department1.update');
        Route::delete('/m-department1/delete/{idrec}', [GeneralAffairController::class, 'department1Delete'])->name('m-department1.delete');

        Route::get('/m-division/{deptId}', [GeneralAffairController::class, 'division'])->name('m-division');
        Route::get('/m-division/edit/{deptId}', [GeneralAffairController::class, 'divisionEdit'])->name('m-division.edit');
        Route::get('/m-division/deletepage/{deptId}', [GeneralAffairController::class, 'divisionDeletePage'])->name('m-division.deletepage');
        Route::get('/m-division/getdata/{deptId}', [GeneralAffairController::class, 'divisionGetData'])->name('m-division.getdata');
        Route::post('/m-division/create', [GeneralAffairController::class, 'divisionCreate'])->name('m-division.create');
        Route::post('/m-division/update/{divId}', [GeneralAffairController::class, 'divisionUpdate'])->name('m-division.update');
        Route::delete('/m-division/delete/{divId}', [GeneralAffairController::class, 'divisionDelete'])->name('m-division.delete');

        Route::get('/m-bank', [GeneralAffairController::class, 'bankir'])->name('bank');
        Route::get('/m-bank/list', [GeneralAffairController::class, 'bankirList'])->name('banklist');
        Route::get('/m-bank/form', [GeneralAffairController::class, 'bankForm'])->name('bank.form');
        Route::get('/m-bank/edit', [GeneralAffairController::class, 'bankEdit'])->name('bank.edit');
        Route::get('/m-bank/deletepage', [GeneralAffairController::class, 'bankDeletePage'])->name('bank.deletepage');
        Route::post('/m-bank/create', [GeneralAffairController::class, 'bankCreate'])->name('bank.create');
        Route::get('/m-bank/getdata', [GeneralAffairController::class, 'bankGetData'])->name('bank.getdata');
        Route::post('/m-bank/update/{idBank}', [GeneralAffairController::class, 'bankUpdate'])->name('bank.update');
        Route::delete('/m-bank/delete/{idBank}', [GeneralAffairController::class, 'bankDelete'])->name('bank.delete');

        Route::get('/m-tax/vat', [GeneralAffairController::class, 'vat'])->name('vat');
        Route::get('/m-tax/vat/form', [GeneralAffairController::class, 'vatForm'])->name('vat.form');
        Route::post('/m-tax/vat/create', [GeneralAffairController::class, 'vatCreate'])->name('vat.create');
        Route::get('/m-tax/vat/getdata', [GeneralAffairController::class, 'vatGetData'])->name('vat.getdata');

        Route::get('/m-tax/wht', [GeneralAffairController::class, 'wht'])->name('wht');
        Route::get('/m-tax/wht/form', [GeneralAffairController::class, 'whtForm'])->name('wht.form');
        Route::post('/m-tax/wht/create', [GeneralAffairController::class, 'whtCreate'])->name('wht.create');
        Route::get('/m-tax/wht/getdata', [GeneralAffairController::class, 'whtGetData'])->name('wht.getdata');

        Route::get('/m-cidbank', [PaymentController::class, 'cidBank'])->name('cidbank');
        Route::get('/m-cidbank/list', [PaymentController::class, 'cidBankList'])->name('cidbanklist');
        Route::get('/m-cidbank/form', [PaymentController::class, 'cidBankForm'])->name('cidbank.form');
        Route::get('/m-cidbank/edit', [PaymentController::class, 'cidBankEdit'])->name('cidbank.edit');
        Route::get('/m-cidbank/deletepage', [PaymentController::class, 'cidBankDeletePage'])->name('cidbank.deletepage');
        Route::post('/m-cidbank/create', [PaymentController::class, 'cidBankCreate'])->name('cidbank.create');
        Route::get('/m-cidbank/getdata', [PaymentController::class, 'cidBankGetData'])->name('cidbank.getdata');
        Route::post('/m-cidbank/update/{id_cidb}', [PaymentController::class, 'cidBankUpdate'])->name('cidbank.update');
        Route::delete('/m-cidbank/delete/{id_cidb}', [PaymentController::class, 'cidBankDelete'])->name('cidbank.delete');

        Route::get('/m-rabbank', [PaymentController::class, 'rabBank'])->name('rabbank');
        Route::get('/m-rabbank/list', [PaymentController::class, 'rabBankList'])->name('rabbanklist');
        Route::get('/m-rabbank/form', [PaymentController::class, 'rabBankForm'])->name('rabbank.form');
        Route::get('/m-rabbank/edit', [PaymentController::class, 'rabBankEdit'])->name('rabbank.edit');
        Route::get('/m-rabbank/deletepage', [PaymentController::class, 'rabBankDeletePage'])->name('rabbank.deletepage');
        Route::post('/m-rabbank/create', [PaymentController::class, 'rabBankCreate'])->name('rabbank.create');
        Route::get('/m-rabbank/getdata', [PaymentController::class, 'rabBankGetData'])->name('rabbank.getdata');
        Route::post('/m-rabbank/update/{id_rabb}', [PaymentController::class, 'rabBankUpdate'])->name('rabbank.update');
        Route::delete('/m-rabbank/delete/{id_rabb}', [PaymentController::class, 'rabBankDelete'])->name('rabbank.delete');

        Route::get('/m-rabapproval1to', [RabApprovalToController::class, 'rabapproval1to'])->name('rabapproval1to');
        Route::get('/m-rabapproval1toonly', [RabApprovalToController::class, 'rabapproval1toonly'])->name('rabapproval1toonly');
        Route::get('/m-rabapproval1to/deletepage', [RabApprovalToController::class, 'rabapproval1toDeletePage'])->name('rabapproval1to.deletepage');
        Route::get('/m-rabapproval1to/editpage', [RabApprovalToController::class, 'rabapproval1toEditPage'])->name('rabapproval1to.editpage');
        Route::post('/m-rabapproval1to/create', [RabApprovalToController::class, 'rabapproval1toCreate'])->name('rabapproval1to.create');
        Route::post('/m-rabapproval1to/update/{id}', [RabApprovalToController::class, 'rabapproval1toUpdate'])->name('rabapproval1to.update');
        Route::get('/m-rabapproval1to/getdata', [RabApprovalToController::class, 'rabapproval1toGetData'])->name('rabapproval1to.getdata');
        Route::delete('/m-rabapproval1to/delete/{id}', [RabApprovalToController::class, 'rabapproval1toDelete'])->name('rabapproval1to.delete');

        Route::get('/m-rabapproval2to', [RabApprovalToController::class, 'rabapproval2to'])->name('rabapproval2to');
        Route::get('/m-rabapproval2toonly', [RabApprovalToController::class, 'rabapproval2toonly'])->name('rabapproval2toonly');
        Route::get('/m-rabapproval2to/deletepage', [RabApprovalToController::class, 'rabapproval2toDeletePage'])->name('rabapproval2to.deletepage');
        Route::get('/m-rabapproval2to/editpage', [RabApprovalToController::class, 'rabapproval2toEditPage'])->name('rabapproval2to.editpage');
        Route::post('/m-rabapproval2to/create', [RabApprovalToController::class, 'rabapproval2toCreate'])->name('rabapproval2to.create');
        Route::post('/m-rabapproval2to/update/{id}', [RabApprovalToController::class, 'rabapproval2toUpdate'])->name('rabapproval2to.update');
        Route::get('/m-rabapproval2to/getdata', [RabApprovalToController::class, 'rabapproval2toGetData'])->name('rabapproval2to.getdata');
        Route::delete('/m-rabapproval2to/delete/{idrec}', [RabApprovalToController::class, 'rabapproval2toDelete'])->name('rabapproval2to.delete');
        
        Route::get('/m-rabapproval3to', [RabApprovalToController::class, 'rabapproval3to'])->name('rabapproval3to');
        Route::get('/m-rabapproval3toonly', [RabApprovalToController::class, 'rabapproval3toonly'])->name('rabapproval3toonly');
        Route::get('/m-rabapproval3to/deletepage', [RabApprovalToController::class, 'rabapproval3toDeletePage'])->name('rabapproval3to.deletepage');
        Route::get('/m-rabapproval3to/editpage', [RabApprovalToController::class, 'rabapproval3toEditPage'])->name('rabapproval3to.editpage');
        Route::post('/m-rabapproval3to/create', [RabApprovalToController::class, 'rabapproval3toCreate'])->name('rabapproval3to.create');
        Route::post('/m-rabapproval3to/update/{id}', [RabApprovalToController::class, 'rabapproval3toUpdate'])->name('rabapproval3to.update');
        Route::get('/m-rabapproval3to/getdata', [RabApprovalToController::class, 'rabapproval3toGetData'])->name('rabapproval3to.getdata');
        Route::delete('/m-rabapproval3to/delete/{idrec}', [RabApprovalToController::class, 'rabapproval3toDelete'])->name('rabapproval3to.delete');

        Route::get('/m-prapproval1to', [RabApprovalToController::class, 'prapproval1to'])->name('prapproval1to');
        Route::get('/m-prapproval1toonly', [RabApprovalToController::class, 'prapproval1toonly'])->name('prapproval1toonly');
        Route::get('/m-prapproval1to/deletepage', [RabApprovalToController::class, 'prapproval1toDeletePage'])->name('prapproval1to.deletepage');
        Route::get('/m-prapproval1to/editpage', [RabApprovalToController::class, 'prapproval1toEditPage'])->name('prapproval1to.editpage');
        Route::post('/m-prapproval1to/create', [RabApprovalToController::class, 'prapproval1toCreate'])->name('prapproval1to.create');
        Route::post('/m-prapproval1to/update/{id}', [RabApprovalToController::class, 'prapproval1toUpdate'])->name('prapproval1to.update');
        Route::get('/m-prapproval1to/getdata', [RabApprovalToController::class, 'prapproval1toGetData'])->name('prapproval1to.getdata');
        Route::delete('/m-prapproval1to/delete/{id}', [RabApprovalToController::class, 'prapproval1toDelete'])->name('prapproval1to.delete');

        Route::get('/m-prapproval2to', [RabApprovalToController::class, 'prapproval2to'])->name('prapproval2to');
        Route::get('/m-prapproval2toonly', [RabApprovalToController::class, 'prapproval2toonly'])->name('prapproval2toonly');
        Route::get('/m-prapproval2to/deletepage', [RabApprovalToController::class, 'prapproval2toDeletePage'])->name('prapproval2to.deletepage');
        Route::get('/m-prapproval2to/editpage', [RabApprovalToController::class, 'prapproval2toEditPage'])->name('prapproval2to.editpage');
        Route::post('/m-prapproval2to/create', [RabApprovalToController::class, 'prapproval2toCreate'])->name('prapproval2to.create');
        Route::post('/m-prapproval2to/update/{id}', [RabApprovalToController::class, 'prapproval2toUpdate'])->name('prapproval2to.update');
        Route::get('/m-prapproval2to/getdata', [RabApprovalToController::class, 'prapproval2toGetData'])->name('prapproval2to.getdata');
        Route::delete('/m-prapproval2to/delete/{idrec}', [RabApprovalToController::class, 'prapproval2toDelete'])->name('prapproval2to.delete');
        
        Route::get('/m-prapproval3to', [RabApprovalToController::class, 'prapproval3to'])->name('prapproval3to');
        Route::get('/m-prapproval3toonly', [RabApprovalToController::class, 'prapproval3toonly'])->name('prapproval3toonly');
        Route::get('/m-prapproval3to/deletepage', [RabApprovalToController::class, 'prapproval3toDeletePage'])->name('prapproval3to.deletepage');
        Route::get('/m-prapproval3to/editpage', [RabApprovalToController::class, 'prapproval3toEditPage'])->name('prapproval3to.editpage');
        Route::post('/m-prapproval3to/create', [RabApprovalToController::class, 'prapproval3toCreate'])->name('prapproval3to.create');
        Route::post('/m-prapproval3to/update/{id}', [RabApprovalToController::class, 'prapproval3toUpdate'])->name('prapproval3to.update');
        Route::get('/m-prapproval3to/getdata', [RabApprovalToController::class, 'prapproval3toGetData'])->name('prapproval3to.getdata');
        Route::delete('/m-prapproval3to/delete/{idrec}', [RabApprovalToController::class, 'prapproval3toDelete'])->name('prapproval3to.delete');

        Route::get('/m-reimburseapprovaltoo', [RabApprovalToController::class, 'reimburseapprovalto'])->name('reimburseapprovalto');
        Route::get('/m-reimburseapprovalto', [RabApprovalToController::class, 'reimburseapprovaltoonly'])->name('reimburseapprovaltoonly');
        Route::get('/m-reimburseapprovalto/deletepage', [RabApprovalToController::class, 'reimburseapprovaltoDeletePage'])->name('reimburseapprovalto.deletepage');
        Route::get('/m-reimburseapprovalto/editpage', [RabApprovalToController::class, 'reimburseapprovaltoEditPage'])->name('reimburseapprovalto.editpage');
        Route::post('/m-reimburseapprovalto/create', [RabApprovalToController::class, 'reimburseapprovaltoCreate'])->name('reimburseapprovalto.create');
        Route::post('/m-reimburseapprovalto/update/{id}', [RabApprovalToController::class, 'reimburseapprovaltoUpdate'])->name('reimburseapprovalto.update');
        Route::get('/m-reimburseapprovalto/getdata', [RabApprovalToController::class, 'reimburseapprovaltoGetData'])->name('reimburseapprovalto.getdata');
        Route::delete('/m-reimburseapprovalto/delete/{idrec}', [RabApprovalToController::class, 'reimburseapprovaltoDelete'])->name('reimburseapprovalto.delete');

        Route::get('/m-reimburseapproval2too', [RabApprovalToController::class, 'reimburseapproval2to'])->name('reimburseapproval2to');
        Route::get('/m-reimburseapproval2to', [RabApprovalToController::class, 'reimburseapproval2toonly'])->name('reimburseapproval2toonly');
        Route::get('/m-reimburseapproval2to/deletepage', [RabApprovalToController::class, 'reimburseapproval2toDeletePage'])->name('reimburseapproval2to.deletepage');
        Route::get('/m-reimburseapproval2to/editpage', [RabApprovalToController::class, 'reimburseapproval2toEditPage'])->name('reimburseapproval2to.editpage');
        Route::post('/m-reimburseapproval2to/create', [RabApprovalToController::class, 'reimburseapproval2toCreate'])->name('reimburseapproval2to.create');
        Route::post('/m-reimburseapproval2to/update/{id}', [RabApprovalToController::class, 'reimburseapproval2toUpdate'])->name('reimburseapproval2to.update');
        Route::get('/m-reimburseapproval2to/getdata', [RabApprovalToController::class, 'reimburseapproval2toGetData'])->name('reimburseapproval2to.getdata');
        Route::delete('/m-reimburseapproval2to/delete/{idrec}', [RabApprovalToController::class, 'reimburseapproval2toDelete'])->name('reimburseapproval2to.delete');

        // Route::get('/m-tax/ppn', [GeneralAffairController::class, 'ppn'])->name('ppn');
        // Route::get('/m-tax/ppn/form', [GeneralAffairController::class, 'ppnForm'])->name('ppn.form');
        // Route::post('/m-tax/ppn/create', [GeneralAffairController::class, 'ppnCreate'])->name('ppn.create');
        // Route::get('/m-tax/ppn/getdata', [GeneralAffairController::class, 'ppnGetData'])->name('ppn.getdata');

        Route::get('/m-outboundapprovalto', [InventoryStockController::class, 'outboundapprovalto'])->name('outboundapprovalto');
        Route::get('/m-outboundapprovaltoonly', [InventoryStockController::class, 'outboundapprovaltoonly'])->name('outboundapprovaltoonly');
        Route::get('/m-outboundapprovalto/deletepage', [InventoryStockController::class, 'outboundapprovaltoDeletePage'])->name('outboundapprovalto.deletepage');
        Route::get('/m-outboundapprovalto/editpage', [InventoryStockController::class, 'outboundapprovaltoEditPage'])->name('outboundapprovalto.editpage');
        Route::post('/m-outboundapprovalto/create', [InventoryStockController::class, 'outboundapprovaltoCreate'])->name('outboundapprovalto.create');
        Route::post('/m-outboundapprovalto/update/{id}', [InventoryStockController::class, 'outboundapprovaltoUpdate'])->name('outboundapprovalto.update');
        Route::get('/m-outboundapprovalto/getdata', [InventoryStockController::class, 'outboundapprovaltoGetData'])->name('outboundapprovalto.getdata');
        Route::delete('/m-outboundapprovalto/delete/{id}', [InventoryStockController::class, 'outboundapprovaltoDelete'])->name('outboundapprovalto.delete');

        Route::get('/m-vehicle', [InventoryStockController::class, 'vehicle'])->name('vehicle');
        Route::get('/m-vehicle/list', [InventoryStockController::class, 'vehicleList'])->name('vehiclelist');
        Route::get('/m-vehicle/form', [InventoryStockController::class, 'vehicleForm'])->name('vehicle.form');
        Route::get('/m-vehicle/edit', [InventoryStockController::class, 'vehicleEdit'])->name('vehicle.edit');
        Route::get('/m-vehicle/deletepage', [InventoryStockController::class, 'vehicleDeletePage'])->name('vehicle.deletepage');
        Route::post('/m-vehicle/create', [InventoryStockController::class, 'vehicleCreate'])->name('vehicle.create');
        Route::get('/m-vehicle/getdata', [InventoryStockController::class, 'vehicleGetData'])->name('vehicle.getdata');
        Route::post('/m-vehicle/update/{idVehicle}', [InventoryStockController::class, 'vehicleUpdate'])->name('vehicle.update');
        Route::delete('/m-vehicle/delete/{idVehicle}', [InventoryStockController::class, 'vehicleDelete'])->name('vehicle.delete');
    });

    //incident-report
    Route::prefix('incident-report')->group(function () {
        Route::get('/form', [IncidentReportController::class, 'form'])->name('incident.form');
        Route::post('/create', [IncidentReportController::class, 'create'])->name('incident.create');
        Route::get('/list/index', [IncidentReportController::class, 'index'])->name('incident.index');
        Route::get('/list/getdata', [IncidentReportController::class, 'getData'])->name('incident.getdata');
        Route::post('/followup', [IncidentReportController::class, 'followUp'])->name('incident.followup');
        Route::get('/single/report', [IncidentReportController::class, 'report'])->name('incident.report');
        Route::get('/single/getreport', [IncidentReportController::class, 'getReport'])->name('incident.getreport');
        Route::get('/list/updatepagelist/{reportId}', [IncidentReportController::class, 'updatePageList'])->name('incident-list.updatepage');
        Route::get('/single/updatepagesingle/{reportId}', [IncidentReportController::class, 'updatePageSingle'])->name('incident-single.updatepage');
        Route::post('/update/{reportId}', [IncidentReportController::class, 'update'])->name('incident.update');
        Route::get('/getdetail/{reportId}', [IncidentReportController::class, 'getDetail'])->name('incident.getdetail');
        Route::post('/followup', [IncidentReportController::class, 'followUp'])->name('incident.followup');
        Route::get('/file1/{reportId}', [IncidentReportController::class, 'file1'])->name('incident.file1');
        Route::get('/file2/{reportId}', [IncidentReportController::class, 'file2'])->name('incident.file2');
        Route::get('/file3/{reportId}', [IncidentReportController::class, 'file3'])->name('incident.file3');
        Route::get('/filefollowup/{followId}', [IncidentReportController::class, 'fileFollowUp'])->name('incident.filefollowup');
        Route::get('/img1/{reportId}', [IncidentReportController::class, 'img1'])->name('incident.img1');
        Route::get('/img2/{reportId}', [IncidentReportController::class, 'img2'])->name('incident.img2');
        Route::get('/img3/{reportId}', [IncidentReportController::class, 'img3'])->name('incident.img3');
        Route::get('/imgfollowup/{followId}', [IncidentReportController::class, 'imgFollowUp'])->name('incident.imgfollowup');
    });

    // Tasks
    Route::prefix('tasks')->group(function () {
        Route::get('/proyek/proyek-all', [ProyekController::class, 'index'])->name('proyek-all');
        Route::get('/proyek/proyek-all/getdata', [ProyekController::class, 'getData'])->name('proyek.getdata');
        Route::get('/proyek/proyek-all/form', [ProyekController::class, 'form'])->name('proyek.form');
        Route::get('/proyek/proyek-all/pic', [ProyekController::class, 'pic'])->name('proyek.pic');
        Route::post('/proyek/proyek-all/createpic', [ProyekController::class, 'createPic'])->name('pic.create');
        Route::post('/proyek/proyek-all/create', [ProyekController::class, 'create'])->name('proyek.create');
        Route::get('/proyek/proyek-all/selectcompany/{idCompany}', [ProyekController::class, 'selectCompany'])->name('create.selectcompany');
        Route::get('/proyek/proyek-all/getproduct', [ProyekController::class, 'getProduct'])->name('create.getproduct');
        Route::get('/proyek/proyek-all/getupdate/{companyId}', [ProyekController::class, 'getUpdate'])->name('proyek.getupdate');
        Route::post('/proyek/proyek-all/update/{projectId}', [ProyekController::class, 'update'])->name('proyek.update');
        Route::get('/proyek/proyek-all/updatepage/{projectId}', [ProyekController::class, 'updatePage'])->name('proyek.updatepage');
        Route::get('/proyek/proyek-all/updateproduct', [ProyekController::class, 'updateProduct'])->name('proyek.updateproduct');
        Route::post('/proyek/proyek-all/proposalupdate/{projectId}', [ProyekController::class, 'proposalUpdate'])->name('proposal.update');
        Route::delete('/proyek/proyek-all/deleteproduct/{taskproductId}', [ProyekController::class, 'deleteProduct'])->name('proyek.deleteproduct');
        Route::get('/proyek/proyek-all/getcompany', [ProyekController::class, 'getCompany'])->name('create.getcompany');

        Route::get('/proyek/proyek-single', [ProyekSingleController::class, 'index'])->name('proyek-single');
        Route::get('/proyek/proyek-single/getdata', [ProyekSingleController::class, 'getData'])->name('proyek-single.getdata');
        Route::get('/proyek/proyek-single/form', [ProyekSingleController::class, 'form'])->name('proyek-single.form');
        Route::post('/proyek/proyek-single/create', [ProyekSingleController::class, 'create'])->name('proyek-single.create');
        Route::get('/proyek/proyek-single/selectcompany/{idCompany}', [ProyekSingleController::class, 'selectCompany'])->name('create-single.selectcompany');
        Route::get('/proyek/proyek-single/getproduct', [ProyekSingleController::class, 'getProduct'])->name('create-single.getproduct');
        Route::get('/proyek/proyek-single/getupdate/{companyId}', [ProyekSingleController::class, 'getUpdate'])->name('proyek-single.getupdate');
        Route::post('/proyek/proyek-single/update/{projectId}', [ProyekSingleController::class, 'update'])->name('proyek-single.update');
        Route::get('/proyek/proyek-single/updatepage/{projectId}', [ProyekSingleController::class, 'updatePage'])->name('proyek-single.updatepage');
        Route::get('/proyek/proyek-single/updateproduct', [ProyekSingleController::class, 'updateProduct'])->name('proyek-single.updateproduct');
        Route::post('/proyek/proyek-single/proposalupdate/{projectId}', [ProyekSingleController::class, 'proposalUpdate'])->name('proposal-single.update');
        Route::delete('/proyek/proyek-single/deleteproduct/{taskproductId}', [ProyekSingleController::class, 'deleteProduct'])->name('proyek-single.deleteproduct');
        Route::get('/proyek/proyek-single/getcompany', [ProyekSingleController::class, 'getCompany'])->name('create-single.getcompany');
        Route::get('/proyek/proyek-single/pic', [ProyekSingleController::class, 'pic'])->name('proyek-single.pic');
        Route::post('/proyek/proyek-single/createpic', [ProyekSingleController::class, 'createPic'])->name('pic-single.create');

        Route::get('/offering/productoffering', [ProductOfferingController::class, 'index'])->name('productoffering');
        Route::get('/offering/productoffering/pic', [ProductOfferingController::class, 'pic'])->name('offering.pic');
        Route::post('/offering/productoffering/createpic', [ProductOfferingController::class, 'createPic'])->name('picoffering.create');
        Route::post('/offering/productoffering/createoffertag', [ProductOfferingController::class, 'createTag'])->name('offering.createoffertag');
        Route::post('/offering/productoffering/createoffer', [ProductOfferingController::class, 'createOffering'])->name('offering.create');
        Route::post('/offering/productoffering/updateoffering/{offeringId}', [ProductOfferingController::class, 'updateOffering'])->name('update.offering');
        Route::get('/offering/productoffering/getupdate/{offeringId}', [ProductOfferingController::class, 'getUpdate'])->name('offering.getupdate');
        Route::get('/offering/productoffering/getdetail/{offeringId}', [ProductOfferingController::class, 'getDetail'])->name('offering.getdetail');
        Route::post('/offering/productoffering/offeringupdate/{offeringId}', [ProductOfferingController::class, 'update'])->name('offering.update');
        Route::delete('/offering/productoffering/offeringdelete/{offeringId}', [ProductOfferingController::class, 'delete'])->name('offering.delete');
        Route::post('/offering/productoffering/offeringreschedule/{offeringId}', [ProductOfferingController::class, 'reschedule'])->name('offering.reschedule');
        Route::get('/offering/productoffering/offeringdetail', [ProductOfferingController::class, 'detail'])->name('offering.detail');
        Route::get('/offering/productoffering/offeringgetdata', [ProductOfferingController::class, 'getData'])->name('offering.getdata');
        Route::get('/offering/productoffering/offeringupdatepage/{offeringId}/{idOfferings}', [ProductOfferingController::class, 'updatePage'])->name('offering.updatepage');
        Route::delete('/offering/productoffering/deleteproduct/{offeringId}', [ProductOfferingController::class, 'deleteProduct'])->name('offering.deleteproduct');
        Route::get('/offering/productoffering/photo1/{offeringId}/{productId}', [ProductOfferingController::class, 'viewPhoto1'])->name('offering.photo1');
        Route::get('/offering/productoffering/photo2/{offeringId}/{productId}', [ProductOfferingController::class, 'viewPhoto2'])->name('offering.photo2');
        Route::get('/offering/productoffering/file1/{offeringId}/{productId}', [ProductOfferingController::class, 'viewFile1'])->name('offering.file1');
        Route::get('/offering/productoffering/file2/{offeringId}/{productId}', [ProductOfferingController::class, 'viewFile2'])->name('offering.file2');
        Route::get('/offering/productoffering/sample/{offeringId}/{productId}', [ProductOfferingController::class, 'sample'])->name('offering.sample');
        Route::post('/offering/productoffering/addproject', [ProductOfferingController::class, 'addProject'])->name('offering.addproject');

        Route::get('/offering/productoffered-all', [ProductOfferingAllController::class, 'index'])->name('productoffered-all');
        Route::post('/offering/productoffered-all/createoffertag', [ProductOfferingAllController::class, 'createTag'])->name('offering-all.createtag');
        Route::get('/offering/productoffered-all/getupdate/{offeringId}', [ProductOfferingAllController::class, 'getUpdate'])->name('offering-all.getupdate');
        Route::get('/offering/productoffered-all/getdetail/{offeringId}', [ProductOfferingAllController::class, 'getDetail'])->name('offering-all.getdetail');
        Route::get('/offering/productoffered-all/offeringdetail', [ProductOfferingAllController::class, 'detail'])->name('offering-all.detail');
        Route::get('/offering/productoffered-all/offeringgetdata', [ProductOfferingAllController::class, 'getData'])->name('offering-all.getdata');
        Route::get('/offering/productoffered-all/tagget/{tagId}', [ProductOfferingAllController::class, 'getTag'])->name('tag.get');
        Route::delete('/offering/productoffered-all/tagdelete/{tagId}', [ProductOfferingAllController::class, 'deleteTag'])->name('tag.delete');
        Route::get('/offering/productoffered-all/offeringdetail', [ProductOfferingAllController::class, 'detail'])->name('offering.detail');

        Route::get('/document-request', [DocumentRequestController::class, 'index'])->name('document.request');
        Route::get('/document-request/getdata', [DocumentRequestController::class, 'getData'])->name('document.getdata');
        Route::get('/document-request/getdetail/{offeringId}', [DocumentRequestController::class, 'getDetail'])->name('document.getdetail');
        Route::get('/document-request/form/{offeringId}/{productId}', [DocumentRequestController::class, 'form'])->name('document.form');
        Route::post('/document-request/upload/{offeringId}/{productId}', [DocumentRequestController::class, 'upload'])->name('document.upload');
        Route::get('/document-request/photo1/{offeringId}/{productId}', [DocumentRequestController::class, 'viewPhoto1'])->name('document.photo1');
        Route::get('/document-request/photo2/{offeringId}/{productId}', [DocumentRequestController::class, 'viewPhoto2'])->name('document.photo2');
        Route::get('/document-request/file1/{offeringId}/{productId}', [DocumentRequestController::class, 'viewFile1'])->name('document.file1');
        Route::get('/document-request/file2/{offeringId}/{productId}', [DocumentRequestController::class, 'viewFile2'])->name('document.file2');

        Route::get('/sample-request', [SampleRequestController::class, 'index'])->name('sample.request');
        Route::get('/sample-request/getdata', [SampleRequestController::class, 'getData'])->name('sample.getdata');
        Route::get('/sample-request/getupdate/{offeringId}', [SampleRequestController::class, 'getUpdate'])->name('sample.getupdate');
        Route::post('/sample-request/update/{offeringId}', [SampleRequestController::class, 'update'])->name('sample.update');
        Route::get('/sample-request/delivery-reff/{deliveryReff}', [DeliveryReffController::class, 'view'])->name('delivery-reff.view');

        Route::get('/delivery-reff', [DeliveryReffController::class, 'index'])->name('delivery-reff');
        Route::get('/delivery-reff/getdata', [DeliveryReffController::class, 'getData'])->name('delivery-reff.getdata');
        Route::get('/delivery-reff/getdetail', [DeliveryReffController::class, 'getDetail'])->name('delivery-reff.getdetail');

        Route::get('/visiting-report/visiting-single/form', [VisitingReportController::class, 'form'])->name('visiting.form');
        Route::post('/visiting-report/visiting-single/create', [VisitingReportController::class, 'create'])->name('visiting.create');
        Route::post('/visiting-report/visiting-single/followup', [VisitingReportController::class, 'followUp'])->name('visiting.followup');
        Route::get('/visiting-report/visiting-all/indexall', [VisitingReportController::class, 'indexAll'])->name('visiting.indexall');
        Route::get('/visiting-report/visiting-single/index', [VisitingReportController::class, 'index'])->name('visiting.index');
        Route::get('/visiting-report/visiting-all/getlist', [VisitingReportController::class, 'getList'])->name('visiting.getlist');
        Route::get('/visiting-report/visiting-single/getdata', [VisitingReportController::class, 'getData'])->name('visiting.getdata');
        Route::get('/visiting-report/visiting-all/getlist', [VisitingReportController::class, 'getList'])->name('visiting.getlist');
        Route::get('/visiting-report/visiting-single/getdata', [VisitingReportController::class, 'getData'])->name('visiting.getdata');
        Route::get('/visiting-report/visiting-single/getdetail/{reportId}', [VisitingReportController::class, 'getDetail'])->name('visiting.getdetail');
        Route::get('/visiting-report/viewfile/{reportId}', [VisitingReportController::class, 'viewFile'])->name('visiting.viewfile');
        
        Route::get('/kanban', function () {
            return view('pages/tasks/tasks-kanban');
        })->name('tasks-kanban');
        Route::get('/list', function () {
            return view('pages/tasks/tasks-list');
        })->name('tasks-list');
    });

    Route::prefix('kan-ban')->group(function (){
        Route::get('/', [KanbanController::class, 'index'])->name('kan-ban');
        Route::post('/createboard', [KanbanController::class, 'createBoard'])->name('kan-ban.createboard');
        Route::post('/kanbannotes', [KanbanController::class, 'notes'])->name('kan-ban.notes');
        Route::post('/deletenotes/{noteId}', [KanbanController::class, 'deleteNotes'])->name('delete.notes');
        Route::post('/kanbancreate', [KanbanController::class, 'createKanban'])->name('kan-ban.create');
        Route::get('/kanbangetupdate/{kanbanId}', [KanbanController::class, 'getUpdate'])->name('kan-ban.getupdate');
        Route::post('/kanbanprogress/{kanbanId}', [KanbanController::class, 'progress'])->name('kan-ban.progress');
        Route::post('/kanbanfinish/{kanbanId}', [KanbanController::class, 'finish'])->name('kan-ban.finish');
        Route::post('/kanbanupdate/{kanbanId}', [KanbanController::class, 'update'])->name('kan-ban.update');
        Route::post('/kanbandelete/{kanbanId}', [KanbanController::class, 'delete'])->name('kan-ban.delete');
        Route::post('/kanbanundo/{kanbanId}', [KanbanController::class, 'undo'])->name('kan-ban.undo');
        Route::get('/notegetupdate/{noteId}', [KanbanController::class, 'noteGetUpdate'])->name('note.getUpdate');
        Route::post('/noteupdate/{noteId}', [KanbanController::class, 'noteUpdate'])->name('note.update');
    });

    Route::prefix('google')->group(function () {
        Route::get('/google-calendar', [GoogleCalendarController::class, 'index'])->name('google-calendar');
    });

    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('calendar');
        Route::post('/createtag', [CalendarController::class, 'createTag'])->name('calendar.createtag');
        Route::post('/createschedule', [CalendarController::class, 'createSchedule'])->name('calendar.createschedule');
        Route::get('/getupdate/{calendarId}', [CalendarController::class, 'getUpdate'])->name('calendar.getupdate');
        Route::post('/calendarupdate/{calendarId}', [CalendarController::class, 'update'])->name('calendar.update');
        Route::delete('/calendardelete/{calendarId}', [CalendarController::class, 'delete'])->name('calendar.delete');
        Route::get('/calendardetail', [CalendarController::class, 'detail'])->name('calendar.detail');
    });

    Route::prefix('company')->middleware('checkRoleUser:101,100')->group(function () {
        Route::get('/companycalendar', [CompanyCalendarController::class, 'index'])->name('company.calendar');
        Route::post('/companycalendar/createtag', [CompanyCalendarController::class, 'createTag'])->name('calendar.createtag');
        Route::get('/companycalendar/getupdate/{calendarId}', [CompanyCalendarController::class, 'getUpdate'])->name('calendar.getupdate');
        Route::get('/companycalendar/calendardetail', [CompanyCalendarController::class, 'detail'])->name('calendar.detail');
        Route::get('/companycalendar/tagget/{tagId}', [CompanyCalendarController::class, 'getTag'])->name('tag.get');
        Route::delete('/companycalendar/tagdelete/{tagId}', [CompanyCalendarController::class, 'deleteTag'])->name('tag.delete');
    });

    Route::prefix('kpi')->group(function () {
        Route::get('/kpi-view', [KpiController::class, 'index'])->name('kpi-view');
        Route::get('/kpi-view/getdata', [KpiController::class, 'getData'])->name('kpi-view.getdata');
        Route::get('/kpi-view/getdata1', [BudgetingController::class, 'getData1'])->name('kpi-view.getdata1');
        
        Route::get('/budget', [BudgetingController::class, 'index'])->name('budget');
        Route::get('/budget/getdata', [BudgetingController::class, 'getData'])->name('budget.getdata');
        Route::get('/budget/getdata1', [BudgetingController::class, 'getData1'])->name('budget.getdata1');
        Route::post('/budget/create', [BudgetingController::class, 'create'])->name('budget.create');
        Route::post('/budget/update/{budgetId}', [BudgetingController::class, 'update'])->name('budget.update');

        Route::get('/weekly-report', [WeeklyReportController::class, 'index'])->name('weekly-report');
        Route::get('/weekly-report/getdata', [WeeklyReportController::class, 'getData'])->name('weekly-report.getdata');
        Route::get('/weekly-report/viewfile1/{reportId}/{notes}', [WeeklyReportController::class, 'viewFile1'])->name('weekly-report.viewfile1');
        Route::get('/weekly-report/viewfile2/{reportId}/{notes}', [WeeklyReportController::class, 'viewFile2'])->name('weekly-report.viewfile2');
        Route::get('/weekly-report/viewfile3/{reportId}/{notes}', [WeeklyReportController::class, 'viewFile3'])->name('weekly-report.viewfile3');
        Route::post('/weekly-report/create', [WeeklyReportController::class, 'create'])->name('weekly-report.create');
        Route::delete('/weekly-report/delete/{reportId}', [WeeklyReportController::class, 'delete'])->name('weekly-report.delete');
        Route::post('/weekly-report/update/{reportId}', [WeeklyReportController::class, 'update'])->name('weekly-report.update');

        Route::get('/report-list', [WeeklyReportController::class, 'index1'])->name('report-list');
        Route::get('/report-list/getdata', [WeeklyReportController::class, 'getData1'])->name('report-list.getdata');
    });

    Route::prefix('setupmenu')->group(function () {
        Route::get('/', [MenuSettingController::class, 'index'])->name('menu-setting');
        Route::post('/update/{userId}', [MenuSettingController::class, 'update'])->name('menu-setting.update');
    });

    Route::prefix('user-manager')->group(function () {
        Route::get('/', [UserManagerController::class, 'index'])->name('user-manager');
        Route::get('/changepassword/{userId}', [UserManagerController::class, 'changePassword'])->name('user-manager.changepassword');
        Route::get('/getdata', [UserManagerController::class, 'getData'])->name('user-manager.getdata');
        Route::post('/create', [UserManagerController::class, 'create'])->name('user-manager.create');
        Route::post('/update/{userId}', [UserManagerController::class, 'update'])->name('user-manager.update');
        Route::post('/update1/{userId}', [UserManagerController::class, 'update1'])->name('user-manager.update1');
        Route::delete('/delete/{userId}', [UserManagerController::class, 'delete'])->name('user-manager.delete');
    });
    

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/getdata', [DashboardController::class, 'getData'])->name('dashboard.sales');
    Route::get('/dashboard/salesachiev', [DashboardController::class, 'getAchiev'])->name('dashboard.achiev');
    Route::get('/dashboard/newcust', [DashboardController::class, 'getCust'])->name('dashboard.cust');
    Route::get('/dashboard/newproduct', [DashboardController::class, 'getProduct'])->name('dashboard.product');
    Route::get('/dashboard/offer', [DashboardController::class, 'getOffer'])->name('dashboard.offer');
    Route::get('/dashboard/getar', [DashboardController::class, 'getAr'])->name('dashboard.getar');
    Route::get('/dashboard/percent', [DashboardController::class, 'achievPersent'])->name('dashboard.percent');
    Route::get('/dashboard/percent1', [DashboardController::class, 'achievPersent1'])->name('dashboard.percent1');
    Route::get('/dashboard/achievsales', [DashboardController::class, 'achievSales'])->name('dashboard.achievsales');
    Route::get('/dashboard/orderprincipal', [DashboardController::class, 'orderPrincipal'])->name('dashboard.orderprincipal');
    Route::get('/dashboard/orderprincipaldetail/{year}/{idsupplier}', [DashboardController::class, 'orderPrincipalDetail'])->name('dashboard.orderprincipaldetail');
    Route::get('/dashboard/principaldetail/{idpo}', [DashboardController::class, 'principalDetail'])->name('dashboard.principaldetail');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');
    Route::get('/ecommerce/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/ecommerce/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/ecommerce/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/ecommerce/shop', function () {
        return view('pages/ecommerce/shop');
    })->name('shop');
    Route::get('/ecommerce/shop-2', function () {
        return view('pages/ecommerce/shop-2');
    })->name('shop-2');
    Route::get('/ecommerce/product', function () {
        return view('pages/ecommerce/product');
    })->name('product');
    Route::get('/ecommerce/cart', function () {
        return view('pages/ecommerce/cart');
    })->name('cart');
    Route::get('/ecommerce/cart-2', function () {
        return view('pages/ecommerce/cart-2');
    })->name('cart-2');
    Route::get('/ecommerce/cart-3', function () {
        return view('pages/ecommerce/cart-3');
    })->name('cart-3');
    Route::get('/ecommerce/pay', function () {
        return view('pages/ecommerce/pay');
    })->name('pay');
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
    Route::get('/community/users-tabs', [MemberController::class, 'indexTabs'])->name('users-tabs');
    Route::get('/community/users-tiles', [MemberController::class, 'indexTiles'])->name('users-tiles');
    Route::get('/community/profile', function () {
        return view('pages/community/profile');
    })->name('profile');
    Route::get('/community/feed', function () {
        return view('pages/community/feed');
    })->name('feed');
    Route::get('/community/forum', function () {
        return view('pages/community/forum');
    })->name('forum');
    Route::get('/community/forum-post', function () {
        return view('pages/community/forum-post');
    })->name('forum-post');
    Route::get('/community/meetups', function () {
        return view('pages/community/meetups');
    })->name('meetups');
    Route::get('/community/meetups-post', function () {
        return view('pages/community/meetups-post');
    })->name('meetups-post');
    Route::get('/finance/cards', function () {
        return view('pages/finance/credit-cards');
    })->name('credit-cards');
    Route::get('/finance/transactions', [TransactionController::class, 'index01'])->name('transactions');
    Route::get('/finance/transaction-details', [TransactionController::class, 'index02'])->name('transaction-details');
    Route::get('/job/job-listing', [JobController::class, 'index'])->name('job-listing');
    Route::get('/job/job-post', function () {
        return view('pages/job/job-post');
    })->name('job-post');
    Route::get('/job/company-profile', function () {
        return view('pages/job/company-profile');
    })->name('company-profile');
    Route::get('/messages', function () {
        return view('pages/messages');
    })->name('messages');
    Route::get('/inbox', function () {
        return view('pages/inbox');
    })->name('inbox');
    Route::get('/settings/account', function () {
        return view('pages/settings/account');
    })->name('account');
    Route::get('/settings/notifications', function () {
        return view('pages/settings/notifications');
    })->name('notifications');
    Route::get('/settings/apps', function () {
        return view('pages/settings/apps');
    })->name('apps');
    Route::get('/settings/plans', function () {
        return view('pages/settings/plans');
    })->name('plans');
    Route::get('/settings/billing', function () {
        return view('pages/settings/billing');
    })->name('billing');
    Route::get('/settings/feedback', function () {
        return view('pages/settings/feedback');
    })->name('feedback');
    Route::get('/utility/changelog', function () {
        return view('pages/utility/changelog');
    })->name('changelog');
    Route::get('/utility/roadmap', function () {
        return view('pages/utility/roadmap');
    })->name('roadmap');
    Route::get('/utility/faqs', function () {
        return view('pages/utility/faqs');
    })->name('faqs');
    Route::get('/utility/empty-state', function () {
        return view('pages/utility/empty-state');
    })->name('empty-state');
    Route::get('/utility/404', function () {
        return view('pages/utility/404');
    })->name('404');
    Route::get('/utility/knowledge-base', function () {
        return view('pages/utility/knowledge-base');
    })->name('knowledge-base');
    Route::get('/onboarding-01', function () {
        return view('pages/onboarding-01');
    })->name('onboarding-01');
    Route::get('/onboarding-02', function () {
        return view('pages/onboarding-02');
    })->name('onboarding-02');
    Route::get('/onboarding-03', function () {
        return view('pages/onboarding-03');
    })->name('onboarding-03');
    Route::get('/onboarding-04', function () {
        return view('pages/onboarding-04');
    })->name('onboarding-04');
    Route::get('/component/button', function () {
        return view('pages/component/button-page');
    })->name('button-page');
    Route::get('/component/form', function () {
        return view('pages/component/form-page');
    })->name('form-page');
    Route::get('/component/dropdown', function () {
        return view('pages/component/dropdown-page');
    })->name('dropdown-page');
    Route::get('/component/alert', function () {
        return view('pages/component/alert-page');
    })->name('alert-page');
    Route::get('/component/modal', function () {
        return view('pages/component/modal-page');
    })->name('modal-page');
    Route::get('/component/pagination', function () {
        return view('pages/component/pagination-page');
    })->name('pagination-page');
    Route::get('/component/tabs', function () {
        return view('pages/component/tabs-page');
    })->name('tabs-page');
    Route::get('/component/breadcrumb', function () {
        return view('pages/component/breadcrumb-page');
    })->name('breadcrumb-page');
    Route::get('/component/badge', function () {
        return view('pages/component/badge-page');
    })->name('badge-page');
    Route::get('/component/avatar', function () {
        return view('pages/component/avatar-page');
    })->name('avatar-page');
    Route::get('/component/tooltip', function () {
        return view('pages/component/tooltip-page');
    })->name('tooltip-page');
    Route::get('/component/accordion', function () {
        return view('pages/component/accordion-page');
    })->name('accordion-page');
    Route::get('/component/icons', function () {
        return view('pages/component/icons-page');
    })->name('icons-page');
    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
