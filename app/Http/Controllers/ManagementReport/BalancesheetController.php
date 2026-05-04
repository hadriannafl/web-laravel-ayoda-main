<?php

namespace App\Http\Controllers\ManagementReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BalancesheetController extends Controller
{
    public function index(){
        return view('pages.management-report.balancesheet.index');
    }

    public function getData(Request $request){
        $dataBs = DB::table('t_balancesheets')
        ->select('*')
        ->orderBy('bs_date', 'desc');

        if ($request->ajax()) {
            return DataTables::of($dataBs)
                ->editColumn('bs_date', function ($dataBs) {
                    return date('Y F', strtotime($dataBs->bs_date));
                })
                ->addColumn('action', function ($dataBs) {
                    return '
                    <a href="/management-report/balancesheet/file/' . $dataBs->idrec . '" target="_blank" class="btn btn-xs bg-indigo-500 hover:bg-indigo-600 text-white">
                        View
                    </a>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function viewFile($bsId)
    {
        $dataBs = DB::table('t_balancesheets')->where('idrec', $bsId)->select('bs_pdf', 'bs_date')->first();
        $filename = $dataBs->bs_date . '.pdf';
        $filebs = $dataBs->bs_pdf;

        // if (is_null($invoice)) {
        //     alert()->error('Error', 'Invoice Not Found');
        //     return to_route('invoice');
        // }

        return Response::make($filebs, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
}
