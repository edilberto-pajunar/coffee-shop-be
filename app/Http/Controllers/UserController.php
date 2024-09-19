<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\call;

class UserController extends Controller
{

    public function index() {
        $users = User::all();
        return response()->json([
            "status" => "success",
            "data" => $users,
        ], 200);
    }

    public function checkToken(Request $request) {
        // If the user is authenticated, the token is valid
        if (Auth::check()) {
            return response()->json(['message' => 'Token is valid'], 200);
        }

        // If the user is not authenticated, the token is invalid
        return response()->json(['message' => 'Token is invalid'], 401);
    }
   
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => "required|unique:users",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            $data = [
                "response" => 422,
                "message" => $validator->errors()
            ];
            return response()->json($data, 422);
        }
    }

    public function info(Request $request) {
        try {
            $auth = Auth::user();
            $user = User::where("id", $auth->id)->first();
            
            return response()->json([
                "status" => "success",
                "data" => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);

        }
    }
}
