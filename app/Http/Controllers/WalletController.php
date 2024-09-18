<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Order\OrderController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    protected $orderController;

    public function __construct(OrderController $orderController) {
        $this->orderController = $orderController;
    }

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

    public function topUp(Request $request) {
        
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            $wallet = Wallet::where("user_id", Auth::user()->id)->first();
            $amount = $request->input('amount');

            $wallet->balance += $amount;

            $transaction = Transaction::create([
                "wallet_id" => $wallet->id,
                "amount" => $amount,
                "type" => "credit",
                "description" => "Wallet credited",
                "payment_type" => "TOPUP",
                "user_id" => Auth::user()->id,
            ]);

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

    public function payment(Request $request) {
        
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            $wallet = Wallet::where("user_id", Auth::user()->id)->first();
            $amount = $request->input('amount');
            
            if ($wallet->balance < $amount) {
                return response()->json([
                    "status" => "error",
                    "message" => "Insufficient balance in wallet.",
                ], 400);
            }

            $wallet->balance -= $amount;

            // Create a new transaction record
            $transaction = Transaction::create([
                "wallet_id" => $wallet->id,
                "amount" => $amount,
                "type" => "purchase",
                "description" => "Order purchase",
                "payment_type" => "PAYMENT",
                "user_id" => Auth::user()->id,
                "order_id" => $request->input('order_id')
            ]);

            $wallet->save();

            $orderResponse = $this->orderController->store($request);

            if ($orderResponse->status() !== 200) {
                $errorMessage = json_decode($orderResponse->getContent(), true);
                $message = $errorMessage["message"];
                return response()->json([
                    "status" => "error",
                    "message" => $message
                ], 400);
            }

            // // Delete user's cart after order and payment are successful
            $cart = Cart::where("user_id", Auth::user()->id)->delete();

            return response()->json([
                "status" => "success",
                "data" => [
                    "wallet" => $wallet,
                    "transaction" => $transaction,
                    "order" => json_decode($orderResponse->getContent())->data
                ],
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
