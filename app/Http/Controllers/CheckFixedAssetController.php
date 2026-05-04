<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use finfo;
use Illuminate\Support\Facades\Response;

class CheckFixedAssetController extends Controller
{
    protected $saveImageUrl;
    protected $baseImageUrl;

    public function __construct()
    {
        $this->saveImageUrl = config('app.save_url_file');
        $this->baseImageUrl = config('app.base_url_file');
    }

    public function fixedAssetPage(Request $request, $idfa)
    {
        // dd($idfa);
        $decodedId = base64_decode($idfa);
        
        $dataFixedAsset = DB::table('t_fixed_asset')
        ->leftJoin('inventory_assets', 't_fixed_asset.idassets', 'inventory_assets.idassets')
        ->leftJoin('m_child_company', 't_fixed_asset.id_company', 'm_child_company.id_company')
        ->leftJoin('m_site_warehouse', 't_fixed_asset.id_warehouse', 'm_site_warehouse.id_warehouse')
        ->select('t_fixed_asset.idrec', 't_fixed_asset.idfa', 't_fixed_asset.idassets', 't_fixed_asset.id_company', 't_fixed_asset.kondisi', 't_fixed_asset.notes', 't_fixed_asset.photo', 'inventory_assets.name', 'inventory_assets.brand', 'inventory_assets.type', 
        'inventory_assets.category', 'inventory_assets.img_name', 'm_child_company.name as companyName', 'm_site_warehouse.w_address')
        ->where('t_fixed_asset.idfa', $decodedId)->first();
        if (!$dataFixedAsset) {
            abort(404); // Page not found
        }

        return view('pages.qr-fixedasset.index', compact('dataFixedAsset'));
    }

    public function updateFixedAsset(Request $request, $idrec)
    {  
        $dataFixedAsset = DB::table('t_fixed_asset')
        ->select('t_fixed_asset.idfa', 't_fixed_asset.idrec')
        ->where('t_fixed_asset.idrec', $idrec)->first();

        $idFixedAsset = $dataFixedAsset->idfa;

        if ($request->hasFile('photo')) {
            $photoName = $request->file('photo')->storeAs('assetPhoto', $idFixedAsset . '.jpg');
            $request->file('photo')->move($this->saveImageUrl . 'fixedAssetPhoto/', $photoName);
        } else {
            $photoName = null;
        }

        if ($request->hasFile('photo')) {
            DB::table('t_fixed_asset')->where('t_fixed_asset.idrec', $idrec)->update([
                'kondisi' => $request->input('kondisi'),   
                'notes' => $request->input('notes'),  
                'photo' => $photoName, 
                'updated_at' => date('Y-m-d')
            ]);
        } else {
            DB::table('t_fixed_asset')->where('t_fixed_asset.idrec', $idrec)->update([
                'kondisi' => $request->input('kondisi'),   
                'notes' => $request->input('notes'),  
                'updated_at' => date('Y-m-d')
            ]);
        }
        alert()->success('Success', 'Data Fixed Aset has been Updated');
        return redirect()->back();
    }
}
