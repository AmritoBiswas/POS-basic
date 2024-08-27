<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    //Category Page
    function CategoryPage(){
        return view('pages.dashboard.category-page');
    }


    //Category List
    function CategoryList(Request $request){
        $user_id = $request->header('id');
        return Category::where('user_id','=',$user_id)->get();
    }
    //Create Cateogory
    function CreateCategory(Request $request){
        $user_id = $request->header('id');
        return Category::create(
            [
                'name'=>$request->input('name'),
                'user_id'=>$user_id
            ]
        );
    }

    //Delete Category

    function CategoryDelete(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');

        return Category::where('user_id',$user_id)->where('id','=',$category_id)->delete();
    }

    //Category by id
    function CategoryById(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id',$user_id)->where('id','=',$category_id)->first();
    }

    //Category Update
    function CategoryUpdate(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id',$user_id)->where('id','=',$category_id)->update([
            'name'=>$request->input('name')
        ]);
    }
}
