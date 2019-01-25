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
        $credentials = $request->only(['username', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([                    
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'message' => 'Invalid Credentials'
                ], 400);
            }
        } catch(JWTException $e) {
			return response()->json(['error' => 'Could not create token'], 500);
		}
        

        // return $this->respondWithToken($token);
        return response([
            'status' => 'success',
            'user' => $credentials,
            'token' => $token,
        ])->header('Authorization', $token);
    }

    public function authenticated(Request $request)
    {
        $user = User::find(Auth::user()->id);
        // return response()->json(auth()->user());
        return response([
            'status'=> 'success',
            'data' => $user
        ]);
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        // return $this->respondWithToken(auth()->refresh());
        return response([
            'status' => 'success'
        ]);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
