<?php

namespace App\Http\Controllers\ga;

use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Fields\Select;
use Illuminate\Support\Str;

class OfficeCatalogueController extends Controller
{
    public function catalogue(Request $request)
{
    $dataCategory = DB::table('m_category')->select('*')->where('p_id_cat', '=', '0')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
    $search = $request->input('search');
    $dataAsset = DB::table('inventory_assets')
        ->select('inventory_assets.idassets', 'inventory_assets.name', 'inventory_assets.unit', 'inventory_assets.category',
            'inventory_assets.qty', 'inventory_assets.description', 'inventory_assets.img_name',
            DB::raw("COUNT(DISTINCT idassets) AS item"))
        ->groupBy('idassets')->orderBy('idassets', 'asc');

    if ($request->has('search')) {
        $dataAsset = $dataAsset->where('inventory_assets.idassets', 'LIKE', '%' . $request->search . '%')
            ->orWhere('inventory_assets.name', 'LIKE', '%' . $request->search . '%');
    }

    $dataAsset = $dataAsset->paginate(9);

    $totalItemsAfterSearch = $dataAsset->total();

    return view('pages.ga.office-catalogue.index', compact('dataAsset', 'totalItemsAfterSearch', 'dataCategory'));
}

public function category(Request $request, $category)
{
    $dataCategory = DB::table('m_category')->select('*')->where('p_id_cat', '=', '0')->where('status', '=', 'Active')->orderBy('name', 'asc')->get();
    $search = $request->input('search');
    $dataAsset = DB::table('inventory_assets')
        ->select('inventory_assets.idassets', 'inventory_assets.name', 'inventory_assets.unit', 'inventory_assets.category',
            'inventory_assets.qty', 'inventory_assets.description', 'inventory_assets.img_name',
            DB::raw("COUNT(DISTINCT idassets) AS item"))
        ->where('inventory_assets.category', '=', $category)
        ->groupBy('idassets')->orderBy('idassets', 'asc');

    if ($request->has('search')) {
        $dataAsset = $dataAsset->where(function ($query) use ($request) {
            $query->where('inventory_assets.idassets', 'LIKE', '%' . $request->search . '%')
                ->orWhere('inventory_assets.name', 'LIKE', '%' . $request->search . '%');
        });
    }

    $dataAsset = $dataAsset->paginate(9);

    $totalItemsAfterSearch = $dataAsset->total();

    return view('pages.ga.office-catalogue.index', compact('dataAsset', 'totalItemsAfterSearch', 'dataCategory'));
}

    
}
