<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index() : JsonResponse{
        $orders = Order::all();

        return response()->json($orders, 200);
    }

    public function show(Request $request) : JsonResponse {
        try {

            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not authenticated",
                ], 401);
            }
            $orders = Order::where("user_id", $user->id)->get();

            return response()->json([
                "status" => "success",
                "message" => "Orders fetched successfully",
                "data" => $orders,
            ], 200);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(Request $request) : JsonResponse {

        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            "items" => "required|array",
            "items.*.product_id" => "required|exists:products,id",
            "items.*.quantity" => "required|integer|min:1",
        ]);

        $hasPendingOrders = Order::where("user_id", auth()->id())
            ->where('status', "pending")
            ->exists();

        if ($hasPendingOrders) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot place a new order until all pending orders are resolved.'
            ], 400);
        }
        
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors(),
            ], 422);
        }

        try {
            $order = Order::create([
                "user_id" => $user->id,
                "order_number" => uniqid("ORD-"),
                "total_amount" => 0,
            ]);

            DB::transaction(function () use($request, $order) {

                $totalAmount = 0;

                foreach ($request->items as $item) {
                    $price = Product::find($item["product_id"])->price;

                    $orderItem = OrderItem::create([
                        "order_id" => $order->id,
                        "product_id" => $item["product_id"],
                        "quantity" => $item["quantity"],
                        "price" => $price,
                        "total" => $price * $item["quantity"]
                    ]);

                    $totalAmount += $orderItem->total;
                }

                $order->update([
                    "total_amount" => $totalAmount,
                ]);

            });

            return response()->json([
                "status" => "success",
                "message" => "Order created successfully",
                "data" => $order,
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getOrders(Request $request) {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $status = $validated['status'];

        try {
            // Fetch orders with related products
            $orders = Order::with(['products.product.category'], function ($query) {
                $query->makeHidden("category_id");
            })
            ->where('status', $status)
            ->get();

            // Transform the response data
            $orders = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'user_id' => $order->user_id,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                    'products' => $order->products->map(function ($orderItem) {
                        $productDetails = $orderItem->product;
                        $productDetails["quantity"] = $orderItem->quantity;

                        $productDetails = $orderItem->product->makeHidden("category_id");

                        return $productDetails;
                    }),
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $orders,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
    }
}

}
