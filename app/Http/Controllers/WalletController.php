<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function userWallet() {
        try {
            $wallet = Wallet::where("user_id", Auth::user()->id)->first();

            return response()->json([
                "status" => "success",
                "data" => $wallet,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);

        }
    }

    public function store(Request $request) {
        
        $request->validate([
            'amount' => 'required|numeric',
        ]);


        try {
            $wallet = Wallet::where("user_id", Auth::user()->id)->first();
            $wallet->balance += request("amount");

            $wallet->save();
            return response()->json([
                "status" => "success",
                "data" => $wallet,
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
