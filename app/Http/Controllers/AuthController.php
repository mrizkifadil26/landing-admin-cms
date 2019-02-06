<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:3|confirmed',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success'
        ], 200);

    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([                    
                    'status' => 'error',
                    'message' => 'Invalid Credentials'
                ], 400);
            }
        } catch(JWTException $e) {
			return response()->json([
                'error' => 'Could not create token'
            ], 500);
		}
        

        return $this->respondWithToken($token);
        // return response([
        //     'status' => 'success',
            // 'user' => Auth::user(),
            // 'name' => Auth::user()->name,
            // 'token' => $token,
        // ], 200)->header('Authorization', 'Bearer ' . $token);
    }

    public function user(Request $request)
    {
        return response()->json(auth()->user());
        // $user = User::find(Auth::user()->id);
        
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $user
        // ]);
    }

    public function logout()
    {
        auth('api')->logout();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ]);
        // $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
        // if ($token = $this->guard()->refresh()) {
        //     return response()->json([
        //         'status' => 'success'
        //     ], 200)->header('Authorization', 'Bearer ' . $token);
        // }

        // return response()->json([
        //     'error' => 'refresh_token_error'
        // ], 201);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => new UserResource($this->guard()->user()),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    private function guard()
    {
        // return Auth::guard();
        return Auth::Guard('api');
    }

}
