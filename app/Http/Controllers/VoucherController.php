<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function applyVoucher(Request $request) {
        try {
            $voucherCode = $request->input("voucher_code");
            $voucher = Voucher::where("code", $voucherCode)->first();
    
            if (!$voucher || $voucher->is_active || $voucher->user_count >= $voucher->usage_limit) {
                return response()->json([
                    "status" => "failed",
                    "message" => "Invalid or expired voucher",
                ], 400);
            }
    
            $voucher->increment("used_count");
    
            return response()->json([
                "status" => "success",
                "message" => "Voucher applied successfully",
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
        
    }
}
