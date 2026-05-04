<?php

namespace App\Http\Controllers\ManagementReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PnlsController extends Controller
{
    public function index(){
        return view('pages.management-report.pnls.index');
    }

    public function getData(Request $request){
        $pnls = DB::table('t_pnls')
        ->select('*')
        ->orderBy('pnl_date', 'desc');

        if ($request->ajax()) {
            return DataTables::of($pnls)
                ->editColumn('pnl_date', function ($pnls) {
                    return date('Y F', strtotime($pnls->pnl_date));
                })
                ->addColumn('action', function ($pnls) {
                    return '
                    <a href="/management-report/pnls/file/' . $pnls->idrec . '" target="_blank" class="btn btn-xs bg-indigo-500 hover:bg-indigo-600 text-white">
                        View
                    </a>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function viewFile($pnlsId)
    {
        $pnls = DB::table('t_pnls')->where('idrec', $pnlsId)->select('pnl_pdf', 'pnl_date')->first();
        $filename = $pnls->pnl_date . '.pdf';
        $filepnls = $pnls->pnl_pdf;

        // if (is_null($invoice)) {
        //     alert()->error('Error', 'Invoice Not Found');
        //     return to_route('invoice');
        // }

        return Response::make($filepnls, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'"'
        ]);
    }
}
