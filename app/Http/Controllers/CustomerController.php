<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CustomerController extends Controller
{
    //Customer Page
    function CustomerPage(){
        return view('pages.dashboard.customer-page');
    }

    //Create customer
    function CreateCustomer(Request $request){
      $user_id = $request->header('id');

      return Customer::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'mobile' => $request->input('mobile'),
        'user_id' => $user_id
      ]);

    }

    //Customer List
    function CustomerList(Request $request){
        $user_id = $request->header('id');

        return Customer::where('user_id','=',$user_id)->get();
    }

    //Delete Customer
    function DeleteCustomer(Request $request){
        $customer_id = $request->input('id');
        $user_id = $request->header('id');
        return Customer::where('id','=',$customer_id)->where('user_id','=',$user_id)->delete();
    }
    //Update Customer
    function UpdateCustomer(Request $request){
      $customer_id = $request->input('id');
      $user_id = $request->header('id');
      return Customer::where('id','=',$customer_id)->where('user_id','=',$user_id)->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'mobile' => $request->input('mobile')
      ]);
    }

    //Customer By ID
    function CustomerById(Request $request){
      $customer_id=$request->input('id');
      $user_id=$request->header('id');
      return Customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }

}
