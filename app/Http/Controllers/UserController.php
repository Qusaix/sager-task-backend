<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(10)->map(function($item){
            return $this->response($item);
        });

        return response()->json([
            'msg'=>'Users was found',
            'data'=>$data,
        ]);
    }

    public function store(RegisterRequest $request)
    {
        try
        {
            User::create($request->all());
            return response()->json([
                'msg'=>'user was created'
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'err'=>'server error'
            ],500);
        }
    }


    public function update(UpdateUserRequest $request,$id)
    {
        try
        {
            $data = User::find($id);
            if(!$data)
            {
                return response()->json([
                    'err'=>'User was not found',
                    'status'=>404
                ],404);
            }
            $data->update($request->all());
            return response()->json([
                'msg'=>'User was updated'
            ],200);
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
            $data = User::find($id);
            if(!$data)
            {
                return response()->json([
                    'err'=>'User was not found',
                    'status'=>404
                ],404);
            }
            if(count($data->products) > 0)
            {
                return response()->json([
                    'err'=>'Cant delete because the user have products'
                ],401);
            }
            $data->delete();
            return response()->json([
                'msg'=>'User was deleted',
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
            'name'=>$item->full_name,
            'email'=>$item->email,
            'image'=>$item->image
        ];
    }
}
