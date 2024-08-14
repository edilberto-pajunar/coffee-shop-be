<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index() : JsonResponse {
        $orderItems = OrderItem::with("order", "product")->get();
        return response()->json($orderItems, 200);
    }

    public function store(Request $request) :JsonResponse {

        $request->validate([
            "user_id" => "required",
            "product_id" => "required|exist:products,id",
            "quantity" => "required|min:1",
            "total" => "required",
        ]);

        try {
            $orderItem = OrderItem::create($request->all());
            return response()->json([
                "status" => "success",
                "message" => "Order Item created successfully",
                "order_item" => $orderItem
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getOrderItemsWithProducts($orderId) : JsonResponse {
        try {

            $orderItems = OrderItem::where("order_id", $orderId)->with("product")->get(); 

            return response()->json([
                "status" => "success",
                "message" => "Order Items fetched successfully",
                "order_items" => $orderItems,
            ], 200);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
