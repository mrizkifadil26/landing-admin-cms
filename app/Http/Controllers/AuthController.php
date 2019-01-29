<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password', 'name']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([                    
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'message' => 'Invalid Credentials'
                ], 400);
            }
        } catch(JWTException $e) {
			return response()->json([
                'error' => 'Could not create token'
            ], 500);
		}
        

        // return $this->respondWithToken($token);
        return response([
            'status' => 'success',
            'user' => Auth::user(),
            'token' => $token,
        ])->header('Authorization', 'Bearer ' . $token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return \Auth::Guard('api');
    }

}
