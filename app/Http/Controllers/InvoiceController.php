<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    //Invoice Page
    function InvoicePage(){
        return view('pages.dashboard.invoice-page');
    }

    //sales PAge
    function SalePage(){
        return view('pages.dashboard.sale-page');
    }



    // create invoice
    function invoiceCreate(Request $request){
        DB::beginTransaction();

        try{
            $user_id = $request->header('id');
            $customer_id = $request->input('customer_id');

            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');


            $invoice = Invoice::create([
                'user_id' =>$user_id,
                'customer_id'=>$customer_id,
                'total'=>$total,
                'discount'=>$discount,
                'vat'=>$vat,
                'payable'=>$payable
            ]);

            $invoiceID = $invoice->id;

            $products = $request->input('products');

            foreach($products as $eachProduct){
                InvoiceProduct::create([
                    'invoice_id'=>$invoiceID,
                    'user_id'=>$user_id,
                    'product_id'=>$eachProduct['product_id'],
                    'qty'=>$eachProduct['qty'],
                    'sale_price'=>$eachProduct['sale_price']
                ]);
            }

            DB::commit();
            return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }

    }

    function InvoiceSelect(Request $request){
        $user_id = $request->header('id');
        return Invoice::where('user_id','=',$user_id)->with('customer')->get();
    }

    function InvoiceDetails(Request $request){
        $user_id = $request->header('id');
        $customerDetails = Customer::where('user_id','=',$user_id)->where('id','=',$request->input('cus_id'))->first();
        $invoiceTotal = Invoice::where('user_id','=',$user_id)->where('id','=',$request->input('inv_id'))->first();
        $invoiceProduct = InvoiceProduct::where('user_id','=',$user_id)->where('invoice_id','=',$request->input('inv_id'))->with('product')->get();

        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct
        );
    }

    function DeleteInvoice(Request $request){
        DB::beginTransaction();
        try{
            $user_id = $request->header('id');

        InvoiceProduct::where('invoice_id','=',$request->input('inv_id'))->where('user_id','=',$user_id)->delete();
        Invoice::where('id','=',$request->input('inv_id'))->where('user_id','=',$user_id)->delete();

        DB::commit();
        return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }
    }





}
