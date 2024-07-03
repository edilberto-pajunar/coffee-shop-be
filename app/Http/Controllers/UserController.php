<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\call;

class UserController extends Controller
{
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
        try {
            

            $user = new User();
            $user->email = $request->email;
            $user->password = $request->password;
    
            $user->save();
            $data = [
                "response" => 200,
                "message" => "Created successfuly!"
            ];
    
            return response()->json($data, 200);
        } catch(Exception $e) {
            $data = [
                "response" => 500,
                "message" => "Server error!" . $e->getMessage(),
            ];
            return(response()->json($data, 500));
        }
    }
}
