<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Clue\Redis\Protocol\Model\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request) {
        try {
            $request->validated();

            $userData = [
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "is_admin" => $request->is_admin,
            ];
    
            $user = User::create($userData);
            $token = $user->createToken("auth_token")->plainTextToken;
    
            $data = [
                "message" =>"Created Sucesssfully",
                "token" => $token,
            ];
    
            return response()->json($data, 200);
        } catch ( Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }

       
    }

    public function login(LoginRequest $request) {

        try {
            $request->validated();

            if (!Auth::attempt($request->only(["email", "password"]))) {
                return response()->json([
                    "status" => "error",
                    "message" => "Email & Password does not match with our record",
                ], 401);
            }


            $user = User::where("email", $request->email)->first();
            
            $data = [
                "status" => "success",
                "message" => "User Logged in Successfully",
                "token" => $user->createToken("auth_token")->plainTextToken,
            ];
    
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function logout() {
        try {
            Auth::user()->tokens()->delete();

            return response()->json([
                "status" => "success",
                "message" => "User Logged out Successfully",
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
