<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::count();
        $categories = Category::count();
        $users = User::count();

        return response()->json([
            'msg'=>'data was found',
            'data'=>[
                'products'=>$products,
                'categories'=>$categories,
                'users'=>$users,
            ]
        ],200);
    }
}
