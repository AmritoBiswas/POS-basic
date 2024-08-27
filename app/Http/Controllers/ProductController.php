<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller

{
    //Product Page
    function ProductPage(){
        return view('pages.dashboard.product-page');
    }
    //Product Create
    function CreateProduct(Request $request){
        $user_id = $request->header('id');

        $img = $request->file('img');

        $time = time();
        $file_name = $img->getClientOriginalName();

        $img_name = "{$user_id}-{$time}-{$file_name}";
        $img_url = "uploads/{$img_name}";

        $img->move(public_path('uploads'),$img_name);

        return Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'user_id'=>$user_id,
            'category_id'=>$request->input('category_id')
        ]);

    }

    //Delete product
    function DeleteProduct(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        $filePath = $request->input('filePath');

        File::delete($filePath);

        return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->delete();

    }

    //Product by id
    function ProductById(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->first();
    }
    //Product List
    function ProductList(Request $request){
        $user_id = $request->header('id');

        return Product::where('user_id','=',$user_id)->get();

    }
    //Product updater
    function ProductUpdate(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img')){
            $img = $request->file('img');

            $time = time();
            $file_name = $img->getClientOriginalName();

            $img_name = "{$user_id}-{$time}-{$file_name}";
            $img_url = "uploads/{$img_name}";

            $img->move(public_path('uploads'),$img_name);

            
            $filePath = $request->input('filePath');

            File::delete($filePath);


            return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);

        }
        else{
            return Product::where('id','=',$product_id)->where('user_id','=',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id')
            ]);
        }
    }
}





