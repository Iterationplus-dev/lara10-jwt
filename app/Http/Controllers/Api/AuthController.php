<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST
    public function register(Request $request){
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed"
        ]);

        // $user = new User();
        // $user->name = $request->name;
        // $user->save();

        User::createOrFirst([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User is created successfully"
        ]);
    }

    // POST Request
    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!empty($token)){
            return response()->json([
                "status" => true,
                "message" => "User logged In",
                "token" => $token,
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid credentials",
        ],401);
    }

    // GET
    public function profile(){
        $user = auth()->user();
        return response()->json([
            "status" => true,
            "message" => "User details correct",
            "token" => $user,
        ]);
    }

    // GET
    public function refreshToken(){
        $newToken = auth()->refresh();
        return response()->json([
            "status" => true,
            "message" => "New token created",
            "token" => $newToken,
        ]);
    }

    // GET
    public function logout(){
        auth()->logout();
        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
}
