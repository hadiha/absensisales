<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateUserLogin;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','refresh']]);
    }
    // public function register(ValidateUserRegistration $request){
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ]); 
    //     return new UserResource($user); 
    // }

    public function login(ValidateUserLogin $request){
      
        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return  response()->json([ 
                'errors' => [
                    'msg' => ['Incorrect username or password.']
                ]  
            ], 401);
        }

        return $this->respondWithToken($token);
    }
 
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function user()
    { 
       return new UserResource(auth()->user());
    }
}
