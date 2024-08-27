<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    function ReportPage(){
        return view('pages.dashboard.report-page');
    }

    //SalesReport
    function SalesReport(Request $request){
        $user_id = $request->header('id');
        $FormDate = date('Y-m-d',strtotime($request->FormDate));
        $ToDate = date('Y-m-d',strtotime($request->ToDate));

        $total = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at','<=',$ToDate)->sum('total');
        $payable = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at','<=',$ToDate)->sum('payable');
        $vat = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at','<=',$ToDate)->sum('vat');
        $discount = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at','<=',$ToDate)->sum('discount');


        $list = Invoice::where('user_id',$user_id)->whereDate('created_at','>=',$FormDate)->whereDate('created_at','<=',$ToDate)->with('customer')->get();


        $data=[
            'payable'=> $payable,
            'discount'=>$discount,
            'total'=> $total,
            'vat'=> $vat,
            'list'=>$list,
            'FormDate'=>$request->FormDate,
            'ToDate'=>$request->FormDate
        ];



        $pdf = Pdf::loadView('report.SalesReport',$data);

        return $pdf->download('invoice.pdf');
    }




}   
