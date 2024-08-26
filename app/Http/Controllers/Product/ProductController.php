<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index() {
        $products = Product::with("category")->get();

        $products->makeHidden("category_id");

        return response()->json([
            "status" => "success",
            "data" => $products,
        ], 200);
    }

    public function show($id) {
        try {
            $products = Product::where("category_id", $id)->get();
            $data = [
                "status" => "success",
                "data" => $products,
            ];
            return response()->json($data, 200);

        } catch (Exception $e) {
            return response([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) : JsonResponse {
        try {
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function search(Request $request) {
        try {
            $name =$request->input("name");
            $products = Product::where('title', 'like', '%' . $name . '%')->get();

            return response()->json([
                "status" => "success",
                "data" => $products ?? [],
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

}
