<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index() : JsonResponse {
        $locations = Store::all();

        return response()->json([
            "status" => "success",
            "data" => $locations,
        ], 200);
    }
}
