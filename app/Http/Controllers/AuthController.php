<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\GenerateCode;
use Auth;
use Exception;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use GenerateCode;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','forget_password']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = Auth::guard('api')->attempt($credentials)) {

            return response()->json(['err' => 'Unauthorized'], 401);
        }
        $user = Auth::guard('api')->user();
        return $this->respondWithToken($token,$user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

   
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$user)
    {
        return response()->json([
            'data'=>[
                'user'=>[
                    'name'=>$user->full_name,
                    'email'=>$user->email,
                    'image'=>'xxx'
                ],
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try
        {
            $data = array_merge($request->all(),['password'=>bcrypt($request->password)]);
            User::create($data);
            return response()->json([
                'msg'=>'User was created',
            ],200);
        }catch(Exception $e)
        {
            return $this->exception_response();
        }
    }

    public function forget_password(ForgetPasswordRequest $request)
    {
        /** Send the code in the email */
        try
        {
            $gene_rate_code = GenerateCode::Code();
            User::where('email',$request->email)->update(['code'=>$gene_rate_code]);
            /** If there was an server i will send the email here the the code */
            #logic.... 

            return response()->json([
                'msg'=>'code was sent',
                'data'=>[
                    'code'=>$gene_rate_code
                ]
            ],200);

        }catch(Exception $e)
        {
            return $this->exception_response();
        }
        return response()->json([],200);
    }


    private function exception_response()
    {
        return response()->json([
            'err'=>'Server error'
        ],500);
    }
}
