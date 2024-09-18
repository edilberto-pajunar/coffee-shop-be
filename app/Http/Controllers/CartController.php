<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function show() {
        try {
            $user = Auth::user();

            // Get all cart items for the user and load the associated products
            $carts = Cart::where('user_id', $user->id)
                        ->with(['product.category']) // Eager load the products
                        ->get();

            // Extract the products from the cart items
            $products = $carts->map(function ($cart) {
                $product = $cart->product->toArray();
                $product["quantity"] = $cart->quantity;
                unset($product['category_id']);
                return [
                    "id" => $cart->id,
                    "product" => $product,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }
    }
    public function addToCart(Request $request) {

        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $user = Auth::user();
            $product_id = $validatedData["product_id"];
            $quantity = $validatedData["quantity"];

            $cart = Cart::updateOrCreate([
                "user_id" => $user->id,
                "product_id" => $product_id,
            ],[
                "quantity" => $quantity,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated',
        ]);


        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function removeToCart(Request $request) {

        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        try {
            $product_id = $validatedData["product_id"];

            $cart = Cart::where('product_id', $product_id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart!',
            ]);


        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
