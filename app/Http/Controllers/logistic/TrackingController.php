<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrackingController extends Controller
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
        return view('pages.logistic.check.index');
    }

    public function report(Request $request, $doNumber, $batchNo, $productCode)
    {
        $dataDeliveryOrders = DB::table('delivery_orders')
            ->leftJoin('products', 'delivery_orders.product_code', 'products.code')
            ->leftJoin('orders', 'delivery_orders.do_number', 'orders.do_number')
            ->select(
                'delivery_orders.do_number',
                'delivery_orders.product_code',
                'delivery_orders.batch_no',
                'delivery_orders.qty',
                'delivery_orders.status',
                'delivery_orders.qty_damaged',
                'delivery_orders.qty_lost',
                'delivery_orders.photo_damage1_name',
                'delivery_orders.photo_damage2_name',
                'delivery_orders.photo_lost1_name',
                'delivery_orders.photo_lost2_name',
                'products.name as product_name',
                'orders.code',
                DB::raw("ISNULL(delivery_orders.photo_damage1_blob) as damage1"),
                DB::raw("ISNULL(delivery_orders.photo_damage2_blob) as damage2"),
                DB::raw("ISNULL(delivery_orders.photo_lost1_blob) as lost1"),
                DB::raw("ISNULL(delivery_orders.photo_lost2_blob) as lost2"),
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
            ")
            )->whereRaw("(delivery_orders.do_number = '$doNumber' and delivery_orders.batch_no = '$batchNo' and delivery_orders.product_code = '$productCode')")->first();

        $viewDo = DB::table('orders')
        ->leftJoin('companies', 'orders.company_id', 'companies.id')
        ->select(
            'orders.id',
            'orders.code',
            'orders.do_number',
            'orders.status',
            'orders.created_at',
            'orders.updated_at',
            'orders.delivery_address',
            'orders.delivery_by',
            'orders.delivery_date',
            'orders.photo1_name',
            'orders.photo2_name',
            'companies.name as company',
            DB::raw("ISNULL(orders.photo1) as photo1"),
            DB::raw("ISNULL(orders.photo2) as photo2"),
            DB::raw("
                case
                    when orders.status = 1 then 'Shipping in Progress'
                    when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                    when orders.status = 301 then 'All Delivered - CONFIRMED'
                    when orders.status = 302 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when orders.status = 303 then 'All Lost Delivery - DAMAGE/LOST'
                    when orders.status = 4 then 'Payment Information Received'
                    when orders.status = 5 then 'Finished Payment Verified'
                    else 'unknown status'
                end as name_status
                ")

            )->where('orders.do_number', $doNumber)->first();

            $kalimat = DB::table('orders')->select('orders.delivery_address')->where('orders.do_number', $doNumber)->get();
            $tampil =substr($kalimat, 22, 160);

        return view('pages.logistic.check.print', compact('viewDo', 'dataDeliveryOrders', 'kalimat', 'tampil'));
    }

    public function updatePage(Request $request)
    {
        $search = $request->input('search');

        $dataDeliveryOrders = DB::table('delivery_orders')
            ->leftJoin('products', 'delivery_orders.product_code', 'products.code')
            ->leftJoin('orders', 'delivery_orders.do_number', 'orders.do_number')
            ->select(
                'delivery_orders.do_number',
                'delivery_orders.product_code',
                'delivery_orders.batch_no',
                'delivery_orders.qty',
                'delivery_orders.status',
                'delivery_orders.qty_damaged',
                'delivery_orders.qty_lost',
                'delivery_orders.photo_damage1_name',
                'delivery_orders.photo_damage2_name',
                'delivery_orders.photo_lost1_name',
                'delivery_orders.photo_lost2_name',
                'orders.id',
                'orders.code',
                'products.name as product_name',
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
            ")
            )->where('orders.code', $search)->get();
        
        $viewDo = DB::table('orders')
            ->leftJoin('delivery_orders', 'orders.do_number', 'delivery_orders.do_number')
            ->leftJoin('companies', 'orders.company_id', 'companies.id')
            ->select(
                'orders.id',
                'orders.code',
                'orders.do_number',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'orders.delivery_address',
                'orders.delivery_by',
                'orders.delivery_date',
                'orders.photo1_name',
                'orders.photo2_name',
                'companies.name as company',
                DB::raw("ISNULL(delivery_orders.photo_damage1_blob) as damage1"),
                DB::raw("ISNULL(delivery_orders.photo_damage2_blob) as damage2"),
                DB::raw("ISNULL(delivery_orders.photo_lost1_blob) as lost1"),
                DB::raw("ISNULL(delivery_orders.photo_lost2_blob) as lost2"),
                DB::raw("ISNULL(orders.photo1) as photo1"),
                DB::raw("ISNULL(orders.photo2) as photo2"),
                DB::raw("
                    case
                        when orders.status = 1 then 'Shipping in Progress'
                        when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                        when orders.status = 301 then 'All Delivered - CONFIRMED'
                        when orders.status = 302 then 'Partially Damage/Lost - DAMAGE/LOST'
                        when orders.status = 303 then 'All Lost Delivery - DAMAGE/LOST'
                        when orders.status = 4 then 'Payment Information Received'
                        when orders.status = 5 then 'Finished Payment Verified'
                        else 'unknown status'
                    end as name_status
                    ")
        )->where('orders.code', $search)->first();

                if ($dataDeliveryOrders->isEmpty() && !$viewDo) {
                    alert()->error('Error', 'Code Delivery Order Not Found');
                    return to_route('tracking');
                }

        return view('pages.logistic.check.trackupdate', compact('viewDo', 'dataDeliveryOrders'));
    }

    public function productPage(Request $request, $doNumber, $batchNo, $productCode)
    {
        $dataDeliveryOrders = DB::table('delivery_orders')
            ->leftJoin('products', 'delivery_orders.product_code', 'products.code')
            ->leftJoin('orders', 'delivery_orders.do_number', 'orders.do_number')
            ->select(
                'delivery_orders.do_number',
                'delivery_orders.product_code',
                'delivery_orders.batch_no',
                'delivery_orders.qty',
                'delivery_orders.status',
                'delivery_orders.qty_damaged',
                'delivery_orders.qty_lost',
                'delivery_orders.photo_damage1_name',
                'delivery_orders.photo_damage2_name',
                'delivery_orders.photo_lost1_name',
                'delivery_orders.photo_lost2_name',
                'products.name as product_name',
                'orders.code',
                'orders.status as orders_status',
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
            ")
            )->whereRaw("(delivery_orders.do_number = '$doNumber' and delivery_orders.batch_no = '$batchNo' and delivery_orders.product_code = '$productCode')")->first();

        return view('pages.logistic.check.product-page', compact('dataDeliveryOrders'));
    }

    public function updateDO(Request $request, $doNumber)
    {  
        $code = $request->input('code');
       // photo1
       $file_photo1 = $request->file('photo1');    
       $photo1 = $file_photo1->openFile()->fread($file_photo1->getSize());

       if ($request->hasFile('photo1')) {
           $fileName1 = $request->file('photo1')->storeAs('doImg', $code . '-1.jpg');
           $request->file('photo1')->move($this->saveImageUrl . 'doImg/', $fileName1);
       } else {
           $fileName1 = null;
       }
       
       // photo2
       $file_photo2 = $request->file('photo2');    
       $photo2 = $file_photo2->openFile()->fread($file_photo2->getSize());

       if ($request->hasFile('photo2')) {
           $fileName2 = $request->file('photo2')->storeAs('doImg', $code . '-2.jpg');
           $request->file('photo2')->move($this->saveImageUrl . 'doImg/', $fileName2);
       } else {
           $fileName2 = null;
       }
        
        // $status = $request->input('status');

        // if ($status == 'All Delivered - CONFIRMED') {
        //     $statusUpdate = "301";
        // } else if ($status == 'Partially Damage/Lost - DAMAGE/LOST') {
        //     $statusUpdate = "302";
        // } else if ($status == 'All Lost Delivery - DAMAGE/LOST') {
        //     $statusUpdate = "303";
        // }

        $status = $request->input('doStatus');

        if ($status == '303') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);

            $updateProduct = DB::table('delivery_orders')->where('do_number', $doNumber)
            ->update([
                'status' => '3',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('tracking');
        }
        
        if ($status == '301') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);
            $updateProduct = DB::table('delivery_orders')->where('do_number', $doNumber)
            ->update([
                'status' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('tracking');
        }

        if ($status == '302') {
            $updateOrders = DB::table('orders')
                ->where('do_number', $doNumber)
                ->update([
                    'status' => $request->input('doStatus'),
                    'photo1' => $photo1,
                    'photo1_name' => $fileName1,
                    'photo2' => $photo2,
                    'photo2_name' => $fileName2,
                    'updated_at' => date('Y-m-d H:i:s')
            ]);
            alert()->success('Success', 'Orders Has Been Updated');
            return to_route('tracking');
        }
    }

    public function productDo(Request $request, $doNumber, $batchNo, $productCode)
    {
        $code = $request->input('code');
        $doNumber = $request->input('doNumber');
        $batchNo = $request->input('batchNo');
        $productCode = $request->input('productCode');
        $damaged = $request->input('qty_damaged');
        $lost = $request->input('qty_lost');
        $damaged1 = $request->hasFile('damaged_image1');
        $lost1 = $request->hasFile('lost_image1');

        $dataDeliveryOrders = DB::table('delivery_orders')
            ->leftJoin('products', 'delivery_orders.product_code', 'products.code')
            ->leftJoin('orders', 'delivery_orders.do_number', 'orders.do_number')
            ->select(
                'delivery_orders.do_number',
                'delivery_orders.product_code',
                'delivery_orders.batch_no',
                'delivery_orders.qty',
                'delivery_orders.status',
                'delivery_orders.qty_damaged',
                'delivery_orders.qty_lost',
                'delivery_orders.photo_damage1_name',
                'delivery_orders.photo_damage2_name',
                'delivery_orders.photo_lost1_name',
                'delivery_orders.photo_lost2_name',
                'orders.id',
                'orders.code',
                'products.name as product_name',
            DB::raw("
                case
                    when delivery_orders.status = 0 then 'Pending'
                    when delivery_orders.status = 1 then 'Uploaded'
                    when delivery_orders.status = 2 then 'Partially Damage/Lost - DAMAGE/LOST'
                    when delivery_orders.status = 3 then 'All Lost Delivery - DAMAGE/LOST'
                    else 'unknown status'
                end as status_order
            ")
            )->where('orders.code', $code)->get();

        $viewDo = DB::table('orders')
            ->leftJoin('delivery_orders', 'orders.do_number', 'delivery_orders.do_number')
            ->leftJoin('companies', 'orders.company_id', 'companies.id')
            ->select(
                'orders.id',
                'orders.code',
                'orders.do_number',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'orders.delivery_address',
                'orders.delivery_by',
                'orders.delivery_date',
                'orders.photo1_name',
                'orders.photo2_name',
                'companies.name as company',
                DB::raw("ISNULL(delivery_orders.photo_damage1_blob) as damage1"),
                DB::raw("ISNULL(delivery_orders.photo_damage2_blob) as damage2"),
                DB::raw("ISNULL(delivery_orders.photo_lost1_blob) as lost1"),
                DB::raw("ISNULL(delivery_orders.photo_lost2_blob) as lost2"),
                DB::raw("ISNULL(orders.photo1) as photo1"),
                DB::raw("ISNULL(orders.photo2) as photo2"),
                DB::raw("
                    case
                        when orders.status = 1 then 'Shipping in Progress'
                        when orders.status = 2 then 'AWB / Shipping Information Uploaded'
                        when orders.status = 301 then 'All Delivered - CONFIRMED'
                        when orders.status = 302 then 'Partially Damage/Lost - DAMAGE/LOST'
                        when orders.status = 303 then 'All Lost Delivery - DAMAGE/LOST'
                        when orders.status = 4 then 'Payment Information Received'
                        when orders.status = 5 then 'Finished Payment Verified'
                        else 'unknown status'
                    end as name_status
                    ")
                )->where('orders.code', $code)->first();

                 // damage1
                if ($request->hasFile('damaged_image1')) {
                 $fileDamaged1 = $request->file('damaged_image1');    
                 $photoDamaged1 = $fileDamaged1->openFile()->fread($fileDamaged1->getSize());
                } else {
                    $photoDamaged1 = null;
                }

                 if ($request->hasFile('damaged_image1')) {
                    $fileDamageName1 = $request->file('damaged_image1')->storeAs('doImg', $code . '-3.jpg');
                    $request->file('damaged_image1')->move($this->saveImageUrl . 'doImg/', $fileDamageName1);
                } else {
                    $fileDamageName1 = null;
                }

                // damage2
                if ($request->hasFile('damaged_image2')) {
                $fileDamaged2 = $request->file('damaged_image2');    
                $photoDamaged2 = $fileDamaged2->openFile()->fread($fileDamaged2->getSize());
                } else {
                    $photoDamaged2 = null;
                }
                if ($request->hasFile('damaged_image2')) {
                    $fileDamageName2 = $request->file('damaged_image2')->storeAs('doImg', $code . '-4.jpg');
                    $request->file('damaged_image2')->move($this->saveImageUrl . 'doImg/', $fileDamageName2);
                } else {
                    $fileDamageName2 = null;
                }

                // lost1
                if ($request->hasFile('lost_image1')) {
                $fileLost1 = $request->file('lost_image1');    
                $photoLost1 = $fileLost1->openFile()->fread($fileLost1->getSize());
                } else {
                    $photoLost1 = null;
                }
                if ($request->hasFile('lost_image1')) {
                    $fileLostName1 = $request->file('lost_image1')->storeAs('doImg', $code . '-5.jpg');
                    $request->file('lost_image1')->move($this->saveImageUrl . 'doImg/', $fileLostName1);
                } else {
                    $fileLostName1 = null;
                }

                // lost2
                if ($request->hasFile('lost_image2')) {
                $fileLost2 = $request->file('lost_image2');    
                $photoLost2 = $fileLost2->openFile()->fread($fileLost2->getSize());
                } else {
                    $photoLost2 = null;
                }

                if ($request->hasFile('lost_image2')) {
                    $fileLostName2 = $request->file('lost_image2')->storeAs('doImg', $code . '-6.jpg');
                    $request->file('lost_image2')->move($this->saveImageUrl . 'doImg/', $fileLostName2);
                } else {
                    $fileLostName2 = null;
                }

        if ($request) {   
            if (!empty($damaged && $damaged1)) {
                $updateProduct = DB::table('delivery_orders')
                ->whereRaw("(delivery_orders.do_number = '$doNumber' and delivery_orders.batch_no = '$batchNo' and delivery_orders.product_code = '$productCode')")
                ->update([
                    'notes' => $request->input('notes'),
                    'qty_damaged' => $request->input('qty_damaged'),
                    'photo_damage1_blob' => $photoDamaged1,
                    'photo_damage1_name' => $fileDamageName1,
                    'photo_damage2_blob' => $photoDamaged2,
                    'photo_damage2_name' => $fileDamageName2,
                    'qty_lost' => $request->input('qty_lost'),
                    'photo_lost1_blob' => $photoLost1,
                    'photo_lost1_name' => $fileLostName1,
                    'photo_lost2_blob' => $photoLost2,
                    'photo_lost2_name' => $fileLostName2,
                    'status' => '2',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $updateOrders = DB::table('orders')
                ->where('orders.do_number', $doNumber)
                ->update([
                    'status' => '302',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            alert()->success('Success', 'Damaged/Lost Orders has been updated');
            return to_route('tracking');
            } if (!empty($lost && $lost1)) {    
                $updateProduct1 = DB::table('delivery_orders')
                ->whereRaw("(delivery_orders.do_number = '$doNumber' and delivery_orders.batch_no = '$batchNo' and delivery_orders.product_code = '$productCode')")
                ->update([
                    'notes' => $request->input('notes'),
                    'qty_damaged' => $request->input('qty_damaged'),
                    'photo_damage1_blob' => $photoDamaged1,
                    'photo_damage1_name' => $fileDamageName1,
                    'photo_damage2_blob' => $photoDamaged2,
                    'photo_damage2_name' => $fileDamageName2,
                    'qty_lost' => $request->input('qty_lost'),
                    'photo_lost1_blob' => $photoLost1,
                    'photo_lost1_name' => $fileLostName1,
                    'photo_lost2_blob' => $photoLost2,
                    'photo_lost2_name' => $fileLostName2,
                    'status' => '2',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
    
                $updateOrders = DB::table('orders')
                ->where('orders.do_number', $doNumber)
                ->update([
                    'status' => '302',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                alert()->success('Success', 'Damaged/Lost Orders has been updated');
                return to_route('tracking');
            }if (empty($damaged && $damaged1) || empty($lost && $lost1)) {
                alert()->error('Error', 'Damaged/lost Photo 1 field must fill');
                return to_route('tracking');
            }
        } else if (!empty($damaged && $damaged1 && $lost && $lost1)){
            alert()->error('Error', 'Damaged/lost Photo 1 field must fill');
            return to_route('tracking');
        }
    }

    public function viewPhoto1($code)
    {
        $data = DB::table('orders')->where('code', $code)->select('photo1')->first();

        return Response::make($data->photo1, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->photo1)
        ]);
    }

    public function viewPhoto2($code)
    {
        $data = DB::table('orders')->where('code', $code)->select('photo2')->first();

        return Response::make($data->photo2, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($data->photo2)
        ]);
    }
}
