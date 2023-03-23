<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::paginate(10)->map(function($item){
            return $this->response($item);
        });

        return response()->json([
            'msg'=>'categories was found',
            'data'=>$data
        ]);
    }

    public function store(CategoryRequest $request)
    {
        try{
            Category::create($request->all());
            return response()->json([
                'msg'=>'Category was created'
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'err'=>'server error'
            ],500);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try
        {
            $data = Category::find($id);
            if(!$data)
            {
                return response()->json([
                    'err'=>'data not found'
                ],404);
            }
            $data->update($request->all());

            return response()->json([
                'msg'=>'Category was updated'
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
        $data = Category::find($id);

        if(!$data)
        {
            return response()->json([
                'err'=>'data not found'
            ],404);
        }
        if(count($data->products) > 0)
        {
            return response()->json([
                'err'=>'Cant delete the category because it has products'
            ],422);
        }

        $data->delete();
        
        return response()->json([
            'msg'=>'category was deleted'
        ]);
    }


    private function response($item)
    {
        return[
             'id'=>$item->id,
             'name'=>$item->name
        ];
    }
}
