<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;


class ProductController extends Controller
{

    public function index() {
        return Product::all();
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
}
