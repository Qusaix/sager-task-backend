<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::whereHas('categories')->orderBy('updated_at','desc')->paginate(10)->map(function($item){
            return $this->response($item);
        });
        return response()->json([
            'msg'=>'All product',
            'data'=>$data
        ]);
    }

    public function store(ProductRequest $request){
        try{
            $request_data = array_merge($request->all(),['user_id'=>Auth::guard('api')->user()->id]);
            $data = Product::create($request_data);
            if($request->hasFile('image'))
            {
                $data->addMedia($request->file('image'))
                ->toMediaCollection('image');
            }
            $data->categories()->sync($request->categories);
            return response()->json([
                'msg'=>'product was created'
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'err'=>'server error'
            ],500);
        }
    }

    public function update($id,ProductRequest $request)
    {
        try{
            $data = Product::find($id);
            if(!$data)
            {
                return response()->json([
                    'err'=>'product not found'
                ],404);
            }
            $data->update($request->all());
            if($request->hasFile('image'))
            {
                $data->addMedia($request->file('image'))
                ->toMediaCollection('image');
            }
            $data->categories()->sync($request->categories);
            return response()->json([
                'msg'=>'data was updated',
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'err'=>'server error'
            ],500);
        }
    }

    public function delete($id)
    {
        try
        {
            $data = Product::find($id);
            if(!$data)
            {
                return response()->json([
                    'err'=>'product not found',
                ],404);
            }
            $data->categories()->sync([]);
            $data->delete();
            return response()->json([
                'msg'=>'product was deleted'
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'err'=>'server error'
            ],500);
        }
    }

    private function response($item)
    {
        return [
            'id'=>$item->id,
            'name'=>$item->name,
            'image'=>$item->image,
            'description'=>$item->description,
            'price'=>$item->price,
            'categories'=>$item->categories->map(function($item){
                return[
                    'id'=>$item->id,
                    'name'=>$item->name,
                ];
            }),
            'user'=>[
                'id'=>$item->users->id,
                'full_name'=>$item->users->full_name,
            ]
            ];
    }
}
